<template>
  <button class="btn float-right btn-delete-list" @click="deleteList">
    <fa :icon="fas.faTrash" />
  </button>
</template>
<script>
import { fas } from "@fortawesome/free-solid-svg-icons";
export default {
  props: {
    listId: Number
  },
  methods: {
    async deleteList() {
      await this.$axios.delete("list/destroy/" + this.listId);
      this.$emit('deleteList');
    },
  },

  computed: {
    fas() {
      return fas;
    }
  }
}
</script>
<style>
  .btn-delete-list{
  position: absolute;
  top: 0;
  right: 0;
  background: transparent;
}
</style>
