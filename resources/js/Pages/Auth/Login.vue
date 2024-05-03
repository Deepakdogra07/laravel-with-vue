<script setup>
import Header from '../Frontend/Header.vue'
import Footer from '../Frontend/Footer.vue'
import SubHeading from '../Frontend/SubHeading.vue'
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import '@/../../resources/css/frontend.css';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import { toast } from 'vue3-toastify';


const showPassword = ref(false);

const passwordFieldType = computed(() => showPassword.value ? 'text' : 'password');
const eyeIconClass = computed(() => showPassword.value ? 'bi bi-eye' : 'bi bi-eye-slash');

const togglePasswordVisibility = () => {
    showPassword.value = !showPassword.value;
};

const props = defineProps({
    canResetPassword: Boolean,
    status: String,
    footer_data :{
        type:Object
    },
    cookies:{
        type:Object
    },
    msg : {
        type:String
    }
});
if(props.msg){
    toast(props.msg, {
            autoClose: 3000,
            theme: 'dark',
        });
}

const form = useForm({
    email: props.cookies.remember_email ?? '',
    password: props.cookies.remember_password ??'',
    remember: false,
});

const submit = () => {
    
    form.post(route('login.post'));
};
</script>
<template>
    <Head title="Log in" />
    <Header class="login-wrapper" :logo_image="props?.footer_data?.logo_image"/>
    <SubHeading />
    <div class="login-bg-wrapper">
        <div class="container h-100">
            <div class="row align-items-center justify-center h-100">
                <div class="col-lg-7 col-md-9 ">
                    <h1 class="mb-4 text-blue">Login</h1>
                    <!-- <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                        <h3>Please Enter Your email and password for login</h3>
                    </div> -->
                    <form @submit.prevent="submit">
                        <div class="mt-4">
                            <!-- <InputLabel class="text-blue" for="email" value="Email" /> -->
                            <span class="label text-label">E-mail or Username<span style="color:red"> *</span></span>

                            <TextInput id="email" type="text" placeholder="Enter your e-mail or username" class="form-control mt-2"

                                v-model="form.email" autofocus/>
                                <InputError class="mt-2" :message="form.errors.email" />
                            <!-- <p style="color: red;"
                                v-if="form.errors.email == 'Your account is inactive. Please contact the admin.'">
                                Your account is inactive. Please contact the administrator.
                            </p> -->
                        </div>

                        <div class="mt-4">
                            <span class="label text-label">Password<span style="color:red"> *</span></span>
                            <div class="eye-icon-div relative">
                                <TextInput id="password" :type="passwordFieldType" placeholder="Enter your Password"
                                    class="form-control mt-2" v-model="form.password"/>
                                <span class="absolute top-[50%] right-[20px] translate-y-[-50%]" @click="togglePasswordVisibility">
                                    <i :class="eyeIconClass"></i>
                                </span>
                            </div>
                            <InputError class="mt-2" :message="form.errors.password" />
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-4">
                            <label class="flex items-center">
                                <Checkbox class="remember-me-check" name="remember" v-model:checked="form.remember" />
                                <span class="ml-2 cursor-pointer remember-me">Remember Me</span>
                            </label>
                        
                            <Link  :href="route('password.request')"
                                class="text-lightgreen  hover:text-gray-900">
                            Forgot Password?
                            </Link>
                        </div>
                        <div class="flex items-center mt-4 login-btn-main">
                            <PrimaryButton class="forms-btn" :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                                Continue <span> <i class="bi bi-arrow-right"></i></span>
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <Footer :footer_data="props?.footer_data"/>
</template>
