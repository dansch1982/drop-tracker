import { reactive } from "vue";

const store = reactive({
	players: [

	],
});

for (let i = 0; i < 8; i++) {
    store.players.push(
        {
			name: `Player ${i+1}`,
			items: {
				weapon: {
					source: 0,
					have: 0,
					side: 0,
				},
				head: {
					source: 0,
					have: 0,
					side: 0,
				},
				body: {
					source: 1,
					have: 1,
					side: 0,
				},
				hands: {
					source: 2,
					have: 0,
					side: 0,
				},
				legs: {
					source: 1,
					have: 0,
					side: 0,
				},
				feet: {
					source: 1,
					have: 0,
					side: 0,
				},
				shield: {
					source: 1,
					have: 0,
					side: 0,
				},
				earrings: {
					source: 0,
					have: 0,
					side: 1,
				},
				necklace: {
					source: 1,
					have: 0,
					side: 1,
				},
				bracelets: {
					source: 2,
					have: 0,
					side: 1,
				},
				right_ring: {
					source: 1,
					have: 0,
					side: 1,
				},
				left_ring: {
					source: 2,
					have: 0,
					side: 1,
				},
			},
		},
    )
}

export default store;
