<template>
  <div class="container mx-auto">
    <loading :isLoading="isLoading"></loading>
    <div class="flex justify-center">
      <button
        @click="isOpen = true"
        class="mb-2 relative inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-bold rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
        type="button"
      >
        Create Product
      </button>

      <transition name="fade">
        <div v-show="isOpen" class="fixed inset-0 z-30">

      <!--       background -->
              <div v-show="isOpen" @click="closeModal()" class="bg-filter bg-white opacity-25 fixed inset-0 w-full h-full z-20">
              </div>
      <!--          -->
              <main class="flex flex-col items-center justify-center h-full w-full">
                  <transition name="fade-up-down">
                      <div v-show="isOpen" class="modal-wrapper w-11/12 md:w-10/12 lg:w-8/12 xl:w-2/5 inline-block flex items-center z-30">
                          <div class="modal max-w-md mx-auto w-full xl:max-w-5xl lg:max-w-5xl md:max-w-2xl bg-white max-h-screen flex-row rounded relative">

                              <div class="modal-header p-5 bg-orange-600 text-gray-900 rounded-t">
                                  <h5 class="text-white text-2xl uppercase">Create Product</h5>
                              </div>
                              <div class="modal-body p-5 w-full h-full overflow-y-auto">
                                  <div class="space-y-8 divide-y divide-gray-200">
                                    <div class="space-y-8 divide-y divide-gray-200">
                                        <div>
                                            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                                <div class="sm:col-span-4">
                                                    <label for="name" class="block text-sm font-medium text-gray-700">
                                                        Name
                                                    </label>
                                                    <div class="mt-1 flex rounded-md shadow-sm">
                                                        <input v-model="form.name" type="text" name="name" id="name" autocomplete="name" class="flex-1 focus:ring-orange-500 focus:border-orange-500 block w-full min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300">
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-4">
                                                    <label for="name" class="block text-sm font-medium text-gray-700">
                                                        Brand
                                                    </label>
                                                    <div class="mt-1 flex rounded-md shadow-sm">
                                                        <input v-model="form.brand" type="text" name="name" id="name" autocomplete="name" class="flex-1 focus:ring-orange-500 focus:border-orange-500 block w-full min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300">
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-4">
                                                    <div class="relative flex items-start ml-4">
                                                        <div class="flex items-center h-5">
                                                            <input v-model="form.new_arrival" id="hot_deal" name="hot_deal" type="checkbox" class="focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300 rounded">
                                                        </div>
                                                        <div class="ml-3 text-sm">
                                                            <label for="hot_deal" class="font-medium text-gray-700">New Arrival</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-3">
                                                    <label for="Category" class="block text-sm font-medium text-gray-700">
                                                        Category
                                                    </label>
                                                    <div class="mt-1">
                                                        <select v-model="form.category_id" id="category" name="category" autocomplete="category-name" class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                                            <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="sm:col-span-6">
                                                    <label for="description" class="block text-sm font-medium text-gray-700">
                                                        Description
                                                    </label>
                                                    <div class="mt-1">
                                                        <textarea v-model="form.description" id="description" name="description" rows="3" class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border border-gray-300 rounded-md"></textarea>
                                                    </div>
                                                    <p class="mt-2 text-sm text-gray-500">Write a few sentences about product.</p>
                                                </div>

                                                <div class="sm:col-span-6">
                                                    <label for="specification" class="block text-sm font-medium text-gray-700">
                                                        Specification
                                                    </label>
                                                    <div class="mt-1">
                                                        <textarea v-model="form.specification" id="specification" name="specification" rows="3" class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border border-gray-300 rounded-md"></textarea>
                                                    </div>
                                                    <p class="mt-2 text-sm text-gray-500">Write product specification.</p>
                                                </div>

                                                <label for="price" class="block text-sm font-medium text-gray-700 -mb-4">Price</label>
                                                <div class="sm:col-span-6 flex items-center">
                                                    <div class="w-3/4 relative rounded-md shadow-sm">
                                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <span class="text-gray-500 sm:text-sm">
                                                                ₱
                                                            </span>
                                                        </div>
                                                        <input v-model="form.price" type="number" name="price" id="price" class="focus:ring-orange-500 focus:border-orange-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="0.00" aria-describedby="price-currency">
                                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                            <span class="text-gray-500 sm:text-sm" id="price-currency">
                                                                PHP
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="relative flex items-start ml-4">
                                                        <div class="flex items-center h-5">
                                                            <input v-model="form.hot_deal" id="hot_deal" name="hot_deal" type="checkbox" class="focus:ring-orange-500 h-4 w-4 text-orange-600 border-gray-300 rounded">
                                                        </div>
                                                        <div class="ml-3 text-sm">
                                                            <label for="hot_deal" class="font-medium text-gray-700">Hot-deal</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- <div class="sm:col-span-4">
                                                    <label for="discount" class="block text-sm font-medium text-gray-700">
                                                        Discount Percentage
                                                    </label>
                                                    <div class="w-3/4 relative rounded-md shadow-sm">
                                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                            <span class="text-gray-500 sm:text-sm">
                                                                
                                                            </span>
                                                        </div>
                                                        <input v-model="form.discount" type="number" name="discount" id="discount" class="focus:ring-orange-500 focus:border-orange-500 block w-full pl-7 pr-12 sm:text-sm border-gray-300 rounded-md" placeholder="0.00" aria-describedby="price-currency">
                                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                            <span class="text-gray-500 sm:text-sm" id="price-currency">
                                                                %
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div> -->

                                                <div class="sm:col-span-4">
                                                    <label for="stock" class="block text-sm font-medium text-gray-700">
                                                        Stock
                                                    </label>
                                                    <div class="mt-1 flex rounded-md shadow-sm">
                                                        <input v-model="form.stock" type="number" name="stock" id="stock" autocomplete="stock" class="flex-1 focus:ring-orange-500 focus:border-orange-500 block w-full min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300">
                                                    </div>
                                                </div>
                                            </div>
                                            <label for="stock" class="block mt-4 text-sm font-bold text-gray-700">
                                                Product Images
                                            </label>
                                            <div class="grid grid-cols-5 gap-2 mt-4">
                                                <div>
                                                    <div v-if="images.pictureOneUrl">
                                                        <img class="object-cover relative w-full" :src="images.pictureOneUrl" alt="">
                                                    </div>
                                                    <div v-if="images.pictureOneUrl == null" class="flex w-full items-center justify-center bg-grey-lighter">
                                                        <label class="w-64 flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-white">
                                                            <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                                            </svg>
                                                            <span class="mt-2 text-xs leading-normal">Image 1</span>
                                                            <input @change="pictureOneChange" type='file' class="hidden" />
                                                        </label>
                                                    </div>
                                                    <div v-else>
                                                        <div class="mt-2 flex w-full items-center justify-center bg-grey-lighter">
                                                            <label class="w-64 flex flex-col items-center px-2 py-2 bg-white text-dark rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-gray-300">
                                                                <span class="text-xs leading-normal">Change Image</span>
                                                                <input @change="pictureOneChange" type='file' class="hidden" />
                                                            </label>
                                                        </div>
                                                        <div class="mt-2 flex w-full items-center justify-center bg-grey-lighter">
                                                            <label @click="removeImage(1)" class="w-64 flex flex-col items-center px-2 py-2 bg-red-500 text-dark rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-red-300 hover:text-gray-300">
                                                                <span class="text-xs leading-normal">Remove</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div v-if="images.pictureTwoUrl">
                                                        <img class="object-cover relative w-full" :src="images.pictureTwoUrl" alt="">
                                                    </div>
                                                    <div v-if="images.pictureTwoUrl == null" class="flex w-full items-center justify-center bg-grey-lighter">
                                                        <label class="w-64 flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-white">
                                                            <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                                            </svg>
                                                            <span class="mt-2 text-xs leading-normal">Image 2</span>
                                                            <input @change="pictureTwoChange" type='file' class="hidden" />
                                                        </label>
                                                    </div>
                                                    <div v-else>
                                                        <div class="mt-2 flex w-full items-center justify-center bg-grey-lighter">
                                                            <label class="w-64 flex flex-col items-center px-2 py-2 bg-white text-dark rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-gray-300">
                                                                <span class="text-xs leading-normal">Change Image</span>
                                                                <input @change="pictureTwoChange" type='file' class="hidden" />
                                                            </label>
                                                        </div>
                                                        <div class="mt-2 flex w-full items-center justify-center bg-grey-lighter">
                                                            <label @click="removeImage(2)" class="w-64 flex flex-col items-center px-2 py-2 bg-red-500 text-dark rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-red-300 hover:text-gray-300">
                                                                <span class="text-xs leading-normal">Remove</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div v-if="images.pictureThreeUrl">
                                                        <img class="object-cover relative w-full" :src="images.pictureThreeUrl" alt="">
                                                    </div>
                                                    <div v-if="images.pictureThreeUrl == null" class="flex w-full items-center justify-center bg-grey-lighter">
                                                        <label class="w-64 flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-white">
                                                            <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                                            </svg>
                                                            <span class="mt-2 text-xs leading-normal">Image 3</span>
                                                            <input @change="pictureThreeChange" type='file' class="hidden" />
                                                        </label>
                                                    </div>
                                                    <div v-else>
                                                        <div class="mt-2 flex w-full items-center justify-center bg-grey-lighter">
                                                            <label class="w-64 flex flex-col items-center px-2 py-2 bg-white text-dark rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-gray-300">
                                                                <span class="text-xs leading-normal">Change Image</span>
                                                                <input @change="pictureThreeChange" type='file' class="hidden" />
                                                            </label>
                                                        </div>
                                                        <div class="mt-2 flex w-full items-center justify-center bg-grey-lighter">
                                                            <label @click="removeImage(3)" class="w-64 flex flex-col items-center px-2 py-2 bg-red-500 text-dark rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-red-300 hover:text-gray-300">
                                                                <span class="text-xs leading-normal">Remove</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div v-if="images.pictureFourUrl">
                                                        <img class="object-cover relative w-full" :src="images.pictureFourUrl" alt="">
                                                    </div>
                                                    <div v-if="images.pictureFourUrl == null" class="flex w-full items-center justify-center bg-grey-lighter">
                                                        <label class="w-64 flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-white">
                                                            <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                                            </svg>
                                                            <span class="mt-2 text-xs leading-normal">Image 4</span>
                                                            <input @change="pictureFourChange" type='file' class="hidden" />
                                                        </label>
                                                    </div>
                                                    <div v-else>
                                                        <div class="mt-2 flex w-full items-center justify-center bg-grey-lighter">
                                                            <label class="w-64 flex flex-col items-center px-2 py-2 bg-white text-dark rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-gray-300">
                                                                <span class="text-xs leading-normal">Change Image</span>
                                                                <input @change="pictureFourChange" type='file' class="hidden" />
                                                            </label>
                                                        </div>
                                                        <div class="mt-2 flex w-full items-center justify-center bg-grey-lighter">
                                                            <label @click="removeImage(4)" class="w-64 flex flex-col items-center px-2 py-2 bg-red-500 text-dark rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-red-300 hover:text-gray-300">
                                                                <span class="text-xs leading-normal">Remove</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div v-if="images.pictureFiveUrl">
                                                        <img class="object-cover relative w-full" :src="images.pictureFiveUrl" alt="">
                                                    </div>
                                                    <div v-if="images.pictureFiveUrl == null" class="flex w-full items-center justify-center bg-grey-lighter">
                                                        <label class="w-64 flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-white">
                                                            <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                                <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                                                            </svg>
                                                            <span class="mt-2 text-xs leading-normal">Image 5</span>
                                                            <input @change="pictureFiveChange" type='file' class="hidden" />
                                                        </label>
                                                    </div>
                                                    <div v-else>
                                                        <div class="mt-2 flex w-full items-center justify-center bg-grey-lighter">
                                                            <label class="w-64 flex flex-col items-center px-2 py-2 bg-white text-dark rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-gray-300">
                                                                <span class="text-xs leading-normal">Change Image</span>
                                                                <input @change="pictureFiveChange" type='file' class="hidden" />
                                                            </label>
                                                        </div>
                                                        <div class="mt-2 flex w-full items-center justify-center bg-grey-lighter">
                                                            <label @click="removeImage(5)" class="w-64 flex flex-col items-center px-2 py-2 bg-red-500 text-dark rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-red-300 hover:text-gray-300">
                                                                <span class="text-xs leading-normal">Remove</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-5">
                                        <div class="flex justify-end">
                                        <button @click="closeModal()" type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                            Cancel
                                        </button>
                                        <button @click="saveProduct()" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                            Save
                                        </button>
                                        </div>
                                    </div>
                                </div>
                              </div>
                          </div>
                      </div>
                  </transition>
              </main>
          </div>
      </transition>
    </div>
  </div>
