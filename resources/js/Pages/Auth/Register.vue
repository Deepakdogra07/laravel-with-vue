<template>
        <Header class="login-wrapper" />
        <Head title="Registro" />
          <div class="register-bg-wrapper">
        <div class="container h-100">
            <div class="row align-items-center h-100">
                <div class="col-md-8 col-lg-6">
                    <div class="w-full">
                        <h1 class="mb-4 text-blue">Criar nova conta</h1>
                        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                            {{ status }}
                        </div>

                       <form @submit.prevent="submit">
                        <div>
                            <!-- <InputLabel class="text-blue" for="name" value="Name" /> -->
                            <span class="label label-default">Nome<span style="color:red"> *</span></span>
                            <TextInput  id="name" type="text" placeholder="Insira o nome" class="block w-full mt-1" v-model="form.name"
                                autofocus autocomplete="name" />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="mt-4">
                            <!-- <InputLabel class="text-blue" for="email" value="Email" /> -->
                            <span class="label label-default">E-mail<span style="color:red"> *</span></span>
                            <TextInput id="email" type="text" placeholder="Digite o e-mail" class="block w-full mt-1" v-model="form.email"
                                autocomplete="username" />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="mt-4">
                            <span class="label label-default">Senha<span style="color:red"> *</span></span>
                            <TextInput id="password" type="password" placeholder="Digite a senha" class="block w-full mt-1" v-model="form.password"
                                 autocomplete="new-password" />
                            <InputError class="mt-2" :message="form.errors.password" />


                        </div>

                        <div class="mt-4">
                            <!-- <InputLabel class="text-blue" for="password_confirmation" value="Confirm Password" /> -->
                            <span class="label label-default">Confirme sua senha<span style="color:red"> *</span></span>
                            <TextInput id="password_confirmation" type="password" placeholder="Digite Confirmar Senha" class="block w-full mt-1"
                                v-model="form.password_confirmation"  autocomplete="new-password" />
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>

                        <div class="mt-4">
                            <!-- <InputLabel class="text-blue" for="phone" value="Phone" /> -->
                            <span class="label label-default">Telefone<span style="color:red"> *</span></span>
                            <TextInput id="phone" type="text" placeholder="Digite o número de telefone" class="mt-1 block w-full" v-model="form.phone"
                                autocomplete="phone" />
                            <InputError class="mt-2" :message="form.errors.phone" />
                        </div>

                        <!-- <div class="mt-4">
                            <InputLabel class="text-blue" for="address" value="Address" />
                            <span class="label label-default">Endereço<span style="color:red"> *</span></span>
                            <TextInput id="address" type="text" placeholder="Insira o endereço" class="mt-1 block w-full" v-model="form.address"
                                autocomplete="address" />
                            <InputError class="mt-2" :message="form.errors.address" />
                        </div> -->

                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" v-model="form.checkbox">
                            <label class="form-check-label" for="flexCheckDefault">
                                Concordo
                                <a class="term-policy-link" href="/term-condition" target="_blank">Termos de uso</a>
                                 e
                                <a class="term-policy-link" href="/privacy-policy" target="_blank">Política de privacidade</a>

                                 <span style="color:red"> *</span>
                            </label>
                            <InputError class="mt-2" :message="form.errors.checkbox" />
                        </div>

                        <div class="flex items-center mt-4">

                            <PrimaryButton class="login-btn " :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                                Criar uma conta
                            </PrimaryButton>
                            <Link :href="route('login')" class=" register-cancel text-sm ml-4 text-gray-900 hover:text-gray-900">
                                Cancelar
                            </Link>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Footer />
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Header from '../Frontend/Header.vue'
import Footer from '../Frontend/Footer.vue'
import '@/../../resources/css/frontend.css';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  dob: '',
//   address: '',
  phone: '',
  gender: '',
  interests: '',
  referralcode: '',
  terms: false,
  checkbox : '',
});
const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<style scoped>
.term-policy-link{
    color: #000D37;
    text-decoration: underline !important;
}

.text-dark-blue {
    color: #00008b; /* Dark blue color */
}
</style>
