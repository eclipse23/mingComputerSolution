<template>
    <div class="bg-white pt-4">
        <loading :isLoading="isLoading"></loading>
        <div class="mt-8 max-w-3xl mx-auto grid grid-cols-1 gap-6 sm:px-6 lg:max-w-7xl grid-flow-col-dense lg:grid-cols-3">
            <div class="space-y-6 col-start-2 col-span-2">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                    <th scope="col" class="px-6 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th scope="col" class="px-6 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pcs</th>
                                    <th scope="col" class="px-6 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Odd row -->
                                    <tr v-for="item in cart" :key="item" class="bg-white">
                                        <td class="px-6 py-1 whitespace-nowrap text-sm font-medium text-gray-900">{{ item.name }}</td>
                                        <td class="px-6 py-1 whitespace-nowrap text-sm text-gray-500">{{ item.pcs }}</td>
                                        <td class="px-6 py-1 whitespace-nowrap text-sm text-gray-500">₱ {{ formatPrice(item.price) }}</td>
                                        <td class="px-6 py-1 whitespace-nowrap text-right text-sm font-medium">
                                            <a @click="removeItem(item)" class="text-orange-600 hover:text-orange-900">Remove</a>
                                        </td>
                                    </tr>
                                </tbody>
                                </table>
                            </div>
                            <div class="bg-gray-50 mt-2">
                                <div class="isolate -space-y-px rounded-md shadow-sm">
                                    <div class="relative border bg-white rounded-md rounded-b-none px-3 py-2 focus-within:z-10 focus-within:ring-1 focus-within:ring-indigo-600 focus-within:border-indigo-600">
                                        <label for="name" class="block text-xs font-medium text-gray-700">Customer Name</label>
                                        <input v-model="customer" type="text" name="name" id="name" class="font-bold w-full block border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0 sm:text-sm">
                                    </div>
                                    <div @click="inputAmount()" class="relative bg-white border px-3 py-2 focus-within:z-10 focus-within:ring-1 focus-within:ring-indigo-600 focus-within:border-indigo-600">
                                        <label for="name" class="block text-xs font-medium text-gray-700">Cash</label>
                                        <input disabled :value="`₱ ${formatPrice(cash)}`" type="text" name="name" id="name" class="font-bold block w-full border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0 sm:text-sm">
                                    </div>
                                    <div class="relative border border-gray-300 rounded-md rounded-t-none px-3 py-2 focus-within:z-10 focus-within:ring-1 focus-within:ring-indigo-600 focus-within:border-indigo-600">
                                        <label for="job-title" class="block w-full text-xs font-medium text-gray-700">Change</label>
                                        <input disabled :value="`₱ ${formatPrice(change)}`" name="job-title" id="job-title" class="font-bold block w-full border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0 sm:text-sm">
                                    </div>
                                </div>
                                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:py-4 lg:px-8 lg:flex lg:items-center lg:justify-between">
                                    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                                    <span class="block">Total</span>
                                    <span class="block text-orange-600">₱  {{ this.formatPrice(reduceTotal()) }}</span>
                                    </h2>
                                    <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                                    <div class="inline-flex rounded-md shadow">
                                        <button :disabled="processValidation()" @click="checkout()" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700">Process Payment</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-start-1 col-span-1">
                <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Products</h2>
                <products :refreshProduct="getProducts" @addToCart="addToCart"/>
            </div>
        </div>
    </div>
</template>

<script>
    import Products from './Products.vue'
    import Loading from "../LoadingSpinner.vue"

    export default {
        components: {
            Products,
            Loading
        },
        data() {
            return {
                cart: [],
                total: 0,
                cash: 0,
                change: 0,
                isLoading: false,
                getProducts: false,
                customer: ''
            }
        },
        watch: {
            cash: function(value) {
                this.change = value - this.total
            }
        },
        methods: {
            processValidation() {
                if(this.cash < this.reduceTotal()) {
                    return true
                } else {
                    if(this.cart.length == 0) {
                        return true
                    } else {
                        false
                    }
                }
            },
            inputAmount() {
                this.$swal.fire({
                    title: 'Input Cash Amount',
                    input: 'number',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    showLoaderOnConfirm: true,
                    preConfirm: (amount) => {
                        this.cash = amount
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                    }).then((result) => {
                    
                })
            },
            removeItem(item) {
                this.cart = this.cart.filter(function( obj ) {
                    return obj.product_id !== item.product_id;
                });
            },
            reduceTotal() {
                const total = Object.values(this.cart).reduce((t, cart) => t + (parseFloat(cart.price)*parseFloat(cart.pcs)), 0)
                this.total = total
                return total
            },
            addToCart(product) {
                if(product.stock < 1) {
                    this.$swal.fire('Item Out of stock')
                } else {
                    this.$swal.fire({
                    text: 'Number of Items',
                    title: product.name,
                    input: 'number',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Add Item',
                    confirmButtonColor: '#ea580c',
                    showLoaderOnConfirm: true,
                    preConfirm: (quantity) => {
                        if(!quantity > 0) {
                            this.$swal.fire('Please enter quantity')
                        } else {
                            var item = {
                                product_id: product.id,
                                pcs: quantity,
                                name: product.name,
                                price: product.price
                            }

                            var index = this.cart.findIndex(x => x.product_id === product.id);
                            
                            if(index >= 0) {
                                if((parseInt(this.cart[index].pcs) + parseInt(quantity)) > parseInt(product.stock)) {
                                    this.$swal.fire('Insufficient Stock')
                                } else {
                                    this.cart[index].pcs = parseInt(this.cart[index].pcs) + parseInt(quantity)
                                }
                            } else {
                                if(parseInt(quantity) > parseInt(product.stock)) {
                                    this.$swal.fire('Insufficient Stock')
                                } else {
                                    this.cart.push(item)
                                }
                            }
                        }
                    },
                    allowOutsideClick: () => !this.$swal.isLoading()
                    }).then((result) => {
                    if (result.isConfirmed) {
                        
                    }
                })
                }
            },
            async checkout() {
                this.isLoading = true
                var form = {
                    list: this.cart,
                    customer: this.customer
                }
                await axios.post('/cashier-checkout', form)
                .then(response => {
                    this.isLoading = false
                    this.getProducts = !this.getProducts
                    this.cart = []
                    this.cash = 0
                    this.total = 0
                    window.open(`/receipt/${response.data.id}`, '_blank');
                })
            }
        },
        created() {
            console.log(this.userGreetings('asdasdas'))
        }
    }
</script>
