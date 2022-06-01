<template>
	<main class="main">
		<section class="main__grid">
			<AppMainCard v-for="({ name, items }, index) in playerStore.players" :key="index" class="main__grid__card" :data-player="name">
				<h2 class="main__grid__card__title">
					{{ name }}
				</h2>
				<section class="main__grid__card__items">
					<article v-for="(key, index) in Object.keys(items)" :key="index" class="main__grid__card__items__item" :style="`background-image: url(${getImage(items, key)})`" :class="items[key].have > 0 ? 'checked' : ''"></article>
				</section>
			</AppMainCard>
		</section>
	</main>
</template>

<script>
import playerStore from "@/stores/players";
import AppMainCard from "./AppMainCard.vue";
export default {
	data() {
		return {
			playerStore,
		};
	},
	methods: {
		getImage(items, key) {
			const item = key.split("_").pop();
			let src = "";
			switch (items[key].source) {
				case 0:
					src += item;
					break;
				case 1:
					src += `coffer_${item}`;
					break;
				case 2:
					src += `upgrade_${items[key].side === 0 ? "left" : "right"}`;
					break;
				default:
					break;
			}
			src += ".png";
			try {
				return require("@/assets/images/" + src);
			} catch (error) {
				return "";
			}
		},
	},
	components: { AppMainCard },
};
</script>

<style lang="scss" scoped>
@import "@/assets/style/imports";
.main {
	background-color: var(--color-bg);
	overflow: auto;
	&__grid {
		@include grid-container;
		justify-content: center;
		padding: 1em;
		gap: 3em;
		&__card {
			display: flex;
			flex-direction: column;
			gap: 1em;
			&__title {
				@include name-plate;
				flex-grow: 1;
				pointer-events: none;
				transition: background-color 250ms;
			}
			&__items {
				display: grid;
				grid-template-columns: repeat(2, 1fr);
				grid-template-rows: repeat(6, 1fr);
				grid-auto-flow: column;
				gap: 1em;
				width: 100%;
				&__item {
					position: relative;
					background-color: #d9d9d9;
					background-size: cover;
					aspect-ratio: 1;
					border-radius: 10px;
					overflow: hidden;
					border-radius: 10px;
					&::before {
						position: absolute;
						content: "";
						height: 100%;
						width: 100%;
						box-shadow: inset 3px 3px 3px rgba($color: #000000, $alpha: 0.5);
					}
				}
			}
		}
	}
}
</style>
