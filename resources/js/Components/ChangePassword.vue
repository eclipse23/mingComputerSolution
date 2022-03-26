<template>
    <div class="min-h-full bg-orange-300 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <div class="space-y-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700"> Password </label>
                        <div class="mt-1">
                            <input v-model="form.password" name="password" type="password" autocomplete="password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                        </div>
                    </div>
                    <div>
                        <label for="retype_password" class="block text-sm font-medium text-gray-700"> Repeat Password </label>
                        <div class="mt-1">
                            <input v-model="form.retype_password" name="retype_password" type="password" autocomplete="retype_password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-orange-500 focus:border-orange-500 sm:text-sm">
                        </div>
                    </div>
                    <div>
                        <button @click="changePassword()" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">Change Password</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: {
                    password: '',
                    retype_password: '',
                },
                isEdit: false
            }
        },
        methods:{
            async changePassword() {
                if(this.form.password != this.form.retype_password) {
                    this.$swal.fire({
                        title: "Password not Matched!",
                        confirmButtonColor: "#ea580c"
                    })
                } else {
                    await axios.post('/user-change-password', this.form)
                    .then(response => {
                        this.$swal.fire({
                            title: "Password change successfully",
                            confirmButtonColor: "#ea580c"
                        })
                        this.form = this.$options.data().form
                    })
                }
            }
        },
        created() {

        }
    }
</script>