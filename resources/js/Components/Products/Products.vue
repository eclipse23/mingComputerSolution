<template>
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <loading :isLoading="isLoading"></loading>
        <edit-product-modal :isOpen="isOpen" :product="product" @closeModal="isOpen = false" @reload="getProducts(1)"></edit-product-modal>
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
                    <div class="max-w-lg w-full lg:max-w-xs mx-2">
                        <label for="search" class="sr-only">Search</label>
                        <div class="relative">
                            <select v-model="category" id="search" name="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" placeholder="Search">
                                <option value="">Categories</option>
                                <option v-for="category in categories" :key="category" :value="category.id">{{ category.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="max-w-lg w-full lg:max-w-xs mx-2">
                        <label for="search" class="sr-only">Search</label>
                        <div class="relative">
                            <select v-model="sortBy" id="search" name="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" placeholder="Search">
                                <option value="">Sort By</option>
                                <option value="name_asc">Name: A-Z</option>
                                <option value="name_desc">Name: Z-A</option>
                                <option value="price_asc">Price: High to Low</option>
                                <option value="price_desc">Price: Low to High</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="ml-4 mt-2 flex-shrink-0">
                    <product-modal></product-modal>
                </div>
            </div>
        </div>
        <ul role="list" class="divide-y divide-gray-200">
            <li v-for="product in products.data" :key="product" @click="editProduct(product)">
                <div class="block hover:bg-gray-50">
                    <div class="px-4 py-4 sm:px-6">
                    <div class="flex items-center justify-between">
                        <div class="flex">
                            <p class="mr-2 text-sm font-bold text-indigo-600 truncate">
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
                            </p><br>
                            <div class="flex justify-end mt-2">
                                <button @click="confirmUpdateStock(product, 'minus')" type="button" class="mr-5 inline-flex items-center p-1 border border-transparent rounded-full shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <!-- Heroicon name: solid/plus-sm -->
                                    <svg viewBox="0 0 24 24" class="h-3 w-3" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                </button>
                                <button @click="confirmUpdateStock(product, 'add')" type="button" class="inline-flex items-center p-1 border border-transparent rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <!-- Heroicon name: solid/plus-sm -->
                                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 sm:flex sm:justify-between">
                        <div class="sm:flex">
                        <p class="flex items-center text-sm text-gray-500">
                            Price: <span class="text-gray-700 font-bold">{{ ` ₱ ${formatPrice(product.price)}` }}</span>
                        </p>
                        <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                            Sold: <span class="text-gray-700 font-bold">{{ product.sold }}</span>
                        </p>
                        <p v-if="product.reserved" class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                            reserved/in-cart: <span class="text-gray-700 font-bold">{{ ` ${product.reserved} pcs.` }}</span>
                        </p>
                        </div>
                        <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                        <!-- Heroicon name: solid/calendar -->
                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                        <p>
                            created at:
                            <time datetime="2020-01-07">{{ product.created_at }}</time>
                        </p>
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
import ProductModal from "./Modals/ProductModal.vue"
import EditProductModal from "./Modals/EditProductModal.vue"
import debounce from 'lodash/debounce'
import Paginate from '../Pagination.vue';

export default {
    components: {
        Paginate,
        Loading,
        ProductModal,
        EditProductModal
    },
    data() {
        return {
            title: 'test',
            isLoading: false,
            isOpen: false,
            product: null,
            categories: null,
            search: '',
            category: '',
            sortBy: ''
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
            this.getProducts()
        }, 200),
        category: debounce(function(newVal){
            this.getProducts()
        }, 200),
        sortBy: debounce(function(newVal){
            this.getProducts()
        }, 200),
    },
    methods: {
        editProduct(product) {
            this.product = product
            this.isOpen = true
        },
        async getProducts(page) {
            this.isLoading = true;
            await this.$store.dispatch('product/getProducts', {
                params: {
                    page: page,
                    search: this.search,
                    category: this.category,
                    sortBy: this.sortBy
                }
            }).then(() => {
                this.isLoading = false;
            });
        },
        async updateStock(id,stock, type) {
            this.isLoading = true;
            await this.$store.dispatch('product/updateStock', {
                form: {
                    id: id,
                    stock: stock,
                    type: type
                }
            }).then(() => {
                this.isLoading = false;
            });
        },
        confirmUpdateStock(product, type) {
            var typeMessage;
            var titleMessage;
            if(type == 'add') {
                typeMessage = 'Increase Stock'
                titleMessage = 'Increase Stock Value'
            } else {
                typeMessage = 'Decrease Stock'
                titleMessage = 'Decrease Stock Value'
            }
        
            this.$swal.fire({
                title: titleMessage,
                input: 'number',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: typeMessage,
                showLoaderOnConfirm: true,
                preConfirm: (stockCount) => {
                    this.updateStock(product.id, stockCount, type)
                },
                allowOutsideClick: () => !this.$swal.isLoading()
                }).then((result) => {
                if (result.isConfirmed) {
                    
                }
            })
        },
        async getCategories() {
            await axios.get('/category-selection')
            .then( response => {
                this.categories = response.data
            });
        }
    },
    created() {
         this.getProducts()
         this.getCategories()   
    }
}
</script>