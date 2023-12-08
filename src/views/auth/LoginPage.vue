<template>
  <ion-page>
    <ion-content :fullscreen="true">
      <ion-row class="flex justify-center ion-margin-top" @click="reloadPage">
        <ion-col size="8">
          <img src="../../../public/images/logo/arenasports.svg" />
        </ion-col>
      </ion-row>
      <ion-grid class="mt-12">
          <ion-row>
            <ion-col class="ion-text-center">
              <ion-text color="medium">
                <h2><strong>BEM VINDO</strong></h2>
              </ion-text>
            </ion-col>
          </ion-row>

        <ion-input
          label="Email:"
          type="email"
          placeholder="voce@email.com"
          v-model="form.email"
        ></ion-input>
        <ion-input
          label="Senha:"
          type="password"
          placeholder="********"
          v-model="form.password"
        ></ion-input>

        <div class="btn-login mt-12">
          <ion-button @click="login">Entrar</ion-button>
        </div>

        <ion-row>
          <ion-col class="ion-text-center">
            <ion-text color="primary" @click="register()">
              Não possui cadastro? Clique aqui!</ion-text
            >
          </ion-col>
        </ion-row>
      </ion-grid>
    </ion-content>
  </ion-page>
</template>

<script lang="ts">
import { defineComponent } from "vue";

import { NavigationFailure } from "vue-router";
import { toastController } from "@ionic/vue";

import {
  IonCol,
  IonContent,
  IonGrid,
  IonPage,
  IonRow,
  IonText,
  IonTitle,
  IonInput,
  IonButton,
} from "@ionic/vue";

//import { AuthController } from "@/http/controllers/AuthController";
//import { LoginKeyboardEnterEvent } from "@/contracts/http/AuthController";

//import { HTTP_OK } from "@/constants/http/Response";
import { AxiosError } from "axios";

export default defineComponent({
  name: "Login",
  data() {
    return {
      form: {
        email: "",
        password: "",
      },
    };
  },
  components: {
    IonCol,
    IonContent,
    IonGrid,
    IonPage,
    IonRow,
    IonText,
    IonTitle,
    IonInput,
    IonButton,
  },
  created() {
    this.clearCache();
  },
  methods: {
    clearCache() {
      localStorage.clear();
    },
    /*async set(event: LoginKeyboardEnterEvent) {
      this.form[event.id] = event.content;
    },*/
    async reloadPage() {
      this.$router.go(0);
    },
    async login() {
      this.clearCache();

      /*new AuthController()
        .login(this.form)
        .then((response: any) => {
          const { token }: { token: string } = response!.data!;
          const { name, email }: { name: string; email: string } =
            response!.data!.user!;

          if (response.status === HTTP_OK) {
            localStorage.setItem("token", token);
            localStorage.setItem("user", JSON.stringify({ name, email }));

            this.$router.push("/system/home");
          }
        })
        .catch(async (err: AxiosError) => {
          interface AuthError {
            email?: Array<string>;
            password?: Array<string>;
          }

          const errors: string | AuthError = err.response!.data!.error;

          if (typeof errors === "string") {
            this.toast(errors, 3000);
          }

          if (typeof errors === "object") {
            if (typeof errors.email === "object") {
              this.toast(
                errors.email.find((n: string) => n) ??
                  "Não foi possível encontrar o e-mail!",
                3000
              );
            }

            if (typeof errors.password === "object") {
              this.toast(
                errors.password.find((n: string) => n) ??
                  "A senha não está em um formato válido!",
                3000
              );
            }
          }
        });*/

      console.log(this.form);
    },
    /* async forgot(): Promise<NavigationFailure | void | undefined> {
      return this.$router.push('/auth/restore/mailer');
    },*/
    async register(): Promise<NavigationFailure | void | undefined> {
      return this.$router.push("/tabs/auth/register");
    },
    async toast(message: string, duration: number): Promise<void> {
      const toast = await toastController.create({
        message: message,
        duration: duration,
      });

      toast.present();
    },
  },
});
</script>

<style scoped>
ion-button {
  width: 100%;
}

.mt-12 {
  margin-top: 24px;
}

.title {
  display: flex;
    justify-content: center;
}
</style>
