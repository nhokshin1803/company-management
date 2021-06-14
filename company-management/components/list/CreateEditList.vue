<template>
  <b-modal id="create-list" size="sm" title="Create list" v-model="createListDialog">
    <label for="board-title">List name</label><br />
    <input
      type="text"
      name=""
      id="board-title"
      class="form-control"
      v-model="listName"
    />
    <template #modal-footer>
      <div class="w-100">
        <button
          class="btn btn-success center"
          variant="primary"
          @click="createList"
        >
          Submit
        </button>
      </div>
    </template>
  </b-modal>
</template>
<script>
export default {
  methods: {
    createList(){
      this.createListDialog = false;
      this.$axios.post('list/store', {name: this.listName, board_id: parseInt(this.boardId)});
      this.$emit('list-created');
    },
  },
  data () {
    return {
      listName: ''
    }
  },
  props: {
    createListDialog: Boolean,
    boardId: Number,
  }
}
</script>
