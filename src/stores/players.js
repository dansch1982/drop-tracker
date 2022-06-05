import { reactive } from "vue";

const store = reactive({
	players: [],
});

for (let i = 0; i < 8; i++) {
	const item = (source, have, side) => ({
		source,
		have,
		side,
	});
	const weapon = item(1, 0, 0);
	const head = item(2, 0, 0);
	const body = item(1, 1, 0);
	const hands = item(2, 1, 0);
	const legs = item(1, 0, 0);
	const feet = item(0, 0, 0);
	const shield = item(1, 0, 1);
	const earrings = item(2, 0, 1);
	const necklace = item(1, 1, 1);
	const bracelets = item(2, 1, 1);
	const right_ring = item(1, 0, 1);
	const left_ring = item(0, 0, 1);

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
}

export default store;
