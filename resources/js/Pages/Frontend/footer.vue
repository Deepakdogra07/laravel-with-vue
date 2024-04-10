<script setup>
import { Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const facebookUrl = ref('');
const instagramUrl = ref('');
const twitterUrl = ref('');

const fetchData = async () => {
  try {
    const response = await axios.get('/get/footer/data');
    facebookUrl.value = response.data.facebookurl,
      instagramUrl.value = response.data.instagramurl,
      twitterUrl.value = response.data.twitterurl;
  } catch (error) {
    console.error('Error fetching data:', error);
  }
};


const phoneNumber = ref('987654321');

onMounted(() => {
  fetchData();

  axios.get('/get-whatsapp')
    .then(response => {
      phoneNumber.value = response.data.whatsappNumber;
    })
    .catch(error => {
      console.error('Error fetching data:', error);
    });
});

</script>
<template>

  <div class="main-footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-section footer-one">
          <Link><img src="/images/web-logo.png" alt=""></Link>
          <p class="white-text mt-3">We are an Job search and immigration services firm specializing in the digital
            processing of job searches and related immigration services, Our aim is to fully digital the job search and
            immigration process in every country in the world, for individuals, families businesses, Let us be part of
            your individuals journey</p>
          <ul class="social-icons-footer d-flex align-items-center gap-3 pl-0 ">
            <li>
              <Link class="social-icons"><i class="fa-brands fa-facebook-f"></i></Link>
            </li>
            <li>
              <Link class="social-icons"><i class="fa-brands fa-square-instagram"></i></Link>
            </li>
            <li>
              <Link class="social-icons"><i class="fa-brands fa-linkedin"></i></Link>
            </li>
            <li>
              <Link class="social-icons"><i class="fa-brands fa-x-twitter"></i></Link>
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
              <Link>Our Testimonials</Link>
            </li>
          </ul>
        </div>

        <div class="footer-section footer-three">
          <h2 class="text-white relative">Business Segments</h2>
          <ul class="pl-0 listing-gap">
            <li class="mb-3">
              <Link href="">For Individuals</Link>
            </li>
            <li class="mb-3">
              <Link>For Businesses</Link>
            </li>
          </ul>
        </div>

        <div class="footer-section footer-four">
          <h2 class="text-white relative">Our Office</h2>
          <ul class="pl-0 listing-gap">
            <li class="mb-3">
              <Link href=""><i class="bi bi-telephone pr-2"></i> +1300 779 462</Link>
            </li>
            <li class="mb-3">
              <Link class="d-flex align-items-baseline gap-2" style="word-break: break-all;"><i class="fa-solid fa-envelope pr-2"></i>
              Info@dizonassociates.com.au</Link>
            </li>
            <li class="mb-3">
              <Link class="d-flex align-items-baseline gap-2" style="word-break: break-all;"><i class="fa-solid fa-envelope pr-2"></i>
                Level 5 12 clarke St, Sunshine Victoria, Australia 3020 (enter via vicroads building) </Link>
            </li>
          </ul>
        </div>

        <div class="footer-section footer-four">
          <h2 class="text-white relative">Registration</h2>
          <div class="d-flex gap-2 listing-gap">
            <img src="/images/MembershipLogo.png" alt="">
            <img src="/images/NewZealandLic.png" alt="">
          </div>
        </div>
      </div>
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
