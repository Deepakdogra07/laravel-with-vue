<script setup>
import { Link } from '@inertiajs/vue3';
import 'bootstrap-icons/font/bootstrap-icons.css';
import { usePage } from '@inertiajs/vue3'
import { ref, onMounted, computed } from "vue";
import axios from 'axios';

const page = usePage()
const site_data = computed(() => page.props.site_data)

const nameFirstLetter = ref('');


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

</script>

<template>

  <div class="main-header">
    <nav class="navbar navbar-expand-lg" :class="{ '!bg-[#1D1F2C1A] border-home': route().current('home') }">
      <div class="container">
        <Link class="navbar-brand" href="/"><img :src="`/storage/logos/${site_data.logo_image}`" alt=""></Link>
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
          <Link class="main-btn" :href="route('login')">Login</Link>
        </div>
      </div>
    </nav>
  </div>



</template>

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
