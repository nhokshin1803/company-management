<template>
  <div>
    <img src="" alt="" class="comment-img col-1" />
    <p class="col-11">
      {{ comment.detail }}
      <button class="btn" @click="deleteComment">
        <fa :icon="fas.faTrash" />
      </button>
    </p>
  </div>
</template>
<script>
import { fas } from "@fortawesome/free-solid-svg-icons";
export default {
  props: {
    comment: {}
  },
  methods: {
    deleteComment() {
      this.$axios.delete("comment/destroy/" + this.comment.id);
      this.$emit("comment-deleted");
    }
  },

  computed: {
    fas() {
      return fas;
    }
  }
};
</script>
