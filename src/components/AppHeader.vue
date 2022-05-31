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
@import "@/assets/style/imports";
.header {
	display: flex;
	flex-direction: column;
	gap: 1em;
	padding: 1em;
	background-color: var(--color-primary);
	color: whitesmoke;
	@media (max-width: $breakpoint-s) {
		gap: 0;
	}
	&__title {
		text-align: center;
		font-size: 2rem;
	}
}
</style>
