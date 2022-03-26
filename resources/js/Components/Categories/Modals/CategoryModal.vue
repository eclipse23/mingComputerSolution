<template>
  <div class="container mx-auto">
    <loading :isLoading="isLoading"></loading>
    <div class="flex justify-center">
      <button
        @click="isOpen = true"
        class="mb-2 relative inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500"
        type="button"
      >
        Create Category
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
                                  <h5 class="text-white text-2xl uppercase">Create Category</h5>
                              </div>
                              <div class="modal-body p-5 w-full h-full overflow-y-auto">
                                  <div class="mt-4">
                                    <label for="name" class="block text-sm font-bold text-gray-700">Category Name</label>
                                    <div>
                                      <div class="mt-1">
                                        <input v-model="name" type="text" name="name" id="name" class="shadow-sm focus:ring-orange-500 focus:border-orange-500 block w-full sm:text-sm border-gray-300 rounded-md">
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
                                    <button @click="saveCategory()" class="px-6 py-2 ml-2 text-orange-100 bg-orange-600 rounded">
                                      Save
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
  components: {
    Loading
  },
  data() {
    return {
      isLoading: false,
      isOpen: false,
      name: ''
    };
  },
  methods: {
    closeModal() {
        this.isOpen = false
        this.name = ''
    },
    async saveCategory() {
      this.isLoading = true
      await this.$store.dispatch('category/saveCategory', {
        name: this.name
      })
      .then( () => {
          this.isLoading = false
          this.isOpen = false
          this.name = ''
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