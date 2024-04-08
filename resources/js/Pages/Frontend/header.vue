<script setup>
import { Link } from '@inertiajs/vue3';
import 'bootstrap-icons/font/bootstrap-icons.css';

import { ref,onMounted } from "vue";
import axios from 'axios';


const nameFirstLetter = ref('');


onMounted(async () => {
  try {
    const response = await axios.get('/login/user/name');
    nameFirstLetter.value = response.data;
  } catch (error) {
    console.error('Error fetching data:', error);
  }
});



const mobileMenu = ref(false);
const height = ref(0);

const showMenu = () => {
    const animationDuration = 200; // in milliseconds
    const framesPerSecond = 120;
    const totalFrames = animationDuration / (1000 / framesPerSecond);
    const heightIncrement = 313 / totalFrames;

    if (!mobileMenu.value) {
        mobileMenu.value = true;
        let currentHeight = 0;
        const animationInterval = setInterval(() => {
            currentHeight += heightIncrement;
            if (currentHeight >= 313) {
                clearInterval(animationInterval);
                height.value = 313;
            } else {
                height.value = currentHeight;
            }
        }, 1000 / framesPerSecond);
    } else {
        let currentHeight = 313;
        const animationInterval = setInterval(() => {
            currentHeight -= heightIncrement;
            if (currentHeight <= 0) {
                clearInterval(animationInterval);
                height.value = 0;
                mobileMenu.value = false;
            } else {
                height.value = currentHeight;
            }
        }, 1000 / framesPerSecond);
    }
};




</script>

<template>
    <nav class="navbar navbar-expand-lg top-main-nav">
        <div class="container">
            <Link href="/" class="navbar-brand main-logo">
            <img src="/images/instant-loan-logo.png" alt="dinheiro-agora">
            </Link>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="dropdown dropdown-mobile-view">
                <div class="d-flex align-items-center gap-1">
                    <a @click="showMenu" class="sidebar-mobile-btn dropdown-toggle" href="#">
                        <p>{{ nameFirstLetter }}</p>
                    </a>
                    <i class="bi bi-chevron-down d-flex"></i>
                </div>
            </div>
            <div v-show="mobileMenu" class="aside-section" :style="{ 'height': `${height}px` }">
                <ul class="d-flex flex-column pl-0">
                    <li>
                        <i class="bi bi-ui-checks-grid"></i>

                        <Link href="/user/loan">Painel</Link>
                    </li>
                    <hr>
                    <li>
                        <i class="bi bi-cash-coin"></i>


                        <Link href="/all-loans">Meus empréstimos</Link>
                    </li>
                    <hr>
                    <li>
                        <i class="bi bi-pencil-square"></i>
                        <Link href="/user/editProfile">Editar Perfil</Link>
                    </li>
                    <hr>
                    <li>
                        <i class="bi bi-link"></i>
                        <Link href="/affiliate">Afiliados</Link>
                    </li>
                    <hr>
                    <li :class="{ 'active-sidetab': route().current() == 'logout' }">
                        <i class="bi bi-box-arrow-left"></i>
                        <Link :class="{ 'active-sidetab': route().current() == 'logout' }" :href="route('logout')"
                            method="post">Sair</Link>
                    </li>
                </ul>
            </div>



            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="main-link-container d-flex align-items-center justify-between w-100">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <Link class="nav-link" :class="{ 'active-tab': route().current() == 'home' }" href="/">Home
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link class="nav-link" :class="{ 'active-tab': route().current() == 'about.us' }"
                                href="/aboutus">Sobre nós
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link class="nav-link" :class="{ 'active-tab': route().current() == 'faq' }" href="/faq">
                            Perguntas
                            frequentes
                            </Link>
                        </li>

                        <li class="nav-item">
                            <Link href="/contactus" :class="{ 'active-tab': route().current() == 'contactus' }"
                                class="nav-link">
                            Contate-nos</Link>
                        </li>



                    </ul>
                    <div class="dashboard-sec">
                        <ul class="mb-0">
                            <li class="nav-item d-flex align-items-center">
                                <div v-if="$page.props.auth.user">
                                    <Link v-if="route().current() == 'home'" :href="route('dashboard')"
                                        class="nav-link login-anchor">
                                    Painel
                                    </Link>
                                </div>

                                <div class="pl-3 " v-if="$page.props.auth.user">
                                    <Link v-if="route().current() == 'home'" class="reg-link nav-link"
                                        :href="route('logout')" method="post">
                                    Sair
                                    </Link>

                                </div>




                                <template v-else>
                                    <Link :href="route('login')" class="nav-link login-anchor">
                                    Conecte-se
                                    </Link>

                                    <Link :href="route('register')" class="nav-link ms-3 reg-link">
                                    Registro
                                    </Link>


                                </template>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<style scoped>
@media (max-width: 992px) {
    .aside-section {
        position: absolute;
        height: unset;
        top: 100px;
        overflow: hidden;
        width: 94%;
        left: 50%;
        transform: translateX(-50%);
    }
}

@media (max-width: 576px) {
    .container {
        position: relative;
    }

    .aside-section {
        top: 79px;
    }
}
</style>
