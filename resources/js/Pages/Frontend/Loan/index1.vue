<script setup>
import "../../../../css/frontend.css";
import { ref, reactive } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
// import { Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';
import { useToast } from 'vue-toastify';
import Swal from 'sweetalert2';

import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

const showNotificationBubble = ref(0);

const handleNewNotification = () => {
  showNotificationBubble.value += 1;
};

const showNotification = () => {
  showNotificationBubble.value = !showNotificationBubble.value;
  if (showNotificationBubble.value) {
    notificationCount.value = 0; // Reset count when bubble is opened
  }
};

const phoneNumber = ref('987654321');



// const deleteRecord = async (id) => {
//   const toast = useToast();
//   if (confirm('Are you sure you want to delete this record?')) {
//     const options = {
//       onSuccess: page => {
//         toast.success("Delete Successfully!");
//       },
//       onError: errors => {
//         alert("Unexpected response. Record may not be deleted.");
//       },
//     }
//     const response = router.delete(`/delete/${id}`, options);
//   }
// };


const deleteRecord = async (id) => {
  const { value: confirmed } = await Swal.fire({
    title: 'Are you sure?',
    text: 'You want to Delete Customer Record?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!'
  });

  try {
    if (confirmed) {
      router.delete(`/delete/${id}`);
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: 'Customer Deleted Successfully',
      });
      router.visit('/user/loan')
    } else {
      Swal.fire({
        icon: 'info',
        title: 'Canceled',
        text: 'Deletion canceled.',
      });
      // router.visit(route('user/loan'));
    }
  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Error Deleting Customer. Please try again.',
    });
  }
};



const editRecord = (id) => {
  router.visit(`/edit/${id}`);
}

const logout = async () => {
  try {
    await axios.post('/logout/user');
    router.replace('/');
  } catch (error) {
    console.error('Logout failed', error);
  }
};

const viewRecord = (id) => {
  router.get(`/loan/view/page/${id}`);
}

// reapplyLoan

const reapplyLoan = (id) => {
  router.post(`/reapply/loan/${id}`);
}

// const options = reactive({
//     order: [[0, 'desc'],[1, 'desc'],[2, 'desc'],[3, 'desc'],[4, 'desc'],[5, 'desc'],[6, 'desc']],
// });

const getIdColumnIndex = () => {
  return 0;
};

const idColumnIndex = getIdColumnIndex();

const options = reactive({
  order: [[idColumnIndex, 'desc']],
});


const formatDate = (timestamp) => {
  const date = new Date(timestamp);
  const formattedDate = date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
  return formattedDate;
};


</script>

