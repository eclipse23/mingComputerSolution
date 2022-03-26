<template>
    <div style="z-index: 9999" v-show="isLoading" class="w-full h-full fixed block top-0 left-0 bg-white opacity-75">
        <span class="text-orange-600 opacity-75 top-1/2 my-0 mx-auto block relative w-0 h-0" style="
          top: 50%;
      ">
          <i class="fas fa-circle-notch fa-spin fa-5x"></i>
        </span>
      </div>
</template>

<script>
    export default {
        props: {
            isLoading: Boolean
        },
    }
</script>