<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Header from '../Pages/Frontend/Header.vue';
import Footer from '../Pages/Frontend/Footer.vue';
import { onMounted } from 'vue';

const props = defineProps({
    sliders: {
        type: Object
    },
    logo:{
      type: Object
    },
    categories:{
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
    dots: true,
  });

  $('#welcome_slider_').slick({
    arrows: false,
    // centerMode: true,
    autoplay: true,
    speed: 2,
    slidesToShow: 3,
    slidesToScroll: 1,
    infinite: true,
    dots: true,
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
  <Header />

  <div class="banner-section">
    <div id="home_banner">
      <div v-for="(slider) in sliders" :key="slider.id" class="web-banner relative">
        <div class="banner-content">
          <h1 class="mb-4">{{ slider.slider_heading }}</h1>
          <p>{{ slider.slider_description }}</p>
          <div class="text-center mt-4">
            <Link class="main-btn" :href="route('login')">Contact Us</Link>
          </div>
        </div>
        <img :src="`/storage/slider/${slider.slider_image}`">
      </div>
    </div>
    <div class="unstoppable-spaces-top">
      <div class="unstoppable-middle">
        <img :src="`/storage/logo/${logo.logo_image}`" alt="">
      </div>
      <div class="unstopable-log unstoppable-spaces-top ">
        <div class="container text-center">
          <h1>{{ logo.logo_heading }}</h1>
          <p>{{ logo.logo_description }}</p>
        </div>
      </div>
    </div>

    <div class=" container-fluid px-0 mt-4">
      <div id="welcome_slider_">

        <div class="image_for_Card " v-for="(category) in categories" :key="category.id" >
          <img :src="`storage/categories/`+category.category_image" alt="">
          <div class="slider-profile-name d-flex gap-3 align-items-center">
            <div class="slider-profile-img">
              <img :src="`storage/categories/`+category.category_image"  alt="">
            </div>
            <p class="mb-0">{{category.category_heading}}</p>
          </div>
        </div>
        
      </div>
    </div>
    <!-- </div> -->
  </div>

  <div class="unstoppable-spaces-top countries-section">
    <div class="welcome-content">
      <h2>Most Interesting Countries With Job Opportunities</h2>
    </div>

    <div class="grid lg:grid-cols-2 grid-cols-1 gap-3 mt-4">
      <div class="country-content content-left relative">
        <img class="left-img" :src="`storage/logo/`+logo.country_1_image" alt="">
        <div class="country-names">
          <h3>{{ logo.country_1_name }}</h3>
          <Link href="">Learn More <i class="bi bi-arrow-right"></i></Link>
        </div>
      </div>
      <div class="country-content content-right relative">
        <img class="right-img" :src="`storage/logo/`+logo.country_2_image"  alt="">
        <div class="country-names">
          <h3>{{ logo.country_2_name }}</h3>
          <Link href="">Learn More <i class="bi bi-arrow-right"></i></Link>
        </div>
      </div>
    </div>
  </div>

  <div class="unstoppable-spaces-top-special unstoppable-spaces-bottom video-section">
    <div class="container">
      <div class="video-background">
        <h2 class="mb-3">{{ logo.video_heading }}</h2>
        <p class="text-center">{{ logo.video_subheading }}</p>
        <div class="video-play">
          <video src="/images/new-video.mp4"></video>
          <a href=""><i class="bi bi-play-circle-fill play-btn"></i></a>
        </div>
        <p class="text-center">{{ logo.video_description }}</p>
      </div>
    </div>
  </div>
  <Footer />
</template>

<style scoped>
.main-header .navbar {
  border-bottom: 1px solid #A5A5AB !important;
  background-color: #1D1F2C1A !important;
}

.main-header {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  z-index: 999;
}

.web-banner {
  width: 100%;
  height: 600px;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
}


.slick-dots {
  display: flex;
  justify-content: center;
  padding-left: 0;
  gap: 20px;
}

.banner-section .slick-dots {
  list-style: none;
  text-align: center;
  position: absolute;
  bottom: 10px;
  left: 50%;
  transform: translateX(-50%);
}

.slick-dots li {
  display: inline-block;
  margin: 0 5px;
}

.slick-dots li button {
  display: block;
  width: 15px;
  height: 15px;
  padding: 0;
  border: none !important;
  border-radius: 50%;
  background-color: #999 !important;
  cursor: pointer;
  font-size: 0;
}

.slick-dots li button {
  border: 2px solid #1A9882 !important;
  background-color: #D2D2D5 !important;
}

.slick-dots li.slick-active button {
  border: 2px solid #FFFFFF !important;
  background-color: #1A9882 !important;
}

.welcome-section .slick-dots {
  align-items: center;
}

.welcome-section .slick-dots li.slick-active button {
  width: 20px !important;
  height: 20px !important;
}

.welcome-section .slick-slider {
  padding: 0;
}

.welcome-section .slick-slider .slick-slide {
  margin: 0 10px;
}

.welcome-section .slick-list {
  margin-left: -25px;
  /* Adjust to match the negative margin of .slick-slide */
  margin-right: -10px;
  overflow: hidden;
  overflow-x: hidden;
}

.welcome-section .slick-dots {
  position: relative;
  margin-top: 50px;
}

.container-fluid.px-0 {
  padding-left: 0;
  padding-right: 0;
  overflow: hidden;
  overflow-x: hidden;
}

.welcome-section .slick-slide {
  margin-right: 15px;
}

.welcome-section .slick-track {
  margin-left: 15px;
}
</style>