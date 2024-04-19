<template>
    <Head title="Registro" />
    <Header class="login-wrapper" />
    <SubHeading />
    <div class="login-bg-wrapper">
        <div class="container h-100">
            <div class="row align-items-center justify-center h-100">
                <div class="col-md-8 col-lg-6">
                    <div class="w-full">
                        <h1 class="mb-4 text-blue">Personal & Company Details</h1>
                        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                            {{ status }}
                        </div>

                        <form @submit.prevent="submit">
                            <div>
                                <TextInput name="type" value="business" type="hidden"/>
                                <!-- <InputLabel class="text-blue" for="name" value="Name" /> -->
                                <span class="label text-label">Name<span style="color:red"> *</span></span>
                                <TextInput id="name" type="text" placeholder="Enter nome" class="form-control mt-2"
                                    v-model="form.name" autofocus autocomplete="name" />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <div class="mt-4">
                                <!-- <InputLabel class="text-blue" for="email" value="Email" /> -->
                                <span class="label text-label">E-mail<span style="color:red"> *</span></span>
                                <TextInput id="email" type="text" placeholder="Enter e-mail"
                                    class="form-control mt-2" v-model="form.email" autocomplete="username" />
                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <div class="mt-4">
                                <span class="label text-label">Password<span style="color:red"> *</span></span>
                                <TextInput id="password" type="password" placeholder="Enter Password"
                                    class="form-control mt-2" v-model="form.password" autocomplete="new-password" />
                                <InputError class="mt-2" :message="form.errors.password" />


                            </div>

                            <div class="mt-4">
                                <!-- <InputLabel class="text-blue" for="password_confirmation" value="Confirm Password" /> -->
                                <span class="label text-label">Confirm Password<span style="color:red">
                                        *</span></span>
                                <TextInput id="password_confirmation" type="password"
                                    placeholder="Confirm Password" class="form-control mt-2"
                                    v-model="form.password_confirmation" autocomplete="new-password" />
                                <InputError class="mt-2" :message="form.errors.password_confirmation" />
                            </div>

                            <div class="mt-4">
                                <!-- <InputLabel class="text-blue" for="phone" value="Phone" /> -->
                                <span class="label text-label">Telephone<span style="color:red"> *</span></span>
                                <TextInput id="phone" type="text" placeholder="Enter phone"
                                    class="form-control mt-2" v-model="form.phone" autocomplete="phone" />
                                <InputError class="mt-2" :message="form.errors.phone" />
                            </div>

                            <!-- <div class="mt-4">
                            <InputLabel class="text-blue" for="address" value="Address" />
                            <span class="label label-default">Endereço<span style="color:red"> *</span></span>
                            <TextInput id="address" type="text" placeholder="Insira o endereço" class="mt-1 block w-full" v-model="form.address"
                                autocomplete="address" />
                            <InputError class="mt-2" :message="form.errors.address" />
                        </div> -->

                            <div class=" mt-3">
                                <input class="remember-me-check" type="checkbox" value="" id="flexCheckDefault"
                                    v-model="form.checkbox">
                                <label class="form-check-label text-label pl-2 " for="flexCheckDefault">
                                    I accept the
                                    <a class="text-lightgreen" href="/term-condition" target="_blank">Term & Conditions</a>
                                    <!-- <span style="color:red"> *</span> -->
                                </label>
                                <InputError class="mt-2" :message="form.errors.checkbox" />
                            </div>

                            <div class="flex items-center mt-4 login-btn-main">

                                <PrimaryButton class="forms-btn" :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                    Continue <span> <i class="bi bi-arrow-right"></i></span>
                                </PrimaryButton>
                                <Link :href="route('login')"
                                    class=" register-cancel text-sm ml-4 text-gray-900 hover:text-gray-900">
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
import SubHeading from '../Frontend/SubHeading.vue'
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
    checkbox: '',
});
const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<style scoped>
.term-policy-link {
    color: #000D37;
    text-decoration: underline !important;
}

.text-dark-blue {
    color: #00008b;
    /* Dark blue color */
}
</style>
