<template>
  <ion-page>
    <ion-header>
      <ion-toolbar>
        <ion-buttons>
          <ion-back-button></ion-back-button>
        </ion-buttons>
        <ion-title>
          <img src="../../public/images/logo/arenasports.svg" />
        </ion-title>
      </ion-toolbar>
    </ion-header>
    <ion-content :fullscreen="true">
      <ion-header collapse="condense">
        <ion-toolbar>
          <div class="title">
            <h1>Escolha seu horário</h1>
          </div>
        </ion-toolbar>
      </ion-header>
      <ion-content>
        <ion-list v-for="schedule in schedules" :key="schedule.id">
          <ion-item @click.prevent="($e) => setPeriodTime($e, schedule.id)">
            <ion-checkbox
              slot="start"
              aria-label="Task name"
              :checked="has(schedule.id)"
            ></ion-checkbox>
            <ion-label>{{ schedule.period }}</ion-label>
          </ion-item>
        </ion-list>

        <div class="btn-schedule">
          <ion-button @click="schedulePeriod()">
            <span v-if="!has()">Agendar</span>
            <span v-else>Atualizar</span>
          </ion-button>
        </div>
      </ion-content>
    </ion-content>
  </ion-page>
</template>

<script lang="ts">
import axios from "axios";
import { Toast } from "@capacitor/toast";

import {
  IonBackButton,
  IonButton,
  IonButtons,
  IonPage,
  IonHeader,
  IonToolbar,
  IonTitle,
  IonContent,
  IonCard,
  IonCardContent,
  IonCardHeader,
  IonCardSubtitle,
  IonCardTitle,
  IonItem,
  IonThumbnail,
  IonLabel,
  IonList,
  IonCheckbox,
  IonInput,
  alertController,
} from "@ionic/vue";

export default {
  data() {
    return {
      schedules: [
        {
          id: 1,
          period: "08h - 09h",
        },
        {
          id: 2,
          period: "09h - 10h",
        },
        {
          id: 3,
          period: "10h - 11h",
        },
        {
          id: 4,
          period: "11h - 12h",
        },
        {
          id: 5,
          period: "12h - 13h",
        },
        {
          id: 6,
          period: "13h - 14h",
        },
        {
          id: 7,
          period: "14h - 15h",
        },
        {
          id: 8,
          period: "15h - 16h",
        },
        {
          id: 9,
          period: "16h - 17h",
        },
        {
          id: 10,
          period: "17h - 18h",
        },
        {
          id: 11,
          period: "18h - 19h",
        },
        {
          id: 12,
          period: "19h - 20h",
        },
      ],
      selected: new Set(),
    };
  },
  components: {
    IonBackButton,
    IonButton,
    IonButtons,
    IonPage,
    IonHeader,
    IonToolbar,
    IonTitle,
    IonContent,
    IonCard,
    IonCardContent,
    IonCardHeader,
    IonCardSubtitle,
    IonCardTitle,
    IonItem,
    IonThumbnail,
    IonLabel,
    IonList,
    IonCheckbox,
    IonInput,
    alertController,
  },
  methods: {
    schedulePeriod() {
      const { id } = this.$route.params;

      const payload = {
        squad_id: parseInt(id),
        periods: Array.from(this.selected),
      };

      axios.post("", payload);
      this.showHelloToast("Horário(s) agendado(s) com sucesso!");
      this.$router.push('/tab1');
    },
    setPeriodTime($e: PointerEvent, id: number): void {
      if (this.has(id)) {
        this.selected.delete(id);
      } else {
        if (this.selected.size < 4) {
          this.selected.add(id);
        } else {
          this.presentAlert();

          $e!.target!.checked = false;
        }
      }
    },
    has(id: number): boolean {
      return this.selected.has(id);
    },
    async presentAlert() {
      const alert = await alertController.create({
        message: "Você pode marcar apenas 4 horários!",
        buttons: ["Fechar"],
      });

      await alert.present();
    },
    async showHelloToast(message: string) {
      await Toast.show({
        text: message,
        duration: "long",
        position: "top",
      });
    },
  },
};
</script>

<style scoped>
.btn-schedule {
  display: flex;
  justify-content: center;
  margin-top: 25px;
}

ion-button {
  width: 100%;
}
</style>
