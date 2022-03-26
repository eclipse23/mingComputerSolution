import { createStore } from "vuex"

import category from "./Modules/categories"
import product from "./Modules/products"
import cart from "./Modules/cart"

const store = createStore({
    modules: {
        category,
        product,
        cart
    },
    state:{
        name: "Vue"
    }
})

export default store