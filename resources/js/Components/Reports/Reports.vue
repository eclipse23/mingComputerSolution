<template>
    <a :href="printUrl" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Print Reports
    </a>
    <div class="grid pt-12 lg:grid-cols-3 lg:gap-x-5 lg:gap-y-12 mb-4">
        <div class="relative bg-white border border-gray-300 rounded-md px-3 py-2 shadow-sm focus-within:ring-1 focus-within:ring-orange-600 focus-within:border-orange-600">
            <label for="name" class="absolute -top-2 left-2 -mt-px inline-block px-1 rounded bg-white text-xs font-medium text-gray-900">Filter By Month</label>
            <div class="mt-1 rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="country" class="sr-only">Month</label>
                    <select v-model="month" id="country" name="country" autocomplete="country-name" class="focus:ring-orange-500 focus:border-orange-500 relative block w-full rounded-none rounded-t-md bg-transparent focus:z-10 sm:text-sm border-gray-300">
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
                <div>
                    <label for="country" class="sr-only">Year</label>
                    <input type="number" min="1900" max="2099" step="1" v-model="month_year" name="year" id="year" class="focus:ring-orange-500 focus:border-orange-500 relative block w-full rounded-none rounded-b-md bg-transparent focus:z-10 sm:text-sm border-gray-300">
                </div>
            </div>
      </div>

      <div class="bg-white relative border border-gray-300 rounded-md px-3 py-2 shadow-sm focus-within:ring-1 focus-within:ring-orange-600 focus-within:border-orange-600">
            <div class="mt-1 rounded-md shadow-sm -space-y-px">
                <div>
                    <div class="relative border border-gray-300 rounded-md px-3 py-2 shadow-sm focus-within:ring-1 focus-within:ring-orange-600 focus-within:border-orange-600">
                        <label for="name" class="absolute -top-2 left-2 -mt-px inline-block px-1 bg-white text-xs font-medium text-gray-900">Filter By Year</label>
                        <input type="number" min="1900" max="2099" step="1" v-model="year" name="year" id="year" class="block w-full border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0 sm:text-sm">
                    </div>
                </div>
                <div>
                <div class="relative border border-gray-300 rounded-md px-3 py-2 shadow-sm focus-within:ring-1 focus-within:ring-orange-600 focus-within:border-orange-600">
                    <label for="name" class="absolute -top-2 left-2 -mt-px inline-block px-1 bg-white text-xs font-medium text-gray-900">Filter By day</label>
                    <input v-model="date" type="date" name="name" id="name" class="block w-full border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0 sm:text-sm">
                </div>
            </div>
            </div>
      </div>

      <div class="bg-white  relative border border-gray-300 rounded-md px-3 py-2 shadow-sm focus-within:ring-1 focus-within:ring-orange-600 focus-within:border-orange-600">
            <div class="mt-1 rounded-md shadow-sm -space-y-px">
                <div class="relative border border-gray-300 rounded-md px-3 py-2 shadow-sm focus-within:ring-1 focus-within:ring-orange-600 focus-within:border-orange-600">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative">
                        <select v-model="paymentMethod" id="search" name="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 sm:text-sm" placeholder="Search">
                            <option value="">Method</option>
                            <option value="e-payment">E-Payment</option>
                            <option value="pick-up">Pick-Up</option>
                            <option value="walk-in">Walk In</option>
                        </select>
                    </div>
                </div>
                <div>
                <div class="relative border border-gray-300 rounded-md px-3 py-2 shadow-sm focus-within:ring-1 focus-within:ring-orange-600 focus-within:border-orange-600">
                    <input disabled :value="`Total: ${formatPrice(totalIncome)}`" class="font-bold block w-full border-0 p-0 text-gray-900 placeholder-gray-500 focus:ring-0 sm:text-sm">
                </div>
            </div>
            </div>
      </div>
    </div>
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cart ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Odd row -->
                    <tr v-for="sold in solds" :key="sold" class="bg-white">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ sold.cart_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ sold.product.name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ sold.method }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ sold.quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ formatPrice(sold.product.price) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ formatPrice(sold.total_price) }}</td>
                    </tr>

                    <!-- More people... -->
                </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                solds: [],
                month: null,
                year: null,
                month_year: null,
                date: null,
                params: {
                    month: null,
                    year: null,
                    month_year: null,
                    date: null,
                    paymentMethod: ''
                },
                totalIncome: 0,
                printUrl: '',
                paymentMethod: '',
            }
        },
        watch: {
            paymentMethod: function(newValue) {
                this.params.paymentMethod = newValue
                this.getReports()
            },
            date: function(newVal){
                this.params.month = null
                this.params.month_year = null
                this.params.year = null
                this.params.date = newVal
                this.month = null
                this.year = null
                this.month_year = null
                this.getReports()
                this.printUrl = `/print-daily/${newVal}`
            },
            year: function(newVal){
                this.params.month = null
                this.params.month_year = null
                this.params.year = newVal
                this.params.date = null
                this.date = null
                this.month_year = null
                this.month = null
                this.getReports()
                this.printUrl = `/print-yearly/${newVal}`
            },
            month: function(newVal){
                this.params.month = newVal
                this.params.year = null
                this.params.date = null
                this.year = null
                this.data = null
                if(this.params.month_year != null) {
                    this.getReports()
                    this.printUrl = `/print-monthly/${newVal}/${this.month_year}`
                }
            },
            month_year: function(newVal){
                this.params.month_year = newVal
                this.params.year = null
                this.params.date = null
                this.year = null
                this.data = null
                if(this.params.month != null) {
                    this.getReports()
                    this.printUrl = `/print-monthly/${this.month}/${newVal}`
                }
            }
        },
        methods: {
            async getReports(){
                this.totalIncome = 0
                await axios.get('/get-reports', {
                    params: this.params
                }).then(response => {
                    this.solds = response.data
                    response.data.forEach(element => {
                        this.totalIncome = parseInt(element.total_price) + this.totalIncome
                    });
                });
            }
        },
        created() {
            this.getReports()
        }
    }
</script>