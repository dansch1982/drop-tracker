<template>
<section class="app">
	<AppHeader />
  <AppMain />
</section>
</template>

<script>
import AppHeader from "./components/AppHeader.vue";
import AppMain from "./components/AppMain.vue";
export default {
	components: { AppHeader, AppMain },
};
</script>

<style lang="scss">
@import "@/assets/style/imports";
.app {
  width: 100vw;
  height: 100vh;
  display: grid;
  grid-template-rows: max-content auto;
  overflow: hidden;
}
</style>
