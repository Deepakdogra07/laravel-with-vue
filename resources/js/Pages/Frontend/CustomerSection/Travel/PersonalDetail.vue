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
import { ref } from 'vue';
import { Country } from 'country-state-city';


const props = defineProps({
    variable:{
        type:Object
    },
    errors:{
        type:Object,
        default:null
    }

})
const countries = Country.getAllCountries(),
image_src = ref('');
const form =useForm({
    job_id:props.variable.job_id,
    date_of_travel:props.variable.date_of_travel,
    passenger_nationality:props.variable.passenger_nationality,
    port_of_arrival:props.variable.port_of_arrival,
    purpose_of_stay:props.variable.purpose_of_stay,
    type_of_visa:props.variable.type_of_visa,
    customer_image : null,
    first_name:null,
    last_name:null,
    email:null,
    confirm_email:null,
    date_of_birth:null,
    country_of_birth:null,
    city_of_birth:null,
    gender:null,
    marital_status:null,
    passport_number:null,
    issuing_authority:null,
    passport_date_of_expiry:null,
    citizen_of_more_than_one:null,
    visa_available:null,
});

function upload_image(event){
    form.customer_image = event.target.files[0];
    image_src.value = URL.createObjectURL(event.target.files[0]);
}

const submitData = () => {
    form.post(route('submit_personal_details',form.job_id),
    {
      onSuccess: () => {
        toast("Details Saved Successfully!", {
          autoClose: 2000,
          theme: 'dark',
        }
        );
      },
    });
};


const select_class =ref({
    territory_birth:'',
    marital_status:'',
});

function handleChange(type){
    if(type =="territory_birth"){
        select_class.value.territory_birth = 'Selected_option';
    }
    if(type =="marital_status"){
        select_class.value.marital_status = 'Selected_option';
    }
}

</script>
 
