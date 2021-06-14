<template>

</template>

<script>

export default {
  auth: false,
  created() {
    if(!this.$auth.loggedIn) this.$router.push('/login');
    this.$router.push('/home')
  }
}
</script>
