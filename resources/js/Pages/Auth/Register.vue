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


<template>
    <Head title="Register" />
    <Header class="login-wrapper" />
    <SubHeading />
    <div class="login-bg-wrapper">
        <div class="container h-100">
            <h1 class="mb-4 text-blue">Personal & Company Details</h1>
            <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                {{ status }}
            </div>
            <form @submit.prevent="submit">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <span class="label text-label">Company Address<span style="color:red"> *</span></span>
                        <div>
                            <TextInput type="text" placeholder="Enter company address" class="form-control mt-2 mb-3" />
                            <select class="form-select mb-3" aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                            <select class="form-select mb-3" aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                            <TextInput type="text" placeholder="Enter pin code" class="form-control mb-3" />
                        </div>
                        <div class="mt-4">
                            <span class="label text-label">key contact person<span style="color:red"> *</span></span>
                            <TextInput id="password" type="password" placeholder="Enter Contact number"
                                class="form-control mt-2" v-model="form.password" autocomplete="new-password" />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>
    
                        <div class="mt-4">
                            <span class="label text-label">key contact person department<span style="color:red">
                                    *</span></span>
                            <TextInput type="text" placeholder="Enter department" class="form-control mt-2"
                                v-model="form.password" autocomplete="new-password" />
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div>
                            <!-- <InputLabel class="text-blue" for="email" value="Email" /> -->
                            <span class="label text-label">E-mail<span style="color:red"> *</span></span>
                            <TextInput id="email" type="text" placeholder="Enter e-mail" class="form-control mt-2"
                                v-model="form.email" autocomplete="username" />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                        <div class="mt-4">
                            <TextInput name="type" value="business" type="hidden" />
                            <!-- <InputLabel class="text-blue" for="name" value="Name" /> -->
                            <span class="label text-label">Mobile<span style="color:red"> *</span></span>
                            <TextInput type="text" placeholder="Enter your mobile number" class="form-control mt-2"
                                autofocus autocomplete="name" />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>
                        <div class="mt-4">
                            <TextInput name="type" value="business" type="hidden" />
                            <!-- <InputLabel class="text-blue" for="name" value="Name" /> -->
                            <span class="label text-label">Company name<span style="color:red"> *</span></span>
                            <TextInput id="name" type="text" placeholder="Enter company name" class="form-control mt-2"
                                v-model="form.name" autofocus autocomplete="name" />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>
                        <div class="mt-4">
                            <TextInput name="type" value="business" type="hidden" />
                            <!-- <InputLabel class="text-blue" for="name" value="Name" /> -->
                            <span class="label text-label">company VAT (if applicable)<span style="color:red">
                                    *</span></span>
                            <TextInput id="name" type="text" placeholder="Enter company VAT" class="form-control mt-2"
                                v-model="form.name" autofocus autocomplete="name" />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <h1 class="my-4 text-blue">Login Details</h1>
                        <div class="mt-4">
                            <!-- <InputLabel class="text-blue" for="email" value="Email" /> -->
                            <span class="label text-label">User name<span style="color:red"> *</span></span>
                            <TextInput type="text" placeholder="Enter user name" class="form-control mt-2"
                                v-model="form.email" autocomplete="username" />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                        <div class="mt-4">
                            <!-- <InputLabel class="text-blue" for="email" value="Email" /> -->
                            <span class="label text-label">Password<span style="color:red"> *</span></span>
                            <TextInput id="email" type="text" placeholder="Enter your password" class="form-control mt-2"
                                v-model="form.email" autocomplete="username" />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                    </div>
                </div>



                <!-- <div>
                    <InputLabel class="text-blue" for="phone" value="Phone" />
                    <span class="label text-label">Telephone<span style="color:red"> *</span></span>
                    <TextInput id="phone" type="text" placeholder="Enter phone" class="form-control mt-2"
                        v-model="form.phone" autocomplete="phone" />
                    <InputError class="mt-2" :message="form.errors.phone" />
                </div> -->
                <!-- <div class="mt-4">
                    <span class="label text-label">Password<span style="color:red"> *</span></span>
                    <TextInput id="password" type="password" placeholder="Enter Password" class="form-control mt-2"
                        v-model="form.password" autocomplete="new-password" />
                    <InputError class="mt-2" :message="form.errors.password" />


                </div>

                <div class="mt-4">
                    <InputLabel class="text-blue" for="password_confirmation" value="Confirm Password" />
                    <span class="label text-label">Confirm Password<span style="color:red">
                            *</span></span>
                    <TextInput id="password_confirmation" type="password" placeholder="Confirm Password"
                        class="form-control mt-2" v-model="form.password_confirmation" autocomplete="new-password" />
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div> -->



                <!-- <div class="mt-4">
                <InputLabel class="text-blue" for="address" value="Address" />
                <span class="label label-default">Endereço<span style="color:red"> *</span></span>
                <TextInput id="address" type="text" placeholder="Insira o endereço" class="mt-1 block w-full" v-model="form.address"
                    autocomplete="address" />
                <InputError class="mt-2" :message="form.errors.address" />
            </div> -->

                <div class=" mt-4">
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
    <Footer />
</template>


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
