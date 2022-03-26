<template>
    <div class="min-h-full bg-orange-300 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="mt-6 flex justify-center">
            <div class="mt-6 flex-grow lg:mt-0 lg:ml-6 lg:flex-grow-0 lg:flex-shrink-0">
                <p class="text-sm font-medium text-gray-700" aria-hidden="true">
                    Change
                </p>
                <div class="mt-1 lg:hidden">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 inline-block rounded-full overflow-hidden h-12 w-12" aria-hidden="true">
                            <img class="object-cover rounded-full h-full w-full" src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-1.2.1&ixqx=GySe9Z9EJy&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=320&h=320&q=80" alt="">
                        </div>
                        <div class="ml-5 rounded-md shadow-sm">
                            <div class="group relative border border-gray-300 rounded-md py-2 px-3 flex items-center justify-center hover:bg-gray-50 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-light-blue-500">
                                <label for="user_photo" class="relative text-sm leading-4 font-medium text-gray-700 pointer-events-none">
                                    <span>Change</span>
                                    <span class="sr-only"> user photo</span>
                                </label>
                                <input @change="profilePrictureChange" id="user_photo" name="user_photo" type="file" class="absolute w-full h-full opacity-0 cursor-pointer border-gray-300 rounded-md">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="hidden relative rounded-full overflow-hidden lg:block">
                    <img class="object-cover  relative rounded-full w-40 h-40" :src="form.profilePicture ? form.profilePicture : 'https://cdn.pixabay.com/photo/2014/04/03/10/32/businessman-310819_960_720.png'" alt="">
                    <label for="user-photo" class="absolute inset-0 w-full h-full bg-black bg-opacity-75 flex items-center justify-center text-sm font-medium text-white opacity-0 hover:opacity-100 focus-within:opacity-100">
                        <span>Change</span>
                        <span class="sr-only">user photo</span>
                        <input @change="profilePrictureChange" type="file" id="user-photo" name="user-photo" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer border-gray-300 rounded-md">
                    </label>
                </div>
            </div>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <div class="space-y-6">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700"> First Name </label>
                        <div class="mt-1">
                            <input :disabled="!isEdit" v-model="form.first_name" name="first_name" type="text" autocomplete="first_name" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                        </div>
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700"> Last Name </label>
                        <div class="mt-1">
                            <input :disabled="!isEdit" v-model="form.last_name" name="last_name" type="text" autocomplete="last_name" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                        </div>
                    </div>
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700"> City </label>
                        <div class="mt-1">
                            <select :disabled="!isEdit" @change="brgyList()" v-model="form.city" name="city" autocomplete="city" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                                <option v-for="location in locationsList" :key="location" :value="location.name">{{ location.name }}</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="brgy" class="block text-sm font-medium text-gray-700"> Barangay </label>
                        <div class="mt-1">
                            <select :disabled="!isEdit" v-model="form.brgy" name="brgy" autocomplete="brgy" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                                <option v-for="brgy in brgys" :key="brgy" :value="brgy">{{ brgy }}</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label for="phone_no" class="block text-sm font-medium text-gray-700"> Contact No. </label>
                        <div class="mt-1">
                            <input :disabled="!isEdit" v-model="form.phone_no" name="phone_no" type="text" autocomplete="phone_no" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700"> Email </label>
                        <div class="mt-1">
                            <input :disabled="!isEdit" v-model="form.email" name="email" type="text" autocomplete="email" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                        </div>
                    </div>
                    <div v-if="isEdit">
                        <button @click="updateData()" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">Update</button>
                        <button @click="isEdit = !isEdit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 mt-2">Cancel</button>
                    </div>
                    <div v-else>
                        <button @click="isEdit = !isEdit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">Edit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import locations from "./locations.json"

    export default {
        data() {
            return {
                form: {
                    first_name: '',
                    last_name: '',
                    phone_no: '',
                    city: '',
                    brgy: '',
                    email: '',
                    profilePicture: ''
                },
                locationsList: locations,
                brgys:[],
                image: null,
                isEdit: false
            }
        },
        methods:{
            buttonFunction() {

            },
            brgyList() {
                for(let value of Object.values(this.locationsList)){
                    if(value.name === this.form.city) {
                        this.brgys = value.barangay_list
                        break;
                    }
                }
            },
            profilePrictureChange() {
                this.image= event.target.files[0]
                this.form.profilePicture = URL.createObjectURL(this.image);
            },
            async getUser() {
                await axios.get('/my-data')
                .then(response => {
                    this.form = response.data.data
                })
            },
            async updateData() {
                let formData = new FormData();
                formData.append('image', this.image);
                formData.append('first_name', this.form.first_name);
                formData.append('last_name', this.form.last_name);
                formData.append('phone_no', this.form.phone_no);
                formData.append('city', this.form.city);
                formData.append('brgy', this.form.brgy);
                formData.append('email', this.form.email);

                await axios.post('/update-data', formData)
                .then(response => {
                    this.isEdit = false
                    this.form = response.data.data
                    this.$swal.fire({
                        title: 'Updated Successfully',
                        confirmButtonColor: "#ea580c"
                    })
                })
            }
        },
        created() {
            this.getUser()
        }
    }
</script>