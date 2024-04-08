<script setup>
import Footer from "../../Frontend/footer.vue";
import Header from "../../Frontend/header.vue";
import "../../../../css/frontend.css";
import { Head, Link, useForm } from '@inertiajs/vue3';

const logout = async () => {
  await Inertia.post('/logout');
}
</script>
<template>
    <div class="aside-section aside-section-desktop">
        <ul class="d-flex flex-column pl-0">
            <li :class="{'active-sidetab' : route().current() == 'user.loan'}">
                <i class="bi bi-ui-checks-grid "></i>
                <Link :class="{'active-sidetab' : route().current() == 'user.loan'}" href="/user/loan">Painel</Link>
            </li>
            <hr>
            <li :class="{'active-sidetab' : route().current() == 'all.loans'}">
                <i class="bi bi-cash-coin"></i>
                <Link :class="{'active-sidetab' : route().current() == 'all.loans'}" href="/all-loans">Meus empréstimos</Link>
            </li>
            <hr>
            <li :class="{'active-sidetab' : route().current() == 'user.edit.profile'}">
                <i class="bi bi-pencil-square"></i>
                <Link :class="{'active-sidetab' : route().current() == 'user.edit.profile'}" href="/user/editProfile">Editar Perfil</Link>
            </li>
            <hr>
            <li :class="{'active-sidetab' : route().current() == 'affiliate'}">
                <i class="bi bi-link"></i>
                <Link :class="{'active-sidetab' : route().current() == 'affiliate'}" href="/affiliate">Afiliados</Link>
            </li>
            <hr>
            <li :class="{'active-sidetab' : route().current() == 'logout'}">
                <i class="bi bi-box-arrow-left"></i>
                <Link :class="{'active-sidetab' : route().current() == 'logout'}" :href="route('logout')" method="post">Sair</Link>
            </li>

            <!-- <Link class="nav-link login-anchor" :href="route('logout')" method="post">Sair</Link> -->
        </ul>
    </div>
</template>
<style scoped>
.active-sidetab{
    color: #2CBCDD !important;
}
</style>