<template>
  <div class="main-containor">
    <div class="container position-relative">
      <!-- navbar-start -->
      <nav class="navbar navbar-expand-lg bg-transparent">
        <div class="container-fluid">
          <a class="navbar-brand main-logo" href="#">
            <img src="/images/instant-loan-logo.png" alt="dinheiro-agora">
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">About us</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Testimonial</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">FAQs</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Contact us</a>
              </li>

            </ul>
            <div v-if="canLogin" class="d-flex login-registration" role="search">
              <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-end">
                <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                  class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                Dashboard</Link>

                <template v-else>
                  <Link :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                  Log in</Link>

                  <Link v-if="canRegister" :href="route('register')"
                    class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                  Register</Link>
                </template>
              </div>
            </div>
          </div>
        </div>
      </nav>
      <!-- navbar-end -->

      <div class="row align-items-center">
        <div class="col-lg-6">
          <div class="banner-content">
            <h1 class="text-right text-white mb-2"><span class="d-block">Seu limite</span><span
                class="d-block heading-banner"> do cartão vira</span> <span class="heading-banner">dinheiro
                imediato.</span></h1>
            <div class="text-right text-white">
              <p>Para obter um empréstimo com cartão de crédito, não é necessári</p>
              <p>Para obter um empréstimo com cartão de crédito, não é necessári</p>
            </div>
            <div class="banner-btn-sec">
              <a type="button" class="banner-link">
                <p class="mb-0">
                  <span class="d-block">TEM CARTÃO DE CRÉDITO?</span>
                  <span style="color: #6be7fc">SIMULE AGORA</span>
                </p>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <img src="/images/instant-banner-img.png" alt="dinheiro-agora">
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
            <h1 class=" text-white mb-3"><span class="d-block">Como funciona o </span><span
                class="d-block heading-banner-2">empréstimo com</span> <span class="heading-banner-2">cartão de
                crédito?</span></h1>
            <p class="mb-4 text-white">Para conseguir o seu dinheiro na hora, de maneira fácil e sem burocracia é
              necessário apenas ter um cartão
              de crédito em seu nome com limite
              disponível. É usando o limite do seu cartão de crédito como garantia que
              poderemos liberar o seu dinheiro na hora. Quanto mais limite disponível você tiver no cartão de crédito,
              maior pode ser o valor do empréstimo.
            </p>
            <p class="text-white">Com o seu cartão em mãos, você já pode seguir o passo
              a passo para solicitar o saque do seu dinheiro:</p>
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
                <h3 class="mb-0"><span class="d-block">APROVAMOS QUEM.</span>ESTÁ NEGATIVADO</h3>
              </div>
            </div>
            <div class="col-md-4 col-12">
              <img src="/images/icon-five.png" alt="dinheiro-agora">
            </div>
          </div>
          <div class="col-md-8 process-detail-sec d-flex align-items-center justify-end mt-4 process-link">
            <a type="button" class="banner-link">SIMULE AGORA</a>
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
                <h3> <span class="d-block" style="font-weight: 400;">Como solicitar</span>o empréstimo?</h3>
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
                      <h3 class="mb-0"><span class="d-block">Nessa página confira as informações</span>e clique em SIMULE
                        AGORA</h3>
                      <div class="text-end mt-2 inner-btn">
                        <a type="button" class="banner-link">SIMULE AGORA</a>
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
                <h2 class="text-right"> <span class="d-block">PRONTO</span><span class="d-block">PRA FAZER </span>SEU
                  SAQUE?</h2>
              </div>
            </div>
            <div class="col-md-6">
              <div class="right-section-loot position-relative">
                <img src="/images/right-dollar.png" alt="dinheiro-agora">
                <p class="text-left">Solicite agora seu empréstimo com o cartão de crédito e garanta o dinheiro no seu
                  bolso de forma rápida, fácil e sem burocracia!</p>
                <div class="col-md-8 process-detail-sec mt-2">
                  <a type="button" class="banner-link">SIMULE AGORA</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="questions-section">
    <div class="container">
      <div class="question-content">
        <h2 class="mb-5">Dúvidas frequentes sobre Emprestimo com <span class="bootom-bold">Cartão de Crédito</span></h2>
        <div class="question-sec mb-4">
          <p>Quais as vantagens de fazer Empréstimo com Limite do Cartão de Crédito?</p>
        </div>
        <div class="question-sec mb-4">
          <p>Quais as vantagens de fazer Empréstimo com Limite do Cartão de Crédito?</p>
        </div>
        <div class="question-sec mb-4">
          <p>Quais as vantagens de fazer Empréstimo com Limite do Cartão de Crédito?</p>
        </div>
        <div class="question-sec">
          <p>Quais as vantagens de fazer Empréstimo com Limite do Cartão de Crédito?</p>
        </div>

      </div>
    </div>
  </div>


  <!-- footer start -->
    <div class="footer-section">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 col-12">
              <ul class="d-flex mb-0">
                <li>
                  <a href="">About us</a>
                </li>
                <li>
                  <a href="">Contact us</a>
                </li>
                <li>
                  <a href="">Privacy Policy</a>
                </li>
                <li>
                  <a href="">Term & Conditions</a>
                </li>
              </ul>
            </div>
            <div class="col-lg-6 col-12">
              <div class="copyright text-right">
                <p> Copyright 	&#169; 2023 | All rights reserved</p>
              </div>
            </div>
          </div>
        </div>
    </div>
  <!-- footer end -->
</template>
