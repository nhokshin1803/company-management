<template>
  <b-modal :id="String(listId)" size="sm" title="Create Card" class="add-card-modal-title" v-model="showThisDialog" @hide="$emit('closed')">
      <label for="card-title" class="card-name-label">Card name</label><br />
      <input
        type="text"
        name=""
        id="card-title"
        class="form-control"
        v-model="cardName"
      />
      <label for="card-des">Card description</label><br />
      <textarea
        name=""
        id="card-des"
        cols="35"
        rows="4"
        v-model="cardDes"
      ></textarea>
      <template #modal-footer>
        <div class="w-100">
          <button
            class="btn btn-success center"
            variant="primary"
            @click="createCard"
          >
            Submit
          </button>
        </div>
      </template>
    </b-modal>
</template>
<script>
export default {
  data () {
    return {
      cardName: '',
      cardDes: '',
      showThisDialog: false
    }
  },
  methods: {
    async createCard() {
      this.showDialog = false;
      await this.$axios.post("card/store", {
        name: that.cardName,
        description: that.cardDes,
        position: that.cardAmount,
        list_id: parseInt(that.listId),
        user_id: parseInt(this.$auth.user.id)
      });
      this.$emit('card-created');
    },
  },
  props: {
    cardAmount: Number,
    listId: Number,
    showCardDialog: Boolean
  },

  watch: {
    showCardDialog: function() {
      this.showThisDialog = this.showCardDialog;
    }
  }


}
</script>
