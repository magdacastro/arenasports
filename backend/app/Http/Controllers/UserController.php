<?php

namespace App\Http\Controllers;

use App\Enums\Cloudinary;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRecoveryRequest;
use App\Http\Requests\UserResetRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\UserRecoveryNotification;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Register a new user.
     *
     * @param \App\Http\Requests\CreateUserRequest $request
     *
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the success of the recovery process.
     */
    public function register(CreateUserRequest $request): JsonResponse
    {
        $resource = User::firstOrCreate(['email' => $request->email], $request->only('name', 'email', 'payment', 'phone') + [
            'password' => Hash::make($request->password)
        ]);

        return new JsonResponse($resource, Response::HTTP_CREATED);
    }

    /**
     * Log in a user.
     *
     * @param \App\Http\Requests\LoginRequest $request
     *
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the success of the recovery process.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $callback = function (string $message): JsonResponse {
            return new JsonResponse([
                'error' => $message
            ], Response::HTTP_UNAUTHORIZED);
        };

        try {
            if (Auth::attemptWhen($request->all(), function (User $user): User {
                return $user;
            })) {
                $token = $request->user()->createToken('API Token')->plainTextToken;

                return new JsonResponse([
                    'token' => $token
                ], Response::HTTP_OK);
            }
        } catch (Exception $e) {
            return $callback($e->getMessage());
        }

        return $callback(trans('auth.failed'));
    }

    /**
     * Get user information.
     *
     * Retrieves the authenticated user information based on the JWT token.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the success of the recovery process.
     */
    public function show(Request $request): JsonResponse
    {
        return new JsonResponse(new UserResource($request->user()));
    }

    /**
     * Log out a user by revoking their current access token.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the success of the recovery process.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Verify the email for the given user.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return JsonResponse
     */
    public function verify(Request $request, User $user): RedirectResponse|Redirector
    {
        if (Route::getCurrentRoute()->email === $user->email) {
            $user->markEmailAsVerified();
        }

        return redirect(
            sprintf('%s/user/auth/recovery/verification/feedback', env('NUXT_APP'))
        );
    }

    /**
     * Handle the recovery request for the user.
     *
     * @param \App\Http\Requests\UserRecoveryRequest $request The user recovery request instance.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the success of the recovery process.
     */
    public function recovery(UserRecoveryRequest $request): JsonResponse
    {
        $app = App::make(PasswordBrokerManager::class);

        $request->user()->notify(
            new UserRecoveryNotification($request->user(), $app->broker()->createToken($request->user()))
        );

        return new JsonResponse([], Response::HTTP_OK);
    }

    /**
     * Reset the user's password based on the provided token.
     *
     * @param \App\Http\Requests\UserResetRequest $request The user reset request object.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response indicating the success of the recovery process.
     */
    public function reset(UserResetRequest $request): JsonResponse
    {
        $app = App::make(PasswordBrokerManager::class);

        $user = $request->user();

        if ($app->broker()->tokenExists(
            $user,
            $request->token
        )) {
            $app->broker()->deleteToken($user);

            if ($user->hasVerifiedEmail() === false) {
                $user->markEmailAsVerified();
            }

            $user->update([
                'password' => Hash::make($request->password)
            ]);

            return new JsonResponse([], Response::HTTP_OK);
        }

        return new JsonResponse([], Response::HTTP_BAD_REQUEST);
    }

    /**
     * No formulário de cadastro das informações do usuário:
     *
     * Twillio https://www.twilio.com/en-us/pricing
     *
     * 1. Ao confirmar o número de telefone, usar a api do Twillio para validar o número de telefone do usuário
     *
     * 2. Conferir no banco de dados se o número informado já existe para outro usuário e vincul
     */
    public function update(UpdateUserRequest $request): JsonResponse
    {
        $request->user()->update(
            $request->only(['name'])
        );

        return new JsonResponse(null, Response::HTTP_OK);
    }
}
