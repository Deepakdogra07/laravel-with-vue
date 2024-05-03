<script setup>
import Header from '@/Pages/Frontend/Header.vue';
import Footer from '@/Pages/Frontend/Footer.vue';
import InputError from '@/Components/InputError.vue';
import SubHeading from '@/Pages/Frontend/SubHeading.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import "../../../../css/frontend.css";
import { useForm } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';



const form = useForm({
    user_name : '',
    user_email : '',
    user_mobile : '',
    user_message : '',
});

function submitForm(){
    form.post(route('contact_us.store'),
    {
      onSuccess: () => {
        toast("Form submitted successfully!", {
          autoClose: 2000,
          theme: 'dark',
        }
        );
      },
    });

 }
</script>
<template>
    <Header class="login-wrapper"/>
    <SubHeading />
    <div class="login-bg-wrapper contactUs-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="contactus-sidebar">
                        <h2 class="text-white mb-4">Contact Info</h2>
                        <ul class="pl-0 listing-gap">
                            <li class="mb-3">
                                <a><i class="bi bi-telephone-fill pr-2"></i> +1300 779 462</a>
                            </li>
                            <li class="mb-3">
                                <a class="d-flex align-items-baseline gap-2" style="word-break: break-all;"><i
                                        class="fa-solid fa-envelope pr-2"></i>
                                    Info@dizonassociates.com.au</a>
                            </li>
                            <li class="mb-3">
                                <a class="d-flex align-items-baseline gap-2" style="word-break: break-all;"><i
                                        class="bi bi-geo-alt-fill"></i>
                                    Level 5 12 clarke St, Sunshine Victoria, Australia 3020 (enter via vicroads
                                    building) </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="main-contact-form">
                        <h2 class="getIn-touch">Get in Touch</h2>
                        <form @submit.prevent="submitForm">
                            <div class="mt-4">
                                <span class="label text-label">Name<span style="color:red"> *</span></span>
                                <TextInput type="text" name="user_name" v-model="form.user_name" placeholder="Enter your name" class="form-control mt-2" />
                                <InputError class="mt-2" :message="form.errors.user_name" />
                            </div>
                            <div class="mt-4">
                                <span class="label text-label">Email<span style="color:red"> *</span></span>
                                <TextInput type="text"name="user_email" v-model="form.user_email" placeholder="Enter your email" class="form-control mt-2" />
                                <InputError class="mt-2" :message="form.errors.user_email" />
                            </div>
                            <div class="mt-4">
                                <span class="label text-label">Mobile<span style="color:red"> *</span></span>
                                <TextInput type="number"name="user_mobile" v-model="form.user_mobile" placeholder="Enter your mobile number" class="form-control mt-2" />
                                <InputError class="mt-2" :message="form.errors.user_mobile" />
                            </div>
                            <div class="mt-4">
                                <span class="label text-label">Message<span style="color:red"> *</span></span>
                                <textarea class="form-control mt-2" name="user_message" v-model="form.user_message" placeholder="Type something..." id="" cols="30"
                                    rows="5"></textarea>
                                    <InputError class="mt-2" :message="form.errors.user_message" />
                            </div>
                            <div class="flex items-center mt-4 login-btn-main">
                                <PrimaryButton class="forms-btn" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Submit <span> <i class="bi bi-arrow-right"></i></span>
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