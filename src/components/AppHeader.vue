<template>
	<header class="header">
		<h1 class="header__title">Drop Tracker</h1>
		<AppNav />
	</header>
</template>

<script>
import AppNav from "./AppNav.vue";
export default { components: { AppNav } };
</script>

<style lang="scss" scoped>
.header {
	display: flex;
	flex-direction: column;
	gap: 1em;
	padding: 1em;
	background-color: #4e598c;
	color: whitesmoke;
	&__title {
		text-align: center;
        font-size: 2rem;
	}
}
</style>
