<template>
    <Header class="login-wrapper" />
    <Head title="Email Verification"/>
    <div class="login-bg-wrapper">
        <div class="container h-100">
            <div class="row align-items-center h-100">
                <div class="col-md-9 col-lg-7">
                    <div class="w-full">
                        <h1 class="mb-4 text-blue">verificação de e-mail</h1>
                        <div v-if="status" class="mb-4 text font-medium text-green-600">
                            <!-- {{ status }} -->
                            link de verificação enviado
                        </div>
          <h4 class="mb-4 font-semibold text-gray-700 text-blue">
            Obrigado por inscrever-se! Antes de começar, você poderia verificar seu endereço de e-mail clicando no link que
             acabei de enviar por e-mail para você? Se você não recebeu o e-mail, teremos prazer em lhe enviar outro.
          </h4>

           <form @submit.prevent="submit">
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
              Reenviar email de verificação
            </PrimaryButton>

            <Link :href="route('logout')" method="post" as="button" class="underline  text-gray-600 hover:text-gray-900 pl-3">
              Sair
            </Link>
          </form>

                    </div>
                </div>
            </div>
        </div>
      </div>
      <Footer />
</template>

<script setup>
import '@/../../resources/css/frontend.css';
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Header from '../Frontend/Header.vue'
import Footer from '../Frontend/Footer.vue'


const props = defineProps({
  status: String,
});
const form = useForm({});
const submit = () => {
  form.post(route('verification.send'));
};
const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>
