<template>
  <div class="board-container">
    <!-- Start header of home page-->
    <div class="row">
      <h1 class="ml-2 mr-3">My boards</h1>

      <!-- Start create board feature -->
      <button-create-board></button-create-board>
      <!-- Dialog create board -->
      <div>
        <create-edit-board
          :createBoardDialog="createBoardDialog"
          @board-created="updatePage"
        ></create-edit-board>
      </div>
      <!-- End create board feature -->

    </div>
    <!-- End header of home page-->

    <div class="no-board text-white" v-if="boards.length <= 0">
      <p class="text-no-board">You don't have any board</p>
    </div>

    <!-- Start boards display -->
    <div class="row" :key="renderPage">
      <div
        class="col-2 mt-3 mr-3"
        v-for="board in boards"
        :key="board.id"
      >
        <div class="text-center board">
          <nuxt-link :to="`/board/${board.id}`" class="link">
            <div>
              <span class="board-name">{{ board.name }}</span>
            </div>
          </nuxt-link>
        </div>
        <button-delete-board :boardId="board.id" @board-deleted="updatePage"></button-delete-board>
      </div>
    </div>
    <!-- End boards display -->
  </div>
</template>

<script>
import { fas } from "@fortawesome/free-solid-svg-icons";
import CreateEditBoard from "../components/board/CreateEditBoard.vue";
import ButtonCreateBoard from "../components/board/ButtonCreateBoard.vue";
import ButtonDeleteBoard from "../components/board/ButtonDeleteBoard.vue";
export default {
  components: {
    CreateEditBoard,
    ButtonCreateBoard,
    ButtonDeleteBoard
  },
  methods:
  {
    async getPageData() {
      let that = this;
      that.boards = [];
      await this.$axios.get("board/search/" + this.$auth.user.id).then(resp => {
        console.log(resp.data.data);
        that.boards = resp.data.data;
      })
    },

    async updatePage() {
      await this.getPageData();
      this.createBoardDialog = false;
      this.renderPage++;
    }
  },
  data() {
    return {
      boards: [],
      createBoardDialog: false,
      renderPage: 0
    };
  },

  mounted() {
    this.getPageData();
  },

  computed: {
    fas() {
      return fas;
    }
  }
};
</script>

<style>
.board {
  height: 7rem;
  line-height: 7rem;
  border-radius: 10px;
  background: url("https://sackim.com/wp-content/uploads/2020/01/21.jpg");
}
.board-container {
  padding: 0 5rem;
}

.board-name {
  color: #000;
  font-weight: 600;
  font-size: 32px;
}

.link:hover {
  text-decoration: none;
}

.text-no-board {
  font-size: 16px;
}

</style>
