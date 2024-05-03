<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Header from '../Frontend/Header.vue';
import Footer from '../Frontend/Footer.vue';



const props = defineProps({
  footer_data: {
    type: Object
  },
  jobs:{
    type:Array
  }
});


</script>

<template>
        <Header :logo_image="footer_data.logo_image" />
        <div>
            <h2>View Posted Jobs:</h2>
        </div>
        <Footer :footer_data="footer_data" />

</template>
<style scoped>
   
</style>
