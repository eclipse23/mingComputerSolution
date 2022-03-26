<template>
    <div class="px-12 pt-4">
        <loading :isLoading="isLoading"></loading>
        <div class="my-20">
            <div class="lg:flex flex-row justify-between my-5">
                <h2 class="text-3xl">{{ pageData.title }}</h2>
                <div class="flex">
                    <div>
                        <div>
                            <select v-model="category" id="country" name="country" autocomplete="country-name" class="block w-full pl-2 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                            <option v-for="category in categories" :key="category" :value="category.id">{{ category.name }}</option>
                            </select>
                        </div>
                    </div>
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
            <div v-if="products != []" class="grid grid-flow-row grid-cols-1 md:grid-cols-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
                <div v-for="product in products" :key="product" class="shadow-lg bg-white rounded-lg">
                    <a href="#">
                        <img :src="generateSrc(product.images)" class="rounded-tl-lg rounded-tr-lg" />
                    </a>
                    <div class="p-5 bg-orange-200">
                        <h3 class="font-bold"><a href="#">{{ product.name }}</a></h3>
                        <h3><a href="#">{{ product.brand }}</a></h3>
                        <h3 class="text-orange-600"><a href="#">{{ product.category.name }}</a></h3>
                        <p class="text-base text-gray-800">
                            ₱ {{ product.price }}
                        </p>
                        <ul class="flex items-center gap-x-1">
                            <li>
                                <i class="text-yellow-300 fas fa-star"></i> {{ roundRating(product.rating.rating) }}
                            </li>
                        </ul>
                        <ul class="flex items-center gap-x-1">
                            <li>
                                <span class="text-orange-600">{{ product.rating.count }} Reviews</span>
                            </li>
                        </ul>
                        <p class="text-gray-600">{{ product.stock }} pcs. Remaining</p>
                    <div class="flex flex-col xl:flex-row justify-between">
                        <button @click="addToCart(product)" v-if="isLoggedIn()" class="bg-gradient-to-r from-orange-600 to-pink-500 rounded-full py-2 px-4 my-2 text-sm text-white hover:bg-orange-600 hover:from-orange-600 hover:to-orange-600 flex flex-row justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Add to cart
                        </button>
                        <a :href="`/product/${product.id}`" class="bg-orange-600 rounded-full py-2 px-4 my-2 text-sm text-white hover:bg-orange-700 flex flex-row justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                            View Details
                        </a>
                    </div>
                    </div>
                </div>
            </div>
            <paginate
                v-if="pagination != []"
                :pagination="pagination"
                @paginate="getProducts"
                @scrollToTop="scrollTop"
                :offset="4"
            />
        </div> 
    </div>
</template>

<script>
    import debounce from 'lodash/debounce';
    import Paginate from '../FrontendPagination.vue';
    import Loading from '../LoadingSpinner.vue';

    export default {
        components: {
            Paginate,
            Loading
        },
        props: {
            pageData: Object
        },
        data() {
            return {
                isLoading: false,
                products: [],
                categories: [],
                pagination: {
                    meta: {
                        last_page: 1
                    }
                },
                search: '',
                category: '',
                page: 1
            }
        },
        watch: {
            pageData: function(value) {
                console.log(value)
            },
            search: debounce(function(newVal){
                this.getProducts()
            }, 200),
            category: debounce(function(newVal){
                this.getProducts()
            }, 200),
        },
        methods: {
            connect(id) {
                window.Echo.join(`updateproduct`)
                .listen('UpateProduct', e => {
                    this.getProducts(this.page)
                })
            },
            roundRating(rate) {
                var rate = Math.round(parseFloat(rate) * 10) / 10
                if(Number.isNaN(rate)) {
                    return 0
                } else {
                    return rate
                }
            },
            addToCart(product) {
                var form = {
                    product_id: product.id
                }

                this.$swal.fire({
                    title: 'How many would you like to purchase?',
                    input: 'number',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Add to Cart',
                    confirmButtonColor: '#EA580C',
                    showLoaderOnConfirm: true,
                    preConfirm: (quantity) => {
                        if(quantity > product.stock) {
                            this.$swal.fire('Insufficient Stock')
                        } else {
                            this.storeToCart(quantity, product)
                        }
                    },
                    allowOutsideClick: () => !this.$swal.isLoading()
                    }).then((result) => {
                    if (result.isConfirmed) {
                        
                    }
                })
            },
            async storeToCart(quantity, product) {
                var form = {
                    product_id: product.id,
                    quantity: quantity
                }
                this.isLoading = true
                await axios.post('/add-to-cart', form)
                .then(response => {
                    this.isLoading = false
                        this.$swal.fire({
                        title: "Added to cart",
                        confirmButtonColor: "#ea580c"
                    })
                    this.getProducts(this.page)
                })
                await this.$store.dispatch('cart/addCart')
            },
            isLoggedIn() {
                return this.app.logged_in
            },
            scrollTop() {
                window.scrollTo(0,0)  
            },
            async getProducts(page) {
                this.page = page
                this.isLoading = true
                await axios.get(`/products-list`, {
                    params: {
                        page: page,
                        type: this.pageData.type,
                        search: this.search,
                        category: this.category
                    }
                })
                .then(response => {
                    this.products = response.data.data
                    this.pagination = response.data
                    this.isLoading = false
                })
            },
            async getCategories(page) {
                await axios.get('/category-selection')
                .then( response => {
                    this.categories = response.data
                });
            },
            generateSrc(images) {
                for(var ctr = 0; ctr < images.length; ctr++) {
                    if(ctr == 4 && images[ctr] == "") {
                        return "https://free-images.com/lg/9f58/desktop_pc_tower_vector.jpg"
                    } else {
                        if(images[ctr] != "") {
                            return images[ctr]
                        }
                    }
                }
            }
        },
        created() {
            this.getCategories()
            if(this.pageData.search == '') {
                this.getProducts()
            } else {
                this.search = this.pageData.search
                this.getProducts()
            }
            this.connect()
        }
    }
</script>