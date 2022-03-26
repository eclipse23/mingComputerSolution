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
                                  <h5 class="text-white text-2xl uppercase">{{ productName }}</h5>
                              </div>
                              <div class="modal-body p-5 w-full h-full overflow-y-auto">
                                  <div class="my-4 w-full">
                                    <div class="flex items-center w-full space-x-4 lg:space-x-6">
                                      <img class="w-20 h-20 rounded-full lg:w-20 lg:h-20" :src="productSrc" alt="">
                                      <div class="font-medium text-lg leading-6 space-y-1">
                                        <h3>{{ productName }}</h3>
                                      </div>
                                    </div>
                                    <div class="flow-root mt-4">
                                        <div>
                                          <label for="comment" class="block text-sm font-medium text-gray-700">Comment</label>
                                          <div class="mt-1 relative rounded-md shadow-sm">
                                            <textarea v-model="comment" name="comment" id="comment" class="focus:ring-orange-600 focus:border-orange-600 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                                          </div>
                                        </div>
                                        <div class="mt-2">
                                          <label class="block text-sm font-medium text-gray-700">Rating</label>
                                          <div class="flex">
                                              <button @click="value = i" type="button" v-for="i in 5" :class="{ 'mr-1': i < 5 }" :key="i">
                                                <svg class="block h-8 w-8" :class="[ value >= i ? 'text-orange-600': 'text-gray-200']" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                                              </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                  <div class="flex mt-4">
                                    <button
                                      @click="closeModal()"
                                      class="px-6 py-2 text-orange-800 border border-orange-600 ml-auto rounded"
                                    >
                                      Cancel
                                    </button>
                                    <button @click="postReview()" class="px-6 py-2 ml-2 text-orange-100 bg-orange-600 rounded">
                                      Post
                                    </button>
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
        cartId: Number,
        productId: Number,
        productName: String,
        isOpen: Boolean,
        totalPrice: String,
        productSrc: String
    },
    components: {
        Loading
    },
    data() {
        return {
            isLoading: false,
            name: '',
            value: 0,
            comment: ''
        };
    },
    methods: {
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
        async postReview() {
          var form = {
            cart_id: this.cartId,
            product_id: this.productId,
            comment: this.comment,
            stars: this.value
          }
          await axios.post('/review', form)
          .then(response => {
            this.closeModal()
          })
        }
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