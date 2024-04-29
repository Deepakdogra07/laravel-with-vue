<script setup>
    import Header from '@/Pages/Frontend/Header.vue'
    import Footer from '@/Pages/Frontend/Footer.vue'
    import SubHeading from '@/Pages/Frontend/SubHeading.vue'
    import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Header />
    <SubHeading />
    <div class="login-bg-wrapper">
        <div class="container">
            <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-3">
                <h1>Terms and Conditions</h1>
                
            </div>
        </div>
    </div>
    <Footer />
</template>