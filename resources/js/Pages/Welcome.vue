<script setup>
import "../../css/frontend.css";
import { ref, reactive, onMounted, onUnmounted, computed, watch } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';
import { useToast } from 'vue-toastify';
import Swal from 'sweetalert2';
import { Head, Link } from '@inertiajs/vue3';
import Header from "./Frontend/header.vue";
import Footer from "./Frontend/footer.vue";
import Modal from "../Components/Modal.vue";


const options = [3, 6, 9, 12];

const showText = ref(false);

const hideModal = () => {
    // showText.value = !showText.value;
    showText.value = true;
    showModal.value = !showModal.value;

}

import { defineProps } from 'vue';
const props = defineProps(['allNews', 'testimonials', 'countTestimonials', 'countallNews']);

const news_arr = ref(props.allNews);
const testimonials_arr = ref(props.testimonials);

const showModal = ref(false)

const slickFn = () => {
  $('#slick1').slick({
    rows: 2,
    arrows: false,
    speed: 300,
    slidesToShow: 2,
    slidesToScroll: 2,
    infinite: true,
    dots: props.countallNews > 4 ? true : false,

    dotsClass: 'slick-dots custom-dots',

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
    dotsClass: 'slick-dots d-flex justify-content-around',
    customPaging: function (slider, i) {
      return `<svg xmlns="http://www.w3.org/2000/svg" width="50" height="12" viewBox="0 0 230 10" fill="none">

          </svg>`;
    }
  });

  $('#slick2').slick({
    rows: 1,
    arrows: false,
    speed: 300,
    slidesToShow: 2,
    slidesToScroll: 2,
    infinite: true,

    dots: props.countTestimonials > 2 ? true : false,


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
    dotsClass: 'slick-dots d-flex justify-content-around',
    customPaging: function (slider, i) {
      return `<svg xmlns="http://www.w3.org/2000/svg" width="50" height="12" viewBox="0 0 230 10" fill="none">
          </svg>`;
    }
  });
}
onMounted(() => {
  submit();
  window.addEventListener('resize', handleResize);
  slickFn();
  //   let currentUrl = window.location.href;
});



const screenSize = ref(window.innerWidth);
const count = ref(0);
const screenSizeWatcher = watch(
  screenSize,
  (newValue, oldValue) => {
    var device = 'desktop';
    if (newValue <= 576) {
      device = 'mobile';
    }
    axios.get(`/home-page?device=${device}`).then(res => {
      var data = res.data;
      news_arr.value = data.news;
      testimonials_arr.value = data.testimonials;
      count.value++;
      setTimeout(() => {
        slickFn()
      }, 400)
    })
  },
  { immediate: true }
);

const handleResize = () => {
  screenSize.value = window.innerWidth;
};



const loanDetails = reactive({
  emi: 0,
  total_interest: 0,
  total_payment: 0,
});

const errors = reactive({
  amount: null,
  interest_rate: null,
  loan_period: null,
});

const form = reactive({
  amount: ref(20000),
  famount: parseInt(20000).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }),
  interest_rate: null,
  loan_period: ref(3),
  amu: ref(2000),
});




const debounce = (func, delay) => {
  let timeoutId;
  return (...args) => {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(() => {
      func(...args);
    }, delay);
  };
};



const rangePercent = ref(form.amount / 49800 * 100);
const submit = async () => {
  errors.amount = null;
  errors.interest_rate = null;
  errors.loan_period = null;
  axios.post('/loan/details', form).then(res => {
    var data = res.data.data;
    loanDetails.emi = data.emi;
    loanDetails.total_interest = data.total_interest;
    loanDetails.total_payment = data.total_payment;
    loanDetails.amount = data.amount;


    // form.amount = null;
    // form.interest_rate = null;
    // form.loan_period = null;
    // errors.amount = null;
    // errors.interest_rate = null;
    // errors.loan_period = null;

  }).catch(err => {
    var error = err.response.data.errors;
    errors.amount = error.amount ? error.amount[0] : null;
    errors.interest_rate = error.interest_rate ? error.interest_rate[0] : null;
    errors.loan_period = error.loan_period ? error.loan_period[0] : null;
  })
}

const debouncedSubmit = debounce(submit, 500);

