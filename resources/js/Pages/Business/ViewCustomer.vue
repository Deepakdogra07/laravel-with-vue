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
        <div class="card">
            <div class="card-image">
                        <img :src="customer.customer_image" alt="" width="450px">
                    </div>
                    <div class="card-header">
                        <h1>{{ customer.first_name }} {{ customer.last_name }}</h1>
                        </div>

                    <div class="card-body">
                        <h2>Other Details:</h2>
                        <b>Date of Birth:</b>{{ customer.date_of_birth }}<br>
                        <b>County of birth:</b>{{ customer.country_of_birth }}<br>
                        <b>City of birth:</b>{{ customer.city_of_birth }}<br>
                        <b>martial_status:</b>{{ customer.martial_status }}<br>
                        <b>Country to immigrate:</b>{{ customer.migrate_country }}<br>
                        <b>Gender:</b>{{ customer.gender }}<br>
                        <!-- {{ customer.martial_status }} -->

                    </div>
                </div>
               
               
               
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