<template>
  <b-modal id="create-board" size="sm" title="Create Board" v-model="showBoardDialog">
    <label for="board-title">Board title</label><br />
    <input
      type="text"
      name=""
      id="board-title"
      class="form-control"
      v-model="boardName"
    />
    <template #modal-footer>
      <div class="w-100">
        <button
          class="btn btn-success center"
          variant="primary"
          @click="createBoard"
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
    async createBoard() {
      this.showBoardDialog = false;
      this.$axios.post('board/store/' + this.$auth.user.id, {name: this.boardName})
      this.$emit('board-created');
    },
  },
  props: {
    createBoardDialog: Boolean
  },
  data () {
    return {
      boardName: '',
      showBoardDialog: false
    }
  },

  watch: {
    createBoardDialog: function() {
      this.showBoardDialog = this.createBoardDialog
    }
  }

}
</script>
