<template>
    <div v-if="recommended.length != 0" class="px-12 pt-4">
        <loading :isLoading="isLoading"></loading>
        <div>
            <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="flex items-center justify-between space-x-4">
                    <h2 class="text-xl font-bold text-gray-900">Recommended For You</h2>
                </div>
                <div class="mt-6 grid grid-cols-1 gap-x-8 gap-y-8 sm:grid-cols-2 sm:gap-y-10 lg:grid-cols-4">
                    <div v-for="product in recommended.slice(0, 4)" :key="product" class="shadow-lg bg-white rounded-lg">
                        <a href="#">
                            <img :src="generateSrc(product.images)" class="rounded-tl-lg rounded-tr-lg" />
                        </a>
                        <div class="p-2 bg-orange-200">
                            <h3 class="font-bold"><a href="#">{{ product.name }}</a></h3>
                            <h3><a href="#">{{ product.brand }}</a></h3>
                            <h3 class="text-orange-600"><a href="#">{{ product.category.name }}</a></h3>
                            <p class="text-base text-gray-800">
                                ₱ {{ formatPrice(product.price) }}
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
            </div>
        </div>
    </div>
</template>

<script>
import Loading from "./LoadingSpinner.vue"

export default {
    components: {
        Loading
    },
    data() {
        return {
            recommended: [],
            isLoading: false
        }
    },
    methods: {
        connect(id) {
            window.Echo.join(`updateproduct`)
            .listen('UpateProduct', e => {
                this.getrecommended()
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
        isLoggedIn() {
            if(this.app.logged_in) {
                if(this.app.is_admin) {
                    return false
                } else {
                    return true
                }
            } else {
                return false
            }
        },
        async getrecommended() {
            await axios.get('/recommendations')
            .then(response => {
                this.recommended = response.data
            })
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
            })
            await this.$store.dispatch('cart/addCart')
        }
    },
    created() {
        this.getrecommended()
        this.connect()
    }
};
</script>

<style scoped>
    .carousel__slide > .carousel__item {
        height: 400px;
        transform: scale(1);
        opacity: 0.5;
        transition: 0.5s;
    }
    .carousel__slide--visible > .carousel__item {
        opacity: 1;
        transform: rotateY(0);
    }
    .carousel__slide--next > .carousel__item {
        transform: scale(0.9) translate(-10px);
    }
    .carousel__slide--prev > .carousel__item {
        transform: scale(0.9) translate(10px);
    }
    .carousel__slide--active > .carousel__item {
        transform: scale(1.1);
    }

    .card {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        max-width: 300px;
        margin: auto;
        text-align: center;
        font-family: arial;
        color: rgb(36, 35, 35);
    }

    .price {
        color: grey;
        font-size: 22px;
    }

    .card button {
        border: none;
        outline: 0;
        padding: 12px;
        color: white;
        background-color: rgb(234, 88, 12);
        text-align: center;
        cursor: pointer;
        width: 100%;
        font-size: 18px;
    }

    .card button:hover {
        opacity: 0.7;
    }
</style>