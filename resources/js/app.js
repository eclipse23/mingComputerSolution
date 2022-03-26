require('./bootstrap')

import { createApp } from "vue";
import store from "./store/store";
import { global } from './mixins';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import 'vue3-carousel/dist/carousel.css';

import Products from './Components/Products/Products'
import Categories from './Components/Categories/Categories'
import ProductGrid from './Components/Products/ProductGrid'
import ProductDetail from './Components/Products/ProductDetail'
import CartItems from './Components/Checkout/CartItems'
import Messages from './Components/Message/Messages'
import Orders from './Components/Orders/Orders'
import CustomerOrders from './Components/Orders/CustomerOrders'
import Cashier from './Components/Cashier/Cashier'
import Report from './Components/Reports/Reports'
import Settings from './Components/Settings'
import ChangePassword from './Components/ChangePassword'
import UserIcons from './Components/UserIcons'
import Inventory from './Components/Inventory'
import Welcome from './Components/Welcome'
import Epayment from './Components/Epayment'
import UserRegistration from './Components/Registration'
import OrderIcon from './Components/OrderIcon'
import SearchBar from './Components/SearchBar'

const app = createApp({
    store,
    components: {
        Products,
        Categories,
        ProductGrid,
        ProductDetail,
        CartItems,
        Messages,
        Orders,
        CustomerOrders,
        Cashier,
        Report,
        Settings,
        ChangePassword,
        UserIcons,
        Inventory,
        Welcome,
        Epayment,
        UserRegistration,
        OrderIcon,
        SearchBar
    }
})
app.mixin(global)

app.use(store)
.use(VueSweetalert2)
.mount("#app")

document.addEventListener('DOMContentLoaded', () => {
    // const navMenu = document.querySelector('#nav-menu')
    const navSubMenu = document.querySelector('#nav-sub-menu')
    const hamburger = document.querySelector('#hamburger')
    const mobileMenu = document.querySelector('#mobile-menu')
    const mobileUserMenu = document.querySelector('#mobile-user-menu')
    const userMenuButton = document.querySelector('#user-menu-button')
    const userMenu = document.querySelector('#user-menu')
  
    if (hamburger) {
        hamburger.addEventListener('click', () => {
            // navMenu.classList.toggle('hidden')
            navSubMenu.classList.toggle('hidden')
        })
    }

    if (mobileUserMenu) {
        mobileUserMenu.addEventListener('click', () => {
            // navMenu.classList.toggle('hidden')
            mobileMenu.classList.toggle('hidden')
        })
    }

    if (userMenuButton) {
        userMenuButton.addEventListener('click', () => {
            // navMenu.classList.toggle('hidden')
            userMenu.classList.toggle('hidden')
        })
    }
})