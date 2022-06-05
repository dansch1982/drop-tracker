<template>
	<nav class="nav">
		<ul class="nav__ul">
			<AppNavItem v-for="({ name }, index) in playerStore.players" :key="index" class="nav__ul__item" @click="scrollToPlayer($event, name)">
				<button class="nav__ul__item__button">
					{{ name }}
				</button>
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
		scrollToPlayer($event, name) {
			$event.target.blur();
			this.$emit("update:modelValue", !this.modelValue);
			this.$nextTick(() => {
				const element = document.querySelector(`[data-player='${name}']`);
				element.scrollIntoView({ block: "start" });
				const prev = document.querySelector(".bg-secondary-dark");
				if (prev) {
					prev.classList.remove("bg-secondary-dark", "text-underline");
				}
				const title = element.querySelector("h2");
				title.classList.add("bg-secondary-dark", "text-underline");
			});
		},
	},
	components: { AppNavItem },
	props: {
		modelValue: Boolean,
	},
};
</script>

<style lang="scss" scoped>
@import "@/assets/style/imports";
.nav {
	@media (min-width: $breakpoint-s) {
		display: grid !important;
	}
	&__ul {
		@include grid-container;
		justify-content: center;
		gap: 0.5em 1em;
		&__item {
			display: flex;
			&__button {
				z-index: 1;
				position: relative;
				flex-grow: 1;
				border: none;
				outline: none;
				@include name-plate;
				@include scale(1.025);
				transition: background-color 250ms;
				cursor: pointer;
				&:hover,
				&:focus {
					background-color: var(--color-secondary-dark);
				}
			}
		}
	}
}
</style>
