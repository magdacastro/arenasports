<template>
  <ion-content>
    <div>
      <div class="main-title">
        <ion-header>
          <ion-label>Meus Dados</ion-label>
        </ion-header>
      </div>
      <ion-list>
        <ion-item href="/tabs/create" button detail="true">
          <ion-label>
            <h3>Cadastrar produto</h3>
            <p>Cadastre aqui algo interessante</p>
          </ion-label>
        </ion-item>
        <ion-item href="/tabs/tab1?action=destroy" button detail="true">
          <ion-label>
            <h3>Remover produto</h3>
            <p>Remova o produto da listagem</p>
          </ion-label>
        </ion-item>
      </ion-list>
    </div>
    <div>
      <div class="main-title">
        <ion-header>
          <ion-label>Notificações</ion-label>
        </ion-header>
      </div>
      <ion-list>
        <ion-item>
          <ion-toggle :checked="false">Alerta de promoções</ion-toggle>
        </ion-item>
        <ion-item>
          <ion-toggle :checked="false">Alerta de produtos novos</ion-toggle>
        </ion-item>
        <ion-item>
          <ion-toggle :checked="false">Impulsionar publicações</ion-toggle>
        </ion-item>
      </ion-list>
    </div>
  </ion-content>
</template>

<script lang="ts">
import {
  IonContent,
  IonTitle,
  IonHeader,
  IonToggle,
  IonItem,
  IonList,
  IonLabel,
} from "@ionic/vue";
import { defineComponent } from "vue";

export default defineComponent({
  components: {
    IonToggle,
    IonItem,
    IonHeader,
    IonTitle,
    IonList,
    IonContent,
    IonLabel,
  },
});
</script>

<style scoped>
ion-toggle {
  display: flex;
}

ion-label {
  padding: 0px 16px 0px 16px;
  text-align: start;
  color: #998d53;
}

.main-title {
  margin: 15px 0px 15px 0px;
}
</style>
