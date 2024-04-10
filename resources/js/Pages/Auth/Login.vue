<script setup>
import Header from '../Frontend/Header.vue'
import Footer from '../Frontend/Footer.vue'
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import '@/../../resources/css/frontend.css';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const showPassword = ref(false);

const passwordFieldType = computed(() => showPassword.value ? 'text' : 'password');
const eyeIconClass = computed(() => showPassword.value ? 'bi bi-eye' : 'bi bi-eye-slash');

const togglePasswordVisibility = () => {
    showPassword.value = !showPassword.value;
};

defineProps({
    canResetPassword: Boolean,
    status: String,
});
const form = useForm({
    email: '',
    password: '',
    remember: false
});
const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>
<template>
    <Header class="login-wrapper" />

    <Head title="Log in" />
    <div class="login-bg-wrapper">
        <div class="container h-100">
            <div class="row align-items-center h-100">
                <div class="col-md-8 col-lg-6">
                    <div class="w-full">
                        <h1 class="mb-4 text-blue">Login</h1>
                        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                            <h3>status</h3>
                        </div>
                        <form @submit.prevent="submit">
                            <div class="mt-4">
                                <!-- <InputLabel class="text-blue" for="email" value="Email" /> -->
                                <span class="label label-default">E-mail<span style="color:red"> *</span></span>
                                <TextInput id="email" type="email" placeholder="Enter e-mail" class="block w-full mt-1"
                                    v-model="form.email" autofocus autocomplete="username" />
                                <p style="color: red;" v-if="form.errors.email == 'Your account is inactive. Please contact the admin.'">
                                    Your account is inactive. Please contact the administrator.
                                </p>
                                <p style="color: red;" v-if="form.errors.email == 'These credentials do not match our records.'">
                                    These credentials do not match our records.
                                </p>
                            </div>
                            
                            <div class="mt-4">
                                <span class="label label-default">Password<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <TextInput id="password" :type="passwordFieldType" placeholder="Enter Password"
                                        class="block w-full mt-1" v-model="form.password" autocomplete="current-password" />
                                    <span @click="togglePasswordVisibility">
                                        <i :class="eyeIconClass"></i>
                                    </span>
                                </div>
                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>

                            <div class="d-flex align-items-center justify-content-between mt-4">
                                <label class="flex items-center">
                                    <Checkbox name="remember" v-model:checked="form.remember" />
                                    <span class="ml-2 text-blue cursor-pointer">Remember Me</span>
                                </label>
                                <Link v-if="canResetPassword" :href="route('password.request')"
                                    class="text-blue  hover:text-gray-900">
                                    Forgot Password
                                </Link>
                            </div>

                            <div class="flex items-center mt-4">
                                <PrimaryButton class="login-btn" :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                    Login
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
