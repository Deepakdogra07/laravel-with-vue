<script setup>
import { Link } from '@inertiajs/vue3';
import 'bootstrap-icons/font/bootstrap-icons.css';
import { usePage } from '@inertiajs/vue3'
import { ref, computed } from "vue";
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import $ from 'jquery';
import { onMounted } from 'vue';

const dropdownOpen = ref(false);

const page = usePage()
const site_data = computed(() => page.props.site_data);

const props = defineProps({
  logo_image: {
    type: String
  }
})

const mobileMenu = ref(false);
const height = ref(0);

const showMenu = () => {
  const animationDuration = 200; // in milliseconds
  const framesPerSecond = 120;
  const totalFrames = animationDuration / (1000 / framesPerSecond);
  const heightIncrement = 313 / totalFrames;

  if (!mobileMenu.value) {
    mobileMenu.value = true;
    let currentHeight = 0;
    const animationInterval = setInterval(() => {
      currentHeight += heightIncrement;
      if (currentHeight >= 313) {
        clearInterval(animationInterval);
        height.value = 313;
      } else {
        height.value = currentHeight;
      }
    }, 1000 / framesPerSecond);
  } else {
    let currentHeight = 313;
    const animationInterval = setInterval(() => {
      currentHeight -= heightIncrement;
      if (currentHeight <= 0) {
        clearInterval(animationInterval);
        height.value = 0;
        mobileMenu.value = false;
      } else {
        height.value = currentHeight;
      }
    }, 1000 / framesPerSecond);
  }
};
const navbar_open = ref(true);
const admin_hover = ref(true);

function TriggerButton(type, event) {
  if (type == 'hamburger_icon') {
    event.preventDefault();
    navbar_open.value = true;
    admin_hover.value = false;
  } else if (type == 'admin_hover') {
    event.preventDefault();
    admin_hover.value = true;
    navbar_open.value = false;
  }
  // console.log(navbar_open.value ,'navbaer',admin_hover.value,'admin')
}

</script>

