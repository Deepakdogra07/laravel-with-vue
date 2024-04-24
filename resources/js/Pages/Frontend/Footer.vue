<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import axios from 'axios';

const page = usePage()
const footer = computed(() => page.props.site_data)


</script>
<template>

  <div class="main-footer">
    <div class="container">
      <div class="footer-grid">
        
        <div class="footer-section footer-one">
          <div class="footer-logo-sec">
            <Link ><img :src="'/storage/logos/'+ footer.logo_image" alt=""></Link>
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
              <Link>About Us</Link>
            </li>
            <li class="mb-3">
              <Link href="/testimonials">Our Testimonials</Link>
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
              <Link href="/job-listing">For Individuals</Link>
            </li>
            <li class="mb-3">
              <Link href="">For Businesses</Link>
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
              <a class="d-flex align-items-baseline gap-2" style="word-break: break-all;"><i class="bi bi-geo-alt-fill"></i>
               {{ footer.office_address }}</a>
            </li>
          </ul>
        </div>

        <div class="footer-section footer-four">
          <h2 class="text-white relative">Registration</h2>
          <div class="d-flex gap-2 listing-gap">
            <div class="row">
                <div v-for="(image, index) in JSON.parse(footer.certificate_images)"
                    :key="index" class="col-md-6 col-6 mb-2">
                    <div class="certificate-img-section">
                      <img class="certificate-img" :src="'/storage/certificates/' + image" alt="">
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="bottom-footer">
    <div class="container">
      <p class="text-center mb-0">Copyright © 2024 Dizon & Associates Pty Ltd |Terms & Conditions</p> 
    </div>
  </div>

  <!-- <div class="footer-section">
        <div class="container">
          <div class="row footer-row">
            <div class="col-12">
              <div class="footer-logo">
                <Link href="/"><img src="/images/Logo-footer.png" alt="dinheiro-agora"></Link>
              </div>
            </div>
            <div class="col-12">
              <ul class="d-flex justify-around mb-0">
                <li>
                   <Link class="nav-link" :class="{'active-footer-tab' : route().current() == 'home'}" href="/">Home</Link>
                </li>
                <li>
                   <Link class="nav-link" :class="{'active-footer-tab' : route().current() == 'about.us'}" href="/aboutus">About Us</Link>
                </li>
                <li>
                      <Link class="nav-link"  :class="{'active-footer-tab' : route().current() == 'privacy.policy'}" href="/privacy-policy">Privacy Policy</Link>
                </li>
                <li>
                      <Link class="nav-link" :class="{'active-footer-tab' : route().current() == 'term.condition'}" href="/term-condition">Terms and Conditions</Link>
                </li>
                <li>
                   <Link class="nav-link" :class="{'active-footer-tab' : route().current() == 'contactus'}" href="/contactus">Contact Us</Link>
                </li>
              </ul>
            </div>
            <div class="col-12">
              <div class="social-icons">
                <ul class="d-flex justify-center">
                  <li>
                    <a :href="facebookUrl" target="_blank"><i class="fab fa-facebook-f"></i></a>
                  </li>
                  <li>
                    <a :href="instagramUrl" target="_blank"> <i class="fa-brands fa-instagram"></i></a>
                  </li>
                  <li>
                    <a :href="twitterUrl" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="copyright-section">
        <div class="copyright text-center">
          <p>HLV SERVIÇOS ADMINISTRATIVOS LTDA</p>
          <p>CNPJ 53.588.824/0001-90</p>
          <p class="mb-0"> direito autoral 	&#169; 2024  Dinheiro agora | Todos os direitos reservados</p>
        </div>
      </div> -->
</template>
