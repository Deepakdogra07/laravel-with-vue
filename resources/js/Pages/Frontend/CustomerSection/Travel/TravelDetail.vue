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
import { Country } from 'country-state-city';
import { ref } from 'vue';
import '@vuepic/vue-datepicker/dist/main.css'; 
import VueDatePicker from '@vuepic/vue-datepicker'; 

const today = new Date();
const format = (date) => {
  const day = date.getDate();
  const month = date.getMonth() + 1;
  const year = date.getFullYear();
   var month1 = (month <=9) ?`0${month}`:month;
   form.date_of_travel = `${year}-${month1}-${day}`;
  return `${year}/${month1}/${day}`;
}
const props = defineProps({
    job_id:{
        type:Number
    },
    already_customer:{
        type:Object
    }
})
const countries =  Country.getAllCountries();
    const form = useForm({
        job_id:props.job_id,
        purpose_of_stay:props?.already_customer?.travel_details?.purpose_of_stay ?? null,
        type_of_visa:props?.already_customer?.travel_details?.type_of_visa ?? null,
        date_of_travel:props?.already_customer?.travel_details?.date_of_travel ?? null,
        passenger_nationality:props?.already_customer?.travel_details?.passenger_nationality  ?? null,
        port_of_arrival:props?.already_customer?.travel_details?.port_of_arrival ?? null,
        migrate_country:props?.already_customer?.migrate_country ?? null
    })
const select_class = ref('');
const migrate = ref('');


function submitform(){
    form.post(route('personal.details',form.job_id));
}
function handleCountryInput(type){
    if(type == 'nationality'){
        select_class.value = 'Selected_option' ;
    }
    if(type == 'migrate'){
        migrate.value = 'Selected_option' ;
    }
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
                    <h4 class="mb-3">Purpose of stay <span data-v-ef3b84b0="" style="color: red;"> *</span></h4>
                    <label class="flex items-center mb-2">
                        <TextInput type="radio"  class="remember-me-check" value="Tourism" v-model="form.purpose_of_stay" />
                        <span class="ml-2 cursor-pointer remember-me">Tourism</span>
                    </label>
                    <label class="flex items-center mb-2">
                        <TextInput type="radio" class="remember-me-check" value="Business" v-model="form.purpose_of_stay"/>
                        <span class="ml-2 cursor-pointer remember-me">Business</span>
                    </label>
                    <label class="flex items-center mb-2">
                        <TextInput type="radio" class="remember-me-check" value="Transit" v-model="form.purpose_of_stay"/>
                        <span class="ml-2 cursor-pointer remember-me">Transit</span>
                    </label>
                    <InputError  class="mt-2" :message="form.errors.purpose_of_stay"/>
                </div>
                <div class="row mt-5 travel_row">
                    <div class="col-md-6 col-12">
                        <div class="travel-detail">
                            <h4 class="mb-3">Traditional visa <span data-v-ef3b84b0="" style="color: red;"> *</span></h4>
                            <label class="flex items-center mb-2">
                                <TextInput type="radio" class="remember-me-check" value="skilled_visa(individual)"   v-model="form.type_of_visa" />
                                <span class="ml-2 cursor-pointer remember-me">Skilled Visa (individual)</span>
                            </label>
                            <label class="flex items-center mb-2">
                                <TextInput type="radio" class="remember-me-check" value="skilled_visa(consultation)"  v-model="form.type_of_visa" />
                                <span class="ml-2 cursor-pointer remember-me">Skilled Visa (consultation)</span>
                            </label>
                            <label class="flex items-center mb-2">
                                <TextInput type="radio" class="remember-me-check" value="relative_option_visa"  v-model="form.type_of_visa" />
                                <span class="ml-2 cursor-pointer remember-me">Relative Option Visa</span>
                            </label>
                            <label class="flex items-center mb-2">
                                <TextInput type="radio" class="remember-me-check" value="partner_visa(consultation)"  v-model="form.type_of_visa" />
                                <span class="ml-2 cursor-pointer remember-me">Partner Visa (consultation)</span>
                            </label>
                            <label class="flex items-center mb-2">
                                <TextInput type="radio" class="remember-me-check" value="investor_visa(consultation)"  v-model="form.type_of_visa" />
                                <span class="ml-2 cursor-pointer remember-me">Investor Visa (consultation)</span>
                            </label>
                            <label class="flex items-center mb-2">
                                <TextInput type="radio" class="remember-me-check" value="other(consultation)"  v-model="form.type_of_visa" />
                                <span class="ml-2 cursor-pointer remember-me">Other (consultation)</span>
                            </label>
                        </div>
                        <InputError  class="mt-2" :message="form.errors.type_of_visa"/>
                    </div>
                    <div class="col-md-6 col-12 travel-form-main">
                            <div class="col-md-12 natoinality_row mt-4 row">
                                <div class="col-md-6 col-12 mt-4 spacinf_rigght">
                                    <span class="label text-label">Planned date of travel <span data-v-ef3b84b0="" style="color: red;"> *</span></span>
                                    <!-- <TextInput id="email" type="date" class="form-control mt-2" v-model="form.date_of_travel"/> -->
                                    <VueDatePicker v-model="form.date_of_travel" placeholder="Select Date of travel" class="form-control mt-2  " :format="format" :min-date="today" prevent-min-max-navigation :type="'date'"
                                    />
                                    <InputError class="mt-2" :message="form.errors.date_of_travel"/>
                                </div>
                                <div class="col-md-6 col-12 mt-4 spacinf_rigght">
                                <!-- <InputLabel class="text-blue" for="email" value="Email" /> -->
                                <span class="label text-label">Passenger nationality <span data-v-ef3b84b0="" style="color: red;"> *</span></span>

                                <select class="form-select select_option mt-2" :class="select_class" @change="handleCountryInput('nationality')" v-model="form.passenger_nationality">
                                    <option selected :value="null" >----</option>
                                    <option v-for="country in countries" :value="country.name">{{ country.name }}</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.passenger_nationality"/>
                            </div>
                            </div>
                            <div class="row natoinality_row">
                                <div class="col-md-6 col-12 mt-4 spacinf_rigght">
                                <!-- <InputLabel class="text-blue" for="email" value="Email" /> -->
                                <span class="label text-label">Country To Immigrate <span data-v-ef3b84b0="" style="color: red;"> *</span></span>

                                <select class="form-select select_option mt-2" :class="migrate" @change="handleCountryInput('migrate')" v-model="form.migrate_country">
                                    <option selected :value="null" >----</option>
                                    <option v-for="country in countries" :value="country.name">{{ country.name }}</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.migrate_country"/>
                            </div>
                            <div class="col-md-6 col-12 mt-4">
                                <!-- <InputLabel class="text-blue" for="email" value="Email" /> -->
                                <span class="label text-label">Port of arrival <span data-v-ef3b84b0="" style="color: red;"> *</span></span>

                                <TextInput  type="text" placeholder="Enter Port of arrival" class="form-control mt-2" v-model="form.port_of_arrival"/>
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
}

input[type='radio']:checked{
    background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e");
}


</style>