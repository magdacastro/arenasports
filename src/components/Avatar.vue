<template>
  <ion-item>
    <ion-avatar>
      <img
        alt="Silhouette of a person's head"
        src="https://ionicframework.com/docs/img/demos/avatar.svg"
      />
    </ion-avatar>
    <ion-label>{{ name }}</ion-label>
  </ion-item>
  <ion-item>
    <ion-label>{{ phone }}</ion-label>
  </ion-item>
    <ion-item>
    <ion-label>{{ email }}</ion-label>
  </ion-item>
  <ion-item>
    <ion-label>Forma de Pagamento Padrão: {{ payment }}</ion-label>
  </ion-item>
</template>

<script lang="ts">
import { IonAvatar, IonItem, IonLabel } from "@ionic/vue";
import { defineComponent } from "vue";

export default defineComponent({
  data() {
    return {
      name: "Joana Doe",
      phone: "(51) 9 9999-3099",
      email: "joanadoe@gmail.com",
      payment: "Pix",
    };
  },
  components: { IonAvatar, IonItem, IonLabel },
});
</script>

<style scoped>
ion-label {
  padding: 0px 10px 0px 10px;
}
</style>
