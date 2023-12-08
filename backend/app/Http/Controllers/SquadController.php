<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSquadRequest;
use App\Http\Requests\UpdateSquadRequest;
use App\Models\Squad;
use Illuminate\Http\Resources\Json\JsonResource;

class SquadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        return JsonResource::collection(
            Squad::all()
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSquadRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Squad $squad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Squad $squad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSquadRequest $request, Squad $squad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Squad $squad)
    {
        //
    }
}
