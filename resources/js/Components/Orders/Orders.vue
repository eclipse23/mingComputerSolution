s<template>
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <loading :isLoading="isLoading"></loading>
        <items-modal :datas="items" :isOpen="isOpen" :totalPrice="totalPrice" @closeModal="isOpen = false"/>
        <div class="bg-white px-4 pb-5 border-b border-gray-200 sm:px-6">
            <div class="-ml-4 pt-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="flex-1 flex items-center justify-start lg:ml-6">
                    <div class="max-w-lg w-full lg:max-w-xs mx-2">
                        <label for="search" class="sr-only">Search</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <!-- Heroicon name: solid/search -->
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                            </div>
                            <input v-model="search" id="search" name="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" placeholder="Search" type="search">
                        </div>
                    </div>
                    <div class="max-w-lg w-full lg:max-w-xs mx-2">
                        <label for="search" class="sr-only">Search</label>
                        <div class="relative">
                            <select v-model="paymentMethod" id="search" name="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" placeholder="Search">
                                <option value="">Method</option>
                                <option value="e-payment">E-Payment</option>
                                <option value="pick-up">Pick-Up</option>
                                <option value="walk-in">Walk In</option>
                            </select>
                        </div>
                    </div>
                    <div class="max-w-lg w-full lg:max-w-xs mx-2">
                        <label for="search" class="sr-only">Status</label>
                        <div class="relative">
                            <select v-model="status" id="search" name="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" placeholder="Search">
                                <option value="">Status</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="processing">Processing</option>
                                <option value="ready for pick-up">Ready for Pick-Up</option>
                                <option value="Sold">Sold</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="ml-4 mt-2 flex-shrink-0">

                </div>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buyer</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Odd row -->
                            <tr v-for="order in orders" :key="order" class="bg-white">
                                <td @click="openModal(order)" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ order.id }}</td>
                                <td @click="openModal(order)" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 capitalize">{{ order.sold_to }}</td>
                                <td @click="openModal(order)" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 capitalize">{{ order.method }}</td>
                                <td @click="openModal(order)" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 capitalize">
                                    <span v-if="order.status === 'cancelled'" class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">Cancelled</span>
                                    <span v-if="order.status === 'processing'" class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-red-100 bg-blue-600 rounded-full">Processing</span>
                                    <span v-if="order.status === 'ready for pick-up'" class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-red-100 bg-blue-600 rounded-full">Ready for Pick-up</span>
                                    <span v-if="order.status === 'Sold'" class="inline-flex items-center justify-center px-2 py-1 mr-2 text-xs font-bold leading-none text-red-100 bg-green-600 rounded-full">Sold</span>
                                </td>
                                <td @click="openModal(order)" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₱ {{ calculateTotal(order.orders)}}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button v-if="checkStatus(order.status)" @click="changeStatus(order)" href="#" class="bg-orange-600 hover:bg-orange-300 text-white font-bold py-2 px-4 rounded">{{ buttonLabel(order) }}</button>
                                </td>
                            </tr>

                            <!-- More people... -->
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Loading from '../LoadingSpinner.vue';
    import ItemsModal from './Modals/ItemsModal.vue'
    import debounce from 'lodash/debounce'

    export default {
        components: {
            Loading,
            ItemsModal
        },
        data() {
            return {
                items: {},
                isLoading: false,
                orders: [],
                isOpen: false,
                search: "",
                paymentMethod: '',
                totalPrice: 0,
                status: ""
            }
        },
        watch: {
            search: debounce(function(newVal){
                this.getOrders()
            }, 200),
            paymentMethod: debounce(function(newVal){
                this.getOrders()
            }, 200),
            status: debounce(function(newVal){
                this.getOrders()
            }, 200),
        },
        methods: {
            checkStatus(status) {
                if(status === "Sold") {
                    return false
                } else {
                    if(status === "cancelled") {
                        return false
                    } else {
                        return true
                    }
                }
            },  
            buttonLabel(order) {
                if(order.status == "processing") {
                    return "Mark as Ready for Pick Up"
                }
                if(order.status == "ready for pick-up") {
                    return "Mark as Sold"
                }
            },
            async changeStatus(order) {
                this.isLoading = true
                if(order.status == "processing") {
                    var status = "ready for pick-up"
                }
                if(order.status == "ready for pick-up") {
                    var status = "Sold"
                }

                await axios.put(`/cart-change-status/${order.id}`, {
                    status: status
                }).then(response => {
                    this.orders = response.data.data
                    this.isLoading = false
                })
            },
            calculateTotal(items) {
                const total = Object.values(items).reduce((t, {product, quantity}) => t + (parseFloat(product.price)*quantity), 0)
                return this.formatPrice(total)
            },
            async getOrders() {
                this.isLoading = true
                await axios.get('/all-orders', {
                    params: {
                        search: this.search,
                        paymentMethod: this.paymentMethod,
                        status: this.status
                    }
                })
                .then(response => {
                    this.orders = response.data.data
                    this.isLoading = false
                });
            },
            openModal(cart) {
                console.log(cart)
                this.isOpen = true
                this.items = cart
                this.totalPrice = this.calculateTotal(cart.orders)
            }
        },
        created() {
            this.getOrders()
        }
    }
</script>