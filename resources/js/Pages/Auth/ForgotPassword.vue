<template>

  <Head title="Forgot Password" />
  <Header class="login-wrapper" />
  <SubHeading />
  <div class="login-bg-wrapper">
    <div class="container h-100">
      <div class="row align-items-center justify-center h-100">
        <div class="col-md-9 col-lg-7">
          <div class="w-full">
            <h1 class="mb-4 text-blue">Forgot Password</h1>
            <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
              We will email you your password reset link.
            </div>

            <form @submit.prevent="submit">
              <div v-if="!status">
                <!-- <InputLabel class="text-blue" for="email" value="Email"/> -->
                <span class="label text-label">Email<span style="color:red"> *</span></span>
                <TextInput id="email" type="text" placeholder="Enter your e-mail" class="form-control mt-2"
                  v-model="form.email"  autofocus autocomplete="username" />
                  <InputError class="mt-2" :message="form.errors.email" />
                <!-- <p style="color:red" v-if="form.errors.email">We couldn't find a user with that email address.</p> -->
              </div>

              <div class="flex items-center justify-start mt-4 login-btn-main">
                <PrimaryButton class="forms-btn" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                  Continue <span> <i class="bi bi-arrow-right"></i></span>
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
import Header from '../Frontend/Header.vue';
import Footer from '../Frontend/Footer.vue';
import SubHeading from '../Frontend/SubHeading.vue';
import { toast } from 'vue3-toastify';

defineProps({
  status: String,
});

const form = useForm({
  email: '',
});

const submit = () => {
  form.post(route('password.email'),{
    onSuccess: () => {
      console.log('hereeererere');
        toast("Email Sent Successfully", {
          autoClose: 2000,
          theme: 'dark',
        }
        );
      },
    });
};
</script>
