<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Header from '../Pages/Frontend/Header.vue';
import Footer from '../Pages/Frontend/Footer.vue';
import { onMounted } from 'vue';
import { useToast } from 'vue-toastify';

const props = defineProps({
  sliders: {
    type: Object
  },
  logo: {
    type: Object
  },
  categories: {
    type: Object
  },
  footer_data: {
    type: Object
  }
});


const slickFn = () => {
  $('#home_banner').slick({
    arrows: false,
    autoplay: true,
    speed: 2,
    slidesToShow: 1,
    slidesToScroll: 1,
    infinite: true,
    dots: $('.web-banner').length > 1,
  });

  $('#welcome_slider_').slick({
    arrows: false,
    // centerMode: true,
    autoplay: true,
    speed: 2,
    slidesToShow: 3,
    slidesToScroll: 1,
    infinite: true,
    dots: $('.image_for_Card').length > 3,
    responsive: [
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 2,
        }
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        }
      }
    ],
  });
}
onMounted(() => {
  slickFn();
});

</script>
<template>
  <Header :logo_image="footer_data.logo_image" />

  <div class="banner-section container-fluid">
    <div id="home_banner">
      <div v-for="(slider) in sliders" :key="slider.id" class="web-banner relative">
        <div class="banner-content">
          <h1 class="mb-4">{{ slider.slider_heading }}</h1>
          <p>{{ slider.slider_description }}</p>
          <div class="text-center mt-4">
            <Link class="main-btn" :href="route('contact.us')">Contact Us</Link>
          </div>
        </div>
        <img :src="`${slider.slider_image}`">
      </div>
    </div>
    <div class="unstoppable-spaces-top">
      <div class="unstoppable-middle">
        <img :src="`${logo.logo_image}`" alt="" 
      </div>
      <div class="unstopable-log mt-2">
        <div class="container text-center">
          <h2 class="middle-logo-heading">{{ logo.logo_heading }}</h2>
          <p class="middle-logo-para">{{ logo.logo_description }}</p>
        </div>
      </div>
    </div>


    <div class="unstopable-log unstoppable-spaces-top category-section">
      <div class="container text-center">
        <h2 class="dark-theme-color">{{ logo.category_heading }}</h2>
        <p>{{ logo.category_subheading }}</p>
      </div>
    </div>
    <div class=" container-fluid px-0 mt-4">
      <div id="welcome_slider_" class="welcome-section">
        <div class="image_for_Card " v-for="(category) in categories" :key="category.id">
          <img :src=" category.category_image" alt="">
          <div class="slider-profile-name d-flex gap-3 align-items-center">
            <div class="slider-profile-img">
              <img :src="`${category.thumbnail}` " alt="">
            </div>
            <p class="mb-0">{{ category.category_heading }}</p>
          </div>
        </div>

      </div>
    </div>
  <!-- </div> -->
  </div>

  <div class="unstoppable-spaces-top countries-section">
    <div class="welcome-content">
      <h2 class="dark-theme-color">{{ logo.country_description }}</h2>
    </div>
    <div class="container-fluid px-0">
      <div class="grid lg:grid-cols-2 grid-cols-1 gap-3 countries-section-margin">
        <div class="country-content content-left relative">
          <img class="left-img" :src="logo.country_1_image" alt="">
          <div class="country-names">
            <h3>{{ logo.country_1_name }}</h3>
            <Link href="">Learn More <i class="bi bi-arrow-right"></i></Link>
          </div>
        </div>
        <div class="country-content content-right relative">
          <img class="right-img" :src="logo.country_2_image" alt="">
          <div class="country-names">
            <h3>{{ logo.country_2_name }}</h3>
            <Link href="">Learn More <i class="bi bi-arrow-right"></i></Link>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="unstoppable-spaces-top-special unstoppable-spaces-bottom video-section">
    <div class="container">
      <div class="video-background">
        <h2 class="mb-3 dark-theme-color">{{ logo.video_heading }}</h2>
        <p class="text-center">{{ logo.video_subheading }}</p>
        <div class="video-play">
          <video controls autoplay>
            <source :src="logo.video_introduction" type="video/mp4">
            Your browser does not support the video tag.
          </video>
          <!-- <a href=""><i class="bi bi-play-circle-fill play-btn"></i></a> -->
        </div>
        <p class="text-center">{{ logo.video_description }}</p>
      </div>
    </div>
  </div>
  <Footer :footer_data="footer_data" />
</template>

<style scoped>
.main-header .navbar {
  border-bottom: 1px solid #A5A5AB !important;
  background-color: #1D1F2C1A !important;
}

.main-header {
  position: absolute;
  top: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 100%;
  z-index: 999;
}

.web-banner {
  width: 100%;
  height: 600px;
}

/* 
.welcome-section .slick-track {
  margin-right: -15px;
} */
</style>