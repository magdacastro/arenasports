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
          <ion-title>Perfil</ion-title>
        </ion-toolbar>
      </ion-header>
      <Avatar />
      <Settings />
    </ion-content>
  </ion-page>
</template>

<script setup lang="ts">
import {
  IonPage,
  IonHeader,
  IonToolbar,
  IonTitle,
  IonContent,
  IonItem,
  IonLabel,
} from "@ionic/vue";
import Avatar from "@/components/Avatar.vue";
import Settings from "@/components/Settings.vue";

</script>

<style scoped>
ion-title {
  color: #4d4522;
  text-transform: uppercase;
  padding: 20px 16px;
  text-align: start;
}

.Profile {
  height: 25%;
} 

.Settings {
  height: 25%;
}
</style>
