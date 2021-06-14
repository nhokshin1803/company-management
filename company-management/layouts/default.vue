<template>
  <div class="layout">
    <app-header></app-header>
    <app-footer></app-footer>
    <Nuxt class="app"/>
  </div>
</template>
<script>
import AppHeader from '../components/AppHeader';
import AppFooter from '../components/AppFooter';
export default {
  methods: {
  },
  components: {
    AppHeader,
    AppFooter
  }
}
</script>
<style>

.app {
  position: relative;
  left: 0;
  top: 4.5rem;
  background-image: url("https://mondaycareer.com/wp-content/uploads/2020/11/background-%C4%91%E1%BA%B9p-3-1024x682.jpg");
  height: calc(100vh - 88px);
}
</style>
