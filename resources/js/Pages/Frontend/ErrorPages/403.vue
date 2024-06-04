<script setup>
import Header from '@/Pages/Frontend/Header.vue'
import Footer from '@/Pages/Frontend/Footer.vue'
import SubHeading from '@/Pages/Frontend/SubHeading.vue'
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    test:{
        type:String
    }
})
</script>
<template>
    <Header />
    <SubHeading />
    <div class="login-bg-wrapper 403_error_main">
        <div class="container">
            <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-3 403_page_top" >
                <!-- <div class="job-listing-cards relative 403_page" > -->
                    <!-- <div class="cards-content"> -->
                        <h1 style="text-align: center;color: #09332B;"> Page Not Found</h1>
                    <!-- </div> -->
                <!-- </div> -->
            </div>
        </div>
    </div>
    <Footer />
</template>
<style scoped>
</style>