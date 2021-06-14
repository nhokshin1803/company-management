<template>
  <div>
    <b-modal size="lg" v-model="isShowCard" @hide="$emit('cardClosed')">
      <template #modal-title>
        <div class="modal-title">
          {{ card.name }}
          <button @click="deleteCard" class="btn float-right btn-delete-card pb-1">
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
            <img src="" alt="" class="comment-img col-1" />
            <p class="col-11">
              {{ comment.detail }}
              <button @click="deleteComment(comment)">Delete</button>
            </p>
          </div>
        </div>
      </template>
    </b-modal>
  </div>
</template>
<script>
import { fas } from "@fortawesome/free-solid-svg-icons";
export default {

  data() {
    return {
      newComment: "",
      isShowCard: false
    };
  },
  props: {
    showCard: Boolean,
    card: {},
    comments: []
  },

  mounted() {
    this.$emit("showcardchange", this.showCard);
  },

  methods: {
    createNewComment() {
      this.comments.push({
        detail: this.newComment,
        card_id: parseInt(this.card.id)
      });
      this.$axios
        .post("comment/store", {
          detail: this.newComment,
          card_id: parseInt(this.card.id),
          user_id: parseInt(1)
        })
        .then(function() {
          this.newComment = "";
        });
    },

    deleteCard() {
      let that = this;
      let disabledCard = this.card;
      disabledCard.is_disabled = 1;
      this.$axios.put("card/update/" + this.card.id, disabledCard);
      this.$emit('updateList');
      console.log('updateList');
      this.isShowCard = false;
    },

    deleteComment(comment) {
      let disabledComment = comment;
      disabledComment.is_disabled = 1;
      this.$axios.put("comment/update/" + comment.id, disabledComment);
      setTimeout(function() {
        location.reload();
      }, 200);
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
  },
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
