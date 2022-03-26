<template>
    <div>
        <div class="container flex justify-center items-center mt-2">
            <div class="relative"> <input v-model="search" type="text" class="h-14 w-96 pr-8 pl-5 rounded z-0 focus:shadow focus:outline-none" placeholder="Search anything...">
                <div class="absolute top-4 right-3"> <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i> </div>
            </div>
        </div>
    </div>
</template>

<script>
import debounce from 'lodash/debounce';

export default {
    data() {
        return {
            search: ''
        }
    },
    watch: {
        search: debounce(function(newVal){
            this.redirectToProducts()
        }, 200),
    },
    methods: {
        redirectToProducts() {
            window.location.href = `/products/all-products?search=${this.search}`
        }
    }
}
</script>