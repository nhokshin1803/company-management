<template>
  <div class="row pt-4" :key="boardRender">
    <div class="col-2" v-for="(list, index) in lists" :key="index">
      <List :list="list" @deleteList="updateBoard"></List>
    </div>
    <div class="col-2">

      <button-create-list></button-create-list>

      <!-- The modal -->
      <create-edit-list :createListDialog="createListDialog" :boardId="parseInt(boardId)" @list-created="updateBoard"></create-edit-list>
    </div>
  </div>
</template>

<script>
import List from "../list/List.vue";
import CreateEditList from "../list/CreateEditList.vue";
import ButtonCreateList from "../list/ButtonCreateList.vue";
import { fas } from "@fortawesome/free-solid-svg-icons";
export default {
  components: {
    List,
    CreateEditList,
    ButtonCreateList
  },
  methods: {
    reRenderBoard(){
      console.log('re render board');
      this.boardRender++;
    },

    getBoardData() {
      this.$axios.get('list/search/'+ this.boardId).then(resp => {
        this.lists = resp.data.data;
      })
    },

    async updateBoard() {
      await this.getBoardData();
      this.reRenderBoard();
    }
  },

  data() {
    return {
      lists: [],
      createListDialog: false,
      listName: '',
      boardRender: 0,
    };
  },
  props: {
    boardId: Number()
  },

  mounted() {
    this.getBoardData();
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
