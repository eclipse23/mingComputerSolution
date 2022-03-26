<template>
    <recommended v-if="auth"></recommended>
    <featured-items></featured-items>
    <new-arrival-items></new-arrival-items>
</template>
<script>
import Recommended from "./Recommended.vue"
import FeaturedItems from "./FeaturedItems.vue"
import NewArrivalItems from "./NewArrivalItems.vue"

export default {
    components: {
        Recommended,
        FeaturedItems,
        NewArrivalItems
    },
    data() {
        return {
            auth: null
        }
    },
    created() {
        this.auth = this.app.logged_in
    }
}
</script>