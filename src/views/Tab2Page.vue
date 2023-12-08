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
          <ion-title>Favoritos</ion-title>
        </ion-toolbar>
      </ion-header>
      
    </ion-content>
  </ion-page>
</template>

<script lang="ts" setup>
import {
  IonBackButton,
  IonButtons,
  IonPage,
  IonHeader,
  IonToolbar,
  IonTitle,
  IonContent,
} from "@ionic/vue";


</script>

<style scoped>
ion-title {
  color: #4D4522;
  text-transform: uppercase;
  padding: 20px 16px;
  text-align: start;
}
</style>
