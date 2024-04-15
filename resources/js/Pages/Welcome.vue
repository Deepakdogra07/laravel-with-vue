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
}
onMounted(() => {
  slickFn();
});

</script>
<template>  
  <Header />
       
    <div class="banner-section">
      <div id="home_banner">
        <div v-for="(slider) in sliders" :key="slider.id" class="web-banner">
          <div class="banner-content">
          <h1>{{slider.slider_heading}}</h1>
          <p>{{slider.slider_description}}</p>
          </div>
          <img :src="`/storage/slider/${slider.slider_image}`">
        </div>  
      </div>
    </div>
    <div class="unstoppable-middle">
      <img src="/images/unstoppable-bw.png" alt="">
    </div>

  <Footer />
</template>

<style>

.main-header .navbar{
    border-bottom: 1px solid #A5A5AB;
    background-color: #1D1F2C1A !important;
}

.web-banner{
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


.banner-section .slick-dots{
  display: flex;
  justify-content: center;
  padding-left: 0;
  gap: 20px;
}
.slick-dots {
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
    border: none;
    border-radius: 50%;
    background-color: #999;
    cursor: pointer;
    font-size: 0;
}

.slick-dots li button {
    border: 2px solid #1A9882;
    background-color: #D2D2D5;
}

.slick-dots li.slick-active button {
    border: 2px solid #FFFFFF;
    background-color: #1A9882;
}

</style>