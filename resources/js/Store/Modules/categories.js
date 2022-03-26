export default {
    namespaced: true,
    state: {
        category: {},
        categories: {},
        errors: [],
        pagination: {
            meta: {
                last_page: 1
            }
        }
    },
    getters: {
        category: state => state.category,
        categories: state => state.categories,
        errors: state => state.errors,
        pagination: state => state.pagination
    },
    mutations: {
        setCategory (state, payload) {
            state.category = payload
        },
        setCategories (state, payload) {
            state.categories = payload
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
        async saveCategory ({ dispatch, commit }, payload = {}) {
            try {
                const response = await axios.post(`/category`, payload)
                .then( response => {
                    commit('setCategories', response.data)
                    commit('setPagination', response.data)
                })
                commit('setErrors', {})
                return response
            } catch (error) {
                console.log(error)
            }
        },
        async updateCategory ({ dispatch, commit }, payload = {}) {
            try {
                const response = await axios.put(`/category/${payload.params}`, {name: payload.name})
                .then( response => {
                    commit('setCategories', response.data)
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
        async getCategories ({commit}, payload = {}) {
            await axios.get(`/get-categories`, {
                params: payload.params
            })
            .then(response => {
                console.log('getCategory',response)
                commit('setCategories', response.data)
                commit('setPagination', response.data)
            })
        }
    }
}