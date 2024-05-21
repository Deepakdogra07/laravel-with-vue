<script setup>
import Header from '@/Pages/Frontend/Header.vue'
import Footer from '@/Pages/Frontend/Footer.vue'
import SubHeading from '@/Pages/Frontend/SubHeading.vue'
import { Link } from '@inertiajs/vue3';


</script>
<template>
    <Header />
    <SubHeading />
    <div class="login-bg-wrapper four_zero_four_page">
        <div class="container">
            <div class="row justify-content-center" >
                <div class="col-lg-4 col-md-4 col-sm-12 relative" >
                    <img src="/images/404.png">
                    <h2 class="text-center text-uppercase mt-2">Sorry, Page not found</h2>
                </div>
            </div>
        </div>
    </div>
    <Footer />
</template>
<style scoped>
</style>