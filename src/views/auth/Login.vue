<template>
  <ion-page>
    <ion-content :fullscreen="true">
      <ion-row class="flex justify-center ion-margin-top" @click="reloadPage">
        <ion-col size="8">
          <Logo></Logo>
        </ion-col>
      </ion-row>
      <ion-grid class="mt-8">
        <Input type="email" label="Email" id="email" :value="form.email" validator="email" :change="set"></Input>
        <Input type="password" label="Senha" id="password" :value="form.password" :change="set"></Input>

        <!--<ion-row>
          <ion-col class="ion-text-end">
            <ion-text color="primary" @click="forgot()">Esqueceu a senha?</ion-text>
          </ion-col>
        </ion-row>-->

        <Button label="Entrar" @click="login"></Button>

        <ion-row>
          <ion-col class="ion-text-center">
            <ion-text color="primary" @click="create()">Não possui cadastro? Clique aqui!</ion-text>
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

import { IonCol, IonContent, IonGrid, IonPage, IonRow, IonText } from "@ionic/vue";

import { AuthController } from "@/http/controllers/AuthController";
import { LoginKeyboardEnterEvent } from "@/contracts/http/AuthController";

import Button from "@/components/units/Button.vue";
import Input from "@/components/units/Input.vue";
import Logo from "@/components/units/Logo.vue";

import { HTTP_OK } from "@/constants/http/Response";
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
    Logo,
    Button,
    Input,
  },
  created() {
    this.clearCache();
  },
  methods: {
    clearCache() {
      localStorage.clear();
    },
    async set(event: LoginKeyboardEnterEvent) {
      this.form[event.id] = event.content;
    },
    async reloadPage() {
      this.$router.go(0);
    },
    async login() {
      this.clearCache();

      new AuthController()
        .login(this.form)
        .then((response: any) => {
          /* eslint-disable-next-line */
          const { token }: { token: string } = response!.data!;
          /* eslint-disable-next-line */
          const { name, email }: { name: string; email: string } = response!.data!.user!;

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

          /* eslint-disable-next-line */
          const errors: string | AuthError = err.response!.data!.error;

          if (typeof errors === "string") {
            this.toast(errors, 3000);
          }

          if (typeof errors === "object") {
            if (typeof errors.email === "object") {
              this.toast(errors.email.find((n: string) => n) ?? "Não foi possível encontrar o e-mail!", 3000);
            }

            if (typeof errors.password === "object") {
              this.toast(errors.password.find((n: string) => n) ?? "A senha não está em um formato válido!", 3000);
            }
          }
        });
    },
    /* async forgot(): Promise<NavigationFailure | void | undefined> {
      return this.$router.push('/auth/restore/mailer');
    },*/
    async create(): Promise<NavigationFailure | void | undefined> {
      return this.$router.push("/auth/register");
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
