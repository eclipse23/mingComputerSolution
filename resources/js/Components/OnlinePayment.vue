<template>
    <div>
        
    </div>
</template>

<script>
    import { loadStripe } from '@stripe/stripe-js';

    export default {
        data() {
            return {
                stripe: {},
                cardElement: {},
                intentToken: ''
            }
        },
        async mounted() {
            this.stripe = await loadStripe(process.env.MIX_STRIPE_KEY);
            const elements = this.stripe.elements();
            this.cardElement = elements.create('card', {
                classes: {
                    base: 'bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 p-3 leading-8 transition-colors duration-200 ease-in-out'
                }
            });
            this.cardElement.mount('#card-element');
        },
        created() {
            console.log('payment')
            axios.get(`/user/setup-intent`)
            .then( function( response ){
                console.log(response);
                this.intentToken = response.data;
            })
        }
    }
</script>