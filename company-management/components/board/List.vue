<template>
  <div class="card" :key="listRender">
    <div class="row card-header">
      <p class="list-name">{{ list.name }}</p>
      <button class="btn float-right btn-delete-list" @click="deleteList"><fa :icon="fas.faTrash"/></button>
    </div>
    <div class="card-body">
      <draggable
        v-model="cards.array"
        class="card-group"
        group="card"
        @start="drag = true"
        @end="drag = false"
      >
        <b-button
          @click="chooseCard(card)"
          class="btn w-100 my-1 card-group"
          v-for="card in cards.array"
          :key="card.position"
          v-b-modal="card.id"
          :empty-insert-threshold="500"
        >
          {{ card.name }}
        </b-button>
        <Card
          :card="cardSelected"
          :showCard="showCard"
          @cardClosed="showCard = !showCard"
          :comments="comments"
          @updateList="updateList"
        ></Card>
      </draggable>
    </div>
    <b-button class="btn btn-add-card" @click="showDialog = true">Add card</b-button>
    <b-modal size="sm" title="Add Card" v-model="showDialog" class="add-card-modal-title">
      <label for="card-title" class="card-name-label">Card name</label><br />
      <input
        type="text"
        name=""
        id="card-title"
        class="form-control"
        v-model="cardName"
      />
      <label for="card-des">Card description</label><br />
      <textarea
        name=""
        id="card-des"
        cols="35"
        rows="4"
        v-model="cardDes"
      ></textarea>
      <template #modal-footer>
        <div class="w-100">
          <button
            class="btn btn-success center"
            variant="primary"
            @click="createCard"
          >
            Submit
          </button>
        </div>
      </template>
    </b-modal>
  </div>
</template>
<script>
import Card from "./Card.vue";
import draggable from "vuedraggable";
import { fas } from "@fortawesome/free-solid-svg-icons";
export default {
  props: {
    list: {
      id: 0,
      name: "",
      board_id: 0
    }
  },
  methods: {

    // sau khi tạo card mới thì lấy api và render lại card
    async createCard() {
      let that = this;
      that.showDialog = false;
      await that.$axios.post("card/store", {
        name: that.cardName,
        description: that.cardDes,
        position: that.cards.array.length,
        list_id: parseInt(that.list.id),
        user_id: parseInt(1)
      }).then(async function(){
        await that.callApi();
        console.log('Before render');
        that.reRenderList();
      });

    },

    chooseCard(card) {
      this.showCard = !this.showCard;
      this.cardSelected = card;
      this.$axios.get("comment/search/" + card.id).then(resp => {
        this.comments = resp.data.data;
      });
    },

    deleteList() {
      let that = this;
      let softDeletedList = this.list;
      softDeletedList.is_disabled = 1;
      this.$axios.put("list/update/" + softDeletedList.id, softDeletedList).then(async function() {
        await that.$emit('deleteList');
        console.log('Delete list');
      });

    },

    // gọi api sau đó sắp xếp lại cards theo position
    callApi() {
      this.$axios.get("card/search/" + this.list.id).then(resp => {
        this.cards.array = resp.data.data;
        this.cards.array.sort(function(a, b) {
          return a.position - b.position;
        });
      });
    },

    reRenderList(){
      this.listRender++;
    },

    async updateList() {
      await this.callApi();
      this.reRenderList();
    }
  },
  components: {
    Card,
    draggable
  },
  data() {
    return {
      showCard: false,
      showDialog: false,
      cards: {
        array: [],
        list_id: this.list.id
      },
      cardName: "",
      cardDes: "",
      cardSelected: {
        id: 0,
        name: "",
        description: "",
        list_id: "",
        user_id: "",
        is_disabled: 1
      },
      comments: [],
      listRender: 0,
    };
  },

  mounted() {
    this.callApi();
  },

  beforeUpdate() {
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
  },
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

.btn-delete-list{
  position: absolute;
  top: 0;
  right: 0;
  background: transparent;
}

.list-name {
  width: 100%;
  font-size: 24px;
  font-weight: 600;
  text-align: center;
  line-height: 2rem;
  margin-top:auto;
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
</style>
