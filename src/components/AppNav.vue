<template>
	<nav class="nav">
		<input type="checkbox" id="menu-toggler" class="nav__checkbox" hidden />
		<label class="nav__hamburger" for="menu-toggler"></label>
		<ul class="nav__ul">
			<AppNavItem v-for="(player, index) in playerStore.players" :key="index" class="nav__ul__item">
				<a :href="'#' + index" class="nav__ul__item__link">
					{{ player }}
				</a>
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
	components: { AppNavItem },
};
</script>

<style lang="scss" scoped>
@import "@/assets/style/imports";
$smallBreakpoint: 468px;
.nav {
	display: flex;
	flex-direction: column;
	gap: 1em;
	&__hamburger {
		margin: auto;
		display: none;
		transition: 200ms;
		cursor: pointer;
		@include scale(1.5);
		@media (max-width: $smallBreakpoint) {
			display: block;
		}
		&:hover::before,
		&:hover::after {
			background: $secondary-color-dark;
		}
		&::before,
		&::after {
			content: "";
			width: 40px;
			aspect-ratio: 1;
			background: $secondary-color;
		}
		&::before {
			display: block;
			mask: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>') no-repeat center;
		}
		&::after {
			display: none;
			mask: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="200%" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 9 6 15"></polyline></svg>') no-repeat center;
		}
	}
	&__checkbox:checked ~ .nav__hamburger::before {
		display: none;
	}
	&__checkbox:checked ~ .nav__hamburger::after {
		display: block;
	}
	&__checkbox:checked ~ .nav__ul {
		display: grid;
	}
	&__ul {
		$itemWidth: 15ch;
		display: grid;
		grid-template-columns: repeat(auto-fit, $itemWidth);
		justify-content: center;
		gap: 0.5em 1em;
		@media (max-width: $smallBreakpoint) {
			display: none;
		}
		&__item {
			display: flex;
			&__link {
				background-color: $secondary-color;
				padding: 0.5em 1em;
				height: 100%;
				width: 100%;
				text-align: center;
				text-decoration: none;
				color: black;
				transition: transform 50ms;
				outline: none;
				@include shadow;
				@include scale(1.025);
				&:hover,
				&:focus {
					background-color: $secondary-color-dark;
				}
			}
		}
	}
}
</style>
