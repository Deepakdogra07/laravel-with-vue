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
import '@vuepic/vue-datepicker/dist/main.css'; 
import VueDatePicker from '@vuepic/vue-datepicker'; 
import { stringify } from 'postcss';

const today = new Date();
const eighteenYearsAgo = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
const format = (date) => {
  const day = date.getDate();
  const month = date.getMonth() + 1;
  const year = date.getFullYear();
   var month1 = (month <=9) ?`0${month}`:month;
   var day1 = (day <=9) ?`0${day}`:day;
   form.date_of_birth = `${year}-${month1}-${day1}`;
  return `${year}/${month1}/${day1}`;
}
const format1 = (date) => {
  const day = date.getDate();
  const month = date.getMonth() + 1;
  const year = date.getFullYear();
   var month1 = (month <=9) ?`0${month}`:month;
   var day1 = (day <=9) ?`0${day}`:day;
   form.date_of_expiry = `${year}-${month1}-${day1}`;
  return `${year}/${month1}/${day1}`;
}


const props = defineProps({
    variable:{
        type:Object
    },
    errors:{
        type:Object,
        default:null
    },
    already_customer:{
        type:Object
    },
     user_email:{
        type:String,
        default:null
    }

})
const countries = Country.getAllCountries(),
image_src = ref(''),
image_name = ref(''),
image_src1 = ref(''),
image_name1 = ref('');


const form =useForm({
    job_id:props.variable.job_id,
    date_of_travel:props.variable.date_of_travel,
    passenger_nationality:props.variable.passenger_nationality,
    port_of_arrival:props.variable.port_of_arrival,
    purpose_of_stay:props.variable.purpose_of_stay,
    type_of_visa:props.variable.type_of_visa,
    migrate_country:props.variable.migrate_country,
    customer_image : props?.already_customer?.customer_image ?? null,
    first_name:props?.already_customer?.first_name ?? null,
    last_name:props?.already_customer?.last_name ?? null,
    email:props?.already_customer?.email ?? props.user_email,
    confirm_email:props?.already_customer?.email ?? props.user_email,
    date_of_birth:props?.already_customer?.date_of_birth ?? eighteenYearsAgo,
    country_of_birth:props?.already_customer?.country_of_birth ?? null,
    city_of_birth:props?.already_customer?.city_of_birth ?? null,
    gender:props?.already_customer?.gender ?? null,
    martial_status:props?.already_customer?.martial_status ?? null,
    passport_number:props?.already_customer?.passport_number ?? null,
    passport_image:props?.already_customer?.passport_image ?? null,
    issuing_authority:props?.already_customer?.issuing_authority ?? null,
    date_of_expiry:props?.already_customer?.date_of_expiry ?? null,
    citizen_of_more_than_one:null,
    visa_available:props?.already_customer?.visa_available ?? null,
});
function upload_image(event){
    form.customer_image = event.target.files[0];
    image_src.value = URL.createObjectURL(event.target.files[0]);
    image_name.value = event.target.files[0].name;
    
}
function upload_image1(event){
    form.passport_image = event.target.files[0];
    image_src1.value = URL.createObjectURL(event.target.files[0]);
    image_name1.value = event.target.files[0].name;
    
}
if(form.customer_image){
    image_src.value = form.customer_image;
    image_name.value = form.customer_image;
}
if(form.passport_image){
    image_src1.value = form.passport_image;
    image_name1.value = form.passport_image;
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
    martial_status:'',
});

function handleChange(type){
    if(type =="territory_birth"){
        select_class.value.territory_birth = 'Selected_option';
    }
    if(type =="marital_status"){
        select_class.value.martial_status = 'Selected_option';
    }
}


function removeImage(){
    form.customer_image = null;
    image_name.value ='';
    image_src.value ='';
}
function removeImage1(){
    form.passport_image = null;
    image_name1.value ='';
    image_src1.value ='';
}
</script>
 
