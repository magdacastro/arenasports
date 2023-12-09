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
            <p>Dezembro</p>
          </div>
        </ion-toolbar>
      </ion-header>
      <ion-content>
        <ion-list>
          <ion-item>
            <ion-select
              @ionChange="getInformationFromStorage()"
              v-model="date"
              label="Dia"
            >
              <ion-select-option v-for="day in fillArrayOfDays()" :key="day">{{
                day
              }}</ion-select-option>
            </ion-select>
          </ion-item>
        </ion-list>
        <ion-list v-for="period in periods" :key="period.id">
          <ion-item @click.prevent="($e) => setPeriodTime($e, period.id)">
            <ion-checkbox
              slot="start"
              aria-label="Task name"
              :checked="has(period.id)"
            ></ion-checkbox>
            <ion-label>{{ period.time }}</ion-label>
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
import axios from "@/services/axios";
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
  IonSelect,
  IonSelectOption,
  IonItem,
  IonThumbnail,
  IonLabel,
  IonList,
  IonCheckbox,
  IonInput,
  alertController,
} from "@ionic/vue";

type Period = {
  id: number;
  time: string;
  created_at: string;
  updated_at: string;
};

export default {
  data() {
    return {
      periods: [] as Period[],
      selected: new Set(),
      date: "",
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
    IonSelect,
    IonSelectOption,
    IonItem,
    IonThumbnail,
    IonLabel,
    IonList,
    IonCheckbox,
    IonInput,
    alertController,
  },
  created() {
    axios
      .get("v1/periods")
      .then(({ data: { data } }: { data: { data: Period[] } }) => {
        this.periods = data;
      })
      .catch((error) => {
        console.log(error);
      });
  },
  methods: {
    schedulePeriod() {
      const { id } = this.$route.params;
      const payload = {
        squad_id: parseInt(id),
        periods: Array.from(this.selected),
        date: this.date,
      };
      const schedulesText = window.localStorage.schedules;
      const schedules = schedulesText ? JSON.parse(schedulesText) : [];
      const exists = schedules.find((schedule) => schedule.date === this.date);

      if (exists) {
        const updatedSchedules = schedules.map((schedule) => {
          if (schedule.date === payload.date) {
            schedule = payload;
          }

          return schedule;
        });

        window.localStorage.setItem(
          "schedules",
          JSON.stringify(updatedSchedules)
        );
      } else {
        schedules.push(payload);

        window.localStorage.setItem("schedules", JSON.stringify(schedules));
      }
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
    fillArrayOfDays() {
      function getLastDayOfMonth(year: number, month: number) {
        return new Date(year, month + 1, 0).getDate();
      }

      function formatDate(date: Date) {
        const day = date.getDate().toString().padStart(2, "0");
        const month = (date.getMonth() + 1).toString().padStart(2, "0");
        const year = date.getFullYear();
        return `${day}-${month}-${year}`;
      }

      function generateDateArray() {
        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth();
        const lastDayOfMonth = getLastDayOfMonth(currentYear, currentMonth);

        const dateArray = [];

        for (let day = currentDate.getDate(); day <= lastDayOfMonth; day++) {
          const currentDate = new Date(currentYear, currentMonth, day);
          dateArray.push(formatDate(currentDate));
        }

        return dateArray;
      }

      return generateDateArray();
    },
    getInformationFromStorage() {
      const schedulesText = window.localStorage.schedules;

      if (schedulesText) {
        const schedules = JSON.parse(schedulesText);

        const todaySchedules = schedules.find(
          (schedule) => schedule.date === this.date
        );

        if (todaySchedules) {
          this.selected = new Set(todaySchedules.periods);
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
