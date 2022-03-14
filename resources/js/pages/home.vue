<template>
    <div class="container">
        <div class="d-flex flex-row gap-3">
            <shop-current-availability></shop-current-availability>
            <shop-availability class="pt-10"></shop-availability>
            <shop-nearest-availability class="pt-10"></shop-nearest-availability>
        </div>
    </div>
</template>


<script>
import ShopCurrentAvailability from '../components/ShopCurrentAvailability.vue';
import ShopAvailability from '../components/ShopAvailability.vue';
import NearestAvailability from '../components/NearestAvailability.vue';
export default {
    components: {
        'shop-current-availability': ShopCurrentAvailability,
        'shop-availability': ShopAvailability,
        'shop-nearest-availability': NearestAvailability
    },
}
</script>

<style scoped>
.pt-10 {
    padding-top: 10px;
}
</style>
