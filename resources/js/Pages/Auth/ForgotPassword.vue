<template>
       <Header class="login-wrapper" />
       <Head title="Esqueceu sua senha" />
      <div class="login-bg-wrapper">
        <div class="container h-100">
            <div class="row align-items-center h-100">
                <div class="col-md-8 col-lg-6">
                    <div class="w-full">
                        <h1 class="mb-4 text-blue">Esqueceu sua senha</h1>
                        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                            Enviamos por e-mail seu link de redefinição de senha.
                        </div>

                         <h4 class="mb-4 font-semibold text-gray-700 text-blue">
                          Esqueceu sua senha? Sem problemas. Basta nos informar seu endereço de e-mail e enviaremos um e-mail para você com uma redefinição de senha
             link que permitirá que você escolha um novo.
          </h4>
            <form @submit.prevent="submit">
            <div>
              <!-- <InputLabel class="text-blue" for="email" value="Email"/> -->
              <span class="label label-default">Email<span style="color:red"> *</span></span>
              <TextInput id="email" type="text"  placeholder="Digite o e-mail" class="block w-full mt-1" v-model="form.email" autofocus autocomplete="username" />
              <!-- <InputError class="mt-2" :message="form.errors.email" /> -->
              <p style="color:red" v-if="form.errors.email">Não conseguimos encontrar um usuário com esse endereço de e-mail.</p>
            </div>

            <div class="flex items-center justify-start mt-4">
              <PrimaryButton class="login-btn" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Redefinir senha
              </PrimaryButton>
            </div>
          </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
     <Footer class="login-wrapper" />
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import '@/../../resources/css/frontend.css';
import Header from '../Frontend/header.vue'
import Footer from '../Frontend/footer.vue'

defineProps({
  status: String,
});

const form = useForm({
  email: '',
});

const submit = () => {
  form.post(route('password.email'));
};
</script>
