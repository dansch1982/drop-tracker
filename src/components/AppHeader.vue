<template>
	<header class="header">
		<section class="header__title">
			<h1 class="header__title__h1">Drop Tracker</h1>
			<button class="header__title__toggler" @click="toggleMenu($event)" :data-toggled="showMenu" ref="toggler"></button>
		</section>
		<AppNav v-model="showMenu" :style="`display:${showMenu === true ? 'grid' : 'none'}`" />
	</header>
</template>

<script>
import AppNav from "./AppNav.vue";
export default {
	data() {
		return {
			showMenu: false,
		};
	},
	methods: {
		toggleMenu($event) {
			$event.target.blur();
			this.showMenu = !this.showMenu;
		},
	},
	components: { AppNav },
};
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
	&__title {
		display: flex;
		align-items: center;
		&__h1 {
			flex: 1;
			text-align: center;
			font-size: 2rem;
			padding-bottom: 4px;
		}
		&__toggler {
			display: none;
			height: 2rem;
			aspect-ratio: 1;
			transition: transform 100ms;
			background: var(--color-secondary);
			border: none;
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
		&__toggler[data-toggled="true"] {
			mask: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>') no-repeat center;
		}
	}
}
</style>
