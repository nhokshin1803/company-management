<template>
  <div class="board-container">
    <div class="row">
      <h1 class="ml-2 mr-3">My boards</h1>
      <b-button class="btn-new-board" v-b-modal="'create-board'">
        New board
        <fa :icon="fas.faPlus"></fa>
      </b-button>
      <div>
        <!-- The modal -->
        <b-modal id="create-board" size="sm" title="Add Board" v-model="show">
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
      </div>
    </div>
    <div class="no-board" v-if="!boards">
      <p class="text-no-board">You don't have any board</p>
    </div>
    <div class="row" :key="listBoard">
      <div
        class="col-2 mt-3 mr-3"
        v-for="(board,index) in boards"
        :key="board.id"
      >
        <div class="text-center board">
          <nuxt-link :to="`/board/${board.id}`" class="link">
            <div>
              <span class="board-name">{{ board.name }}</span>
            </div>
          </nuxt-link>

        </div>
        <button class="float-right btn-delete-board" @click="deleteBoard(board,index)">
          <fa :icon="fas.faTrash"/>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { fas } from "@fortawesome/free-solid-svg-icons";
export default {
  methods: {
    async createBoard() {
      this.show = false;
      let that = this;
      await that.$axios.post('board/store', {name: that.boardName}).then(async function(){
        await that.$axios.get('board/last').then(async function(resp) {
          await that.$axios.post('userboard/store', {user_id: that.$auth.user.id, board_id: resp.data.data.id}).then(async function(){
            await that.callApi().then(function() {
              that.listBoard++;
            });
          });
        })
      });
    },

    deleteBoard(board,index) {
      this.boards.splice(index, 1);
      let softdeletedBoard = board;
      softdeletedBoard.is_disabled = 1;
      this.$axios.put('board/update/' + board.id, softdeletedBoard);
      this.$axios.delete(`userboard/destroy/${this.$auth.user.id}/${board.id}`);
    },

    async callApi() {
      let that = this;
      that.boards = [];
      await this.$axios.get("userboard/" + this.$auth.user.id).then(resp => {
        for(let i = 0; i < resp.data.length; i++) {
          that.$axios.get('board/search/' + resp.data[i].board_id).then(resp => {
            if(resp.data.data[0]) that.boards.push(resp.data.data[0]);
          })
        }
      });
    }
  },
  data() {
    return {
      boards: [],
      show: false,
      boardName: "",
      listBoard: 0,
    };
  },

  mounted() {
    this.callApi();
  },

  computed: {
    fas() {
      return fas;
    }
  },

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

.btn-new-board {
  /* background: transparent; */
  line-height: 1.5rem;
  background-color: transparent !important;
}

.btn-delete-board {
  margin-top: -7rem;
  background-color: transparent;
  border-radius: 10px;
  height: 2.25rem;
  border: none;
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