<template>
    <Header />
    <SubHeading :job_id="form.job_id"/>
    <div class="login-bg-wrapper travel-section">
        <div class="container travel_width">
            <form @submit.prevent="submitData()">
            <div class="row">
                <div class="col-lg-6 col-12 personal_column">
                    <div v-if="image_src" width="250px" class="close_image_wrapper">
                        <div class="d-flex align-items-start all_image_close"><p class="btn btn-sm btn-danger justify-content-end close_mark"  @click="removeImage()"><i class="fas fa-times"></i></p>
                        <img :src="image_src" alt="" srcset=""width="200px" height="200px" ></div>
                        <p class="mt-2 close_image_name">{{ image_name }}</p>
                    </div>
                    <div v-else class="file-inputs mt-3 relative">
                        <div class="dotted-bg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"
                                fill="none">
                                <path
                                    d="M54.0774 47.7783L54.0771 47.7778L43.0478 32.5166C43.047 32.5155 43.0463 32.5145 43.0455 32.5134C41.5448 30.4238 38.4396 30.4235 36.9386 32.5128C36.9377 32.5141 36.9368 32.5153 36.9359 32.5166L25.9066 47.7778L25.9062 47.7783C24.1017 50.2769 25.8784 53.7609 28.9661 53.7609H32.6383V67.1046H15.4721C8.09988 66.6655 2 59.6549 2 51.908C2 46.6514 4.84793 42.0611 9.08693 39.5752L10.5322 38.7276L9.951 37.1562C9.59374 36.1903 9.40499 35.1506 9.40499 34.0412C9.40499 29.0159 13.4626 24.9583 18.4879 24.9583C19.5794 24.9583 20.6192 25.1465 21.5866 25.5043L23.3067 26.1405L24.0892 24.4818C27.3185 17.6362 34.28 12.8951 42.3688 12.8945C52.8366 12.9101 61.4659 20.9279 62.4473 31.143L62.5934 32.664L64.0993 32.9228C71.9373 34.2702 78 41.5883 78 49.9301C78 58.8106 71.0858 66.4598 62.4369 67.1046H47.3453V53.7609H51.0176C54.0719 53.7609 55.8919 50.2907 54.0774 47.7783Z"
                                    stroke="#01796F" stroke-width="4"></path>
                            </svg>
                            <h2 class="choose-para">Upload Customer Image </h2>
                            <p class="file-type ">Max size 20MB</p>
                            <input class="upload" type="file" @change="upload_image($event)"id="banner" accept="image/*" >
                            
                            
                        </div>
                    </div>
                    <InputError  class="mt-2" v-if="form.errors.customer_image" :message="form.errors.customer_image[0]"/>
                </div>
                <div class="col-lg-6 col-12 Pass_column_upload">
                    <div v-if="image_src1" width="250px" class="close_image_wrapper">
                        <div class="d-flex align-items-start all_image_close"><p class="btn btn-sm btn-danger justify-content-end close_mark"  @click="removeImage1()"><i class="fas fa-times"></i></p>
                        <img :src="image_src1" alt="" srcset=""width="200px" height="200px" ></div>
                        <p class="mt-2 close_image_name">{{ image_name1 }}</p>
                    </div>
                    <div v-else class="file-inputs mt-3 relative">
                        <div class="dotted-bg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"
                                fill="none">
                                <path
                                    d="M54.0774 47.7783L54.0771 47.7778L43.0478 32.5166C43.047 32.5155 43.0463 32.5145 43.0455 32.5134C41.5448 30.4238 38.4396 30.4235 36.9386 32.5128C36.9377 32.5141 36.9368 32.5153 36.9359 32.5166L25.9066 47.7778L25.9062 47.7783C24.1017 50.2769 25.8784 53.7609 28.9661 53.7609H32.6383V67.1046H15.4721C8.09988 66.6655 2 59.6549 2 51.908C2 46.6514 4.84793 42.0611 9.08693 39.5752L10.5322 38.7276L9.951 37.1562C9.59374 36.1903 9.40499 35.1506 9.40499 34.0412C9.40499 29.0159 13.4626 24.9583 18.4879 24.9583C19.5794 24.9583 20.6192 25.1465 21.5866 25.5043L23.3067 26.1405L24.0892 24.4818C27.3185 17.6362 34.28 12.8951 42.3688 12.8945C52.8366 12.9101 61.4659 20.9279 62.4473 31.143L62.5934 32.664L64.0993 32.9228C71.9373 34.2702 78 41.5883 78 49.9301C78 58.8106 71.0858 66.4598 62.4369 67.1046H47.3453V53.7609H51.0176C54.0719 53.7609 55.8919 50.2907 54.0774 47.7783Z"
                                    stroke="#01796F" stroke-width="4"></path>
                            </svg>
                            <h2 class="choose-para">Upload Passport and Prefill information </h2>
                            <p class="file-type ">Max size 20MB</p>
                            <input class="upload" type="file" @change="upload_image1($event)"id="banner" accept="image/*" >
                            
                            
                        </div>
                    </div>
                    <InputError  class="mt-2" v-if="form.errors.passport_image" :message="form.errors.passport_image[0]"/>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-6 col-12 personal_column">
                    <div class="container-fluid form-division-right">
                        <div class="row px-0 justify-content-between">
                            <h2 class="mb-4">Personal Details</h2>
                            <div class="col-md-6 column_spacing">
                                <div class="mb-4 margin_btm">
                                    <span class="label text-label">Given Name (s) <span data-v-ef3b84b0="" style="color: red;"> *</span></span>
                                    <TextInput placeholder="---" v-model="form.first_name" type="text" class="form-control mt-2" />
                                    <InputError class="mt-2" v-if="form.errors.first_name" :message="props.errors.first_name[0]"/>
                                </div>
                            </div>
                            <div class="col-md-6 column_spacing">
                                <div class="mb-4 margin_btm">
                                    <span class="label text-label">Surname / family name <span data-v-ef3b84b0="" style="color: red;"> *</span></span>
    
                                    <TextInput placeholder="---" v-model="form.last_name" type="text" class="form-control mt-2" />
                                    <InputError class="mt-2" v-if="form.errors.last_name" :message="props.errors.last_name[0]"/>
                                </div>
                            </div>
                            <div class="col-md-6 column_spacing">
                                <div class="mb-4 margin_btm">
                                    <span class="label text-label">E-mail address <span data-v-ef3b84b0="" style="color: red;"> *</span></span>
                                    
                                    <div class="email_icons">
                                        <div class="email_icon">
                                            <TextInput placeholder="---" type="text" v-model="form.email"class="form-control mt-2" /> 
                                            <span class="icon_mail"><i class="far fa-envelope"></i></span>
                                        </div>
                                        <InputError class="mt-2" v-if="form.errors.email" :message="props.errors.email[0]" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 column_spacing">
                                <div class="mb-4 margin_btm">
                                    <span class="label text-label">Confirm E-mail <span data-v-ef3b84b0="" style="color: red;"> *</span></span>
    
                                    <div class="email_icons">
                                        <div class="email_icon">
                                            <TextInput placeholder="---" v-model="form.confirm_email"type="text" class="form-control mt-2" />
                                            <span class="icon_mail"><i class="far fa-envelope"></i></span>
                                        </div>
                                        <InputError class="mt-2" v-if="form.errors.confirm_email" :message="props.errors.confirm_email[0]"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 column_spacing calender_wrappers calender_">
                                <div class="mb-4 margin_btm">
                                    <span class="label text-label">Date of birth <span data-v-ef3b84b0="" style="color: red;"> *</span></span>
                                     <VueDatePicker v-model="form.date_of_birth" placeholder="Select date of birth" class="form-control mt-2 " v-bind:clearable="false" :format="format" :max-date="eighteenYearsAgo" :initial-date="eighteenYearsAgo" />
                                    <InputError class="mt-2" v-if="form.errors.date_of_birth" :message="props.errors.date_of_birth[0]"/>
                                </div>
                            </div>
                            <div class="col-md-6 column_spacing">
                                <div class="mb-4 margin_btm">
                                    <span class="label text-label">Country/territory birth</span>
    
                                    <select class="form-select mt-2  Selected_option" :class="select_class?.territory_birth" @change="handleChange('territory_birth')" v-model="form.country_of_birth">
                                        <option selected :value="null">----</option>
                                        <option selected v-for="country in countries" :value="country.name" v-html="country.name"></option>
                                        <!-- <option>Hello</option> -->
                                    </select>
                                    <InputError class="mt-2" v-if="form.errors.country_of_birth" :message="props.errors.country_of_birth[0]"/>
                                </div>
                            </div>
                            <div class="col-md-6 column_spacing">
                                <div class="mb-4 margin_btm">
                                    <span class="label text-label">City of birth <span data-v-ef3b84b0="" style="color: red;"> *</span></span>
                                    <TextInput placeholder="---" v-model="form.city_of_birth" type="text" class="form-control mt-2" />
                                    <InputError class="mt-2" v-if="form.errors.city_of_birth" :message="props.errors.city_of_birth[0]"/>
                                </div>
                            </div>
                            <div class="col-md-6 column_spacing">
                                <div class="mb-4 margin_btm">
                                    <span class="label text-label">Marital status</span>
    
                                    <select class="form-select mt-2 Selected_option" :class="select_class?.martial_status" @change="handleChange('marital_status')" v-model="form.martial_status">
                                        <option selected :value="null">----</option>
                                        <option value="0">Married</option>
                                        <option value="1">Unmarried</option>
                                    </select>
                                    <InputError class="mt-2" v-if="form.errors.martial_status" :message="props.errors.martial_status[0]"/>
                                </div>
                            </div>
                            <div class="col-md-12 column_spacing">
                                <div class="mb-4 margin_btm">
                                    <span class="label text-label">Gender</span>
                                    <div class="d-flex gap-4 mt-2">
                                        <div class="form-check new-radio-btns">
                                            <input class="form-check-input" type="radio" name="flexRadioDefault1"
                                                id="flexRadioDefault1" v-model="form.gender" value="0">
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
                                    <InputError class="mt-2" v-if="form.errors.gender" :message="props.errors.gender[0]"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 col-12 Pass_column">
                    <div class="container-fluid form-division-left">

                        <div class="row px-0">
                            <h2 class="mb-4">Passport Details</h2>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <span class="label text-label">Passport Number <span data-v-ef3b84b0="" style="color: red;"> *</span></span>
                                        <!-- v-model="form.passport_number"  -->
                                        <TextInput placeholder="---"v-model="form.passport_number" type="text"class="form-control mt-2"  />
                                        <InputError class="mt-2" v-if="form.errors.passport_number" :message="props.errors.passport_number[0]" />
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <span class="label text-label">Issuing Authority <span data-v-ef3b84b0="" style="color: red;"> *</span></span>
                                        <!-- v-model="form.issuing_authority" -->
                                        <TextInput placeholder="---"v-model="form.issuing_authority" type="text"  class="form-control mt-2" />
                                        <InputError class="mt-2" v-if="form.errors.issuing_authority" :message="props.errors.issuing_authority[0]" />
                                    </div>
                                </div>
                                <div class="col-md-12 calender_wrapper">
                                    <div class="mb-4">
                                        <span class="label text-label">Passport Date Of Expiry</span>
                                        <!-- v-model="form.date_of_expiry" -->
                                        <!-- <TextInput placeholder="---"v-model="form.date_of_expiry"  type="date" class="form-control mt-2" /> -->
                                        <VueDatePicker v-model="form.date_of_expiry"  placeholder="Select date of expiry" class="form-control mt-2  " :format="format1" :min-date="today"   :type="'date'" />
                                        <InputError class="mt-2" v-if="form.errors.date_of_expiry" :message="props.errors.date_of_expiry[0]" />
                                    </div>
                                </div>
                            <div class="col-md-12">
                                <div class="d-flex gap-4 mt-2">
                                        <div class="form-check new-radio-btns">
                                            <input class="form-check-input" type="checkbox" value="1" v-model="form.citizen_of_more_than_one" name="flexRadioDefault2"
                                                id="citixen" >
                                            <label class="form-check-label" for="citixen">
                                                I’m a citizen of more than one country
                                            </label>
                                        </div>
                                    </div>
                            </div>

                            <div class="col-md-12 mt-4">
                                <div class="mb-4 margin_btm">

                                    <span class="label">Have you ever obtained an visa using current or previous passport?</span>
                                    <div class="d-flex gap-4 mt-2">
                                        <div class="form-check new-radio-btns">
                                            <input class="form-check-input" type="radio" v-model="form.visa_available" value="1"  name="flexRadioDefault4"
                                                id="flexRadioDe">
                                            <label class="form-check-label font-normal" for="flexRadioDe">
                                                Yes
                                            </label>
                                        </div>
                                        <div class="form-check new-radio-btns">
                                            <input class="form-check-input" type="radio" v-model="form.visa_available" value="0" name="flexRadioDefault4"
                                                id="flexRadioDe2" checked>
                                            <label class="form-check-label font-normal" for="flexRadioDe2">
                                                No
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="flex items-center login-btn-main">
                                <PrimaryButton class="forms-btn" type="submit" :disabled="form.processing">
                                    Continue <span> <i class="bi bi-arrow-right"></i></span>
                                </PrimaryButton>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-between align-items-start mx-2 back_button_wrapss">
                <div class="flex items-center mt-4 ">
                    <p class="mb-0" style="display:inline-block;"><Link class="forms-btn-transparent step-form-back forms-btn-transparent mb-4" href="/travel-details/2">
                        <span> <i class="bi bi-arrow-left"></i></span>  Back 
                    </Link></p>
                </div>
             <div class="flex items-center mt-4 login-btn-main">
                <PrimaryButton  class="forms-btn"  v-if="form.processing" :disabled="form.processing">
                    Submitting....
                    <img src="/images/loader.gif" style="width:20px; height:20px;">
                </PrimaryButton>
                <PrimaryButton class="forms-btn"type="submit" v-else>
                    Next Step <span> <i class="bi bi-arrow-right"></i></span>
                </PrimaryButton>
                </div>
            </div>
        </form>

            
        </div>
    </div>
    <Footer />
</template>

<style scoped>


</style>
