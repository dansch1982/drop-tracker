import { reactive } from "vue";

const store = reactive({
	players: [],
	sources: ["none", "raid", "tome"],
	createItem(source, have, side) {
		return {
			source,
			have,
			side,
		};
	},
});

/* for (let i = 0; i < 8; i++) {
	const item = (source, have, side) => ({
		source,
		have,
		side,
	});
	const weapon = item(0, 0, 0);
	const head = item(0, 0, 0);
	const body = item(0, 0, 0);
	const hands = item(0, 0, 0);
	const legs = item(0, 0, 0);
	const feet = item(0, 0, 0);
	const shield = item(0, 0, 0);
	const earrings = item(0, 0, 0);
	const necklace = item(0, 0, 0);
	const bracelets = item(0, 0, 0);
	const right_ring = item(0, 0, 0);
	const left_ring = item(0, 0, 0);

	store.players.push({
		name: `Player Player ${i + 1}`,
		items: {
			weapon,
			head,
			body,
			hands,
			legs,
			feet,
			shield,
			earrings,
			necklace,
			bracelets,
			right_ring,
			left_ring,
		},
	});
} */

export default store;
