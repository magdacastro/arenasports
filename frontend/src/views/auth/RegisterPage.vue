<template>
  <ion-page>
    <ion-content>
      <ion-grid>
        <form formGroup="ionicForm" @submit="submit()" novalidate>
          <ion-row class="flex justify-center ion-margin-top">
            <ion-col size="8">
              <img src="../../../public/images/logo/arenasports.svg" alt="" />
            </ion-col>
          </ion-row>
          <ion-row>
            <ion-col class="ion-text-center">
              <ion-text color="medium">
                <h2><strong>CRIAR SUA CONTA</strong></h2>
              </ion-text>
            </ion-col>
          </ion-row>
          <ion-input label="Nome:" type="text" placeholder="Joana Doe" v-model="form.name"></ion-input>
          <ion-input label="Telefone:" type="text" placeholder="(51) 9 9999 3099" v-model="form.phone"></ion-input>

          <ion-select v-model="form.payment" label="Forma de Pagamento:" placeholder="Escolha">
            <ion-select-option value="pix">Pix</ion-select-option>
            <ion-select-option value="cartao">Cartão</ion-select-option>
            <ion-select-option value="boleto">Boleto</ion-select-option>
            <ion-select-option value="dinheiro">Dinheiro</ion-select-option>
          </ion-select>

          <ion-input label="Email:" type="email" placeholder="voce@email.com" v-model="form.email"></ion-input>
          <ion-input label="Senha:" type="password" placeholder="********" v-model="form.password"></ion-input>
          <ion-input label="Repetir Senha:" type="password" placeholder="********" v-model="form.password_confirmation"></ion-input>

          <ion-col class="flex flex-col items-center justify-center">
            <ion-text class="min-w-full text-center" color="danger">
              <span class="text-xs p-0" v-if="errors.password.status === false">{{ errors.password.message }}</span>
            </ion-text>
          </ion-col>

          <div class="btn-register mt-12">
            <ion-button @click="submit">Cadastrar</ion-button>
          </div>
        </form>
        <ion-row>
          <ion-col class="ion-text-center">
            <ion-text color="primary" @click="goToLogin()"> Já possui cadastro? Clique aqui!</ion-text>
          </ion-col>
        </ion-row>
      </ion-grid>
    </ion-content>
  </ion-page>
</template>

<script lang="ts">
import { defineComponent } from "vue";

import { toastController } from "@ionic/vue";

import { AxiosError } from "axios";

import axios from "@/services/axios";

import { IonCol, IonContent, IonPage, IonRow, IonText, IonGrid, IonInput, IonSelect, IonSelectOption, IonItem, IonButton } from "@ionic/vue";
import { NavigationFailure } from "vue-router";

export default defineComponent({
  name: "Register",
  data() {
    return {
      form: {
        name: "",
        phone: "",
        payment: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
      submitted: false,
      errors: {
        password: {
          status: true,
          message: "",
        },
      },
    };
  },
  components: {
    IonCol,
    IonContent,
    IonPage,
    IonRow,
    IonText,
    IonInput,
    IonSelect,
    IonGrid,
    IonSelectOption,
    IonItem,
    IonButton,
  },
  methods: {
    filled(): boolean {
      return this.form.name.length > 0 && this.form.email.length > 0 && this.form.password.length > 0 && this.form.password_confirmation.length > 0;
    },
    validatePassword() {
      const password = this.form.password;
      const confirmPassword = this.form.password_confirmation;

      if (password !== confirmPassword && confirmPassword.length > 0) {
        this.errors.password = {
          status: false,
          message: "As senhas não conferem",
        };
      } else {
        this.errors.password.status = true;
      }
    },
    async submit() {
      axios
        .post("v1/auth/register", this.form)
        .then(({ status }) => {
          if (status === 201) {
            this.toast("Usuário criado som sucesso!", 3000);

            this.$router.push("/tabs/auth/login");
          }
        })
        .catch((error) => {
          if (error instanceof AxiosError) {
            this.toast(error.response!.data.message, 3000);
          }
        });
    },
    async toast(message: string, duration: number): Promise<void> {
      const toast = await toastController.create({
        message: message,
        duration: duration,
      });

      toast.present();
    },
    async goToLogin(): Promise<NavigationFailure | void | undefined> {
      return this.$router.push("/auth/login");
    },
  },
});
</script>

<style scoped>
.mt-12 {
  margin-top: 24px;
}

ion-button {
  width: 100%;
}
</style>
