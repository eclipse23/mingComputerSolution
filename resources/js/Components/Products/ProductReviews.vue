<template>
    <div class="bg-gray-50">
        <div class="max-w-7xl mx-auto py-12 px-4 divide-y divide-gray-200 sm:px-6 lg:py-16 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900">Comments and Rating</h2>
            <div class="p-8">
                <div>
                    <h2 id="reviews-heading" class="sr-only">Reviews</h2>

                    <div v-for="review in reviews" :key="review" class="space-y-10">
                        <div class="flex flex-col sm:flex-row">
                            <div class="mt-6 order-2 sm:mt-0 sm:ml-16">
                                <div class="mt-3 space-y-6 text-sm text-gray-600">
                                    <p>{{ review.message }}</p>
                                </div>
                            </div>

                            <div class="order-1 flex items-center sm:flex-col sm:items-start">
                                <img :src="review.user.profilePicture ? review.user.profilePicture : 'https://cdn.pixabay.com/photo/2014/04/03/10/32/businessman-310819_960_720.png'" alt="Mark Edwards." class="h-12 w-12 rounded-full">

                                <div class="ml-4 sm:ml-0 sm:mt-4">
                                    <p class="text-sm font-medium text-gray-900">{{ review.user.name }}</p>
                                    <p class="text-xs font-medium text-gray-900">Date: {{ review.created_at }}</p>
                                    <div class="mt-2 flex items-center">
                                        <svg class="text-orange-600 h-5 w-5 flex-shrink-0 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        {{ review.stars }} of 5 Stars
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            product: Object
        },
        data() {
            return {
                reviews: []
            }
        },
        methods: {
            async getReviews() {
                await axios.get(`/reviews/${this.product.id}`)
                .then(response => {
                    this.reviews = response.data.data;
                })
            }
        },
        created() {
            this.getReviews()
        }
    }
</script>