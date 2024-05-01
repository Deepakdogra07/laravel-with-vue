<script setup>
import { Link } from '@inertiajs/vue3';
import 'bootstrap-icons/font/bootstrap-icons.css';
import { usePage } from '@inertiajs/vue3'
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';


const props = defineProps({
  logo_image: {
    type: String
  }
})


</script>


<template>
    <Header>
        <div class="main-header">
    <nav class="navbar navbar-expand-lg" :class="{ '!bg-[#1D1F2C1A] border-home': route().current('home') }">
    <div class="container">
        <Link class="navbar-brand" href="/"><img :src="`${logo_image}`" alt=""></Link>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span><i class="bi bi-list"></i></span>
        </button>
        <div class="collapse navbar-collapse justify-center" id="navbarNav">
        <ul class="navbar-nav gap-3">
            <li class="nav-item">
            <Link class="nav-link" :class="{ 'active-nav': route().current() == 'home' }" aria-current="page" href="/">Home</Link>
            </li>
            <li class="nav-item">
            <Link class="nav-link" :class="{ 'active-nav': route().current() == 'job.listing' }" href="/job-listing">For Individuals</Link>
            </li>
            <li class="nav-item">
            <Link class="nav-link"  href="#">For Businesses</Link>
            </li>
            <li class="nav-item">
            <Link class="nav-link" :class="{ 'active-nav': route().current() == 'testimonial.main' }" href="/testimonials">Our Testimonials</Link>
            </li>
            <li class="nav-item">
            <Link class="nav-link" :class="{ 'active-nav': route().current() == 'about.us' }" href="/about-us">About Us</Link>
            </li>
            <li class="nav-item login-section-mob">
            <Link class="main-btn" :href="route('login')">Login</Link>
            </li>
        </ul>
        </div>
        <div class="login-section-desk">                 
            <dropdown>
                <template #trigger>
                    <button @click="dropdownOpen = ! dropdownOpen" class="btn btn-info">
                        {{ $page.props.auth.user.name }}
                    </button>
                </template>

                <template #content>
                    <dropdown-link :href="route('profile.edit')">
                        Profile
                    </dropdown-link>

                    <dropdown-link class="w-full text-left" :href="route('logout')" method="post" as="button">
                        Log out
                    </dropdown-link>
                </template>
            </dropdown>
        </div>
    </div>
    </nav>
    </div>

    </Header>
</template>


