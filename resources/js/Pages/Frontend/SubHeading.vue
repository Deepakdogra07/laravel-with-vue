<script setup>
import { Link } from '@inertiajs/vue3';

</script>
<template>
    <div class="sub-heading-section" :class="{'!pb-[50px]' : !route().current('login') || !route().current('password.request')}">
        <div class="container">
            <h1 class="mb-0" v-if="route().current('login') || route().current('password.request') || route().current('password.reset') ">Welcome to Login</h1>
            <h1 class="mb-0" v-if="route().current('job.listing') || route().current('view.job')">List of Jobs</h1>
            <h1 class="mb-0" v-if="route().current('register')">Create New Account For Business</h1>
            <h1 class="mb-0" v-if="route().current('contact.us')">Contact us</h1>
            <h1 class="mb-0" v-if="route().current('about.us')">About us</h1>
            <h1 class="mb-0" v-if="route().current('business-jobs.create')">Job Application Form</h1>
            <h1 class="mb-0" v-if="route().current('testimonial.main')">Testimonial</h1>
        </div>
    </div>
    <div class="form-navigation" v-if="route().current('login') || route().current('password.request') || route().current('register') || route().current('password.reset')">
        <div class="container">
            <ul class="row nav-underline pl-0">
                <div class="col-md-1 col-3">
                    <li class="nav-item">
                        <Link class="nav-link text-center" 
                            :class="{ 'active': route().current('login') || route().current('password.request') }" 
                            aria-current="page" 
                            :href="route('login')"
                        >Login</Link>
                    </li>
                </div>
                <div class="col-md-2 col-5">
                    <li class="nav-item">
                        <Link class="nav-link text-center"  
                            :class="{ 'active': route().current('register') }"  
                            :href="route('register')"
                        >Create account</Link>
                    </li>
                </div>
            </ul>
        </div>
    </div>
</template>

<style scoped>

.sub-heading-section h1{
    color: #fff;
    font-size: 40px !important;
}

.form-navigation li a{
    font-size: 18px !important;
}

@media(max-width: 992px){
    .sub-heading-section h1{
        font-size: 30px !important;
    }
}

</style>