<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Header from '../Frontend/Header.vue';
import Footer from '../Frontend/Footer.vue';



const props = defineProps({
  footer_data: {
    type: Object
  }
});


</script>

<template>
        <Header :logo_image="footer_data.logo_image" />
        <div>
            <h1>Customer Dashboard</h1>
        </div>
        <Footer :footer_data="footer_data" />

</template>
<style scoped>
   
</style>
