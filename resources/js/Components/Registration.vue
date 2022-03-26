<template>
    <div class="min-h-full bg-orange-300 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
             <div class="sm:mx-auto sm:w-full sm:max-w-md">
                <h2 class="pt-6 text-center text-3xl font-extrabold text-gray-900">
                    Register now for free!
                </h2>
            </div>
            <div class="bg-gray-300 py-8 px-4 shadow sm:rounded-lg sm:px-10">
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
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700"> Password </label>
                        <div class="mt-1">
                            <input v-model="form.password" name="password" type="password" autocomplete="password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                        </div>
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700"> Repeat Password </label>
                        <div class="mt-1">
                            <input v-model="form.password_confirmation" name="password_confirmation" type="password" autocomplete="password_confirmation" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                        </div>
                    </div>
                    <div class="flex items-center justify-between pt-4">
                        <div class="flex justify-between items-center">
                            <input v-model="isReaded" name="remember-me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-900 ml-4 font-bold">
                               Yes, I agree with  <a :href="'/disclaimer'" class="text-purple-600 hover:text-purple-400" target="_blank">Disclaimer or terms and condition</a>
                            </label>
                        </div>
                    </div>
                    <div>
                        <button @click="storeData" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">Register</button>
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
                    profilePicture: '',
                    password: '',
                    password_confirmation: '',
                },
                locationsList: locations,
                brgys: [],
                image: null,
                isEdit: true,
                isReaded: false
            }
        },
        methods:{
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
            async storeData() {
                let formData = new FormData();
                formData.append('first_name', this.form.first_name);
                formData.append('last_name', this.form.last_name);
                formData.append('phone_no', this.form.phone_no);
                formData.append('city', this.form.city);
                formData.append('brgy', this.form.brgy);
                formData.append('email', this.form.email);
                formData.append('password', this.form.password);
                formData.append('password_confirmation', this.form.password_confirmation);

                if(this.form.password != this.form.password_confirmation) {
                    this.$swal.fire({
                        title: "Password not Matched!",
                        confirmButtonColor: "#ea580c"
                    })
                } else {
                    if(!this.isReaded) {
                        this.$swal.fire({
                            title: "Agree with the disclaimer",
                            confirmButtonColor: "#ea580c"
                        })
                    } else {
                        await axios.post('/register', formData)
                        .then(response => {
                            this.isEdit = false
                            this.form = response.data.data
                            this.$swal.fire({
                                title: 'Registered Successfully',
                                confirmButtonColor: "#ea580c"
                            })
                            window.location.href = "/"
                        })
                    }
                }
            }
        }
    }
</script>