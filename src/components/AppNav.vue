<template>
	<nav class="nav">
		<input type="checkbox" id="menu-toggler" class="nav__checkbox" hidden />
		<label class="nav__hamburger" for="menu-toggler"></label>
		<ul class="nav__ul">
			<AppNavItem v-for="({ name }, index) in playerStore.players" :key="index" class="nav__ul__item" @click="scrollToPlayer(name)">
				<label for="menu-toggler" class="nav__ul__item__label">
					{{ name }}
				</label>
			</AppNavItem>
		</ul>
	</nav>
</template>

<script>
import playerStore from "@/stores/players";
import AppNavItem from "./AppNavItem.vue";
export default {
	data() {
		return {
			playerStore,
		};
	},
	methods: {
		scrollToPlayer(name) {
			const element = document.querySelector(`[data-player='${name}']`);
			element.scrollIntoView({ block: "center" });
			const prev = document.querySelector(".bg-secondary-dark");
			if (prev) {
				prev.classList.remove("bg-secondary-dark", "text-underline");
			}
			const title = element.querySelector("h2");
			title.classList.add("bg-secondary-dark", "text-underline");
		},
	},
	components: { AppNavItem },
};
</script>

<style lang="scss" scoped>
@import "@/assets/style/imports";
.nav {
	display: flex;
	flex-direction: column;
	gap: 1em;
	&__hamburger {
		position: fixed;
		top: 1em;
		right: 1em;
		margin: auto;
		display: none;
		width: 40px;
		aspect-ratio: 1;
		transition: transform 100ms;
		border: 5px solid var(--color-primary);
		background: var(--color-secondary);
		mask: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="12" x2="20" y2="12"></line><line x1="4" y1="6" x2="20" y2="6"></line><line x1="4" y1="18" x2="20" y2="18"></line></svg>') no-repeat center;
		cursor: pointer;
		@include scale(1.2);
		@media (max-width: $breakpoint-s) {
			display: block;
		}
		&:hover {
			background: var(--color-secondary-dark);
		}
	}
	&__checkbox:checked ~ .nav__hamburger {
		mask: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>') no-repeat center;
	}
	&__checkbox:checked ~ .nav__ul {
		display: grid;
	}
	&__ul {
		@include grid-container;
		justify-content: center;
		gap: 0.5em 1em;
		@media (max-width: $breakpoint-s) {
			display: none;
			margin-top: 1em;
		}
		&__item {
			display: flex;
			&__label {
				z-index: 1;
				position: relative;
				flex-grow: 1;
				@include name-plate;
				transition: background-color 250ms;
				&:hover {
					background-color: var(--color-secondary-dark);
				}
			}
		}
	}
}
</style>
