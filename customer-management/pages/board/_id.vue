<template>
  <div class="board-container">
    <Board :boardId="boardId"></Board>
  </div>
</template>
<script>
import Board from '../../components/board/Board.vue'
export default {
  components: {
    Board
  },
  data () {
    return {
      boardId: this.$route.params.id
    }
  },

}
</script>
<style>
  .board-container {
    margin: 0;
    padding-left: 1rem;
  }
</style>
