<template>
    <div class="flex flex-row h-screen antialiased text-gray-800">
    <div class="flex flex-row w-96 flex-shrink-0 bg-orange-100 p-4">
      <div class="flex flex-col w-full h-full pl-4 pr-4 py-4 -mr-4">
        <div class="flex flex-row items-center">
          <div class="flex flex-row items-center">
            <div class="text-xl font-semibold">Inquiries</div>
          </div>
        </div>
        <div class="h-full overflow-hidden relative pt-2">
          <div class="flex flex-col divide-y h-full overflow-y-auto -mx-4">
            <div @click="selectInquire(message, index)" v-for="(message, index) in inquires" :key="message" class="flex flex-row items-center p-4 relative">
              <div class="flex flex-col flex-grow ml-3">
                <div class="text-sm font-bold text-indigo-600">Product: {{ message.product.name }}</div>
                <div class="text-xs truncate w-40">{{ message.message }}</div>
              </div>
              <div v-if="current_user.id != message.user_last_message && message.unseen != 0" class="flex-shrink-0 ml-2 self-end mb-1">
                <span class="flex items-center justify-center h-5 w-5 bg-red-500 text-white text-xs rounded-full">{{ message.unseen }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="inquire" class="flex flex-col h-full w-full bg-white px-4 py-6">
      <div class="flex flex-row items-center py-4 px-6 rounded-2xl shadow">
        <div class="flex flex-col ml-3">
          <div class="text-xs text-gray-500">
            <h2 class="text-xl font-extrabold text-gray-900 sm:text-2xl capitalize">{{ inquire.message }}</h2>
            Product: <a :href="`/product/${inquire.product.id}`" target="_blank" class="text-sm text-gray-500 hover:text-orange-600">{{ inquire.product.name }}</a>
            <p v-if="isAdmin()">From: <h1 class="text-xl font-bold text-indigo-600 capitalize">{{ inquire.user.name }}</h1></p>
        </div>
        </div>
      </div>
      <div class="h-full overflow-hidden py-4">
        <div class="h-full overflow-y-auto">
          <div class="grid grid-cols-12 gap-y-2">
            <template v-for="message in inquire.replies" :key="message">
                <div v-if="current_user.id == message.user_id" class="col-start-6 col-end-13 p-3 rounded-lg">
                  <div class="flex items-center justify-start flex-row-reverse">
                    <div
                        class="relative text-sm bg-indigo-100 py-2 px-4 shadow rounded-xl"
                    >
                      <div>{{ message.message }}</div>
                    </div>
                  </div>
                  <p class="text-right mr-2 font-bold text-gray-700">Me</p>
                </div>
                <div v-else class="col-start-1 col-end-8 p-3 rounded-lg">
                  <div class="flex flex-row items-center">
                    <div
                        class="relative text-sm bg-white py-2 px-4 shadow rounded-xl"
                    >
                      <div>
                        {{ message.message }}
                      </div>
                    </div>
                  </div>
                  <p v-if="this.isAdmin()" class="ml-2 font-bold text-gray-700">{{ inquire.user.name }}</p>
                  <p v-else class="ml-2 font-bold text-gray-700">Ming Computer Solutions</p>
                </div>
            </template>
          </div>
        </div>
      </div>
      <div class="flex flex-row items-center">
        <div class="flex flex-row items-center w-full border rounded-3xl h-12">
          <div class="w-full">
            <input v-model="message" type="text"
                   class="border rounded-3xl border-transparent w-full focus:outline-none text-sm h-10 flex items-center" placeholder="Type your message....">
          </div>
        </div>
        <div class="ml-6">
          <button @click="sendReply()" class="flex items-center justify-center h-10 w-10 rounded-full bg-gray-200 hover:bg-gray-300 text-indigo-800 text-white">
            <svg class="w-5 h-5 transform rotate-90 -mr-px"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
            </svg>
          </button>
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
              if(this.app.is_customer) {
                window.Echo.join(`noticecustomer${this.app.current_user.id}`)
                .listen('NoticeCustomer', e => {
                    this.getInquires()
                })
              } else {
                window.Echo.join("noticeadmin")
                .listen('MessageSent', e => {
                    this.getInquires()
                })
              }
            },
            isAdmin() {
                return !this.app.is_customer
            },
            async sendReply() {
                var form = {
                    message: this.message,
                    inquire_id: this.inquire.id,
                    user_id: this.current_user.id
                }
                await axios.post('/reply-message', form)
                .then(response => {
                    this.getInquires()
                    this.inquire.replies.push(form)
                    this.message = ''
                })
            },
            async selectInquire(inquire) {
                this.inquire_id = inquire.id
                this.inquire = inquire

                if(this.current_user.id != inquire.user_last_message) {
                  this.seenInquire(inquire.id) 
                }
            },
            async seenInquire(id) {
              await axios.put(`/seen-inquire/${id}`)
              .then(response => {
                this.getInquires()
              });
            },
            async getInquires() {
                if(this.app.is_customer) {
                  await axios.get('/customer-inquires')
                  .then(response => {
                      this.inquires = response.data.data
                      if(this.inquire_id != 0) {
                        this.inquire = response.data.data.find( ({ id }) => id === this.inquire_id )
                      }
                  })
                } else {
                  await axios.get('/admin-inquires')
                  .then(response => {
                      this.inquires = response.data.data
                      if(this.inquire_id != 0) {
                        this.inquire = response.data.data.find( ({ id }) => id === this.inquire_id )
                      }
                  })
                }
            },
            checkLastMessage(message) {
              if(message.unseen == 0) {
                return false
              } else {
                if(message.replies.length == 0) {
                  if(this.isAdmin) {
                    return true
                  } else {
                    return false
                  }
                } else {
                  const id = this.checkLastMessage(message.replies)
                  if(id == this.app.current_user.id) {
                    return false
                  } else {
                    return true
                  }
                }
              }
            },
            lastMessageId(replies){
              return replies[replies.length-1].user_id
            },
            async messageSeen() {
              await axios.get('/seen-message')
            }
        },
        created() {
            this.current_user = this.app.current_user
            this.connect()
            if(this.app.is_customer) {
              this.messageSeen()
            }
        }
    }
</script>