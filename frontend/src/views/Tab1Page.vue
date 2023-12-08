<template>
  <ion-page>
    <ion-header>
      <ion-toolbar>
        <ion-title>
          <img src="../../public/images/logo/arenasports.svg" />
        </ion-title>
      </ion-toolbar>
    </ion-header>
    <ion-content :fullscreen="true">
      <ion-header collapse="condense">
        <ion-toolbar>
          <ion-title>Quadras de Esportes</ion-title>
        </ion-toolbar>
      </ion-header>
      <SportsFacilities />
    </ion-content>
  </ion-page>
</template>

<script lang="ts">
import { IonPage, IonHeader, IonToolbar, IonTitle, IonContent } from "@ionic/vue";
import SportsFacilities from "@/components/SportsFacilities.vue";
export default {
  components: {
    IonPage,
    IonHeader,
    IonToolbar,
    IonTitle,
    IonContent,
    SportsFacilities,
  },
  data() {
    return {
      action: "index",
    };
  },
  ionViewWillEnter() {
    const token = window.localStorage.token;

    const interval = setInterval(() => {
      if (!token) {
        this.$router.push("/tabs/auth/register");
      }

      clearInterval(interval);
    }, 100);
  },
  created() {
    const { action } = this.$route.query;

    if (typeof action === "string") {
      this.action = action;
    }
  },
};
</script>

<style scoped>
ion-title {
  color: #4d4522;
  text-transform: uppercase;
  padding: 20px 16px;
  text-align: start;
}
</style>
