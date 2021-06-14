<template>
  <div class="card" :key="listRender">
    <div class="row card-header">
      <p class="list-name">{{ list.name }}</p>
      <button-delete-list
        :listId="list.id"
        @deleteList="$emit('deleteList')"
      ></button-delete-list>
    </div>
    <div class="card-body">
      <draggable
        v-model="cards.array"
        class="card-group"
        group="card"
        @start="drag = true"
        @end="drag = false"
      >
        <div
          v-for="card in cards.array"
          :key="card.position"
          class="card-button"
        >
          <button-card :cardId="card.id" :cardName="card.name" @showCard="showCard=!showCard"></button-card>
          <Card
            :card="card"
            :showCard="showCard"
            @cardClosed="showCard = !showCard"
            @updateList="updateList"
          ></Card>
        </div>
      </draggable>
    </div>
    <b-button
      v-b-modal="`${list.id}`"
      class="btn btn-add-card"
      @click="showCardDialog = true"
      >Add card</b-button
    >
    <create-edit-card
      :showCardDialog="showCardDialog"
      @card-created="updateList"
      :cardAmount="cards.array.length"
      :listId="list.id"
      @closed="showCardDialog = false"
    ></create-edit-card>
  </div>
</template>
<script>
import Card from "../card/CardDialog.vue";
import CreateEditCard from "../card/CreateEditCard.vue";
import ButtonDeleteList from "./ButtonDeleteList.vue";
import ButtonCard from "../card/ButtonCard.vue";
import draggable from "vuedraggable";
import { fas } from "@fortawesome/free-solid-svg-icons";
export default {
  components: {
    Card,
    CreateEditCard,
    draggable,
    ButtonDeleteList,
    ButtonCard
  },
  props: {
    list: {
      id: 0,
      name: "",
      board_id: 0
    }
  },
  methods: {

    // gọi api sau đó sắp xếp lại cards theo position
    async getListData() {
      await this.$axios.get("card/search/" + this.list.id).then(resp => {
        this.cards.array = resp.data.data;
      });
    },

    reRenderList() {
      this.listRender++;
    },

    async updateList() {
      await this.getListData();
      this.reRenderList();
    },

    cardOrdered() {
      for (let i = 0; i < this.cards.array.length - 1; i++) {
        if (this.cards.array[i].position > this.card.array[i + 1].position) {
          return false;
        }
      }
      return true;
    }
  },
  data() {
    return {
      showCard: false,
      showCardDialog: false,
      cards: {
        array: [],
        list_id: this.list.id
      },
      cardSelected: {
        id: 0,
        name: "",
        description: "",
        position: 0,
        list_id: 0,
        user_id: 0,
        is_disabled: 1
      },
      listRender: 0
    };
  },

  mounted() {
    this.getListData();
  },

  beforeUpdate() {
    if (!this.cardOrdered())
      for (let i = 0; i < this.cards.array.length; i++) {
        this.cards.array[i].position = i;
        this.cards.array[i].list_id = this.cards.list_id;
        this.$axios.put(
          "card/update/" + this.cards.array[i].id,
          this.cards.array[i]
        );
      }
  },

  computed: {
    fas() {
      return fas;
    }
  }
};
</script>
<style>
.card {
  min-height: 30rem;
}
.card-body {
  background: #f7f7f7;
  padding: 10px;
}

.card-group {
  min-height: 2rem;
}

.btn {
  background-color: white;
  border: none;
  font-size: 14px;
  color: #000;
  text-align: left;
}

.btn:hover {
  background-color: #f0f0f1;
  color: #000;
}

.card-body {
  background: url("https://media.istockphoto.com/videos/background-wallpaper-rainbow-unicorn-video-id1160302447?s=640x640");
}

.row .card-header {
  margin: 0;
}

.list-name {
  width: 100%;
  font-size: 24px;
  font-weight: 600;
  text-align: center;
  line-height: 2rem;
  margin-top: auto;
  margin-bottom: auto;
}

.btn-add-card {
  width: 100%;
  text-align: center;
  font-size: 16px;
  font-weight: 500;
}

.add-card-modal-title {
  width: 100%;
}

.card-name-label {
  text-align: center;
}

.card-button {
  width: 100%;
}
</style>
