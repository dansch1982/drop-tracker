<template>
	<main class="main">
		<section class="main__grid">
			<AppMainCard v-for="({ name, items }, index) in playerStore.players" :key="index" class="main__grid__card" :data-player="name">
				<h2 class="main__grid__card__title">
					{{ name }}
				</h2>
				<section class="main__grid__card__items">
					<button v-for="(key, index) in Object.keys(items)" :key="index" class="main__grid__card__items__item" :style="`background-image: url(${getImage(items, key)})`" :class="items[key].have > 0 ? 'checked' : ''" @click="editItem($event, name, items, key)"></button>
				</section>
			</AppMainCard>
		</section>
	</main>
	<section class="overlay" @click.self="reset" ref="overlay">
		<section class="overlay__popup" ref="popup">
			<section class="overlay__popup__title">
				<h2 class="overlay__popup__title__name">{{ current.name }}</h2>
				<button class="overlay__popup__title__close" @click.self="reset">✖</button>
			</section>
			<section class="overlay__popup__item">
				<article class="overlay__popup__item__key">{{ formatName(current.key) }}</article>
				<select @change="changeSource($event)" class="overlay__popup__item__source" data-popup="source" id="source">
					<option v-for="(source, index) in playerStore.sources" :value="index" :key="index">{{ source }}</option>
				</select>
				<button :class="current.item.have > 0 ? 'checked overlay__popup__item__have' : 'overlay__popup__item__have'" @click="toggleHave"></button>
			</section>
		</section>
	</section>
</template>

<script>
import playerStore from "@/stores/players";
import AppMainCard from "./AppMainCard.vue";
export default {
	data() {
		return {
			playerStore,
			current: {},
			nullObject: {
				name: null,
				item: {
					source: null,
					key: null,
					have: null,
				},
			},
		};
	},
	created() {
		//playerStore.players.length = 0;
		const url = new URL("http://localhost/players");
		fetch(url)
			.then((data) => {
				if (data.status === 200) {
					return data.json();
				} else {
					return "[]";
				}
			})
			.then((json) => {
				const array = JSON.parse(json);
				array.forEach((element) => {
					const { id, name } = element;
					delete element.id;
					delete element.name;
					const items = {};
					Object.entries(element).forEach((item) => {
						const [prop, info] = item;
						items[prop] = playerStore.createItem(...Array.from(info.split(",")).map(item => parseInt(item)));
					});
					const player = {
						id,
						name,
						items,
					};
					playerStore.players.push(player);
				});
			});
	},
	beforeMount() {
		this.current = this.nullObject;
	},
	methods: {
		changeSource($event) {
			const { item } = this.current;
			item.source = parseInt($event.target.value);
		},
		toggleHave() {
			const { item } = this.current;
			item.have = 1 - item.have;
		},
		reset() {
			this.$refs.overlay.classList.remove("display-grid");
			this.current = this.nullObject;
		},
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
					src += `upgrade_${item}`;
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
		editItem($event, ...args) {
			if ($event.pointerId >= 1) {
				$event.target.blur();
			}
			const [name, items, key] = args;

			const item = items[key];
			this.current = {
				name,
				key: key,
				item,
			};
			const source = this.$refs.popup.querySelector("[data-popup='source']");
			[...source.childNodes].some((node) => {
				if (parseInt(node.value) === item.source) {
					return (source.value = node.value);
				}
			});
			this.$refs.overlay.classList.add("display-grid");
			this.$nextTick(() => {
				this.$refs.popup.classList.add("scale-1");
			});
		},
		formatName(string) {
			if (typeof string === "string") {
				return string.split("_").join(" ");
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
					display: flex;
					background-color: #d9d9d9;
					background-size: cover;
					aspect-ratio: 1;
					border-radius: 10px;
					overflow: hidden;
					border: none;
					outline: none;
					@include scale(1.05);
					transition: transform 50ms;
					cursor: pointer;
					&::before {
						position: absolute;
						content: "";
						height: 100%;
						width: 100%;
						box-shadow: inset 3px 3px 3px rgba($color: #000000, $alpha: 0.5);
					}
					&::after {
						position: absolute;
						content: "";
						top: 50%;
						left: 50%;
						transform: translate(-50%, -50%);
						background-color: greenyellow;
						transition: 200ms;
						width: 0%;
						aspect-ratio: 1;
						mask: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>') no-repeat center;
					}
				}
			}
		}
	}
}
.overlay {
	display: none;
	place-items: center;
	z-index: 10;
	position: fixed;
	top: 0;
	left: 0;
	bottom: 0;
	right: 0;
	background-color: rgba($color: #000000, $alpha: 0.5);
	&__popup {
		display: grid;
		gap: 1em;
		width: calc(100% - 2em);
		max-width: 400px;
		overflow: hidden;
		background-color: var(--color-bg);
		padding: 1em;
		&__title {
			display: flex;
			justify-content: space-between;
			gap: 1em;
			overflow: hidden;
			&__name {
				text-align: center;
				flex: 1;
				padding: 0.5rem 0.25em;
				overflow: hidden;
				font-size: 2rem;
				white-space: nowrap;
				text-overflow: ellipsis;
			}
			&__close {
				padding: 0.5rem 0.25em;
				margin-left: auto;
				background-color: unset;
				border: none;
				font-size: 1.5rem;
				cursor: pointer;
				transition: transform 100ms;
				@include scale(1.2);
			}
		}
		&__item {
			margin: auto;
			display: grid;
			gap: 1em;
			max-width: 25ch;
			width: 100%;

			&__key {
				font-size: 1.5rem;
				text-transform: capitalize;
				text-align: center;
			}
			&__source {
				outline: none;
				padding: 0.5em 1em;
				border-radius: 0;
				width: 100%;
				margin: auto;
				text-transform: capitalize;
			}
			&__have {
				position: relative;
				display: flex;
				justify-content: center;
				align-items: center;
				gap: 1em;
				border: none;
				outline: none;
				background-color: unset;
				cursor: pointer;
				font-size: 1rem;
				width: 2em;
				aspect-ratio: 1;
				border: 2px solid black;
				background-color: var(--color-primary);
				&::before {
					position: absolute;
					left: calc(100% + 1em);
					content: "Have";
					display: block;
				}
				&::after {
					position: absolute;
					top: 50%;
					left: 50%;
					transform: translate(-50%, -50%);
					content: "";
					display: block;
					aspect-ratio: 1;
					background-color: greenyellow;
					width: 0;
					transition: 200ms;
					mask: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>') no-repeat center;
				}
			}
		}
	}
}
</style>
