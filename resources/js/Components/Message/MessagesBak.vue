<template>
    <div class="relative bg-white">
        <loading :isLoading="isLoading"></loading>
        <div class="flex flex-row justify-center my-5">
            <h2 class="text-3xl text-center">Questions and Inquiries</h2>
        </div>
        <div class="relative max-w-7xl mx-auto lg:grid lg:grid-cols-5">
            <div class="bg-gray-50 py-16 px-4 sm:px-6 lg:col-span-2 lg:px-8 lg:py-24 xl:pr-12">
                <fieldset @click="selectInquire(message)" v-for="message in inquires" :key="message" class="border-t border-b border-gray-200 hover:bg-gray-400">
                    <legend class="sr-only">Questions</legend>
                    <div class="ml-2 divide-y divide-gray-200">
                        <div class="relative flex items-start py-4">
                            <div class="min-w-0 flex-1 text-sm">
                                <label for="comments" class="font-bold text-gray-700 truncate">Product: {{ message.product.name }}</label>
                                <p id="comments-description" class="text-gray-500 truncate">{{ message.message }}</p>
                            </div>
                            <div class="ml-3 flex items-center h-5">

                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div v-if="inquire" class="bg-white py-16 px-4 sm:px-6 lg:col-span-3 lg:py-24 lg:px-8 xl:pl-12">
                <div class="max-w-4xl mx-auto text-center">
                    <h2 class="text-xl font-extrabold text-gray-900 sm:text-2xl">{{ inquire.message }}</h2>
                    Product: <a :href="`/product/${inquire.product.id}`" target="_blank" class="text-sm text-gray-500 hover:text-orange-600">{{ inquire.product.name }}</a>
                    <p v-if="!isAdmin()">yeah</p>
                </div>
                <div v-for="message in inquire.replies" :key="message" class="bg-white px-4 py-5 sm:px-6">
                    <div v-if="current_user.id != message.user_id" class="flex space-x-3">
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-gray-900">
                                <span class="hover:underline font-bold text-orange-600">Ming Computer Solutions</span>
                            </p>
                            <p class="text-sm text-gray-500">
                                <a href="#" class="hover:underline">{{ message.created_at }}</a>
                            </p>
                        </div>
                    </div>
                    <div v-else class="flex justify-end">
                        <div>
                            <p class="text-sm font-medium text-right text-gray-900">
                                <span class="hover:underline font-bold text-orange-600">Me</span>
                            </p>
                            <p class="text-sm text-gray-500">
                                <a href="#" class="hover:underline">{{ message.created_at }}</a>
                            </p>
                        </div>
                    </div>
                    <div v-if="current_user.id != message.user_id" class="text-left">
                        {{ message.message }}
                    </div>
                    <div v-else class="text-right">
                        {{ message.message }}
                    </div>
                </div>
                <div class="max-w-lg mx-auto lg:max-w-none">
                    <div class="grid grid-cols-1 gap-y-6">
                        <div>
                            <label for="message" class="sr-only">Message</label>
                            <textarea v-model="message" id="message" name="message" rows="4" class="block w-full shadow-sm py-3 px-4 placeholder-gray-500 focus:ring-orange-500 focus:border-orange-500 border border-gray-300 rounded-md" placeholder="Message"></textarea>
                        </div>
                        <div>
                            <button @click="sendReply()" class="inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Loading from "../LoadingSpinner.vue"

    export default {
        props: {
            datas: Object
        },
        components: {
            Loading
        },
        data() {
            return {
                message: '',
                inquire: null,
                inquire_id: 0,
                current_user: null,
                inquires: this.datas
            }
        },
        methods: {
            connect(id) {
              window.Echo.join("testchannel")
              .listen('MessageSent', e => {
                  this.getInquires()
              })
            },
            isAdmin() {
                return this.app.is_customer
            },
            async sendReply() {
                var form = {
                    message: this.message,
                    inquire_id: this.inquire.id
                }
                await axios.post('/reply-message', form)
                .then(response => {
                    console.log(response)
                })
            },
            selectInquire(inquire) {
                this.inquire = inquire;
            },
            async getInquires() {
                await axios.get('/admin-inquires')
                .then(response => {
                    this.inquires = response.data.data
                })
            }
        },
        created() {
            this.current_user = this.app.current_user
            this.connect()
        }
    }
</script>