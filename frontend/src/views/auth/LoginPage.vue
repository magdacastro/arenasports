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

        <ion-input label="Email:" type="email" placeholder="voce@email.com" v-model="form.email"></ion-input>
        <ion-input label="Senha:" type="password" placeholder="********" v-model="form.password"></ion-input>

        <div class="btn-login mt-12">
          <ion-button @click="login">Entrar</ion-button>
        </div>

        <ion-row>
          <ion-col class="ion-text-center">
            <ion-text color="primary" @click="register()"> Não possui cadastro? Clique aqui!</ion-text>
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

import { IonCol, IonContent, IonGrid, IonPage, IonRow, IonText, IonTitle, IonInput, IonButton } from "@ionic/vue";

import { AxiosError } from "axios";

import axios from "@/services/axios";

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
    async reloadPage() {
      this.$router.go(0);
    },
    async login() {
      this.clearCache();

      axios
        .post("v1/auth/login", this.form)
        .then(({ data, status }) => {
          if (status === 200) {
            this.toast("Usuário logado com sucesso!", 3000);

            window.localStorage.setItem("token", data.token);

            this.$router.push("/tabs/tab1");
          }
        })
        .catch(({ response: { data } }) => {
          this.toast(data.message, 4000);
        });
    },
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
