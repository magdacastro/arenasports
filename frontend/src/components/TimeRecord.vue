<template>
  <div class="ion-padding">
    <ion-row>
      <ion-col size="6">
        <ion-label>Horário(s):</ion-label>
        <ion-item v-for="period in periods" :key="period.id" detail="false">
          <ion-label>{{ period.hour }}</ion-label>
        </ion-item>
      </ion-col>
      <ion-col size="6">
        <ion-item detail="false">
          <ion-label>Preço por hora: R$ 100,00</ion-label>
        </ion-item>
        <ion-item detail="false">
          <ion-label
            >Preço Total: R$ {{ moneyFormat.format(getSum()) }}
          </ion-label>
        </ion-item>
        <ion-item detail="false">
          <ion-label
            >Você tem até dia "" para cancelar sua reserva gratuitamente. Após esta data, será necessário pagamento.
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
import { IonItem, IonCol, IonRow, IonLabel, alertController } from "@ionic/vue";
import { defineComponent } from "vue";
import { Toast } from "@capacitor/toast";

export default {
  data() {
    return {
      periods: [
        { id: 1, hour: "12h - 13h" },
        { id: 2, hour: "13h - 14h" },
        { id: 3, hour: "14h - 15h" },
      ],
      moneyFormat: new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL",
      }),
    };
  },
  methods: {
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
        message: "Esteja no local na hora marcada! Caso contrário, será cobrado juros de sua conta.",
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
             /* axios.post().then((response) => {
                if (response.status === 204) {
                  this.showHelloToast("Agendado com sucesso");
                }
              });*/
            },
          },
        ],
      });

      await confirm.present();
    },
  },
  components: {
    IonItem,
    IonCol,
    IonRow,
    IonLabel,
  },
};
</script>
