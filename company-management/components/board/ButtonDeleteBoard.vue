<template>
  <button
    class="float-right btn-delete-board"
    @click="deleteBoard(boardId)"
  >
    <fa :icon="fas.faTrash" />
  </button>
</template>
<script>
import { fas } from "@fortawesome/free-solid-svg-icons";
export default {
  methods: {
    async deleteBoard(boardId) {
      await this.$axios.delete(
        `board/destroy/${this.$auth.user.id}/${boardId}`
      );
      this.$emit("board-deleted");
    }
  },
  props: {
    boardId: Number
  },

  computed: {
    fas() {
      return fas;
    }
  }
};
</script>
<style>
.btn-delete-board {
  margin-top: -7rem;
  background-color: transparent;
  border-radius: 10px;
  height: 2.25rem;
  border: none;
}
</style>
