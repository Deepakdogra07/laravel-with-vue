<template>
  <Head title="Reset Password" />
  <Header class="login-wrapper" />
  <SubHeading />
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
                <div class="relative">
                  <TextInput id="password" :type="passwordFieldType" placeholder="Enter new password" class="form-control mt-2"
                    v-model="form.password" autocomplete="new-password" />
                    <span class="absolute top-[50%] right-[20px] translate-y-[-50%] cursor-pointer" @click="togglePasswordVisibility">
                                          <i :class="eyeIconClass"></i>
                                      </span>
                </div>
                  <InputError class="mt-2" :message="form.errors.password" />
                </div>

              <div class="mt-4">
                <!-- <InputLabel for="password_confirmation" value="Confirm Password" class="text-blue"/> -->
                <span class="label text-label">Confirm Password</span>
                <div class="relative">
                  <TextInput id="password_confirmation" :type="passwordFieldType1" placeholder="Confirm new password"
                    class="form-control mt-2" v-model="form.password_confirmation" autocomplete="new-password" />
                    <span class="absolute top-[50%] right-[20px] translate-y-[-50%] cursor-pointer" @click="togglePasswordVisibility1">
                                          <i :class="eyeIconClass1"></i>
                                      </span>
                </div>
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
import SubHeading from '../Frontend/SubHeading.vue';
import { computed,ref } from 'vue';
import { toast } from 'vue3-toastify';

const showPassword = ref(false),
showPassword1 = ref(false);

const props = defineProps({
  email: String,
  token: String,
});
const togglePasswordVisibility = () => {
    showPassword.value = !showPassword.value;
};
const togglePasswordVisibility1 = () => {
    showPassword1.value = !showPassword1.value;
};
const passwordFieldType = computed(() => showPassword.value ? 'text' : 'password');
const passwordFieldType1 = computed(() => showPassword1.value ? 'text' : 'password');
const eyeIconClass = computed(() => showPassword.value ? 'bi bi-eye' : 'bi bi-eye-slash'),
eyeIconClass1 = computed(() => showPassword1.value ? 'bi bi-eye' : 'bi bi-eye-slash');
const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(route('password.store') ,{
    onSuccess: () => {
        toast("Password Reset Successfully", {
          autoClose: 2000,
          theme: 'dark',
        }
        );
      },
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
