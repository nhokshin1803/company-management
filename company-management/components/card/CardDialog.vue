<template>
  <div :key="renderCard">
    <!--Start card dialogue shown when click card in list-->
    <b-modal size="lg" v-model="isShowCard" @hide="$emit('cardClosed')">
      <template #modal-title>
        <div class="modal-title">
          {{ card.name }}
          <button
            @click="deleteCard"
            class="btn float-right btn-delete-card pb-1"
          >
            <fa :icon="fas.faTrash" />
          </button>
        </div>
      </template>
      <div>
        <div><h6>Description</h6></div>
        <div>
          <p>{{ card.description }}</p>
        </div>
      </div>
      <template #modal-footer class="footer">
        <div class="new-comment row">
          <img src="" alt="" class="comment-img col-1" />
          <input
            type="text"
            v-model="newComment"
            @keyup.enter="createNewComment"
            class="col-11 comment-text"
            placeholder="Viết bình luận...."
          />
        </div>
        <div class="comment row">
          <div v-for="comment in comments" :key="comment.id">
            <Comment :comment="comment" @comment-deleted="updateCard"></Comment>
          </div>
        </div>
      </template>
    </b-modal>
    <!--End card dialogue shown when click card in list-->
  </div>
</template>
<script>
import { fas } from "@fortawesome/free-solid-svg-icons";
import Comment from "../comment/Comment.vue";
export default {
  components: {
    Comment
  },
  data() {
    return {
      comments: [],
      newComment: "",
      isShowCard: false,
      renderCard: 0
    };
  },
  props: {
    showCard: Boolean,
    card: {}
  },

  mounted() {
    this.$emit("showcardchange", this.showCard);
    this.getCardData();
  },

  methods: {
    async createNewComment() {
      await this.$axios.post("comment/store", {
        detail: this.newComment,
        card_id: parseInt(this.card.id),
        user_id: this.$auth.user.id
      });
      this.newComment = "";
    },

    async deleteCard() {
      await this.$axios.delete("card/destroy/" + this.card.id);
      this.$emit("updateList");
      this.isShowCard = false;
    },

    async getCardData() {
      await this.$axios.get("comment/search/" + this.card.id).then(resp => {
        this.comments = resp.data.data;
      });
    },

    async updateCard() {
      await this.getCardData();
      this.renderCard++;
    }
  },

  watch: {
    showCard() {
      this.isShowCard = this.showCard;
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
.comment-img {
  width: 1rem;
  height: 1rem;
}

.footer {
  background-color: #000;
}

.modal-title {
  width: 100%;
}
</style>
