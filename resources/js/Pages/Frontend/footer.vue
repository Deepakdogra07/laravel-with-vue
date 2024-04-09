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
     <div class="footer-section">
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
      </div>
</template>
