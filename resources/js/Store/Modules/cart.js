export default {
    namespaced: true,
    state: {
        cart: 0
    },
    getters: {
        cart: state => state.cart
    },
    mutations: {
        setCart (state, payload) {
            state.cart = payload
        },
    },
    actions: {
        async getCart ({commit}, payload = {}) {
            await axios.get(`/my-cart`)
            .then(response => {
                commit('setCart', response.data.data.length)
            })
            console.log(this.state.cart.cart + 1);
        },
        async addCart({commit}, payload = {}) {
            console.log(this.state.cart.cart + 1);
            commit('setCart', this.state.cart.cart + 1)
        },
        async removeCart({commit}, payload = {}) {
            commit('setCart', this.state.cart.cart - 1)
        },
        async checkOut({commit}, payload = {}) {
            commit('setCart', 0)
        }
    }
}