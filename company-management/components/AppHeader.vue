<template>
  <div class="row no-gutters app-header">
    <div class="col-2 d-flex justify-content-center">
      <router-link :to="`/home`">
      <img src="../assets/devfast-logo.png" alt="logo" class="logo d-flex justify-content-center">
      </router-link>
    </div>
    <div class="col-10">
      <span>Company Management</span>
    </div>
    <div class="col-12">
      <button class="btn btn-dark btn-log-out float-right mt-1" @click="logout" v-if="$auth.loggedIn==true"><span>Log out</span>
        </button>
    </div>
  </div>
</template>
<script>
export default {
  watch: {
  },
  methods: {
    async logout() {
        await this.$auth.logout().then(function() {
          location.replace('/login');
        });
    }
  },
}
</script>
<style>
  .app-header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background-color: #201e1e;
    height: 2.5rem;
    text-align: center;
    font-size: 20px;
    color: #fff;
    line-height: 2.5rem;
    z-index: 100;
  }

  .logo {
    height: 2.5rem;
    width: auto;
  }

  .col-12 {
    height: 2rem;
    background-color: lightblue;
  }

  .btn-log-out {
    height: 1.5rem;
    margin-top: -0.75rem;
    line-height: 0.5rem;
  }

  .user-info {
    color: #000;
    margin-top: -4px;
  }
</style>
