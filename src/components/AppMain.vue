<template>
	<main class="main">
		<section class="main__grid">
			<AppMainCard v-for="({ name, items }, index) in playerStore.players" :key="index" class="main__grid__card">
				<h2 class="main__grid__card__title">
					{{ name }}
				</h2>

				<section class="main__grid__card__items">
					<article v-for="(key, index) in Object.keys(items)" :key="index" class="main__grid__card__items__item" :style="`background-image: url(${getImage(items, key)})`"></article>
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
						display: block;
						top: 0;
						height: 100%;
						width: 100%;
						box-shadow: inset 3px 3px 3px rgba($color: #000000, $alpha: 0.5);
					}
					&::after {
						position: absolute;
                        top:50%;
                        left:50%;
                        transform: translate(-50%, -50%);
						background-color: greenyellow;
						width: 80%;
						height: 80%;
						content: "";
						mask: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>') no-repeat center;
					}
				}
			}
		}
	}
}
</style>
