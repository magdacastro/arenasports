<template>
  <ion-content>
    <div>
      <div class="main-title">
        <ion-header>
          <ion-label>Meus Dados</ion-label>
        </ion-header>
      </div>
      <ion-list>
        <ion-item href="/tabs/tab1" button detail="true">
          <ion-label>
            <h3>Agendar um horário</h3>
            <p>Agende aqui um horário na quadra</p>
          </ion-label>
        </ion-item>
        <ion-item href="" button detail="true">
          <ion-label>
            <h3>Meus horários</h3>
            <p>Visualizar sua agenda de horários</p>
          </ion-label>
        </ion-item>
        <ion-item href="/tabs/tab1" button detail="true">
          <ion-label>
            <h3>Cancelar horário</h3>
            <p>Cancele um horário marcado da listagem</p>
          </ion-label>
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
