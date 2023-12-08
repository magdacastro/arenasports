<template>
  <ion-page>
    <ion-content>
      <ion-grid>
        <form formGroup="ionicForm" @submit="submit()" novalidate>
          <ion-row class="flex justify-center ion-margin-top">
            <ion-col size="8">
              <Logo></Logo>
            </ion-col>
          </ion-row>
          <ion-row>
            <ion-col class="ion-text-center">
              <ion-text color="medium">
                <h2><strong>CRIAR SUA CONTA</strong></h2>
              </ion-text>
            </ion-col>
          </ion-row>
          <Input label="Nome" type="text" :value="form.name" @keyup="validateName($event)" :change="set" id="name"></Input>
          <Input label="Email" type="email" :value="form.email" :change="set" id="email"></Input>
          <Input label="Senha" type="password" :value="form.password" :change="set" id="password"></Input>
          <Input label="Confirmar Senha" type="password" @keyup="validatePassword()" :value="form.password_confirmation" :change="set" id="password_confirmation"></Input>
          <ion-col class="flex flex-col items-center justify-center">
            <ion-text class="min-w-full text-center" color="danger">
              <span class="text-xs p-0" v-if="errors.password.status === false">{{ errors.password.message }}</span>
            </ion-text>
          </ion-col>
          <Button label="Cadastrar" :disabled="submitted === true || filled() === false" @click="submit"></Button>
        </form>
        <Button label="Voltar" @click="back()" color="light"></Button>
      </ion-grid>
    </ion-content>
  </ion-page>
</template>

<script lang="ts">
import { defineComponent } from "vue";

import { toastController } from "@ionic/vue";

import { AxiosError } from "axios";

import Logo from "@/components/units/Logo.vue";
import Input from "@/components/units/Input.vue";
import Button from "@/components/units/Button.vue";

import { AuthController } from "@/http/controllers/AuthController";

import { RegisterKeyboardEnterEvent } from "@/contracts/http/AuthController";

import { HTTP_CREATED } from "@/constants/http/Response";

import {
  IonCol,
  IonContent,
  IonPage,
  IonRow,
  IonText,
  IonGrid,
} from "@ionic/vue";
import { NavigationFailure } from "vue-router";

export default defineComponent({
  name: "Register",
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        /* eslint-disable-next-line @typescript-eslint/camelcase */
        password_confirmation: '',
      },
      submitted: false,
      errors: {
        password: { 
          status: true, 
          message: ''
        }
      }
    };
  },
  components: {
    IonCol,
    IonContent,
    IonPage,
    IonRow,
    IonText,
    Input,
    Logo,
    Button,
    IonGrid,
  },
  methods: {
    async set(event: RegisterKeyboardEnterEvent) {
      this.form[event.id] = event.content;
    },
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
      if(validate.match(regexNum)){
        event.target.value = event.target.value.slice(0, -1);
      }
    },
    validatePassword() {
      const password = this.form.password;
      const confirmPassword = this.form.password_confirmation;

      if(password !== confirmPassword && confirmPassword.length > 0){
        this.errors.password = {
          status: false,
          message: "As senhas não conferem"
        };
      } else {
        this.errors.password.status = true;
      }
    },
    async submit() {
      if (this.submitted === true || this.filled() === false) {
        return false;
      }

      new AuthController().register(this.form).then((response: any) => {
        if (response.status === HTTP_CREATED) {
          this.form = {
            name: "",
            email: "",
            password: "",
            // eslint-disable-next-line @typescript-eslint/camelcase
            password_confirmation: "",
          };

          this.submitted = false;

          this.toast('Usuário cadastrado!', 3000).then(() => {
            setTimeout(() => {
              this.$router.push('/auth/login');
            }, 3000);
          });

          this.submitted = true;
        }
      }).catch(async (err: AxiosError) => {
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
        
      }).finally(function () {
        //
      });
    },
    async toast(message: string, duration: number): Promise<void> {
      const toast = await toastController.create({
        message: message,
        duration: duration,
      });

      toast.present();
    },
    async back(): Promise<NavigationFailure | void | undefined> {
      return this.$router.push('/auth/login');
    },
  }
});
</script>