<template>
  <!-- <div class="container-fluid relative"> -->
  <div class="main-header">
    <nav class="navbar navbar-expand-lg" :class="{ '!bg-[#1D1F2C1A] border-home': route().current('home') }">
      <div class="container header_cn">
        <Link class="navbar-brand" href="/"><img :src="`${site_data?.logo_image}`" alt=""></Link>
        <div class="d-flex align-items-center gap-2">
          <GuestLayout>
            <div class="login-section-mob">
              <div class="login-section-desk" v-if="$page.props.auth.user">
                <dropdown>
                  <template #trigger>
                    <button @click="dropdownOpen = !dropdownOpen" class="main-btn">
                      {{ $page.props.auth.user.name }}
                      <i class="fa-solid fa-caret-down"></i>
                    </button>
                  </template>

                  <template #content>
                    <dropdown-link :href="route('dashboard')">
                      Dashboard
                    </dropdown-link>

                    <dropdown-link :href="route('profile.edit')">
                      Profile
                    </dropdown-link>

                    <dropdown-link class="w-full text-left" :href="route('logout')" method="post" as="button">
                      Log out
                    </dropdown-link>
                  </template>
                </dropdown>
              </div>

              <div class="login-section-mob" v-if="$page.props.auth.user">
                
                <div class="dropdown mobile_amdin_dropdown">
                  <button class="btn btn-secondary dropdown-toggle" @click="TriggerButton('admin_hover', $event)" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                      {{ $page.props.auth.user.name }}
                  </button>
                    <ul class="dropdown-menu" v-show="admin_hover">
                      <li><Link class="dropdown-item" :href="route('dashboard')"> Dashboard </Link></li>
                      <li><Link class="dropdown-item" :href="route('profile.edit')"> Profile </Link></li>
                      <li><Link class="dropdown-item":href="route('logout')" > Log out </Link></li>
                    </ul>
                  <!-- </div> -->
                </div>
              
              <!-- <dropdown >
                  <template #trigger>
                    <button class="main-btn"  @click="TriggerButton('admin_hover', $event)">
                      {{ $page.props.auth.user.name }}
                      <i class="fa-solid fa-caret-down"></i>
                    </button>
                  </template>
    
                  <template #content>
                    <div v-show="admin_hover">
                    
                    <dropdown-link :href="route('dashboard')">
                      Dashboard 
                    </dropdown-link>

                    <dropdown-link :href="route('profile.edit')">
                      Profile 
                    </dropdown-link>
    
                    <dropdown-link class="w-full text-left" :href="route('logout')" method="post" as="button">
                      Log out 
                    </dropdown-link>
                  </div>
                  </template>
                </dropdown>   -->


            </div>
            <div v-else="">
              <div class="nav-item">
                <Link class="main-btn" :href="route('login')">Login</Link>
              </div>
            </div>
        </div>
        </GuestLayout>
        <div class="login-section-desk">
        <button @click="TriggerButton('hamburger_icon', $event)" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
          aria-controls="navbarNav"  style="padding-right: 0;">
          <!-- <button class="btn btn-secondary dropdown-toggle" @click="TriggerButton('hamburger_icon', $event)" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false"> -->
          <span><i class="bi bi-list" ></i></span>
        </button>
      </div>
      <div class="collapse navbar-collapse justify-center" id="navbarNav" v-show="navbar_open">
      <!-- <div id="navbarNav" class="collapse navbar-collapse justify-center" v-show="navbar_open"> -->
        <ul class="navbar-nav gap-3">
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active-nav': route().current() == 'home' }" aria-current="page" href="/">
            Home
            </Link>
          </li>
          <li class="nav-item" v-if="!$page.props.auth.user || $page?.props?.auth?.user?.user_type == 3">
            <Link class="nav-link" :class="{ 'active-nav': route().current() == 'job.listing' }" href="/job-listing">
            For Individuals</Link>
          </li>
          <li class="nav-item">
            <!-- v-if="$page?.props?.auth?.user?.user_type == 2" -->
            <Link class="nav-link" :href="route('business-jobs.index')"
              :class="{ 'active-nav': route().current() == 'business-jobs.index' }">For Businesses</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active-nav': route().current() == 'testimonial.main' }"
              href="/testimonials">Our
            Testimonials</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active-nav': route().current() == 'about.us' }" href="/about-us">About
            Us</Link>
          </li>
        </ul>
        </div>
         <!-- Section mobile -->
         <div class="login-section-mob">
          <div class="dropdown mobile_amdin_dropdown navbar_toggler_tab">
                  <button class="btn dropdown-toggle" @click="TriggerButton('hamburger_icon', $event)" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <span><i class="bi bi-list" ></i></span>
                  </button>
                    <ul class="dropdown-menu toggler_menu" v-show="navbar_open">
              <li class="nav-item">
                <Link class="nav-link" :class="{ 'active-nav': route().current() == 'home' }" aria-current="page" href="/">
                Home
                </Link>
              </li>
              <li class="nav-item" v-if="!$page.props.auth.user || $page?.props?.auth?.user?.user_type == 3">
                <Link class="nav-link" :class="{ 'active-nav': route().current() == 'job.listing' }" href="/job-listing">
                For Individuals</Link>
              </li>
              <li class="nav-item">
                <!-- v-if="$page?.props?.auth?.user?.user_type == 2" -->
                <Link class="nav-link" :href="route('business-jobs.index')"
                  :class="{ 'active-nav': route().current() == 'business-jobs.index' }">For Businesses</Link>
              </li>
              <li class="nav-item">
                <Link class="nav-link" :class="{ 'active-nav': route().current() == 'testimonial.main' }"
                  href="/testimonials">Our
                Testimonials</Link>
              </li>
              <li class="nav-item">
                <Link class="nav-link" :class="{ 'active-nav': route().current() == 'about.us' }" href="/about-us">About
                Us</Link>
              </li>
            </ul>
                  <!-- </div> -->
                </div>
        </div>
       
        <!-- </div> -->
      </div>
      <GuestLayout>
        <div class="login-section-desk">
          <div class="login-section-desk" v-if="$page.props.auth.user">
            <div class="dropdown mobile_amdin_dropdown">
                  <button class="btn btn-secondary dropdown-toggle" @click="TriggerButton('admin_hover', $event)" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                      {{ $page.props.auth.user.name }}
                  </button>
                    <ul class="dropdown-menu" v-show="admin_hover">
                      <li><Link class="dropdown-item" :href="route('dashboard')"> Dashboard </Link></li>
                      <li><Link class="dropdown-item" :href="route('profile.edit')"> Profile </Link></li>
                      <li><Link class="dropdown-item":href="route('logout')"> Log out </Link></li>
                    </ul>
                  <!-- </div> -->
                </div>
          </div>
          <!-- <div v-else="">
                <div class="nav-item">
                  <Link class="main-btn" :href="route('login')">Login</Link>
                </div>
              </div> -->
          <div class="login-section-mob" v-if="$page.props.auth.user">
            <dropdown>
              <template #trigger>
                <button @click="dropdownOpen = !dropdownOpen" class="main-btn">
                  {{ $page.props.auth.user.name }}
                  <i class="fa-solid fa-caret-down"></i>
                </button>
              </template>

              <template #content>
                <dropdown-link :href="route('dashboard')">
                  Dashboard
                </dropdown-link>
                <dropdown-link :href="route('profile.edit')">
                  Profile
                </dropdown-link>

                <dropdown-link class="w-full text-left" :href="route('logout')" method="post" as="button">
                  Log out
                </dropdown-link>
              </template>
            </dropdown>
          </div>
          <div v-else="">
            <div class="nav-item">
              <Link class="main-btn" :href="route('login')">Login</Link>
            </div>
          </div>
        </div>
      </GuestLayout>
  </div>
  </nav>
  </div>
  <!-- </div> -->
</template>



<!-- <script>
     $(document).ready(function(){
      $(".main-btn").click(function(){
        $(".main-header").toggleClass("main");
      });
    });
      </script>  -->





<style scoped>
.border-home {
  border-bottom: 1px solid #A5A5AB !important;
}

.navbar {
  background-color: #01796f;
}

@media (max-width: 992px) {
  .aside-section {
    position: absolute;
    height: unset;
    top: 100px;
    overflow: hidden;
    width: 94%;
    left: 50%;
    transform: translateX(-50%);
  }
}

@media (max-width: 576px) {
  .container {
    position: relative;
  }

  .aside-section {
    top: 79px;
  }
}
</style>
