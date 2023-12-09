<template>
  <div class="ion-padding">
    <ion-row>
      <ion-col size="12">
        <ion-label>Data:</ion-label>
        <ion-label>{{ date }}</ion-label>
      </ion-col>

      <ion-col size="12">
        <ion-label>Quadra:</ion-label>
        <ion-label>{{ squad_id }}</ion-label>
      </ion-col>

      <ion-col size="12">
        <ion-label>Horário(s):</ion-label>
        <ion-item v-for="period in periods" :key="period.id" detail="false">
          <ion-label>{{ period.time }}</ion-label>
        </ion-item>
      </ion-col>
      <ion-col size="12">
        <ion-item detail="false">
          <ion-label>Preço por hora: {{ formatNumberToMoney(100) }}</ion-label>
        </ion-item>
        <ion-item detail="false">
          <ion-label
            >Preço Total: R$ {{ moneyFormat.format(getSum()) }}
          </ion-label>
        </ion-item>
      </ion-col>
    </ion-row>
    <ion-row>
      <ion-button @click="confirmSchedule()">Confirmar Agendamento</ion-button>
    </ion-row>
  </div>
</template>

<script lang="ts">
import {
  IonButton,
  IonItem,
  IonCol,
  IonRow,
  IonLabel,
  alertController,
} from "@ionic/vue";
import { defineComponent } from "vue";
import { Toast } from "@capacitor/toast";
import axios from "@/services/axios";

export default {
  props: {
    date: {
      type: String,
      required: true,
    },
    squad_id: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      periods: [],
      moneyFormat: new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL",
      }),
    };
  },
  created() {
    const textSchedules = window.localStorage.schedules;
    if (textSchedules) {
      const schedules = JSON.parse(textSchedules);
      const schedule = schedules.find(
        (schedule) =>
          schedule.squad_id === this.squad_id && schedule.date === this.date
      );
      const periods = schedule.periods;

      axios
        .get("v1/periods")
        .then(({ status, data: { data } }) => {
          if (status === 200) {
            const periodsArray = data.filter((period) =>
              periods.includes(period.id)
            );

            this.periods = periodsArray;
          }
        })
        .catch();
    }
  },
  methods: {
    formatNumberToMoney(money: Number): string {
      return this.moneyFormat.format(money);
    },
    getSum(): number {
      return this.periods.length * 100;
    },
    async showHelloToast(message: string) {
      await Toast.show({
        text: message,
        duration: "long",
        position: "top",
      });
    },
    async confirmSchedule() {
      const confirm = await alertController.create({
        header: "Lembre-se!",
        message:
          "Esteja no local na hora marcada! Caso contrário, será cobrado juros de sua conta.",
        buttons: [
          {
            text: "Cancelar",
            role: "cancel",
            handler: () => {
              return;
            },
          },
          {
            text: "OK",
            handler: () => {
              this.showHelloToast("Agendado com sucesso");
              
              this.$router.push("/tabs/tab1");
            },
          },
        ],
      });

      await confirm.present();
    },
  },
  components: {
    IonButton,
    IonItem,
    IonCol,
    IonRow,
    IonLabel,
  },
};
</script>
