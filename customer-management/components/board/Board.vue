<template>
  <div class="row pt-4" :key="boardRender">
    <div class="col-2" v-for="(list, index) in lists" :key="index">
      <List :list="list" @deleteList="updateBoard"></List>
    </div>
    <div class="col-2">
      <b-button v-b-modal="'add-list'" class="btn-add-list"
        ><span class="text-add-list mr-2">Add list</span></b-button
      >
        <!-- The modal -->
        <b-modal id="add-list" size="sm" title="Add list" v-model="addListDialog">
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
        </div>
  </div>
</template>

<script>
import List from "./List.vue";
import { fas } from "@fortawesome/free-solid-svg-icons";
export default {
  components: {
    List
  },
  methods: {
    createList(){
      let that = this;
      this.addListDialog = false;
      this.$axios.post('list/store', {name: this.listName, board_id: parseInt(this.boardId)}).then(async function(){
          await that.callApi();
          console.log('Before render board');
          that.reRenderBoard();
      });
    },

    reRenderBoard(){
      console.log('re render board');
      this.boardRender++;
    },

    callApi() {
      this.$axios.get('list/search/'+ this.boardId).then(resp => {
        this.lists = resp.data.data;
      })
    },

    async updateBoard() {
      await this.callApi();
      this.reRenderBoard();
    }
  },

  data() {
    return {
      lists: [],
      addListDialog: false,
      listName: '',
      boardRender: 0,
    };
  },
  props: {
    boardId: Number()
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

<!--Style -->
<style>
.row {
  width: 100%;
}
.col-2 {
  padding: 0 0 0 0.5rem;
}

.text-add-list {
  font-size: 32px;
}

.btn-add-list, .btn-add-list:hover {
  background: transparent;
  border: 2px solid gray;
}

.icon-add-list {
  width: 32px;
}

</style>
