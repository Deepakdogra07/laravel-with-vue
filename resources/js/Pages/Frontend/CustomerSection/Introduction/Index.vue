<script setup>
    import { Head, Link, router } from '@inertiajs/vue3';
    import Header from '@/Pages/Frontend/Header.vue';
    import Footer from '@/Pages/Frontend/Footer.vue';
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
    <div class="login-bg-wrapper contactUs-section">
        <div class="container">
            <p class="text-margin">When you apply for a Trade Skills Assessment, the first step in the process will be a Documentary Evidence Assessment. The documentary evidence is a collection of your employment and training documents that prove you have the skills and knowledge needed to work in your trade in Australia.</p>
            <p class="text-margin">This guide contains information about the types of evidence you need to provide so that your application is decision ready. Presenting your evidence correctly will enable our assessors to make a fair and accurate assessment decision.</p>
            <p class="text-margin">Some forms of evidence are mandatory – you must provide them.Other forms of evidence are not compulsory, but you can submit them to support your application.</p>
            <p class="text-margin">Your evidence needs to demonstrate that you meet the minimum employment experience requirement for your nominated occupation:</p>
            <div class="row mt-5">
                <div class="col-md-6 col-12">
                    <div class="d-flex gap-3">
                        <i class="fa-solid fa-circle-check green-text"></i>
                        <p class="light-text">Licensed Trades with no formal training – 6 years’ employment experience.</p>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="d-flex gap-3">
                        <i class="fa-solid fa-circle-check green-text"></i>
                        <p class="light-text">Non-licensed Trades with no formal training – 5 years’ employment experience</p>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="d-flex gap-3">
                        <i class="fa-solid fa-circle-check green-text"></i>
                        <p class="light-text">Licensed Trades with relevant formal training* – 4 years’ employment experience</p>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="d-flex gap-3">
                        <i class="fa-solid fa-circle-check green-text"></i>
                        <p class="light-text">Non-licensed Trades with relevant formal training* – 3 years’ employment experience</p>
                    </div>
                </div>
            </div>
            <div class="employment-highlight">
                <p class="green-text">Your employment must be in your nominated occupation, or in an occupation that is directly related to your nominated occupation and must include at least 12 months’ employment in your nominated occupation within the last 3 years.</p>
            </div>
            <p class="text-margin">It also has to be paid and full-time (or equivalent part-time). Full-time employment is defined as at least 38 hours per week. Part-time employment is counted on a pro rata basis.</p>
            <p class="text-margin">*Formal training is a training that is accredited by the authorised governing body in the country where the qualification was undertaken. It must be in your nominated occupation or an occupation directly related to your nominated occupation.</p>
            <div class="flex items-center justify-end mt-4 login-btn-main">
                <PrimaryButton class="forms-btn">
                    Next Step <span> <i class="bi bi-arrow-right"></i></span>
                </PrimaryButton>
            </div>
        </div>
    </div>
    <Footer />
</template>

<style scoped>

</style>