// onMounted(() => {
//   submit();
// });


const loanpage = () => {
  router.visit('/applyloan', {
    method: 'get',
    data: {
      loan_amount: form.amount,
      time: form.loan_period,
    },
  })
}


const formatAmount = () => {
  if (form.famount == null || form.famount == '') {
    let number = 0;
    form.amount = 0
    debouncedSubmit();
    return;
  }

  if (isNaN(form.famount)) {
    let number = form.famount.split(/\s+/)[1];


    if (typeof (number) == 'undefined') {
      if (form.famount.includes('R$')) {
        number = form.famount.replace('R$', '');
      } else {
        form.amount = form.famount;
        debouncedSubmit();
        return;
      }
    }
    let numberValue = '';
    for (const num of number) {
      if (parseInt(num) >= 0) {
        numberValue += num
      } else if (num == '.') {
      } else if (num == ',') {

        numberValue += '.'
      }
    }
    form.amount = numberValue;

    if (parseFloat(numberValue)) {
      form.famount = parseFloat(numberValue).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    }

  } else {
    form.amount = form.famount
    form.famount = parseInt(form.famount).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
  }


  debouncedSubmit();
}

const formatAmountSlider = () => {
  form.famount = parseInt(form.amount).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
  rangePercent.value = (form.amount / 49800) * 100;
  debouncedSubmit();
}




</script>



