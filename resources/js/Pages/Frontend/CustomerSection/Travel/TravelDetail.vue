<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Header from '@/Pages/Frontend/Header.vue';
import Footer from '@/Pages/Frontend/Footer.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import SubHeading from '@/Pages/Frontend/SubHeading.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import "../../../../../css/frontend.css";
import {  } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import { Country } from 'country-state-city';
import { ref } from 'vue';
const props = defineProps({
    job_id:{
        type:Number
    }
})
const countries =  Country.getAllCountries();

const form = useForm({
    job_id:props.job_id,
    purpose_of_stay:[],
    type_of_visa:[],
    date_of_travel:null,
    passenger_nationality:null,
    port_of_arrival:null,

})
const select_class = ref('');


function submitform(){
    form.post(route('personal.details',form.job_id));
}
function handleCountryInput(){
    select_class.value = 'Selected_option' ;
}

</script>

<template>
    <Header />
    <SubHeading :job_id="form.job_id"/>
    <div class="login-bg-wrapper travel-section">
        <div class="container">
            <form @submit.prevent="submitform()">
                <div class="travel-detail mb-5">

                    <h2 class="mb-3">Travel details</h2>
                    <h4 class="mb-3">Purpose of stay</h4>
                    <label class="flex items-center mb-2">
                        <TextInput type="checkbox"  class="remember-me-check" name="remember1" value="Tourism" v-model="form.purpose_of_stay" />
                        <span class="ml-2 cursor-pointer remember-me">Tourism</span>
                    </label>
                    <label class="flex items-center mb-2">
                        <TextInput type="checkbox" class="remember-me-check" name="remember1" value="Business" v-model="form.purpose_of_stay"/>
                        <span class="ml-2 cursor-pointer remember-me">Business</span>
                    </label>
                    <label class="flex items-center mb-2">
                        <TextInput type="checkbox" class="remember-me-check" name="remember1" value="Transit" v-model="form.purpose_of_stay"/>
                        <span class="ml-2 cursor-pointer remember-me">Transit</span>
                    </label>
                    <InputError  class="mt-2" :message="form.errors.purpose_of_stay"/>
                </div>
                <div class="row mt-5 travel_row">
                    <div class="col-md-6 col-12">
                        <div class="travel-detail">
                            <h4 class="mb-3">Traditional visa</h4>
                            <label class="flex items-center mb-2">
                                <TextInput type="checkbox" class="remember-me-check" name="remember" value="skilled_visa(individual)"   v-model="form.type_of_visa"/>
                                <span class="ml-2 cursor-pointer remember-me">Skilled Visa (individual)</span>
                            </label>
                            <label class="flex items-center mb-2">
                                <TextInput type="checkbox" class="remember-me-check" name="remember" value="skilled_visa(consultation)"  v-model="form.type_of_visa"/>
                                <span class="ml-2 cursor-pointer remember-me">Skilled Visa (consultation)</span>
                            </label>
                            <label class="flex items-center mb-2">
                                <TextInput type="checkbox" class="remember-me-check" name="remember" value="relative_option_visa"  v-model="form.type_of_visa"/>
                                <span class="ml-2 cursor-pointer remember-me">Relative Option Visa</span>
                            </label>
                            <label class="flex items-center mb-2">
                                <TextInput type="checkbox" class="remember-me-check" name="remember" value="partner_visa(consultation)"  v-model="form.type_of_visa"/>
                                <span class="ml-2 cursor-pointer remember-me">Partner Visa (consultation)</span>
                            </label>
                            <label class="flex items-center mb-2">
                                <TextInput type="checkbox" class="remember-me-check" name="remember" value="investor_visa(consultation)"  v-model="form.type_of_visa"/>
                                <span class="ml-2 cursor-pointer remember-me">Investor Visa (consultation)</span>
                            </label>
                            <label class="flex items-center mb-2">
                                <TextInput type="checkbox" class="remember-me-check" name="remember" value="other(consultation)"  v-model="form.type_of_visa"/>
                                <span class="ml-2 cursor-pointer remember-me">Other (consultation)</span>
                            </label>
                        </div>
                        <InputError  class="mt-2" :message="form.errors.type_of_visa"/>
                    </div>
                    <div class="col-md-6 col-12 travel-form-main">
                            <div class="col-md-12 mt-4">
                                <!-- <InputLabel class="text-blue" for="email" value="Email" /> -->
                                <span class="label text-label">Planned date of travel</span>

                                <TextInput id="email" type="date" class="form-control mt-2" v-model="form.date_of_travel"/>
                                    <InputError class="mt-2" :message="form.errors.date_of_travel"/>
                            </div>
                            <div class="row natoinality_row">
                                <div class="col-md-6 col-12 mt-4 spacinf_rigght">
                                <!-- <InputLabel class="text-blue" for="email" value="Email" /> -->
                                <span class="label text-label">Passenger nationality</span>

                                <select class="form-select select_option mt-2" :class="select_class" @change="handleCountryInput()" v-model="form.passenger_nationality">
                                    <option selected :value="null" >----</option>
                                    <option v-for="country in countries" :value="country.name">{{ country.name }}</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.passenger_nationality"/>
                            </div>
                            <div class="col-md-6 col-12 mt-4">
                                <!-- <InputLabel class="text-blue" for="email" value="Email" /> -->
                                <span class="label text-label">Port of arrival</span>

                                <TextInput  type="text" class="form-control mt-2" v-model="form.port_of_arrival"/>
                                    <InputError class="mt-2" :message="form.errors.port_of_arrival"/>
                            </div>

                            </div>
                            <div class="flex items-center mt-4 login-btn-main">
                                <PrimaryButton class="forms-btn">
                                    Continue <span> <i class="bi bi-arrow-right"></i></span>
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
    <Footer />
</template>

<style scoped>
.remember-me-check{
    width: 20px;
}</style>