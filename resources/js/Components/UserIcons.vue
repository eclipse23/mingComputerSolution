<template>
    <a href="/orders" type="button" class="text-white hover:text-gray-300 group p-3 rounded-md flex flex-col items-center text-xs font-medium">
        <span class="sr-only">orders</span>
        <span class="relative inline-block">
            <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            <span v-if="order > 0" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-indigo-600 rounded-full">!</span>
        </span>
        <p class="text-xs">Orders</p>
    </a>
    <a href="/messages" type="button" class="text-white hover:text-gray-300 group  p-3 rounded-md flex flex-col items-center text-xs font-medium">
        <span class="sr-only">Queries</span>
        <span class="relative inline-block">
            <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
            <span v-if="message > 0" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-indigo-600 rounded-full">!</span>
        </span>
        <p class="text-xs">Queries</p>
    </a>
    <a href="/cart-items" type="button" class="text-white hover:text-gray-300 group p-3 rounded-md flex flex-col items-center text-xs font-medium">
        <span class="sr-only">Cart</span>
        <span class="relative inline-block">
            <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
            <span v-if="cart" class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-indigo-600 rounded-full">{{ cart }}</span>
        </span>
        <p class="text-xs">Cart</p>
    </a>
</template>

<script>
    import { mapGetters } from 'vuex';

    export default {
        data() {
            return {
                notificationValues: null,
                message: 0,
                order: 0
            }
        },
        computed: {
        ...mapGetters({
                cart: 'cart/cart'
            }),
        },
        methods: {
            connect(id) {
                window.Echo.join(`notifyuser${this.app.current_user.id}`)
                .listen('UserNotification', e => {
                    this.getUserNotification()
                })
            },
            async getUserNotification() {
                await axios.get('/get-notification')
                .then(response => {
                    this.message = response.data.message
                    this.order = response.data.order
                })
            },
            async cartCount() {
                await this.$store.dispatch('cart/getCart')
            }
        },
        created() {
            this.cartCount()
            this.getUserNotification()
            this.connect()
        }
    }
</script>