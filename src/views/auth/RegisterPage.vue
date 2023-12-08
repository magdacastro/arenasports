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
          <ion-input
            label="Nome:"
            type="text"
            placeholder="Joana Doe"
            v-model="form.name"
          ></ion-input>
          <ion-input
            label="Telefone:"
            type="text"
            placeholder="(51) 9 9999 3099"
            v-model="form.phone"
          ></ion-input>

          <ion-select
            v-model="payment"
            label="Forma de Pagamento:"
            placeholder="Escolha"
          >
            <ion-select-option value="1">Pix</ion-select-option>
            <ion-select-option value="2">Cartão</ion-select-option>
            <ion-select-option value="3">Boleto</ion-select-option>
            <ion-select-option value="4">Dinheiro</ion-select-option>
          </ion-select>

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
          <ion-input
            label="Repetir Senha:"
            type="password"
            placeholder="********"
            v-model="form.password_confirmation"
          ></ion-input>

          <ion-col class="flex flex-col items-center justify-center">
            <ion-text class="min-w-full text-center" color="danger">
              <span
                class="text-xs p-0"
                v-if="errors.password.status === false"
                >{{ errors.password.message }}</span
              >
            </ion-text>
          </ion-col>

          <div class="btn-register mt-12">
            <ion-button @click="submit">Cadastrar</ion-button>
          </div>
        </form>
        <ion-row>
          <ion-col class="ion-text-center">
            <ion-text color="primary" @click="login()">
              Já possui cadastro? Clique aqui!</ion-text
            >
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

//import { AuthController } from "@/http/controllers/AuthController";

//import { RegisterKeyboardEnterEvent } from "@/contracts/http/AuthController";

//import { HTTP_CREATED } from "@/constants/http/Response";

import {
  IonCol,
  IonContent,
  IonPage,
  IonRow,
  IonText,
  IonGrid,
  IonInput,
  IonSelect,
  IonSelectOption,
  IonItem,
  IonButton,
} from "@ionic/vue";
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
    /* async set(event: RegisterKeyboardEnterEvent) {
      this.form[event.id] = event.content;
    }, */
    filled(): boolean {
      return (
        this.form.name.length > 0 &&
        this.form.email.length > 0 &&
        this.form.password.length > 0 &&
        this.form.password_confirmation.length > 0
      );
    },
    validateName(event: any) {
      const regexNum = /[0-9]/g;
      const validate = this.form.name;
      if (validate.match(regexNum)) {
        event.target.value = event.target.value.slice(0, -1);
      }
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
      /*if (this.submitted === true || this.filled() === false) {
        return false;
      }

      new AuthController()
        .register(this.form)
        .then((response: any) => {
          if (response.status === HTTP_CREATED) {
            this.form = {
              name: "",
              email: "",
              password: "",
              // eslint-disable-next-line @typescript-eslint/camelcase
              password_confirmation: "",
            };

            this.submitted = false;

            this.toast("Usuário cadastrado!", 3000).then(() => {
              setTimeout(() => {
                this.$router.push("/auth/login");
              }, 3000);
            });

            this.submitted = true;
          }
        })
        .catch(async (err: AxiosError) => {
          if (typeof err.response === typeof {}) {
            // eslint-disable-next-line @typescript-eslint/no-non-null-assertion
            const errors = err.response!.data!.error ?? [];

            if (typeof errors.email !== typeof undefined) {
              errors.email.map(async (message: string) => {
                this.toast(message, 2000);
              });
            }

            if (typeof errors.password !== typeof undefined) {
              errors.password.map(async (message: string) => {
                this.toast(message, 2000);
              });
            }
          }

          this.submitted = false;
        })
        .finally(function () {
          //
        });*/
      console.log(this.form);
    },
    async toast(message: string, duration: number): Promise<void> {
      const toast = await toastController.create({
        message: message,
        duration: duration,
      });

      toast.present();
    },
    async back(): Promise<NavigationFailure | void | undefined> {
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
