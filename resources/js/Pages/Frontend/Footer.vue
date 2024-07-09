<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import axios from 'axios';

const page = usePage()
const footer = computed(() => page.props.site_data)
const user = ref(page?.props?.auth?.user)


</script>
<template>
  <div class="container-fluid">
    <div class="main-footer">
      <div class="container about-width">
        <div class="footer-grid">
          
          <div class="footer-section footer-one">
            <div class="footer-logo-sec">
              <Link ><img :src="footer?.logo_image" alt=""></Link>
            </div>
            <p class="white-text mt-3">{{ footer.logo_description }}</p>
            <ul class="social-icons-footer d-flex align-items-center gap-3 pl-0 ">
              <li>
                <a :href="footer.facebook_url" target="_blank" class="social-icons"><i class="fa-brands fa-facebook-f"></i></a>
              </li>
              <li>
                <a :href="footer.instagram_url" target="_blank"  class="social-icons"><i class="bi bi-instagram d-flex"></i></a>
              </li>
              <li>
                <a :href="footer.linkedin_url" target="_blank"  class="social-icons"><i class="fa-brands fa-linkedin-in"></i></a>
              </li>
              <li>
                <a  :href="footer.twitter_url" target="_blank"  class="social-icons"><i class="fa-brands fa-x-twitter"></i></a>
              </li>
            </ul>
          </div>

          <div class="footer-section footer-two">
            <h2 class="text-white relative">Useful Link</h2>
            <ul class="pl-0 listing-gap">
              <li class="mb-3">
                <Link href="/">Home</Link>
              </li>
              <li class="mb-3">
                <Link href="/about-us" >About Us</Link>
              </li>
              <li class="mb-3">
                <Link href="/testimonials">Our Testimonials</Link>
              </li>
              <li class="mb-3">
                <Link href="/job-listing" >Jobs</Link>
              </li>
              <li class="mb-3">
                <Link href="/contact-us">Contact us</Link>
              </li>
            </ul>
          </div>

          <div class="footer-section footer-three">
            <h2 class="text-white relative">Business Segments</h2>
            <ul class="pl-0 listing-gap">
              <li class="mb-3">
                <Link :href="route('customer-dash')" >For Individuals</Link>
              </li>
              <li class="mb-3">
                <!-- v-if="user?.user_type == 2" -->
                <Link :href="route('business-jobs.index')">For Businesses</Link>
              </li>
            </ul>
          </div>

          <div class="footer-section footer-four">
            <h2 class="text-white relative">Our Office</h2>
            <ul class="pl-0 listing-gap">
              <li class="mb-3">
                <a :href="`tel:${footer.office_phone}`" ><i class="bi bi-telephone-fill pr-2"></i> {{ footer.office_phone }}</a>
              </li>
              <li class="mb-3">
                <a :href="`mailto:${footer.office_email}`" class="d-flex align-items-baseline gap-2" style="word-break: break-all;"><i class="fa-solid fa-envelope pr-2"></i>
                {{ footer.office_email }} </a>
              </li>
              <li class="mb-3">
                <a target="_blank" :href="`https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(footer.office_address)}`" class="d-flex align-items-baseline gap-2" style="word-break: break-all;"><i class="bi bi-geo-alt-fill"></i>
                {{ footer.office_address }}</a>
              </li>
            </ul>
          </div>

          <div class="footer-section footer-five">
            <h2 class="text-white relative">Registration</h2>
              <div class="row home_certificate_row">
                  <div v-for="(image, index) in JSON.parse(footer.certificate_images)"
                      :key="index" class="col-md-6 col-4  mb-2 certificate_ftr">
                      <img class="certificate-img" :src="image" alt="">
                  </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="bottom-footer">
      <div class="container footer_padding about-width">

        <div class="row justify-content-between align-items-center">
            <div class="col-lg-3 col-md-3 col-sm-12 remove_padding_footer">
              <div class="rating_image">
                <img src="/images/google_rating.png" style="border-top: 5px solid #34A853; border-radius: 5px 5px 0px 0px; background-color: #fff">
              </div>
        
              <!-- <div class="google_ratings">
                <div class="ratings_img">
                  <img src="/images/google-logo.png">
                </div>
                <div class="rating_txt">
                  <h6>Google Rating</h6>
                  <ul class="pl-0 mb-0">
                    <li>4.8</li>
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star"></i></li>
                    <li><i class="fas fa-star"></i></li>
                  </ul>
                  <a href="#">See all reviews</a>
                </div>
              </div> -->
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 remove_padding_footer">
              <p class="mb-0">Copyright © 2024 Dizon & Associates Pty Ltd | <a :href="route('term.condition')" target="_blank">Terms & Conditions</a></p> 
            </div>
        </div>
      </div>
    </div>
  </div>
</template>






