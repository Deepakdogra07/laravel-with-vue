<template>
  <Header class="login-wrapper" />

  <Head title="Redefinir senha" />
  <div class="login-bg-wrapper">
    <div class="container h-100">
      <div class="row align-items-center justify-center h-100">
        <div class="col-md-9 col-lg-7">
          <div class="w-full">
            <h1 class="mb-4 text-blue"> Reset Password</h1>
            <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
              {{ status }}
            </div>
            <form @submit.prevent="submit">
              <!-- <div>
                <span class="label text-label">E-mail<span style="color:red"> *</span></span>
                <TextInput id="email" type="email" placeholder="Digite o e-mail" class="form-control mt-2"
                  v-model="form.email" autofocus autocomplete="username" />
                <InputError class="mt-2" :message="form.errors.email" />
              </div> -->

              <div class="mt-4">
                <!-- <InputLabel for="password" value="Password" class="text-blue"/> -->
                <span class="label text-label">New password</span>
                <TextInput id="password" type="password" placeholder="Enter new password" class="form-control mt-2"
                  v-model="form.password" autocomplete="new-password" />
                <InputError class="mt-2" :message="form.errors.password" />
              </div>

              <div class="mt-4">
                <!-- <InputLabel for="password_confirmation" value="Confirm Password" class="text-blue"/> -->
                <span class="label text-label">Confirm Password</span>
                <TextInput id="password_confirmation" type="password" placeholder="Confirm new password"
                  class="form-control mt-2" v-model="form.password_confirmation" autocomplete="new-password" />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
              </div>



              <div class="flex items-center justify-start mt-4 login-btn-main">
                <PrimaryButton class="forms-btn" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                  Reset Password <span><i class="bi bi-arrow-right"></i></span>
                </PrimaryButton>
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
import { Head, useForm } from '@inertiajs/vue3';
import '@/../../resources/css/frontend.css';
import Header from '../Frontend/Header.vue'
import Footer from '../Frontend/Footer.vue'

const props = defineProps({
  email: String,
  token: String,
});

const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(route('password.store'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>
<style scoped>
.text-dark-blue {
  color: #00008b;
  /* Dark blue color */
}
</style>
