<template>
    <div v-if="hotDeals.length != 0" class="px-12 pt-4">
        <div class="my-20">
            <div class="flex flex-row justify-between my-5">
                <h2 class="text-3xl">Products on same category</h2>
            </div>
            <div class="grid grid-flow-row grid-cols-1 md:grid-cols-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
                <div v-for="hotdeal in hotDeals" :key="hotdeal" class="shadow-lg rounded-lg">
                    <a href="#">
                        <img :src="generateSrc(hotdeal.images)" class="rounded-tl-lg rounded-tr-lg" />
                    </a>
                    <div class="p-5">
                        <h3 class="font-bold"><a href="#">{{ hotdeal.name }}</a></h3>
                        <p>₱ {{ hotdeal.price }}</p>
                        <ul class="flex items-center gap-x-1">
                            <li>
                                <i class="text-yellow-300 fas fa-star"></i>
                            </li>
                            <li>
                                <i class="text-yellow-300 fas fa-star"></i>
                            </li>
                            <li>
                                <i class="text-yellow-300 fas fa-star"></i>
                            </li>
                            <li>
                                <i class="text-yellow-300 fas fa-star"></i>
                            </li>
                            <li>
                                <i class="text-yellow-300 far fa-star"></i>
                            </li>
                        </ul>
                        <p>{{ hotdeal.category.name }}</p>
                    <div class="flex flex-col xl:flex-row justify-between">
                        <a v-if="isLoggedIn()" class="bg-gradient-to-r from-orange-600 to-pink-500 rounded-full py-2 px-4 my-2 text-sm text-white hover:bg-orange-600 hover:from-orange-600 hover:to-orange-600 flex flex-row justify-center" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Add to cart
                        </a>
                        <a class="bg-orange-600 rounded-full py-2 px-4 my-2 text-sm text-white hover:bg-orange-700 flex flex-row justify-center" :href="`/product/${hotdeal.id}`">
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
</template>

<script>

export default {
    data() {
        return {
            hotDeals: []
        }
    },
    methods: {
        isLoggedIn() {
            return this.app.logged_in
        },
        async getHotDeals() {
            await axios.get('/hot-deals')
            .then(response => {
                this.hotDeals = response.data.data
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
        }
    },
    created() {
        this.getHotDeals()
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