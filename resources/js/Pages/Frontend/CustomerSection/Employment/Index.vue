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
    <div class="login-bg-wrapper employment-first-form">
        <div class="container">
            <!-- 1 -->
            <div class="employment-first-form">
                <p class="light-text">You must provide official employment evidence to demonstrate that you meet the minimum
                    employment experience requirements for your nominated occupation.Each period of employment submitted for
                    assessment must be supported by the following two forms of evidence:</p>
                <h2>1. An employer statement that includes all the following details:</h2>
                <div class="row mt-4">
                    <div class="col-md-6 col-12">
                        <div class="d-flex gap-3">
                            <i class="fa-solid fa-circle-check green-text"></i>
                            <p class="light-text">your exact employment period (start and finish dates, including day and
                                month)
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="d-flex gap-3">
                            <i class="fa-solid fa-circle-check green-text"></i>
                            <p class="light-text">the nature of your employment (full-time,part-time, casual)</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="d-flex gap-3">
                            <i class="fa-solid fa-circle-check green-text"></i>
                            <p class="light-text">your normal hours of work</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="d-flex gap-3">
                            <i class="fa-solid fa-circle-check green-text"></i>
                            <p class="light-text">your job title(s)</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="d-flex gap-3">
                            <i class="fa-solid fa-circle-check green-text"></i>
                            <p class="light-text">a detailed description of the tasks that you perform</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="d-flex gap-3">
                            <i class="fa-solid fa-circle-check green-text"></i>
                            <p class="light-text">the name and address of the business on official business letterhead</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex gap-3">
                            <i class="fa-solid fa-circle-check green-text"></i>
                            <p class="light-text"> the name, position, contact details (business phone number and email
                                address), date and signature of the person authorised to make the employer statement and the
                                length of time they supervised your work. This person, known as your ‘referee’, must be your
                                manager, supervisor or human resources department representative.</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="file-inputs mt-3 relative">
                            <div class="dotted-bg">
                                <img src="" alt="" srcset="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"
                                    fill="none">
                                    <path
                                        d="M54.0774 47.7783L54.0771 47.7778L43.0478 32.5166C43.047 32.5155 43.0463 32.5145 43.0455 32.5134C41.5448 30.4238 38.4396 30.4235 36.9386 32.5128C36.9377 32.5141 36.9368 32.5153 36.9359 32.5166L25.9066 47.7778L25.9062 47.7783C24.1017 50.2769 25.8784 53.7609 28.9661 53.7609H32.6383V67.1046H15.4721C8.09988 66.6655 2 59.6549 2 51.908C2 46.6514 4.84793 42.0611 9.08693 39.5752L10.5322 38.7276L9.951 37.1562C9.59374 36.1903 9.40499 35.1506 9.40499 34.0412C9.40499 29.0159 13.4626 24.9583 18.4879 24.9583C19.5794 24.9583 20.6192 25.1465 21.5866 25.5043L23.3067 26.1405L24.0892 24.4818C27.3185 17.6362 34.28 12.8951 42.3688 12.8945C52.8366 12.9101 61.4659 20.9279 62.4473 31.143L62.5934 32.664L64.0993 32.9228C71.9373 34.2702 78 41.5883 78 49.9301C78 58.8106 71.0858 66.4598 62.4369 67.1046H47.3453V53.7609H51.0176C54.0719 53.7609 55.8919 50.2907 54.0774 47.7783Z"
                                        stroke="#01796F" stroke-width="4"></path>
                                </svg>
                                <h2 class="choose-para">Upload Document Or Scan Document </h2>
                                <p class="file-type">Max size 20MB</p><input class="upload" type="file" id="banner">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-between align-items-center">
                        <div class="flex items-center mt-4 ">
                            <PrimaryButton class="forms-btn-transparent step-form-back">
                                <span> <i class="bi bi-arrow-left"></i></span> Back
                            </PrimaryButton>
                        </div>
                        <div class="flex items-center mt-4 login-btn-main">
                            <PrimaryButton class="forms-btn">
                                Next Step <span> <i class="bi bi-arrow-right"></i></span>
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2 -->
            
        </div>
    </div>
    <Footer />
</template>
<style scoped></style>