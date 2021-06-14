<template>
  <b-button
    class="btn w-100 my-1 card-group"
    v-b-modal="`${cardId}`"
    :empty-insert-threshold="500"
    @click="$emit('showCard')"
  >
    {{ cardName }}
  </b-button>
</template>
<script>
export default {
  props: {
    cardId: Number,
    cardName: String
  },

}
</script>
