<template>
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <loading :isLoading="isLoading"></loading>
        <div class="bg-white px-4 pb-5 border-b border-gray-200 sm:px-6">
            <div class="-ml-4 pt-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                <div class="flex-1 flex items-center justify-start lg:ml-6">
                    <div class="max-w-lg w-full lg:max-w-xs">
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
                </div>
            </div>
        </div>
        <ul role="list" class="divide-y divide-gray-200">
            <li v-for="product in products.data" :key="product" @click="addToCart(product)">
                <div class="block hover:bg-gray-50">
                    <div class="px-4 py-4 sm:px-6">
                    <div class="flex items-center justify-between">
                        <div class="flex">
                            <p class="mr-2 text-sm font-bold text-orange-600 truncate">
                                {{ product.name }}
                            </p>
                            <img v-if="product.hot_deal" src="https://img.icons8.com/ios-glyphs/20/000000/hot-price--v1.png"/>
                        </div>
                        <div class="ml-2">
                            <p v-if="product.stock > 0" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                {{ product.stock }} Stock Left
                            </p>
                            <p v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Out of stock
                            </p>
                        </div>
                    </div>
                    <div class="mt-2 sm:flex sm:justify-between">
                        <div class="sm:flex">
                            <p class="flex items-center text-sm text-gray-500">
                                Price: <span class="text-gray-700 font-bold">{{ ` ₱  ${formatPrice(product.price)}` }}</span>
                            </p>
                            <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                Sold: <span class="text-gray-700 font-bold">{{ product.sold }}</span>
                            </p>
                            </div>
                            <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                            <!-- Heroicon name: solid/calendar -->
                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    </div>
                </div>
            </li>
        </ul>
        <paginate
            :pagination="pagination"
            @paginate="getProducts"
            :offset="4"
        />
        </div>
</template>
<script>
import { mapGetters } from 'vuex';
import Loading from "../LoadingSpinner.vue"
import debounce from 'lodash/debounce'
import Paginate from '../Pagination.vue';

export default {
    props: {
        refreshProduct: Boolean
    },
    components: {
        Paginate,
        Loading,
    },
    data() {
        return {
            title: 'test',
            isLoading: false,
            isOpen: false,
            product: null,
            search: '',
            page: 1, 
        }
    },
    computed: {
        ...mapGetters({
            products: 'product/products',
            pagination: 'product/pagination'
        }),
    },
    watch: {
        search: debounce(function(newVal){
            if(newVal != '') {
                this.getProducts()
            }
        }, 200),
        refreshProduct: function(newVal) {
           this.getProducts() 
        }
    },
    methods: {
        connect(id) {
            window.Echo.join(`updateproduct`)
            .listen('UpateProduct', e => {
                //this.getProducts(this.page)
            })
        },
        addToCart(product) {
            this.$emit('addToCart', product)
        },
        async getProducts(page) {
            this.isLoading = true;
            this.page = page
            await this.$store.dispatch('product/getProducts', {
                params: {
                    page: page,
                    search: this.search
                }
            }).then(() => {
                this.isLoading = false;
            });
        }
    },
    created() {
         this.connect()   
    }
}
</script>
