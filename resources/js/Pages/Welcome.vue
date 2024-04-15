<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Header from '../Pages/Frontend/Header.vue';
import Footer from '../Pages/Frontend/Footer.vue';
import { onMounted } from 'vue';

const props = defineProps({
  sliders: {
    type: Object
  },
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
    // dotsClass: 'slick-dots custom-dots',
    // dotsClass: 'slick-dots d-flex justify-content-center gap-3 pl-0',
    // customPaging: function (slider, i) {
    //   return `<svg xmlns="http://www.w3.org/2000/svg" width="50" height="12" viewBox="0 0 230 10" fill="none">

    //       </svg>`;
    // }
  });

  $('#welcome_slider_').slick({
    arrows: false,
    centerMode: true,
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
  </div>

  <div class="unstoppable-spaces-top unstoppable-middle">
    <img src="/images/unstoppable-bw.png" alt="">
  </div>

  <div class="unstoppable-spaces-top welcome-section">
    <!-- <div class="container-fluid"> -->
    <div class="welcome-content">
      <h2>Welcome to UNSTOPPABLE</h2>
      <p>We are an job search and immigration services firm specializing in the digital processing of job searches and
        related immigration services for skilled workers. Our aim is to fully digitize the job search and immigration
        process in every country in the world. for skilled workers. UNSTOPPABLE best describe the two founders but also
        the vision for the firm to make everything possible our clients aim for.</p>
    </div>

    <div class=" container-fluid px-0 mt-4">
      <div id="welcome_slider_">
        <div class="image_for_Card ">
          <img src="/images/web-banner.png" alt="">
          <div class="slider-profile-name d-flex gap-3 align-items-center">
            <div class="slider-profile-img">
              <img src="/images/profile1.jpg" alt="">
            </div>
            <p class="mb-0">Engineering</p>
          </div>
        </div>
        <div class="image_for_Card ">
          <img src="/images/australia.jpg" alt="">
          <div class="slider-profile-name d-flex gap-3 align-items-center">
            <div class="slider-profile-img">
              <img src="/images/profile1.jpg" alt="">
            </div>
            <p class="mb-0">Hospitality worker</p>
          </div>
        </div>
        <div class="image_for_Card ">
          <img src="/images/web-banner3.png" alt="">
          <div class="slider-profile-name d-flex gap-3 align-items-center">
            <div class="slider-profile-img">
              <img src="/images/profile1.jpg" alt="">
            </div>
            <p class="mb-0">Health & Public Services</p>
          </div>
        </div> 
        <div class="image_for_Card ">
          <img src="/images/web-banner2.png" alt="">
          <div class="slider-profile-name d-flex gap-3 align-items-center">
            <div class="slider-profile-img">
              <img src="/images/profile1.jpg" alt="">
            </div>
            <p class="mb-0">Health & Public Services</p>
          </div>
        </div>
        <div class="image_for_Card">
          <img src="/images/web-banner3.png" alt="">
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
        <img class="left-img" src="/images/australia.jpg" alt="">
        <div class="country-names">
          <h3>Australia</h3>
          <Link href="">Learn More <i class="bi bi-arrow-right"></i></Link>
        </div>
      </div>
      <div class="country-content content-right relative">
        <img class="right-img" src="/images/new-zealand.jpg" alt="">
        <div class="country-names">
          <h3>New Zealand</h3>
          <Link href="">Learn More <i class="bi bi-arrow-right"></i></Link>
        </div>
      </div>
    </div>
  </div>

  <div class="unstoppable-spaces-top unstoppable-spaces-bottom video-section">
    <div class="container">
      <div class="video-background">
        <h2 class="mb-3">How Does It Work</h2>
        <p class="text-center">Watch our video on how the journey is done in our app and get inspired</p>
        <div class="video-play">
          <video src="/images/new-video.mp4"></video>
          <a href=""><i class="bi bi-play-circle-fill play-btn"></i></a>
        </div>
        <p class="text-center">log your profile now and apply in your country of choise</p>
      </div>
    </div>
  </div>
  <Footer />
</template>

<style>
.main-header .navbar {
  border-bottom: 1px solid #A5A5AB;
  background-color: #1D1F2C1A !important;
}

.web-banner {
  width: 100%;
  height: 500px;
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

.welcome-section .slick-dots {
  list-style: none;
  text-align: center;
  margin-top: 30px;
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
.welcome-section .slick-slider {
  padding: 0  ; /* Adjust the padding as needed */
}

.welcome-section .slick-slider .slick-slide {
  margin: 0 10px; /* Adjust the margin between slides */
}
</style>