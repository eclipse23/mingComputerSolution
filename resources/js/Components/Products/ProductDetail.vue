<template>
    <div class="bg-white">
        <loading :isLoading="isLoading"></loading>
        <div class="pt-6">

            <div class="flex flex-wrap">
                <div class="w-full sm:w-full md:w-full lg:w-5/12 xl:w-5/12 mb-4">
                    <div class="px-8 flex">
                        <div class="w-2/12">
                            <img @click="currentUrl = slide" class="px-2 pb-4" v-for="slide in images" :key="slide" :src="slide">
                        </div>
                        <div class="w-10/12">
                            <img class="w-full" :src="currentUrl">
                        </div>
                    </div>
                </div>
                <div class="w-full sm:w-full md:w-full lg:w-4/12 xl:w-4/12 mb-4 px-4">
                    <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">{{ product.name }}</h1>
                    <h1 class="text-xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">{{ product.brand }}</h1>
                    <div>
                        <h3 class="sr-only">Description</h3>

                        <div class="space-y-6">
                            <p class="text-base text-gray-900">{{ product.description }}</p>
                        </div>
                    </div>

                    <div class="mt-10">
                        <h2 class="text-sm font-medium text-gray-900">Specification</h2>

                        <div class="mt-4 space-y-6">
                            <p class="text-sm text-gray-600">{{ product.specification }}</p>
                        </div>
                    </div>
                </div>
                <div class="w-full sm:w-full md:w-full lg:w-3/12 xl:w-3/12 mb-4 px-4">
                    <div class="mt-4 lg:mt-0 lg:row-span-3">
                        <h2 class="sr-only">Product information</h2>
                        <p class="text-3xl text-gray-900">₱{{ product.price }}</p>
                        <div class="mt-2">
                            Remaining Items: <span class="ml-3 text-sm font-bold text-orange-600 hover:text-orange-500">{{ product.stock }}</span>
                        </div>
                        <!-- Reviews -->
                        <div class="mt-6">
                        <h3 class="sr-only">Reviews</h3>
                        <div class="flex items-center">
                            <div class="flex items-center">
                            <!--
                                Heroicon name: solid/star

                                Active: "text-gray-900", Default: "text-gray-200"
                            -->
                                <svg class="text-orange-600 h-8 w-8 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                            <p>{{ roundRating(product.rating.rating) }} out of 5 stars</p>
                            <p class="ml-3 text-sm font-medium text-orange-600 hover:text-orange-500">{{ product.rating.count }} reviews</p>
                        </div>
                        </div>
                        <div v-if="!isAdmin()">
                            <div class="pt-10">
                                <label for="quantity" class="block text-sm font-medium text-gray-700">Qty.</label>
                                <div class="mt-1">
                                    <input v-model="pcs" type="number" name="quantity" id="quantity" class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="0">
                                </div>
                            </div>
                            <button :disabled="checkQuantity()" @click="storeToCart()" v-if="isLoggedIn()" type="submit" class="mt-2 w-full bg-orange-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">Add to Cart</button>
                            <a v-else href="/login" class="mt-2 w-full bg-orange-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">Login</a>
                            <button v-if="isLoggedIn()" @click="sendMessage()" type="submit" class="mt-10 w-full bg-orange-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">Ask Question</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <product-reviews :product="product"/>
    </div>
</template>

<script>
    import RelatedProducts from '../RelatedProducts.vue'
    import ProductReviews from './ProductReviews.vue'
    import Loading from "../LoadingSpinner.vue"
    import { Carousel, Navigation, Pagination, Slide } from 'vue3-carousel';

    import 'vue3-carousel/dist/carousel.css';

    export default {
        props: {
            data: Object
        },
        components: {
            RelatedProducts,
            ProductReviews,
            Loading,
            Carousel,
            Slide,
            Pagination,
            Navigation
        },
        data() {
            return {
                pcs: 0,
                isLoading: false,
                images: [],
                product: null,
                currentUrl: ''
            }
        },
        methods: {
            connect(id) {
                window.Echo.join(`updateproductview${this.product.id}`)
                .listen('UpdateProductView', e => {
                    this.getProductStock()
                    console.log('yow')
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
            checkQuantity() {
                return (this.data < this.pcs || this.pcs == 0)
            },
            async storeToCart() {
                var form = {
                    product_id: this.data.id,
                    quantity: this.pcs
                }
                this.isLoading = true
                await axios.post('/add-to-cart', form)
                .then(response => {
                    this.isLoading = false
                    this.pcs = 0
                    this.$swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'item added to cart',
                        showConfirmButton: false,
                        timer: 1000
                    })
                })
            },
            sendMessage() {
                this.$swal.fire({
                title: 'Write a question',
                input: 'textarea',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Send ',
                confirmButtonColor: '#EA580C',
                showLoaderOnConfirm: true,
                preConfirm: (message) => {
                    this.send(message)
                },
                allowOutsideClick: () => !this.$swal.isLoading()
                }).then((result) => {
                if (result.isConfirmed) {
                    
                }
                })
            },
            async send(message) {
                this.isLoading = true;
                var form = {
                    message: message,
                    product_id: this.data.id
                }
                await axios.post('/message', form)
                .then(response => {
                    this.isLoading = false;
                    console.log(response)
                })
            },
            isLoggedIn() {
                return this.app.logged_in
            },
            isAdmin() {
                return this.app.is_admin
            },
            async storeRecommendation() {
                var form = {
                    product_id: this.data.id
                }
                await axios.post('/add-recommendation', form)
                .then(response => {
                    console.log(response)
                })
            },
            async getProductStock() {
                await axios.get(`/product-stock/${this.product.id}`)
                .then(response => {
                    this.product.stock = response.data
                })
            }
        },
        created() {
            this.product = this.data
            this.product.images.forEach(element => {
                if(element != '') {
                    this.images.push(element)
                    this.currentUrl = element
                }
            });
            this.storeRecommendation()
            this.getProductStock()
            this.connect()
        }
    }
</script>

<style>
    .carousel__item {
        min-height: 200px;
        width: 100%;
        background-color: #ffedd5;
        color:  rgb(234, 88, 12);
        font-size: 20px;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .carousel__slide {
        padding: 10px;
    }

    .carousel__prev,
    .carousel__next {
        box-sizing: content-box;
        border: 5px solid white;
    }
</style>