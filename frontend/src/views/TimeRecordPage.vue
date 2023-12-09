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
            <h1>Dados do Agendamento</h1>
          </div>
        </ion-toolbar>
      </ion-header>
      <ion-content v-if="date">
        <TimeRecord :date="date" :squad_id="squad_id" />
      </ion-content>
    </ion-content>
  </ion-page>
</template>

<script lang="ts">
import axios from "axios";
import { Toast } from "@capacitor/toast";
import TimeRecord from "@/components/TimeRecord.vue";

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
      date: null,
      squad_id: null,
    };
  },
  created() {
    const { date, squad_id } = this.$route.query;

    this.squad_id = parseInt(squad_id);
    this.date = date;
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
    TimeRecord,
  },
};
</script>
