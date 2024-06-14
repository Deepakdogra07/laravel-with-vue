<script setup>
import 'vue3-toastify/dist/index.css';
import Header from '@/Pages/Frontend/Header.vue'
import Footer from '@/Pages/Frontend/Footer.vue'
import SubHeading from '@/Pages/Frontend/SubHeading.vue'

const props = defineProps({
    customer:{
        type:Object
    }
});
</script>

<template>
    <Header />
    <SubHeading :job_id ="job_id"/>
    <div class="container py-12">
                
               
               
               
            </div>
        <Footer/>
</template>

<style scoped>
.success{
    color:green;
}
.main-outer-section{
    background-color: #F2F2F2;
}
.active-filter {
    color: #1A9882; /* Change color as per your requirement */
    border-bottom: 2px solid #1A9882;
}
.text-danger{
    color:red;
}
</style>