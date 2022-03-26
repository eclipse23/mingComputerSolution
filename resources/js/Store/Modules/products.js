export default {
    namespaced: true,
    state: {
        product: {},
        products: {},
        errors: [],
        pagination: {
            meta: {
                last_page: 1
            }
        }
    },
    getters: {
        product: state => state.product,
        products: state => state.products,
        errors: state => state.errors,
        pagination: state => state.pagination
    },
    mutations: {
        setProduct (state, payload) {
            state.product = payload
        },
        setProducts (state, payload) {
            state.products = payload
        },
        setErrors (state, payload) {
            state.errors = payload
        },
        setPagination (state, payload) {
            if (payload == {}) {
                state.pagination = {
                    meta: {
                        last_page: 1
                    }
                }
            } else {
                state.pagination = payload
            }
        },
    },
    actions: {
        async saveProduct ({ dispatch, commit }, payload = {}) {
            try {
                const response = await axios.post(`/product`, payload)
                .then( response => {
                    commit('setProducts', response.data)
                    commit('setPagination', response.data)
                    console.log(response)
                })
                commit('setErrors', {})
                return response
            } catch (error) {
                console.log(error)
            }
        },
        async updateStock ({ commit }, payload = {}) {
            try {
                const response = await axios.put(`/update-stock/${payload.form.id}`, payload.form)
                .then( response => {
                    commit('setProducts', response.data)
                    commit('setPagination', response.data)
                    console.log(response)
                })
                commit('setErrors', {})
                return response
            } catch (error) {
                console.log(error)
            }
        },
        async updateProduct ({ dispatch, commit }, payload = {}) {
            try {
                console.log(payload)
                const response = await axios.put(`/product/${payload.id}`, payload)
                .then( response => {
                    commit('setProducts', response.data)
                    commit('setPagination', response.data)
                });
                commit('setErrors', {})
                return response
            } catch (error) {
                console.log(error)
            }
        },
        async deleteCategory ({ commit }, payload = {}) {
            try {
                const response = await axios.delete(`/${payload.params}/category`).then( response => {
                    commit('setCategories', response.data)
                    commit('setPagination', response.data)
                })
                return response
            } catch (error) {
                return Promise.reject(error);
            }
        },
        async getCategory ({commit}, payload = {}) {
            await axios.delete(`/get-category`, {
                params: {
                    id: payload.id
                }
            })
            .then(response => {
                commit('setCategories', response.data.data)
            })
        },
        async getProducts ({commit}, payload = {}) {
            await axios.get(`/get-products`, {
                params: payload.params
            })
            .then(response => {
                commit('setProducts', response.data)
                commit('setPagination', response.data)
            })
        }
    }
}