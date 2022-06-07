<template>
<div class="app">
	<AppHeader />
  <AppMain />
  <AppFooter />
</div>
</template>

<script>
import AppHeader from "./components/AppHeader.vue";
import AppMain from "./components/AppMain.vue";
import AppFooter from "./components/AppFooter.vue";
export default {
	components: { AppHeader, AppMain, AppFooter },
};
</script>

<style lang="scss">
@import "@/assets/style/imports";
.app {
  width: 100vw;
  height: 100vh;
  display: grid;
  grid-template-rows: max-content auto 2em;
  overflow: hidden;
}
</style>
