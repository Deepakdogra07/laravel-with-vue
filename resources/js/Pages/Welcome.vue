<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Header from '../Pages/Frontend/Header.vue';
import Footer from '../Pages/Frontend/Footer.vue';
import { onMounted } from 'vue';

const slickFn = () => {
  $('#home_banner').slick({
    arrows: false,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    infinite: true,
    dotsClass: 'slick-dots custom-dots',
    dotsClass: 'slick-dots d-flex justify-content-around',
    customPaging: function (slider, i) {
      return `<svg xmlns="http://www.w3.org/2000/svg" width="50" height="12" viewBox="0 0 230 10" fill="none">

          </svg>`;
    }
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
        <div class="banner-one">

        </div>
      </div>
    </div>
  <Footer />
</template>

<style>

.main-header .navbar{
    border-bottom: 1px solid #A5A5AB;
    background-color: #1D1F2C1A !important;
}

.banner-one{
    width: 100%;
    height: 500px;
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
    display: flex;
    justify-content: center;
    align-items: center;
}

.banner-one{
    background-image: url(/images/web-banner.png);
}

</style>