</template>
<script>
//import debounce from 'lodash/debounce'
import Loading from '../../LoadingSpinner.vue';

export default {
  components: {
    Loading
  },
  data() {
    return {
        categories: [],
        isLoading: false,
        isOpen: false,
        name: '',
        form: {
            name: '',
            desctription: '',
            specification: '',
            category_id: '',
            discount:'',
            price:'',
            hot_deal:false,
            new_arrival: false,
            stock: '',
            brand: ''
        },
        images: {
            pictureOne: null,
            pictureOneUrl: null,
            pictureTwo: null,
            pictureTwoUrl: null,
            pictureThree: null,
            pictureThreeUrl: null,
            pictureFour: null,
            pictureFourUrl: null,
            pictureFive: null,
            pictureFiveUrl: null,
        }
    };
  },
  methods: {
    closeModal() {
        this.isOpen = false
    },
    async saveProduct() {
      this.isLoading = true

      let formData = new FormData();

      formData.append('image_one', this.images.pictureOne);
      formData.append('image_two', this.images.pictureTwo);
      formData.append('image_three', this.images.pictureThree);
      formData.append('image_four', this.images.pictureFour);
      formData.append('image_five', this.images.pictureFive);
      formData.append('name', this.form.name);
      formData.append('description', this.form.description);
      formData.append('specification', this.form.specification);
      formData.append('category_id', this.form.category_id);
      formData.append('discount', this.form.discount);
      formData.append('price', this.form.price);
      formData.append('hot_deal', this.form.hot_deal);
      formData.append('stock', this.form.stock);

      await this.$store.dispatch('product/saveProduct', formData)
      .then( () => {
          this.form = this.$options.data().form
          this.images = this.$options.data().images
          this.isLoading = false
          this.isOpen = false
          this.name = ''
      })
    },
    pictureOneChange(e) {
        this.images.pictureOne= event.target.files[0]
        this.images.pictureOneUrl = URL.createObjectURL(this.images.pictureOne);
    },
    pictureTwoChange(e) {
        this.images.pictureTwo= event.target.files[0]
        this.images.pictureTwoUrl = URL.createObjectURL(this.images.pictureTwo);
    },
    pictureThreeChange(e) {
        this.images.pictureThree= event.target.files[0]
        this.images.pictureThreeUrl = URL.createObjectURL(this.images.pictureThree);
    },
    pictureFourChange(e) {
        this.images.pictureFour= event.target.files[0]
        this.images.pictureFourUrl = URL.createObjectURL(this.images.pictureFour);
    },
    pictureFiveChange(e) {
        this.images.pictureFive= event.target.files[0]
        this.images.pictureFiveUrl = URL.createObjectURL(this.images.pictureFive);
    },
    removeImage(count) {
        if(count == 1) {
            this.images.pictureOne= null
            this.images.pictureOneUrl = null
        }
        if(count == 2) {
            this.images.pictureTwo= null
            this.images.pictureTwoUrl = null
        }
        if(count == 3) {
            this.images.pictureThree= null
            this.images.pictureThreeUrl = null
        }
        if(count == 4) {
            this.images.pictureFour= null
            this.images.pictureFourUrl = null
        }
        if(count == 5) {
            this.images.pictureFive= null
            this.images.pictureFiveUrl = null
        }
    },
    async getCategories() {
        await axios.get('/category-selection')
        .then( response => {
            this.categories = response.data
        });
    }
  },
  created() {
      this.getCategories()
  }
};
</script>

<style lang="css">
  .modal-body{
    min-height: 250px;
    max-height: 500px;
  }
  .bg-gray-800-opacity{
    background-color: #000000;
  }
  @media screen and (max-width: 768px){
    .modal-body {
        max-height: 400px;
    }
  }

  /* animation for vue transition tag */

  .fade-up-down-enter-active {
    transition: all 0.3s ease;
  }
  .fade-up-down-leave-active {
    transition: all 0.3s ease;
  }
  .fade-up-down-enter {
    transform: translateY(10%);
    opacity: 0;
  }
  .fade-up-down-leave-to {
    transform: translateY(10%);
    opacity: 0;
  }

  .fade-enter-active{
      -webkit-transition: opacity 2s;
      transition: opacity .3s;

  }
  .fade-leave-active {
      transition: opacity .3s;
  }

  .fade-enter,
  .fade-leave-to{
      opacity: 0;
  }
</style>