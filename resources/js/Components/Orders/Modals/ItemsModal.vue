<template>
  <div class="container mx-auto">
    <loading :isLoading="isLoading"></loading>
    <div class="flex justify-center">
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
                                  <h5 class="text-white text-2xl uppercase">Order id: {{ datas.id }} ({{ datas.status }})</h5>
                              </div>
                              <div class="modal-body p-5 w-full h-full overflow-y-auto">
                                  <div class="mt-8">
                                    <div class="flow-root">
                                        <ul role="list" class="-my-6 divide-y divide-gray-200">
                                        <li v-for="item in datas.orders" :key="item" class="py-6 flex">
                                            <div class="flex-shrink-0 w-24 h-24 border border-gray-200 rounded-md overflow-hidden">
                                            <img :src="generateSrc(item.product.images)" alt="Salmon orange fabric pouch with match zipper, gray zipper pull, and adjustable hip belt." class="w-full h-full object-center object-cover">
                                            </div>

                                            <div class="ml-4 flex-1 flex flex-col">
                                            <div>
                                                <div class="flex justify-between text-base font-medium text-gray-900">
                                                <h3>
                                                    <a :href="`/product/${item.product.id}`"> {{ item.product.name }} </a>
                                                </h3>
                                                <p class="ml-4 text-gray-900">₱ {{ (parseFloat(item.product.price)*item.quantity) }}</p>
                                                </div>
                                                <p class="mt-1 text-sm text-gray-500">₱ {{ item.product.price }}</p>
                                            </div>
                                            <div class="flex-1 flex items-end justify-between text-sm">
                                                <p class="text-gray-500">Qty {{ item.quantity }}</p>

                                                <div v-if="isCustomer(item)" class="flex">
                                                  <button @click="postReview(item)" class="font-medium text-orange-600 hover:text-orange-500">Post Review</button>
                                                </div>
                                            </div>
                                            </div>
                                        </li>

                                        <!-- More products... -->
                                        </ul>
                                    </div>
                                </div>
                                  <div class="flex mt-4">
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
    props: {
        datas: Object,
        isOpen: Boolean,
        totalPrice: Number,
        status: String,
        label: String
    },
    components: {
        Loading
    },
    data() {
        return {
            isLoading: false,
            name: ''
        };
    },
    methods: {
        isCustomer(item) {
          if(this.datas.status == 'Sold') {
            if(this.app.is_customer && item.has_review === true) {
              return false
            } else {
              return true
            }
          } else {
            return false
          }
        },
        async postReview(product) {
          this.$emit('productReviewModal', product)
        },
        reduceTotal() {
          let total = null;
          if(this.datas) {
            total = Object.values(this.datas.orders).reduce((t, {product, quantity}) => t + (parseFloat(product.price)*quantity), 0)
          } else {
            total = 0
          }
          return total
        },
        closeModal() {
            this.$emit('closeModal')
            this.name = ''
        },
        async saveCategory() {
        this.isLoading = true
        await this.$store.dispatch('category/saveCategory', {
            name: this.name
        })
            .then( () => {
                this.isLoading = false
                this.name = ''
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