<template>
  <Head title="Home" />
  <div class="home-page-header">
    <Header />
  </div>
  <div class="main-containor">
    <div class="container position-relative">

      <div class="row align-items-center">
        <div class="col-lg-6">
          <div class="banner-content">
            <h1 class="text-right text-white mb-2"><span class="d-block">Seu limite</span><span
                class="d-block heading-banner"> do cartão vira</span> <span class="heading-banner">dinheiro
                imediato.</span></h1>
            <div class="text-right text-white">
              <p>Para obter um empréstimo com cartão de crédito não é necessário ter nome limpo, apenas um cartão de
                crédito com limite disponível.</p>
            </div>
            <div class="banner-btn-sec">
              <Link href="#loan-calaaaa" type="button" class="banner-link">
              <p class="mb-0">
                <span class="d-block">TEM CARTÃO DE CRÉDITO?</span>
                <!-- <span style="color: #6be7fc">SIMULE AGORA</span> -->
                <!-- <span style="color: #6be7fc">SIMULE AGORA</span> -->
                <Link href="#loan-calaaaa" style="color: #2CBCDD;">SIMULE AGORA</Link>
              </p>
              </Link>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <img id="img-src" src="/images/instant-banner-img.png" alt="dinheiro-agora">
        </div>
      </div>
    </div>
  </div>

  <div class="loan-calculator" id="loan-calaaaa">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-12">
          <div class="selecting-range">
            <h2 style="color: #2CBCDD;"><span class="como-fonts">Faça sua</span> simulação</h2>
            <div class="range-input position-relative mt-4">

              <form @submit.prevent="submit" class="custom-form">
                <div class="d-flex justify-between align-items-center">
                  <div>
                    <label for="amount">Valor<span style="color:red">*</span></label>
                  </div>
                  <div class="input-width">

                    <input id="amount" v-model="form.famount" class="small-input amount-range w-100" min="200"
                      max="50000" placeholder="Enter Amount" @change="formatAmount" />

                    <p class="text-red-700 text-right mt-1" v-if="errors.amount">{{ errors.amount }}</p>
                  </div>
                </div>


                <div class="position-relative">
                  <input class="ravit my-4" type="range"
                    :style="{ 'background': `linear-gradient(to right, #2CBCDD 0%, #2CBCDD ${rangePercent}%, rgb(183 183 183) ${rangePercent}%, rgb(183 183 183) 100%)` }"
                    v-model="form.amount" @change="debouncedSubmit()" min="200" max="50000"
                    @input="formatAmountSlider" />
                  <!-- <input class="w-100 my-2" type="range" v-model="form.amount" @change="submit" min="200" max="50000"
                    @input="formatAmountSlider" /> -->
                </div>



                <div class="d-flex justify-between align-items-center">
                  <div>
                    <label for="amount">Número de parcelas<span style="color:red">*</span></label>
                  </div>

                  <div>
                    <select v-model="form.loan_period" class="small-input dropdown-amount" @change="submit"
                      placeholder="Enter Year">
                      <option disabled>Selecione número de parcelas</option>
                      <option v-for="(option, index) in options" :value="option" :key="index">{{ option }} mês
                      </option>
                    </select>
                    <p class="text-red-700 mt-1" v-if="errors.loan_period">{{ errors.loan_period }}</p>
                  </div>
                </div>

                <div class="mt-4">

                </div>
              </form>
            </div>
          </div>
          <p class="mt-3" style="color: #000D37;">
            Taxa e condições sujeita a aprovação do cadastro
          </p>

          <p v-if="showText" style="color: red;">
            Infelizmente não temos o valor disponível no seu cartão de crédito, ainda não temos linha de crédito disponível para outros formatos.
          </p>


        </div>
        <div class="col-lg-6 col-12">
          <div class="total-calculate">
            <div class="heading">
              <h2 class="text-white">Sua simulação</h2>
              <hr style="color: #f5f5f5;">
            </div>
            <div class="calculation-list">
              <div class="row">
                <div class="col-md-8 col-8">
                  <p>Valor </p>
                </div>

                <div class="col-md-4 col-4" v-if="form.amount > 0">
                  <p>
                    <!-- ${{ form.amount }} -->
                    {{ new Intl.NumberFormat('pt-BR', {
                style: 'currency', currency: 'BRL', minimumFractionDigits: 2
              }).format(form.amount) }}
                  </p>
                </div>

                <div class="col-md-8 col-8">
                  <p>Juros</p>
                </div>
                <div class="col-md-4 col-4">
                  <p>{{ new Intl.NumberFormat('pt-BR', {
                style: 'currency', currency: 'BRL', minimumFractionDigits: 2
              }).format(loanDetails.total_interest) }}</p>


                </div>
                <!-- <div class="col-md-8 col-8">
                  <p>Taxes</p>
                </div>
                <div class="col-md-4 col-4">
                  <p>$1000</p>
                </div> -->
              </div>
            </div>
            <hr style="color: #f5f5f5;">
            <div class="calculation-total">
              <div class="row">
                <div class="col-md-8 col-8">
                  <p>Total</p>
                </div>
                <div class="col-md-4 col-4" v-if="loanDetails.total_payment > 0">
                  <!-- <p>${{ Number(loanDetails.total_payment) + 1000 }}</p> -->
                  <!-- <p>${{(Number(loanDetails.total_payment)).toFixed(2)}}</p> -->
                  <p>{{ new Intl.NumberFormat('pt-BR', {
                style: 'currency', currency: 'BRL', minimumFractionDigits: 2
              }).format(Number(loanDetails.total_payment)) }}</p>
                </div>
              </div>
            </div>
            <div class="apply-now mt-2 row align-items-center justify-between w-100">
              <div class="col-lg-5 col-md-7 col-6">
                <!-- <a :href="'/applyloan?loan_amount=' + form.amount" target="_blank" class="banner-link">Aplique agora</a> -->

                <span class="banner-link cursor-pointer" @click="showModal = !showModal">Aplique agora</span>




              </div>
              <div class="col-lg-7 col-md-5 col-6">
                <h3 class="text-white ">
                  <!-- ${{((Number(loanDetails.total_payment) + 1000) / ((form.loan_period) *12 )).toFixed(2)}} -->
                  <!-- ${{ loanDetails.emi.toFixed(2) }} -->
                  <p>{{ new Intl.NumberFormat('pt-BR', {
                style: 'currency', currency: 'BRL', minimumFractionDigits: 2
              }).format(loanDetails.emi) }}<span>/mês</span></p>

                </h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>




  <div class="loan-credit-section position-relative">
    <div class="dollar-image">
      <img src="/images/instantloan-dollarBg.png" alt="dinheiro-agora">
    </div>
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 col-md-12">
          <div class="left-content text-right">
            <h1 class=" text-white mb-3"><span class="d-block como-fonts">Como funciona o </span><span
                class="d-block heading-banner-2">empréstimo com</span> <span class="heading-banner-2">o Dinheiro
                Agora?</span></h1>
            <p class="mb-4 text-white">O empréstimo com o Dinheiro Agora é simples: você preenche o formulário online,
              nós analisamos sua solicitação e, se aprovada, o valor é depositado em sua conta bancária através de PIX
              ou TED. É importante ressaltar que é necessário ter limite disponível no cartão para realizar o
              empréstimo.
            </p>
            <p class="text-white">Transforme seus planos em realidade com o Dinheiro Agora - onde simplicidade e
              praticidade se encontram, diretamente no seu cartão de crédito. O passo a passo é mais fácil ainda:</p>
          </div>
        </div>

        <div class="col-lg-6 col-md-12 position-relative z-1">
          <div class="row process-loan align-items-center mb-4">
            <div class="col-md-8 col-12 process-detail-sec d-flex align-items-center">
              <div class="loan-detail">
                <h3 class="mb-0"><span class="d-block">EMPRÉSTIMO ONLINE</span> COM CARTÃO</h3>
              </div>
            </div>
            <div class="col-md-4 col-12">
              <img src="/images/icon-one.png" alt="dinheiro-agora">
            </div>
          </div>
          <div class="row process-loan align-items-center mb-4">
            <div class="col-md-8 col-12 process-detail-sec d-flex align-items-center">
              <div class="loan-detail">
                <h3 class="mb-0"><span class="d-block">RECEBA EM 30 MIN</span>APÓS APROVAÇÃO</h3>
              </div>
            </div>
            <div class="col-md-4 col-12">
              <img src="/images/icon-two.png" alt="dinheiro-agora">
            </div>
          </div>
          <div class="row process-loan align-items-center mb-4">
            <div class="col-md-8 process-detail-sec d-flex align-items-center">
              <div class="loan-detail">
                <h3 class="mb-0"><span class="d-block">USE 100% DO LIMITE LIVRE </span>DO SEU CARTÃO DE CRÉDITO</h3>
              </div>
            </div>
            <div class="col-md-4 col-12">
              <img src="/images/icon-three.png" alt="dinheiro-agora">
            </div>
          </div>
          <div class="row process-loan align-items-center mb-4">
            <div class="col-md-8 process-detail-sec d-flex align-items-center">
              <div class="loan-detail">
                <h3 class="mb-0">PARCELE EM ATÉ 12 VEZES</h3>
              </div>
            </div>
            <div class="col-md-4 col-12">
              <img src="/images/icon-four.png" alt="dinheiro-agora">
            </div>
          </div>
          <div class="row process-loan align-items-center mb-4">
            <div class="col-md-8 process-detail-sec d-flex align-items-center">
              <div class="loan-detail">
                <h3 class="mb-0"><span class="d-block">APROVAMOS QUEM</span>ESTÁ NEGATIVADO</h3>
              </div>
            </div>
            <div class="col-md-4 col-12">
              <img src="/images/icon-five.png" alt="dinheiro-agora">
            </div>
          </div>
          <div class="col-md-8 process-detail-sec d-flex align-items-center justify-end mt-4 process-link">
            <!-- <a href="#loan-cal" type="button" class="banner-link">SIMULE AGORA</a> -->
            <Link class="banner-link" href="#loan-calaaaa">SIMULE AGORA</Link>
          </div>

        </div>
      </div>
    </div>
  </div>

  <div class="request-section position-relative">
    <div class="white-image-mob">
      <img src="/images/Rectangle-mobile.png" alt="dinheiro-agora">
    </div>
    <div class="white-image">
      <img src="/images/instantloan-whitebg.png" alt="dinheiro-agora">
    </div>
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 col-md-12 order-bottom-mob">
          <div class="request-content">
            <div class="requste-mob-content d-flex justify-between align-items-center">
              <div class="request-heading">
                <h3>
                  <p class="d-block request-heading-top">Como solicitar</p>o empréstimo?
                </h3>
              </div>
              <div>
                <p> <span class="d-block">Como fazer um empréstimo </span>pelo Dinheiro Agora </p>
                <p class="text-white">em 5 passos simples:</p>
              </div>
            </div>
            <div class="row ">
              <div class="col-md-12">
                <div class="row align-items-center process-loan mt-4 position-relative">
                  <div class="col-md-3 count-num">
                    <h2>01</h2>
                  </div>


                  <div class="col-md-9 process-detail-sec d-flex align-items-center mb-4">
                    <div class="loan-detail">
                      <h3 class="mb-0"><span class="d-block">Nessa página confira as informações</span>e clique em
                        SIMULE
                        AGORA</h3>
                      <div class="text-end mt-2 inner-btn">
                        <!-- <a type="button" class="banner-link">SIMULE AGORA</a> -->
                        <Link class="banner-link" href="#loan-calaaaa">SIMULE AGORA</Link>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row align-items-center process-loan position-relative">
                  <div class="col-md-3 count-num">
                    <h2>02</h2>
                  </div>
                  <div class="col-md-9 process-detail-sec d-flex align-items-center mb-4">
                    <div class="loan-detail">
                      <h3 class="mb-0">Simule os valores, quantidade de
                        parcelas e confirme possuir cartão de crédito com limite disponível.</h3>
                    </div>
                  </div>
                </div>
                <div class="row align-items-center process-loan position-relative">
                  <div class="col-md-3 count-num">
                    <h2>03</h2>
                  </div>
                  <div class="col-md-9 process-detail-sec d-flex align-items-center mb-4">
                    <div class="loan-detail">
                      <h3 class="mb-0">Preencha seus dados pessoais, sua conta bancária e confirme.</h3>
                    </div>
                  </div>
                </div>
                <div class="row align-items-center process-loan position-relative">
                  <div class="col-md-3 count-num">
                    <h2>04</h2>
                  </div>
                  <div class="col-md-9 process-detail-sec d-flex align-items-center mb-4">
                    <div class="loan-detail">
                      <h3 class="mb-0">Na tela de envio da proposta, confirme o valor desejado, anexe as fotos do
                        documento e do cartão de crédito.
                      </h3>
                    </div>
                  </div>
                </div>
                <div class="row align-items-center process-loan position-relative">
                  <div class="col-md-3 count-num">
                    <h2>05</h2>
                  </div>
                  <div class="col-md-9 process-detail-sec d-flex align-items-center">
                    <div class="loan-detail">
                      <h3 class="mb-0">PRONTO! Finalizado o cadastro, nos informe o ID da proposta, ex:197459.
                        Verificaremos
                        se foi preenchida corretamente e prosseguimos
                        para a análise final.
                        PRONTO

                        PRA FAZER SEU SAQUE?</h3>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12 order-top-mob">
          <div class="request-section-img">
            <img src="/images/Agrupar.png" alt="dinheiro-agora">
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="press-section" v-if="news_arr.length > 0">
    <div class="container">
      <h2 class="text-center text-white mb-2">O que a imprensa diz sobre nós</h2>
      <div class="slick-wrapper">
        <div :key="count" id="slick1">
          <div v-for="(newsItem, index) in news_arr" :key="index" class="press-profile">
            <div class="slide-item row align-items-center">
              <div class="image-slider col-md-4 col-4">
                <img :src="`storage/news/${newsItem.image}`" :alt="newsItem.title" height="50px" width="80px">
              </div>
              <div class="slide-content col-md-8 col-8">
                <p>{{ newsItem.title }}</p>
                <p><a :href="newsItem.link">consulte Mais informação <i class="bi bi-arrow-right"></i></a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="news-btn text-center mt-5">
        <Link class="banner-link" href="/press">VER TUDO</Link>
      </div>

    </div>
  </div>

  <div class="loot-section">
    <div class="container">
      <div class="row justify-center">
        <div class="col-lg-9 col-md-12">
          <div class="row">
            <div class="col-md-6">
              <div class="image-for-mobile">
                <img class="d-lg-none d-md-none d-sm-block" src="/images/dollar-group.png" alt="dinheiro-agora">
              </div>
              <div class="loot-left-heading position-relative">
                <img src="/images/left-dollar.png" alt="dinheiro-agora">
                <h2 class="text-right"> <span class="d-block">PRONTO</span><span class="d-block">para receber </span>um
                  PIX?</h2>
              </div>
            </div>
            <div class="col-md-6">
              <div class="right-section-loot position-relative">
                <img src="/images/right-dollar.png" alt="dinheiro-agora">
                <p class="text-left">Com o Dinheiro Agora seu PIX está a um passo de distância! É rápido e fácil e o
                  melhor sem burocracia.</p>
                <div class="col-md-8 process-detail-sec mt-2">
                  <Link class="banner-link" href="#loan-calaaaa">SIMULE AGORA</Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="testimonial-section" v-if="testimonials_arr.length > 0">
    <div class="container">
      <h2 class="text-center mb-2" style="color: #000D37;">Depoimento</h2>
      <div class="slick-wrapper">
        <div :key="count" id="slick2">
          <div v-for="(testimonial, index) in testimonials_arr" :key="index" class="textimonial-box">
            <div class="slide-item position-relative">
              <i class="bi bi-quote"></i>
              <h2 class="text-center">{{ testimonial.name }}</h2>
              <p class="text-center">
                {{ testimonial.content }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



  <div class="questions-section">
    <div class="container">
      <div class="question-content">
        <p class="mb-4 heading-question"><span class="lighter-text">Dúvidas frequentes sobre Emprestimo com</span>
          Cartão de Crédito</p>
        <div class="accordion accordion-flush" id="accordionFlushExample">
          <div>
            <div class="accordion-item mb-4">
              <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                  Como funciona o processo de obtenção de empréstimo pelo cartão de crédito na Dinheiro Agora?
                </button>
              </h2>
              <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                  Na Dinheiro Agora, o processo de obtenção de empréstimo é simples. Basta acessar nosso site, preencher
                  o
                  formulário de solicitação e seguir as instruções para fornecer as informações necessárias. Após a
                  análise
                  e aprovação do seu pedido, o valor do empréstimo será depositado diretamente em sua conta bancária ou
                  disponibilizado em seu cartão de crédito, dependendo da opção escolhida.
                </div>
              </div>
            </div>
          </div>
          <div>
            <div class="accordion-item mb-4">
              <h2 class="accordion-header" id="flush-headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                  Quais são os requisitos para solicitar um empréstimo pelo cartão de crédito na Dinheiro Agora?
                </button>
              </h2>
              <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                  Para solicitar um empréstimo conosco, você precisa atender a alguns requisitos básicos, incluindo ser
                  maior de 18 anos, possuir um cartão de crédito válido com limite disponível e apresentar comprovante de
                  renda. Além disso, também pode ser necessário fornecer informações adicionais, conforme solicitado
                  durante o processo de solicitação.
                </div>
              </div>
            </div>
          </div>
          <div>
            <div class="accordion-item mb-4">
              <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseOne">
                  Como funciona o programa de afiliados da Dinheiro Agora?
                </button>
              </h2>
              <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                  Nosso programa de afiliados permite que nossos clientes indiquem amigos e familiares para utilizar
                  nossos serviços. Ao fazer uma indicação bem-sucedida, você receberá um código exclusivo que seu amigo
                  deverá inserir durante o processo de solicitação. Após a aprovação e realização do empréstimo pelo seu
                  amigo, você receberá 5% do valor do empréstimo como recompensa.
                </div>
              </div>
            </div>
          </div>
          <div>
            <div class="accordion-item mb-4">
              <h2 class="accordion-header" id="flush-headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseTwo">
                  É seguro solicitar um empréstimo pelo cartão de crédito na Dinheiro Agora?
                </button>
              </h2>
              <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                  Sim, a segurança dos nossos clientes é uma prioridade para nós. Utilizamos tecnologia de criptografia
                  avançada para proteger todas as informações fornecidas durante o processo de solicitação.
                  Além disso, garantimos a confidencialidade e o tratamento seguro de todos os dados pessoais de acordo
                  com as regulamentações de privacidade aplicáveis.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <Modal :modal='4' :show="showModal" :loanData="form" @welcome="hideModal" :loanDetails="loanDetails"/>
  <Footer />
</template>

<style scoped>
.ravit {
  /* border: solid 1px #636262; */
  /* background-color: #636262; */

  border-radius: 8px;
  height: 4px;
  width: 100%;
  outline: none;
  transition: background 450ms ease-in;
  -webkit-appearance: none;
}

.ravit::-webkit-slider-thumb {
  width: 26px;
  height: 26px;
  border-radius: 50%;
  -webkit-appearance: none;
  cursor: ew-resize;
  border: 2px solid #2cbcdd;
  background-color: #fff;
}
</style>
