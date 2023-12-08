<template>
  <div class="ion-padding">
    <ion-row>
      <ion-col v-for="squad in squads" :key="squad.id" size="6">
        <ion-item :href="buildLink(squad)" button detail="false">
          <img :src="squad.image" alt="Squad Image" />
          <ion-label>{{ squad.category }}</ion-label>
        </ion-item>
      </ion-col>
    </ion-row>
  </div>
</template>

<script lang="ts">
import { IonItem, IonCol, IonRow, IonLabel } from "@ionic/vue";
import { defineComponent } from "vue";
import axios from "@/services/axios";

type Squad = {
  id: number;
  image: string;
  category: string;
};

export default {
  data() {
    return {
      squads: [] as Squad[],
    };
  },
  components: {
    IonItem,
    IonCol,
    IonRow,
    IonLabel,
  },
  created() {
    axios.get("v1/squads").then(({ data: { data } }: { data: { data: Squad[] } }) => {
      this.squads = data;
    });
  },
  methods: {
    buildLink(squad: Squad) {
      return `/tabs/schedule/${squad.id}`;
    },
  },
};
</script>
