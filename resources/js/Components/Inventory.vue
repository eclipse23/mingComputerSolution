<template>
    <a href="/inventory-print" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Print Inventory
    </a>
    <div class="flex flex-col mt-8">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reserved</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sold</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Odd row -->
                    <tr v-for="sold in solds" :key="sold" class="bg-white">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ sold.id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ sold.name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ sold.reserved }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ sold.sold }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ formatPrice(sold.price) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ formatPrice(sold.price*sold.sold) }}</td>
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
                    date: null
                },
                totalIncome: 0,
                printUrl: ''
            }
        },
        watch: {
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
            async getProducts(){
                this.totalIncome = 0
                await axios.get('/inventory-products').then(response => {
                    this.solds = response.data
                    response.data.forEach(element => {
                        this.totalIncome = parseInt(element.total_price) + this.totalIncome
                    });
                });
            }
        },
        created() {
            this.getProducts()
        }
    }
</script>