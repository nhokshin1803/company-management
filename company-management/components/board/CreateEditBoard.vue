<template>
  <b-modal id="create-board" size="sm" title="Create Board" v-model="createBoardDialog">
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
      let that = this;
      await that.$axios.post('board/store', {name: that.boardName}).then(async function(){
        await that.$axios.get('board/last').then(async function(resp) {
          await that.$axios.post('userboard/store', {user_id: that.$auth.user.id, board_id: resp.data.data.id});
          that.$emit('board-created');
        })
      });
    },
  },
  props: {
    createBoardDialog: Boolean
  },
  data () {
    return {
      boardName: ''
    }
  },

}
</script>