<template>
    <Header />
    <SubHeading :job_id="form.job_id"/>
    <div class="login-bg-wrapper travel-section s">
        <div class="container">
            <form @submit.prevent="submitData()">
            <div class="row">
                <div class="col-lg-7 col-12">
                    <div class="file-inputs mt-3 relative">
                        <div class="dotted-bg">
                            <img :src="image_src" alt="" srcset="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"
                                fill="none">
                                <path
                                    d="M54.0774 47.7783L54.0771 47.7778L43.0478 32.5166C43.047 32.5155 43.0463 32.5145 43.0455 32.5134C41.5448 30.4238 38.4396 30.4235 36.9386 32.5128C36.9377 32.5141 36.9368 32.5153 36.9359 32.5166L25.9066 47.7778L25.9062 47.7783C24.1017 50.2769 25.8784 53.7609 28.9661 53.7609H32.6383V67.1046H15.4721C8.09988 66.6655 2 59.6549 2 51.908C2 46.6514 4.84793 42.0611 9.08693 39.5752L10.5322 38.7276L9.951 37.1562C9.59374 36.1903 9.40499 35.1506 9.40499 34.0412C9.40499 29.0159 13.4626 24.9583 18.4879 24.9583C19.5794 24.9583 20.6192 25.1465 21.5866 25.5043L23.3067 26.1405L24.0892 24.4818C27.3185 17.6362 34.28 12.8951 42.3688 12.8945C52.8366 12.9101 61.4659 20.9279 62.4473 31.143L62.5934 32.664L64.0993 32.9228C71.9373 34.2702 78 41.5883 78 49.9301C78 58.8106 71.0858 66.4598 62.4369 67.1046H47.3453V53.7609H51.0176C54.0719 53.7609 55.8919 50.2907 54.0774 47.7783Z"
                                    stroke="#01796F" stroke-width="4"></path>
                            </svg>
                            <h2 class="choose-para">Upload Passport And Prefill Information</h2>
                            <p class="file-type">Max size 20MB</p>
                            <input class="upload" type="file" @change="upload_image($event)"id="banner" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-6 col-12">
                    <div class="container-fluid form-division-right">
                        <div class="row px-0">
                            <h2 class="mb-3">Personal Details</h2>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <span class="label text-label">Given Name (s) <span data-v-ef3b84b0="" style="color: red;"> *</span></span>
                                    <TextInput placeholder="---" v-model="form.first_name" type="text" class="form-control mt-2" />
                                    <InputError class="mt-2" v-if="props.errors.first_name" :message="props.errors.first_name[0]"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <span class="label text-label">Surname / family name <span data-v-ef3b84b0="" style="color: red;"> *</span></span>
    
                                    <TextInput placeholder="---" v-model="form.last_name" type="text" class="form-control mt-2" />
                                    <InputError class="mt-2" v-if="props.errors.last_name" :message="props.errors.last_name[0]"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <span class="label text-label">E-mail address <span data-v-ef3b84b0="" style="color: red;"> *</span></span>
    
                                    <TextInput placeholder="---" type="email" v-model="form.email"class="form-control mt-2" />
                                    <InputError class="mt-2" v-if="props.errors.email" :message="props.errors.email[0]" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <span class="label text-label">Confirm E-mail <span data-v-ef3b84b0="" style="color: red;"> *</span></span>
    
                                    <TextInput placeholder="---" v-model="form.confirm_email"type="email" class="form-control mt-2" />
                                    <InputError class="mt-2" v-if="props.errors.confirm_email" :message="props.errors.confirm_email[0]"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <span class="label text-label">Date of birth <span data-v-ef3b84b0="" style="color: red;"> *</span></span>
    
                                    <TextInput placeholder="---"v-model="form.date_of_birth" type="date" class="form-control mt-2" />
                                    <InputError class="mt-2" v-if="props.errors.date_of_birth" :message="props.errors.date_of_birth[0]"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <span class="label text-label">Country/territory birth</span>
    
                                    <select class="form-select mt-2  Selected_option" :class="select_class?.territory_birth" @change="handleChange('territory_birth')" v-model="form.country_of_birth">
                                        <option selected :value="null">----</option>
                                        <option selected v-for="country in countries" :value="country.name" v-html="country.name"></option>
                                        <!-- <option>Hello</option> -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <span class="label text-label">City of birth <span data-v-ef3b84b0="" style="color: red;"> *</span></span>
                                    <TextInput placeholder="---" v-model="form.city_of_birth" type="text" class="form-control mt-2" />
                                    <InputError class="mt-2" v-if="props.errors.city_of_birth" :message="props.errors.city_of_birth[0]"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <span class="label text-label">Marital status</span>
    
                                    <select class="form-select mt-2 Selected_option" :class="select_class?.marital_status" @change="handleChange('marital_status')" v-model="form.marital_status">
                                        <option selected :value="null">----</option>
                                        <option value="0">Married</option>
                                        <option value="1">Unmarried</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-4">
                                    <span class="label text-label">Gender</span>
                                    <div class="d-flex gap-4 mt-2">
                                        <div class="form-check new-radio-btns">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault1"
                                                id="flexRadioDefault1" v-model="form.gender" value="1">
                                            <label class="form-check-label font-normal" for="flexRadioDefault1">
                                                Male
                                            </label>
                                        </div>
                                        <div class="form-check new-radio-btns">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault1"
                                                id="flexRadioDefault2" v-model="form.gender" value="1">
                                            <label class="form-check-label font-normal" for="flexRadioDefault2">
                                                Female
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="container-fluid form-division-left">
                        <div class="row px-0">
                            <h2 class="mb-3">Passport Details</h2>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <span class="label text-label">Passport Number <span data-v-ef3b84b0="" style="color: red;"> *</span></span>

                                    <TextInput placeholder="---" v-model="form.passport_number" type="text" class="form-control mt-2" />
                                    <InputError class="mt-2" v-if="props.errors.passport_number" :message="props.errors.passport_number[0]" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <span class="label text-label">Issuing Authority <span data-v-ef3b84b0="" style="color: red;"> *</span></span>

                                    <TextInput placeholder="---" v-model="form.issuing_authority" type="text" class="form-control mt-2" />
                                    <InputError class="mt-2" v-if="props.errors.issuing_authority" :message="props.errors.issuing_authority[0]" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-4">
                                    <span class="label text-label">Passport Date Of Expiry</span>

                                    <TextInput placeholder="---"v-model="form.passport_date_of_expiry"  type="date" class="form-control mt-2" />
                                    <InputError class="mt-2" v-if="props.errors.passport_date_of_expiry" :message="props.errors.passport_date_of_expiry[0]" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="d-flex gap-4 mt-2">
                                        <div class="form-check new-radio-btns">
                                            <input class="form-check-input" type="radio" value="1" v-model="form.citizen_of_more_than_one" name="flexRadioDefault2"
                                                id="flexRadioDefault1">
                                            <label class="form-check-label" for="flexRadioDefault1">
                                                I’m a citizen of more than one country
                                            </label>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <div class="mb-4">
                                    <span class="label">Have you ever obtained an visa using current or previous passport?</span>
                                    <div class="d-flex gap-4 mt-2">
                                        <div class="form-check new-radio-btns">
                                            <input class="form-check-input" type="radio" v-model="form.visa_available" value="1"  name="flexRadioDefault4"
                                                id="flexRadioDefault1">
                                            <label class="form-check-label font-normal" for="flexRadioDefault1">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check new-radio-btns">
                                            <input class="form-check-input" type="radio" v-model="form.visa_available" value="0" name="flexRadioDefault4"
                                                id="flexRadioDefault2" checked>
                                            <label class="form-check-label font-normal" for="flexRadioDefault2">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center login-btn-main">
                                <PrimaryButton class="forms-btn" type="submit">
                                    Continue <span> <i class="bi bi-arrow-right"></i></span>
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

            <div class="d-flex justify-between align-items-center">
                <div class="flex items-center mt-4 ">
                    <Link class="forms-btn-transparent step-form-back" href="/travel-details/2">
                        <span> <i class="bi bi-arrow-left"></i></span>  Back 
                    </Link>
                </div>
                <div class="flex items-center mt-4 login-btn-main">
                    <PrimaryButton class="forms-btn">
                        Next Step <span> <i class="bi bi-arrow-right"></i></span>
                    </PrimaryButton>
                </div>
            </div>
            
        </div>
    </div>
    <Footer />
</template>

<style scoped></style>