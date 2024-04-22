<script setup>
import { Link } from '@inertiajs/vue3';

</script>
<template>
    <div class="sub-heading-section" :class="{'!pb-[50px]' : !route().current('login') || !route().current('password.request')}">
        <div class="container">
            <h2 class="mb-0" v-if="route().current('login') || route().current('password.request')">Welcome to Login</h2>
            <h2 class="mb-0" v-if="route().current('job.listing') || route().current('view.job')">List of Jobs</h2>
            <h2 class="mb-0" v-if="route().current('register')">Create New Account For Business</h2>
            <h2 class="mb-0" v-if="route().current('contact.us')">Contact us</h2>
            <h2 class="mb-0" v-if="route().current('testimonial.main')">Testimonial</h2>
        </div>
    </div>
    <div class="form-navigation" v-if="route().current('login') || route().current('password.request') || route().current('register')">
        <div class="container">
            <ul class="nav nav-underline gap-5">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" :href="route('login')">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" :href="route('register')">Create account</a>
                </li>
            </ul>
        </div>
    </div>
</template>