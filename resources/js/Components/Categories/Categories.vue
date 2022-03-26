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
                <div class="ml-4 mt-2 flex-shrink-0">
                    <category-modal @click="openModal == !modal" :openModal="openModal"></category-modal>
                </div>
            </div>
        </div>
        <ul role="list" class="divide-y divide-gray-200">
            <li v-for="(category, index) in categories.data">
                <div class="block hover:bg-orange-200">
                    <div class="px-4 py-1 sm:px-6">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-bold text-orange-600 truncate uppercase">
                                {{`${index+1}. ${category.name}` }}
                            </p>
                            <div class="ml-2 flex-shrink-0 flex">
                                <edit-category-modal :category="category"></edit-category-modal>
                                <button @click="deleteCategory(category.id)" class="text-red-600 hover:text-red-900">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        <paginate
            :pagination="pagination"
            @paginate="getCategories"
            :offset="4"
        />
    </div>
</template>
<script>
import CategoryModal from "./Modals/CategoryModal.vue";
import EditCategoryModal from "./Modals/EditCategoryModal.vue";
import Loading from '../LoadingSpinner.vue';
import { mapGetters } from 'vuex';
import debounce from 'lodash/debounce'
import Paginate from '../Pagination.vue';

export default {
    components: {
        Paginate,
        Loading,
        CategoryModal,
        EditCategoryModal
    },
    data() {
        return {
            isLoading: false,
            search: ''
        }
    },
    watch: {
        search: debounce(function(newVal){
            this.getCategories()
        }, 200),
    },
    computed: {
        ...mapGetters({
            categories: 'category/categories',
            pagination: 'category/pagination'
        }),
    },
    methods: {

        async getCategories(page) {
            this.isLoading = true;
            await this.$store.dispatch('category/getCategories', {
                params: {
                    page: page,
                    search: this.search
                }
            }).then(() => {
                this.isLoading = false;
            });
        },

        deleteCategory(id) {
            this.$swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                this.confirmDelete(id)
                this.isLoading = true
            }
            })
        },

        async confirmDelete(id) {
            await this.$store.dispatch('category/deleteCategory', {
                params: id
            }).then( () => {
                this.isLoading = false
                this.$swal.fire(
                    'Deleted!',
                    'Category Deleted.',
                    'success'
                )
            });
        },

        

    },
    created() {
        this.getCategories(1);
    }
}
</script>