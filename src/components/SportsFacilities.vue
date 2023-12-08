<template>
  <div class="ion-padding">
    <ion-row>
      <ion-col v-for="squad in squads" :key="squad.id" size="6">
        <ion-item :href="buildLink(squad)" button detail="false">
          <img :src="squad.img" />
          <ion-label>{{ squad.text }}</ion-label>
        </ion-item>
      </ion-col>
    </ion-row>
  </div>
</template>

<script lang="ts">
import { IonItem, IonCol, IonRow, IonLabel } from "@ionic/vue";
import { defineComponent } from "vue";

type Squad = {
    id: number,
    img: string,
    text: string,
};

const squads: Squad[] = [
  {
    id: 1,
    img: "https://images.pexels.com/photos/11644798/pexels-photo-11644798.jpeg?auto=compress&cs=tinysrgb&w=600",
    text: "Futebol",
  },
  {
    id: 2,
    img: "https://images.pexels.com/photos/8858493/pexels-photo-8858493.jpeg?auto=compress&cs=tinysrgb&w=600",
    text: "Basquete",
  },
  {
    id: 3,
    img: "https://images.pexels.com/photos/17460018/pexels-photo-17460018/free-photo-of-exercicio-praticando-atividade-fisica-partida-jogo.jpeg?auto=compress&cs=tinysrgb&w=600",
    text: "Vôlei",
  },
  {
    id: 4,
    img: "https://images.pexels.com/photos/16639180/pexels-photo-16639180/free-photo-of-vista-traseira-tribunal-corte-de-justica-quadra.jpeg?auto=compress&cs=tinysrgb&w=600",
    text: "Tênis",
  },
];

export default {
  data() {
    return {
      squads,
    };
  },
  components: {
    IonItem,
    IonCol,
    IonRow,
    IonLabel,
  },
  methods: {
    buildLink(squad: Squad) {
      return `/tabs/schedule/${squad.id}`;
    },
  },
};
</script>
