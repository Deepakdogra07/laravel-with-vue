<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import Header from '@/Pages/Frontend/Header.vue';
import Footer from '@/Pages/Frontend/Footer.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import SubHeading from '@/Pages/Frontend/SubHeading.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import "../../../../../css/frontend.css";
import { useForm } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
</script>

<template>
    <Header />
    <SubHeading />
    <div class="login-bg-wrapper travel-section">
        <div class="container">
            <div class="travel-detail mb-5">
                <h2 class="mb-3">Travel details</h2>
                <h4 class="mb-3">Purpose of stay</h4>
                <label class="flex items-center mb-2">
                    <Checkbox class="remember-me-check" name="remember" />
                    <span class="ml-2 cursor-pointer remember-me">Tourism</span>
                </label>
                <label class="flex items-center mb-2">
                    <Checkbox class="remember-me-check" name="remember" />
                    <span class="ml-2 cursor-pointer remember-me">Business</span>
                </label>
                <label class="flex items-center mb-2">
                    <Checkbox class="remember-me-check" name="remember" />
                    <span class="ml-2 cursor-pointer remember-me">Transit</span>
                </label>
            </div>
            <div class="row mt-5">
                <div class="col-md-6 col-12">
                    <div class="travel-detail">
                        <h4 class="mb-3">Traditional visa</h4>
                        <label class="flex items-center mb-2">
                            <Checkbox class="remember-me-check" name="remember" />
                            <span class="ml-2 cursor-pointer remember-me">Skilled Visa (consultation)</span>
                        </label>
                        <label class="flex items-center mb-2">
                            <Checkbox class="remember-me-check" name="remember" />
                            <span class="ml-2 cursor-pointer remember-me">Skilled Visa (consultation)</span>
                        </label>
                        <label class="flex items-center mb-2">
                            <Checkbox class="remember-me-check" name="remember" />
                            <span class="ml-2 cursor-pointer remember-me">Relative Option Visa</span>
                        </label>
                        <label class="flex items-center mb-2">
                            <Checkbox class="remember-me-check" name="remember" />
                            <span class="ml-2 cursor-pointer remember-me">Partner Visa (consultation)</span>
                        </label>
                        <label class="flex items-center mb-2">
                            <Checkbox class="remember-me-check" name="remember" />
                            <span class="ml-2 cursor-pointer remember-me">Investor Visa (consultation)</span>
                        </label>
                        <label class="flex items-center mb-2">
                            <Checkbox class="remember-me-check" name="remember" />
                            <span class="ml-2 cursor-pointer remember-me">Other (consultation)</span>
                        </label>
                    </div>
                </div>
                <div class="col-md-6 col-12 travel-form-main">
                    <form class="row px-0 ">
                        <div class="col-md-12 mt-4">
                            <!-- <InputLabel class="text-blue" for="email" value="Email" /> -->
                            <span class="label text-label">Planned date of travel</span>

                            <TextInput id="email" type="date" class="form-control mt-2"/>
                                <InputError class="mt-2" />
                        </div>
                        <div class="col-md-6 col-12 mt-4">
                            <!-- <InputLabel class="text-blue" for="email" value="Email" /> -->
                            <span class="label text-label">Passenger nationality</span>

                            <select class="form-select mt-2">
                                <option selected :value="null" >----</option>
                                <option>Hello</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-12 mt-4">
                            <!-- <InputLabel class="text-blue" for="email" value="Email" /> -->
                            <span class="label text-label">Port of arrival</span>

                            <select class="form-select mt-2">
                                <option selected :value="null" >----</option>
                                <option>Hello</option>
                            </select>
                        </div>
                        <div class="flex items-center mt-4 login-btn-main">
                            <PrimaryButton class="forms-btn">
                                Continue <span> <i class="bi bi-arrow-right"></i></span>
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <Footer />
</template>

<style scoped></style>