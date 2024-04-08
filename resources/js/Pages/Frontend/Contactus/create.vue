<script setup>
import { reactive } from 'vue'
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import {Head, router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';
import { useToast } from 'vue-toastify';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Header from '../../Frontend/header.vue';
import Footer from '../../Frontend/footer.vue';
import "../../../../css/frontend.css";



const form = reactive({
  name: null,
  email: null,
  phone: null,
  position: null,
  message: null,
})

const props = defineProps({
  errors: Object,
  contactDetails: Array,
});


const submit = async () => {
  const options = {
    onSuccess: page => {
      toast("Formulário enviado com sucesso!", {
        autoClose: 2000,
        theme: 'dark',
      }
      );
        form.name = '';
        form.email = '',
        form.phone = '',
        form.message = ''
    },
    onError: errors => {
    },
  }
  const response = router.post('/contactus', form, options);
};


</script>

<template>
     <Head title="Contate-nos" />
    <Header class="login-wrapper" />
    <div class="about-us-bg-wrapper">
        <div class="container">
            <h1 class="mb-4 text-blue text-center">Contate-nos</h1>
            <div v-if="status" class="mb-4 text-sm font-medium text-green-600">A
                {{ status }}
            </div>
        </div>
    </div>
    <div class="contact-form">
        <div class="row w-100 contact-form-row">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="contact-info">
                    <h2>Informações de contato</h2>
                    <div class="d-flex my-5 " style="gap: 10px;">
                        <div>
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <h4 class="mb-2">Ligue para nós</h4>
                            <p v-if="props.contactDetails">{{ props.contactDetails.phone_no }}</p>
                        </div>
                    </div>
                    <div class="d-flex " style="gap: 10px;">
                        <div>
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <h4 class="mb-2">Envia-nos um email</h4>
                            <p v-if="props.contactDetails">{{ props.contactDetails.email }}</p>
                        </div>
                    </div>
                    <div class="d-flex my-5" style="gap: 10px;">
                        <div>
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <h4 class="mb-2">Endereço</h4>
                            <p v-if="props.contactDetails">{{ props.contactDetails.address }}</p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-1 col-0 white-space">

            </div>
            <div class="col-lg-6 col-md-6 col-12 main-contact-form">
                <h2 class="text-white">Entrar em contato</h2>
                <form @submit.prevent="submit">
                    <div class="row form-row">
                        <div class="col-md-12 my-4 form-inputs">
                            <label class="text-white" for="receive-loan-through">Nome <span
                                    class="text-red-500">*</span></label>
                            <input class="form-control" id="name" v-model="form.name" placeholder="Insira o nome" />
                            <div v-if="errors.name" style="color: red;">{{ errors.name }}</div>
                        </div>
                        <div class="col-md-12 form-inputs">
                            <label class="text-white" for="receive-loan-through">E-mail <span
                                    class="text-red-500">*</span></label>
                            <input class="form-control" id="email" v-model="form.email" placeholder="Digite o e-mail" />
                            <div v-if="errors.email" style="color: red;">{{ errors.email }}</div>
                        </div>
                        <div class="col-md-12 my-4 form-inputs">
                            <label class="text-white" for="receive-loan-through">Telefone <span
                                    class="text-red-500">*</span></label>
                            <input class="form-control" id="phone" v-model="form.phone" placeholder="Digite o telefone" />
                            <div v-if="errors.phone" style="color: red;">{{ errors.phone }}</div>
                        </div>



                        <div class="col-md-12 form-inputs">
                            <label class="text-white" for="receive-loan-through">Mensagem <span
                                    class="text-red-500">*</span></label>

                            <textarea class="form-control" id="message" v-model="form.message"
                                placeholder="Digite a mensagem"></textarea>

                            <div v-if="errors.message" style="color: red;">{{ errors.message }}</div>
                        </div>




                    </div>
                    <button class="contact-submit mt-4" type="submit">Enviar</button>
                </form>
            </div>
            <div class="col-lg-1 col-0 d-md-none"></div>

        </div>
</div>
<Footer /></template>
