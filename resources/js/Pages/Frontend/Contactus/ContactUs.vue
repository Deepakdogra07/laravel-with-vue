<script setup>
import Header from '@/Pages/Frontend/Header.vue';
import Footer from '@/Pages/Frontend/Footer.vue';
import SubHeading from '@/Pages/Frontend/SubHeading.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import "../../../../css/frontend.css";
import { Link } from '@inertiajs/vue3';
</script>
<template>
    <Header class="login-wrapper" />
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
                        <div class="mt-4">
                            <span class="label text-label">Name<span style="color:red"> *</span></span>
                            <TextInput type="text" placeholder="Enter your password" class="form-control mt-2" />
                        </div>
                        <div class="mt-4">
                            <span class="label text-label">Email<span style="color:red"> *</span></span>
                            <TextInput type="text" placeholder="Enter your email" class="form-control mt-2" />
                        </div>
                        <div class="mt-4">
                            <span class="label text-label">Mobile<span style="color:red"> *</span></span>
                            <TextInput type="text" placeholder="Enter your mobile number" class="form-control mt-2" />
                        </div>
                        <div class="mt-4">
                            <span class="label text-label">Message<span style="color:red"> *</span></span>
                            <textarea class="form-control mt-2" placeholder="Type something..." id="" cols="30"
                                rows="5"></textarea>
                        </div>
                        <div class="flex items-center mt-4 login-btn-main">
                            <PrimaryButton class="forms-btn">
                                Submit <span> <i class="bi bi-arrow-right"></i></span>
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Footer />
</template>