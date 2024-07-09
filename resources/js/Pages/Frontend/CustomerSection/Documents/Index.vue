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
import { reactive, ref } from 'vue';
import { Country } from 'country-state-city';

const props = defineProps({
    job_id: {
        type: Number,
        required: true,
        default: 0
    },
    customer_id: {
        type: Number,
        required: true,
        default: 0
    },
    errors:{
        type:Object
    }
});
const countries = Country.getAllCountries()



const form = useForm({
    job_id: props.job_id,
    customer_id: props.customer_id,
    employment_evidence: null,
    licences: null,
    kitchen_area: null,
    ingredients: null,
    cooking_tech: null,
    dish: null,
    clean_up: null,
    evidence_image: null,
    resume: null,
    is_australia: null,
    step:null
});
const div_numbers = ref(`step-form-1`),
    document = reactive({}),
    image_name = reactive({});

async function show_next_div(div_number) {
    if(div_number == 4 ){
        div_numbers.value = `step-form-${div_number+1}`;
    }else{
        form.step = div_number;
            try {
                    const response = await axios.post(route('validate_customer_documents'), form, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
            if(response ){
                if (response.data.success ) {
                    div_numbers.value = `step-form-${response.data.step}`;
                } else{
                    for (const key in response.data.error) {
                        if (Object.prototype.hasOwnProperty.call(response.data.error, key)) {
                            const errorMessageArray = response.data.error[key];
                            props.errors[key] = errorMessageArray[0]                       
                        }
                    }
                    div_numbers.value = `step-form-${response.data.step}`;
                }
                window.scrollTo(0,0);
            }
        } catch (error) {
            console.error('Error form validation:', error);
            div_numbers.value = `step-form-${div_number}`;
        }
    }
    
}
function previous_div(div_number) {     
    div_numbers.value = `step-form-${div_number - 1}`
}
function show_document(type, event) {
    form[type] = event.target.files[0];
    document[type] = URL.createObjectURL(event.target.files[0]);
}
function submit_form() {
    form.post(route('submit_customers_documents'), {
        onSuccess: () => {
            // toast("Job Applied Successfully!", {
            //     autoClose: 2000,
            //     theme: 'dark',
            // });
            // setTimeout(() => {
            window.location.href = route('processTransaction',props.customer_id);
        // }, 2000)
        }
    })
    // axios.post(route('submit_customers_documents'),form)
    // .then(response => {
    //     toast("Job Applied Successfully!", {
    //         autoClose: 2000,
    //         theme: 'dark',
    //     });
        
    //     // Wait for the toast to close before redirecting
    //     // setTimeout(() => {
    //     //     window.location.href = response.data.redirect_url;
    //     // }, 2000); // 2000 milliseconds = 2 seconds
    // }).catch(error => {
    //     console.error('There was an error!', error);
    // });
}
// function validateForm(formData){
// console.log(formData,'formDataformData');
// }

function removeImage(type){
    // alert(type)
    form[type] = null;
    document[type] = null;
    image_name[type] = null;
}


</script>
<template>
    <Header />
    <SubHeading />
    <form @submit.prevent="submit_form()">
        <!------step one----->
        <div class="login-bg-wrapper steps_form document-first-form step-form-1 application_guide" v-if="div_numbers == 'step-form-1'">
            <div class="container width_content">
                <div class="employment-first-form">
                    <p class="light-text">The following documents can be submitted as supporting evidence of your
                        skills, knowledge and experience, in addition to the mandatory employment documents:</p>
                    <h2>1. Supporting employment evidence:</h2>
                    <div class="row mt-4">
                        <div class="col-md-6 col-12 checkbox_icon employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">Employment contract listing your job title, salary and other
                                    information
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text"> Position description outlining duties performed</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">Offer, appointment and/or relieving letters.</p>
                            </div>
                        </div>

                        <div class="col-12">
                            <div v-if="document.employment_evidence" class="mt-3 relative">
                                <div class="d-flex align-items-start all_image_close"><p class="btn btn-sm btn-danger justify-content-end close_mark" style="float:right;" @click="removeImage('employment_evidence')"><i class="fas fa-times"></i></p>
                                <img :src="document.employment_evidence" alt="" srcset="" width="250px"></div>
                                <p class="close_image_name">{{ image_name.employment_evidence }}</p>
                            </div>
                            <div v-else class="file-inputs mt-3 relative">
                                <div class="dotted-bg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"
                                        fill="none">
                                        <path
                                            d="M54.0774 47.7783L54.0771 47.7778L43.0478 32.5166C43.047 32.5155 43.0463 32.5145 43.0455 32.5134C41.5448 30.4238 38.4396 30.4235 36.9386 32.5128C36.9377 32.5141 36.9368 32.5153 36.9359 32.5166L25.9066 47.7778L25.9062 47.7783C24.1017 50.2769 25.8784 53.7609 28.9661 53.7609H32.6383V67.1046H15.4721C8.09988 66.6655 2 59.6549 2 51.908C2 46.6514 4.84793 42.0611 9.08693 39.5752L10.5322 38.7276L9.951 37.1562C9.59374 36.1903 9.40499 35.1506 9.40499 34.0412C9.40499 29.0159 13.4626 24.9583 18.4879 24.9583C19.5794 24.9583 20.6192 25.1465 21.5866 25.5043L23.3067 26.1405L24.0892 24.4818C27.3185 17.6362 34.28 12.8951 42.3688 12.8945C52.8366 12.9101 61.4659 20.9279 62.4473 31.143L62.5934 32.664L64.0993 32.9228C71.9373 34.2702 78 41.5883 78 49.9301C78 58.8106 71.0858 66.4598 62.4369 67.1046H47.3453V53.7609H51.0176C54.0719 53.7609 55.8919 50.2907 54.0774 47.7783Z"
                                            stroke="#01796F" stroke-width="4"></path>
                                    </svg>
                                    <h2 class="choose-para">Upload Document Or Scan Document </h2>
                                    <p class="file-type">Max size 20MB</p>
                                    <input class="upload" type="file" id="banner"
                                        @change="show_document('employment_evidence', $event)">

                                </div>

                            </div>
                            <InputError class="mt-2" :message="props.errors.employment_evidence" />
                        </div>
                        <div class="d-flex justify-between align-items-start p-0">
                            <div class="flex align-items-start mt-4 ">
                                <PrimaryButton class="forms-btn-transparent step-form-back">
                                    <span> <i class="bi bi-arrow-left"></i></span> Back
                                </PrimaryButton>
                            </div>
                            <div class="flex align-items-start mt-4" style="cursor:pointer;">
                                <p class="forms-btn" @click="show_next_div(1)">
                                    Next Step <span> <i class="bi bi-arrow-right"></i></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!------step two----->
        <div class="login-bg-wrapper steps_form document-first-form step-form-2 application_guide" v-if="div_numbers == 'step-form-2'">
            <div class="container width_content">
                <div class="employment-first-form">
                    <p class="light-text">The following documents can be submitted as supporting evidence of your
                        skills, knowledge and experience, in addition to the mandatory employment documents:</p>
                    <h2>2. Licences:</h2>
                    <div class="row mt-4">
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">You should submit evidence of any licences you hold that are
                                    related to your trade.
                                </p>
                            </div>
                        </div>

                        <div class="col-12 employ_padding">
                            <div v-if="document.licences" class="mt-3 relative">
                                <div class="d-flex align-items-start all_image_close"><p class="btn btn-sm btn-danger justify-content-end close_mark" style="float:right;" @click="removeImage('licences')"><i class="fas fa-times"></i></p>
                                    <img :src="document.licences" alt="" srcset="" width="250px"></div>
                                    <p class="close_image_name">{{ image_name.licences }}</p>
                                </div>
                            <div v-else class="file-inputs mt-3 relative">
                                <div class="dotted-bg">
                                    <img :src="document.licences" alt="" srcset="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"
                                        fill="none">
                                        <path
                                            d="M54.0774 47.7783L54.0771 47.7778L43.0478 32.5166C43.047 32.5155 43.0463 32.5145 43.0455 32.5134C41.5448 30.4238 38.4396 30.4235 36.9386 32.5128C36.9377 32.5141 36.9368 32.5153 36.9359 32.5166L25.9066 47.7778L25.9062 47.7783C24.1017 50.2769 25.8784 53.7609 28.9661 53.7609H32.6383V67.1046H15.4721C8.09988 66.6655 2 59.6549 2 51.908C2 46.6514 4.84793 42.0611 9.08693 39.5752L10.5322 38.7276L9.951 37.1562C9.59374 36.1903 9.40499 35.1506 9.40499 34.0412C9.40499 29.0159 13.4626 24.9583 18.4879 24.9583C19.5794 24.9583 20.6192 25.1465 21.5866 25.5043L23.3067 26.1405L24.0892 24.4818C27.3185 17.6362 34.28 12.8951 42.3688 12.8945C52.8366 12.9101 61.4659 20.9279 62.4473 31.143L62.5934 32.664L64.0993 32.9228C71.9373 34.2702 78 41.5883 78 49.9301C78 58.8106 71.0858 66.4598 62.4369 67.1046H47.3453V53.7609H51.0176C54.0719 53.7609 55.8919 50.2907 54.0774 47.7783Z"
                                            stroke="#01796F" stroke-width="4"></path>
                                    </svg>
                                    <h2 class="choose-para">Upload Document Or Scan Document </h2>
                                    <p class="file-type">Max size 20MB</p>
                                    <input class="upload" type="file" id="banner"
                                        @change="show_document('licences', $event)">

                                    </div>
                                </div>
                                <InputError class="mt-2" :message="props.errors.licences" />

                        </div>
                        <div class="d-flex justify-between align-items-start p-0">
                            <div class="flex items-start mt-4 ">
                                <PrimaryButton class="forms-btn-transparent step-form-back" @click="previous_div(2)">
                                    <span> <i class="bi bi-arrow-left"></i></span> Back
                                </PrimaryButton>
                            </div>
                            <div class="flex items-start mt-4" style="cursor:pointer;">
                                <p class="forms-btn" @click="show_next_div(2)">
                                    Next Step <span> <i class="bi bi-arrow-right"></i></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!------step three----->
        <div class="login-bg-wrapper steps_form document-first-form step-form-3 application_guide" v-if="div_numbers == 'step-form-3'">
            <div class="container width_content">
                <div class="employment-first-form">
                    <h2>3. Photographs and videos</h2>
                    <p class="light-text mt-3">Photos and videos of you performing work tasks maybe provided if they:</p>
                    <div class="row mt-2">
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">clearly show it is you doing the work,not somebody else
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">include a description of what you are doingand why

                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">show that you are performing tasks in a safe working manner.
                                </p>
                            </div>
                        </div>

                        <!-- <div class="col-12 employ_padding">
                            <div v-if="document.is_australia" class="mt-3 relative">
                                <div class="d-flex align-items-start all_image_close"><p class="btn btn-sm btn-danger justify-content-end close_mark" style="float:right;" @click="removeImage('is_australia')"><i class="fas fa-times"></i></p>
                                    <img :src="document.is_australia" alt="" srcset="" width="250px"></div>
                                    <p class="close_image_name">{{ image_name.is_australia }}</p>
                                </div>
                            <div v-else class="file-inputs mt-3 relative">
                                <div class="dotted-bg">
                                    <img :src="document.is_australia" alt="" srcset="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"
                                        fill="none">
                                        <path
                                            d="M54.0774 47.7783L54.0771 47.7778L43.0478 32.5166C43.047 32.5155 43.0463 32.5145 43.0455 32.5134C41.5448 30.4238 38.4396 30.4235 36.9386 32.5128C36.9377 32.5141 36.9368 32.5153 36.9359 32.5166L25.9066 47.7778L25.9062 47.7783C24.1017 50.2769 25.8784 53.7609 28.9661 53.7609H32.6383V67.1046H15.4721C8.09988 66.6655 2 59.6549 2 51.908C2 46.6514 4.84793 42.0611 9.08693 39.5752L10.5322 38.7276L9.951 37.1562C9.59374 36.1903 9.40499 35.1506 9.40499 34.0412C9.40499 29.0159 13.4626 24.9583 18.4879 24.9583C19.5794 24.9583 20.6192 25.1465 21.5866 25.5043L23.3067 26.1405L24.0892 24.4818C27.3185 17.6362 34.28 12.8951 42.3688 12.8945C52.8366 12.9101 61.4659 20.9279 62.4473 31.143L62.5934 32.664L64.0993 32.9228C71.9373 34.2702 78 41.5883 78 49.9301C78 58.8106 71.0858 66.4598 62.4369 67.1046H47.3453V53.7609H51.0176C54.0719 53.7609 55.8919 50.2907 54.0774 47.7783Z"
                                            stroke="#01796F" stroke-width="4"></path>
                                    </svg>
                                    <h2 class="choose-para">Upload Document Or Scan Document </h2>
                                    <p class="file-type">Max size 20MB</p>
                                    <input class="upload" type="file" id="banner"
                                        @change="show_document('is_australia', $event)">

                                    </div>
                                </div>
                                <InputError class="mt-2" :message="props.errors.is_australia" />
                        </div> -->
                    </div>
                </div>
            </div>
            <Section class="determine_job step-form-3 mt-4">
            <div class="container width_content">
                <div class="inner_determine">
                    <h6>For example, below is a unit of competency taken from the qualification ‘MEM31519 Certificate
                        III in Engineering – Toolmaking Trade’.</h6>
                    <h2>3.1 Determine job requirements</h2>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 employ_padding">
                            <ul class="job_ul">
                                <li>1.1 Follow standard operating procedures (SOPs)</li>
                                <li>1.3 Use appropriate personal protective equipment (PPE) in accordance with SOPs</li>
                            </ul>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 employ_padding">
                            <ul class="job_ul">
                                <li>1.2 Comply with work health and safety (WHS) requirements at all times</li>
                                <li>1.4 Identify job requirements from specifications, sketches, job sheets or
                                    workinstructions</li>
                            </ul>
                        </div>
                    </div>
                    <h2>3.2 Perform precision measurement</h2>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 employ_padding">
                            <ul class="job_ul">
                                <li>2.1 Select appropriate precision equipment to achieve specified outcomes</li>
                                
                                <li>2.3 Use correct and appropriate measuring techniques for the measurement task </li>
                                <li>2.5 Interpret readings and measurements</li>
                            </ul>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 employ_padding">
                            <ul class="job_ul">
                                <li>2.2 Check the accuracy of the selected measuring equipment for where appropriate
                                </li>
                                <li>2.4 Take measurements to the finest graduation of instrument in an accurate manner
                                </li>
                              
                            </ul>
                        </div>
                    </div>
                    <h2>3.3 Maintain precision equipment</h2>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 employ_padding">
                            <ul class="job_ul">
                                <li>3.1 Set measuring equipment to specifications using manufacturer guidelines or
                                    procedures and techniques</li>
                                    <li>3.3 Store equipment to manufacturer’s specifications or SOPs </li>
                            </ul>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 employ_padding">
                            <ul class="job_ul">
                                <li>3.2 Adjust and maintain measuring equipment to required accuracy using appropriate
                                    techniques according to manufacturer’s specifications or SOPs</li>
                               
                            </ul>
                        </div>
                    </div>
                    <h6>For this unit, our AI Engine would be looking for evidence that you can</h6>
                    <div class="row">
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">identify the requirements of the job from drawings or instructions
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">et up and adjust measuring equipment to required accuracy and
                                    specifications</p>
                            </div>
                        </div> 
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text"> use appropriate personal protective equipment and follow standard
                                    operating procedures</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text"> licences held.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </Section>
            <div class="button_end_grey">
                <div class="container container-width">
                    <div class="d-flex justify-between align-items-start p-0">
                        <div class="flex items-start mt-4">
                            <PrimaryButton class="forms-btn-transparent step-form-back" @click="previous_div(3)">
                                <span> <i class="bi bi-arrow-left"></i></span> Back
                            </PrimaryButton>
                        </div>
                        <div class="flex items-start mt-4" style="cursor:pointer;">
                            <p class="forms-btn" @click="show_next_div(4)">
                            Next Step <span> <i class="bi bi-arrow-right"></i></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Section class="determine_job step-form-4" v-if="div_numbers == 'step-form-4'">
            <div class="container width_content">
                <!------step five----->
                <div class="login-bg-wrapper steps_form document-first-form step-form-4 application_guide">
                    <div class="container p-0 width_content">
                        <div class="employment-first-form intro_steps intro_top">            
                            <div class="row mt-4">
                                <div class="d-flex justify-between align-items-start p-0">
                                    <div class="flex items-start mt-4 ">
                                        <PrimaryButton class="forms-btn-transparent step-form-back"
                                            @click="previous_div(4)">
                                            <span> <i class="bi bi-arrow-left"></i></span> Back
                                        </PrimaryButton>
                                    </div>
                                    <div class="flex items-start mt-4" style="cursor:pointer">
                                        <p class="forms-btn" @click="show_next_div(4)">
                                            Next Step <span> <i class="bi bi-arrow-right"></i></span>
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Section>

        <!------step five----->
        <div class="login-bg-wrapper steps_form document-first-form step-form-5 application_guide" v-if="div_numbers == 'step-form-5'">
            <div class="container">
                <div class="employment-first-form intro_steps intro_top">
                    <div class="intro_inner">
                        <h2>Introduction</h2>
                        <p class="light-text">When you provide evidence of your workplace skills for the Stage 1 Documentary
                            Evidence Assessment, you
                            must also provide Video and Photo evidence.</p>
                        <p class="light-text">This Guideline provides instructions about what types of skills to capture in
                            your video/photo evidence and how
                            to record them.</p>
                    </div>
                    <h2 class="margin_intro">Instructions for video evidence</h2>
                    <h5 class="take_over">Task overview</h5>
                    <p class="light-text">Prepare and present one (1) main dish consisting of:</p>
                    <div class="row mt-4">
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">a protein (e.g. meat, fish, tofu)
                                </p>
                            </div>
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">a sauce.
                                </p>
                            </div>
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">a side dish
                                </p>
                            </div>
                        </div>
                        <div class="col-12 employ_padding">
                            <p class="light-text">As you prepare your dish, film the following five (5) videos. Note the
                                skills you should demonstrate in each
                                video</p>
                            <h2 class="margin_intro">Video</h2>
                            <p class="light-text">Video Skills you should demonstrate in this video </p>
                        </div>
                        <div class="prepare_kitchen p-0">
                            <h2 class="margin_intro">1 - Prepare kitchen area</h2>
                            <div class="row">
                                <div class="col-md-6 col-12 employ_padding">
                                    <div class="d-flex gap-3">
                                        <i class="fa-solid fa-circle-check green-text"></i>
                                        <p class="light-text">Visually checking work areas and equipment are hygienic
                                            and safe to use
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 employ_padding">
                                    <div class="d-flex gap-3">
                                        <i class="fa-solid fa-circle-check green-text"></i>
                                        <p class="light-text">Selecting appropriate equipment based on recipe
                                            requirements
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 employ_padding">
                                    <div class="d-flex gap-3">
                                        <i class="fa-solid fa-circle-check green-text"></i>
                                        <p class="light-text">Assembling equipment according to manufacturer's
                                            instructions and checking it is in proper working order
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 employ_padding">
                                    <div class="d-flex gap-3">
                                        <i class="fa-solid fa-circle-check green-text"></i>
                                        <p class="light-text">Visually checking work areas and equipment are hygienic
                                            and safe to use
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-12 employ_padding">
                            <div v-if="document.kitchen_area" class="mt-3 relative">
                                <div class="d-flex align-items-start all_image_close">
                                    <!-- close_mark -->
                                    <p class="btn btn-sm btn-danger justify-content-end close_mark" style="float:right; z-index:1;" @click="removeImage('kitchen_area')"><i class="fas fa-times"></i></p>
                                    <video :src="document.kitchen_area" controls v-if="document.kitchen_area"></video></div>
                                    <p class="close_image_name">{{ image_name.kitchen_area }}</p>
                                </div>
                            <div v-else class="file-inputs mt-3 relative">
                                <div class="dotted-bg">
                                    
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"
                                        fill="none">
                                        <path
                                            d="M54.0774 47.7783L54.0771 47.7778L43.0478 32.5166C43.047 32.5155 43.0463 32.5145 43.0455 32.5134C41.5448 30.4238 38.4396 30.4235 36.9386 32.5128C36.9377 32.5141 36.9368 32.5153 36.9359 32.5166L25.9066 47.7778L25.9062 47.7783C24.1017 50.2769 25.8784 53.7609 28.9661 53.7609H32.6383V67.1046H15.4721C8.09988 66.6655 2 59.6549 2 51.908C2 46.6514 4.84793 42.0611 9.08693 39.5752L10.5322 38.7276L9.951 37.1562C9.59374 36.1903 9.40499 35.1506 9.40499 34.0412C9.40499 29.0159 13.4626 24.9583 18.4879 24.9583C19.5794 24.9583 20.6192 25.1465 21.5866 25.5043L23.3067 26.1405L24.0892 24.4818C27.3185 17.6362 34.28 12.8951 42.3688 12.8945C52.8366 12.9101 61.4659 20.9279 62.4473 31.143L62.5934 32.664L64.0993 32.9228C71.9373 34.2702 78 41.5883 78 49.9301C78 58.8106 71.0858 66.4598 62.4369 67.1046H47.3453V53.7609H51.0176C54.0719 53.7609 55.8919 50.2907 54.0774 47.7783Z"
                                            stroke="#01796F" stroke-width="4"></path>
                                    </svg>
                                    <h2 class="choose-para">Upload Video</h2>
                                    <p class="file-type">limit 100mb</p>
                                    <input class="upload" type="file" id="banner"
                                        @change="show_document('kitchen_area', $event)" accept="video/*">
                                </div>
                            </div>
                            <InputError class="mt-2" :message="props.errors.kitchen_area" />
                        </div>

                        <!------intro_two----->
                        <div class="employment-first-form intro_steps employ_padding ">
                            <h2>2 - Prepare ingredients</h2>
                            <div class="row mt-4">
                                <div class="col-md-6 col-12 employ_padding">
                                    <div class="d-flex gap-3">
                                        <i class="fa-solid fa-circle-check green-text"></i>
                                        <p class="light-text">Identifying and selecting ingredients based on recipe
                                            requirements
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 employ_padding">
                                    <div class="d-flex gap-3">
                                        <i class="fa-solid fa-circle-check green-text"></i>
                                        <p class="light-text">Visually checking ingredients for quality and freshness
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 employ_padding">
                                    <div class="d-flex gap-3">
                                        <i class="fa-solid fa-circle-check green-text"></i>
                                        <p class="light-text">Sorting ingredients in the order they will be used during
                                            food production
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 employ_padding">
                                    <div class="d-flex gap-3">
                                        <i class="fa-solid fa-circle-check green-text"></i>
                                        <p class="light-text">Using equipment (e.g. scales) to accurately measure and
                                            weigh ingredients
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 employ_padding">
                                    <div class="d-flex gap-3">
                                        <i class="fa-solid fa-circle-check green-text"></i>
                                        <p class="light-text">Cutting ingredients to the required size and shape,
                                            ensuring consistency and minimising waste.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-12 employ_padding">
                            <div v-if="document.ingredients" class="mt-3 relative">
                                <div class="d-flex align-items-start all_image_close"><p class="btn btn-sm btn-danger justify-content-end close_mark" style="float:right; z-index:1;" @click="removeImage('ingredients')"><i class="fas fa-times"></i></p>
                                    <video :src="document.ingredients" controls v-if="document.ingredients"></video></div>
                                    <p class="close_image_name">{{ image_name.ingredients }}</p>
                                </div>
                            <div v-else class="file-inputs mt-3 relative">
                                <div class="dotted-bg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"
                                        fill="none">
                                        <path
                                            d="M54.0774 47.7783L54.0771 47.7778L43.0478 32.5166C43.047 32.5155 43.0463 32.5145 43.0455 32.5134C41.5448 30.4238 38.4396 30.4235 36.9386 32.5128C36.9377 32.5141 36.9368 32.5153 36.9359 32.5166L25.9066 47.7778L25.9062 47.7783C24.1017 50.2769 25.8784 53.7609 28.9661 53.7609H32.6383V67.1046H15.4721C8.09988 66.6655 2 59.6549 2 51.908C2 46.6514 4.84793 42.0611 9.08693 39.5752L10.5322 38.7276L9.951 37.1562C9.59374 36.1903 9.40499 35.1506 9.40499 34.0412C9.40499 29.0159 13.4626 24.9583 18.4879 24.9583C19.5794 24.9583 20.6192 25.1465 21.5866 25.5043L23.3067 26.1405L24.0892 24.4818C27.3185 17.6362 34.28 12.8951 42.3688 12.8945C52.8366 12.9101 61.4659 20.9279 62.4473 31.143L62.5934 32.664L64.0993 32.9228C71.9373 34.2702 78 41.5883 78 49.9301C78 58.8106 71.0858 66.4598 62.4369 67.1046H47.3453V53.7609H51.0176C54.0719 53.7609 55.8919 50.2907 54.0774 47.7783Z"
                                            stroke="#01796F" stroke-width="4"></path>
                                    </svg>
                                    <h2 class="choose-para">Upload Video</h2>
                                    <p class="file-type">limit 100mb</p>
                                    <input class="upload" type="file" id="banner"
                                        @change="show_document('ingredients', $event)" accept="video/*">
                                </div>
                            </div>
                            <InputError class="mt-2" :message="props.errors.ingredients" />
                        </div>

                        <!------intro_three----->
                        <div class="employment-first-form intro_steps employ_padding">
                            <h2>3 - Demonstrate cooking techniques</h2>
                            <div class="row mt-4">
                                <div class="col-md-6 col-12 employ_padding">
                                    <div class="d-flex gap-3">
                                        <i class="fa-solid fa-circle-check green-text"></i>
                                        <p class="light-text">Using appropriate cooking methods to prepare the dish and
                                            relevant
                                            sides/sauces according to recipe requirements
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 employ_padding">
                                    <div class="d-flex gap-3">
                                        <i class="fa-solid fa-circle-check green-text"></i>
                                        <p class="light-text">Handling and operating food preparation equipment safely,
                                            according to
                                            manufacturer specifications
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 employ_padding">
                                    <div class="d-flex gap-3">
                                        <i class="fa-solid fa-circle-check green-text"></i>
                                        <p class="light-text">Reviewing the dish and making quality adjustments (e.g.
                                            taste and texture) where necessary
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-12 employ_padding">
                            <div v-if="document.cooking_tech" class="mt-3 relative">
                                <div class="d-flex align-items-start all_image_close"><p class="btn btn-sm btn-danger justify-content-end close_mark" style="float:right; z-index:1;" @click="removeImage('cooking_tech')"><i class="fas fa-times"></i></p>
                                <video :src="document.cooking_tech" controls v-if="document.cooking_tech"></video></div>
                                <p class="close_image_name">{{ image_name.cooking_tech }}</p>
                            </div>
                            <div v-else class="file-inputs mt-3 relative">
                                <div class="dotted-bg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"
                                        fill="none">
                                        <path
                                            d="M54.0774 47.7783L54.0771 47.7778L43.0478 32.5166C43.047 32.5155 43.0463 32.5145 43.0455 32.5134C41.5448 30.4238 38.4396 30.4235 36.9386 32.5128C36.9377 32.5141 36.9368 32.5153 36.9359 32.5166L25.9066 47.7778L25.9062 47.7783C24.1017 50.2769 25.8784 53.7609 28.9661 53.7609H32.6383V67.1046H15.4721C8.09988 66.6655 2 59.6549 2 51.908C2 46.6514 4.84793 42.0611 9.08693 39.5752L10.5322 38.7276L9.951 37.1562C9.59374 36.1903 9.40499 35.1506 9.40499 34.0412C9.40499 29.0159 13.4626 24.9583 18.4879 24.9583C19.5794 24.9583 20.6192 25.1465 21.5866 25.5043L23.3067 26.1405L24.0892 24.4818C27.3185 17.6362 34.28 12.8951 42.3688 12.8945C52.8366 12.9101 61.4659 20.9279 62.4473 31.143L62.5934 32.664L64.0993 32.9228C71.9373 34.2702 78 41.5883 78 49.9301C78 58.8106 71.0858 66.4598 62.4369 67.1046H47.3453V53.7609H51.0176C54.0719 53.7609 55.8919 50.2907 54.0774 47.7783Z"
                                            stroke="#01796F" stroke-width="4"></path>
                                    </svg>
                                    <h2 class="choose-para">Upload Video</h2>
                                    <p class="file-type">limit 100mb</p>
                                    <input class="upload" type="file" id="banner"
                                        @change="show_document('cooking_tech', $event)" accept="video/*">
                                </div>
                            </div>
                            <InputError class="mt-2" :message="props.errors.cooking_tech" />
                        </div>

                        <!------intro_four----->
                        <div class="employment-first-form intro_steps employ_padding">
                            <h2>4 - Present dish </h2>
                            <div class="row mt-4">
                                <div class="col-md-6 col-12 employ_padding">
                                    <div class="d-flex gap-3">
                                        <i class="fa-solid fa-circle-check green-text"></i>
                                        <p class="light-text">Using appropriate dishware and garnishes to enhance the
                                            visual appeal of the dish</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 employ_padding">
                                    <div class="d-flex gap-3">
                                        <i class="fa-solid fa-circle-check green-text"></i>
                                        <p class="light-text">Arranging the dish in a visually pleasing way, ensuring
                                            the plate is free of drips</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 employ_padding">
                                    <div class="d-flex gap-3">
                                        <i class="fa-solid fa-circle-check green-text"></i>
                                        <p class="light-text">Serving an appropriate portion size
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-12 employ_padding">
                            <div v-if="document.dish" class="mt-3 relative">
                                <div class="d-flex align-items-start all_image_close"><p class="btn btn-sm btn-danger justify-content-end close_mark" style="float:right; z-index:1;" @click="removeImage('dish')"><i class="fas fa-times"></i></p>
                                <video :src="document.dish" controls v-if="document.dish"></video></div>
                                <p class="close_image_name">{{ image_name.dish }}</p>
                            </div>
                            <div v-else class="file-inputs mt-3 relative">
                                <div class="dotted-bg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"
                                        fill="none">
                                        <path
                                            d="M54.0774 47.7783L54.0771 47.7778L43.0478 32.5166C43.047 32.5155 43.0463 32.5145 43.0455 32.5134C41.5448 30.4238 38.4396 30.4235 36.9386 32.5128C36.9377 32.5141 36.9368 32.5153 36.9359 32.5166L25.9066 47.7778L25.9062 47.7783C24.1017 50.2769 25.8784 53.7609 28.9661 53.7609H32.6383V67.1046H15.4721C8.09988 66.6655 2 59.6549 2 51.908C2 46.6514 4.84793 42.0611 9.08693 39.5752L10.5322 38.7276L9.951 37.1562C9.59374 36.1903 9.40499 35.1506 9.40499 34.0412C9.40499 29.0159 13.4626 24.9583 18.4879 24.9583C19.5794 24.9583 20.6192 25.1465 21.5866 25.5043L23.3067 26.1405L24.0892 24.4818C27.3185 17.6362 34.28 12.8951 42.3688 12.8945C52.8366 12.9101 61.4659 20.9279 62.4473 31.143L62.5934 32.664L64.0993 32.9228C71.9373 34.2702 78 41.5883 78 49.9301C78 58.8106 71.0858 66.4598 62.4369 67.1046H47.3453V53.7609H51.0176C54.0719 53.7609 55.8919 50.2907 54.0774 47.7783Z"
                                            stroke="#01796F" stroke-width="4"></path>
                                    </svg>
                                    <h2 class="choose-para">Upload Video</h2>
                                    <p class="file-type">limit 100mb</p>
                                    <input class="upload" type="file" id="banner"
                                        @change="show_document('dish', $event)" accept="video/*">
                                </div>
                            </div>
                            <InputError class="mt-2" :message="props.errors.dish" />
                        </div>

                        <!------intro_five----->
                        <div class="employment-first-form intro_steps employ_padding">
                            <h2>5 - Clean up</h2>
                            <div class="row mt-4">
                                <div class="col-md-6 col-12 employ_padding">
                                    <div class="d-flex gap-3">
                                        <i class="fa-solid fa-circle-check green-text"></i>
                                        <p class="light-text">Cleaning and sanitising the work area (including benches,
                                            appliances and equipment) </p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 employ_padding">
                                    <div class="d-flex gap-3">
                                        <i class="fa-solid fa-circle-check green-text"></i>
                                        <p class="light-text">Storing prepared food in appropriate containers</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 employ_padding">
                                    <div class="d-flex gap-3">
                                        <i class="fa-solid fa-circle-check green-text"></i>
                                        <p class="light-text">Labelling food containers with description and date of
                                            preparation
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-12 employ_padding">
                            <div v-if="document.clean_up" class="mt-3 relative">
                                <div class="d-flex align-items-start all_image_close"><p class="btn btn-sm btn-danger justify-content-end close_mark" style="float:right; z-index:1;" @click="removeImage('clean_up')"><i class="fas fa-times"></i></p>
                                <video :src="document.clean_up" controls v-if="document.clean_up"></video></div>
                                <p class="close_image_name">{{ image_name.clean_up }}</p>
                            </div>
                            <div v-else class="file-inputs mt-3 relative">
                                <div class="dotted-bg">
                                    <video :src="document.clean_up" controls v-if="document.clean_up"></video>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"
                                        fill="none">
                                        <path
                                            d="M54.0774 47.7783L54.0771 47.7778L43.0478 32.5166C43.047 32.5155 43.0463 32.5145 43.0455 32.5134C41.5448 30.4238 38.4396 30.4235 36.9386 32.5128C36.9377 32.5141 36.9368 32.5153 36.9359 32.5166L25.9066 47.7778L25.9062 47.7783C24.1017 50.2769 25.8784 53.7609 28.9661 53.7609H32.6383V67.1046H15.4721C8.09988 66.6655 2 59.6549 2 51.908C2 46.6514 4.84793 42.0611 9.08693 39.5752L10.5322 38.7276L9.951 37.1562C9.59374 36.1903 9.40499 35.1506 9.40499 34.0412C9.40499 29.0159 13.4626 24.9583 18.4879 24.9583C19.5794 24.9583 20.6192 25.1465 21.5866 25.5043L23.3067 26.1405L24.0892 24.4818C27.3185 17.6362 34.28 12.8951 42.3688 12.8945C52.8366 12.9101 61.4659 20.9279 62.4473 31.143L62.5934 32.664L64.0993 32.9228C71.9373 34.2702 78 41.5883 78 49.9301C78 58.8106 71.0858 66.4598 62.4369 67.1046H47.3453V53.7609H51.0176C54.0719 53.7609 55.8919 50.2907 54.0774 47.7783Z"
                                            stroke="#01796F" stroke-width="4"></path>
                                    </svg>
                                    <h2 class="choose-para">Upload Video</h2>
                                    <p class="file-type">limit 100mb</p>
                                    <input class="upload" type="file" id="banner"
                                        @change="show_document('clean_up', $event)" accept="video/*">
                                </div>
                            </div>
                            <InputError class="mt-2" :message="props.errors.clean_up" />
                        </div>

                        <div class="d-flex justify-between align-items-center p-0">
                            <div class="flex items-center mt-4 ">
                                <PrimaryButton class="forms-btn-transparent step-form-back" @click="previous_div(5)">
                                    <span> <i class="bi bi-arrow-left"></i></span> Back
                                </PrimaryButton>
                            </div>
                            <div class="flex items-center mt-4" style="cursor:pointer;">
                                <p class="forms-btn" @click="show_next_div(5)">
                                    Next Step <span> <i class="bi bi-arrow-right"></i></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!------step six----->
        <div class="login-bg-wrapper steps_form document-first-form step-form-6 application_guide" v-if="div_numbers == 'step-form-6'">
            <div class="container width_content">
                <div class="employment-first-form instructions">
                    <h2>Instructions for photo evidence</h2>
                    <p class="light-text">In addition to submitting videos, you must at least twenty (20) photos
                        demonstrating your skills as a commercial chef.</p>
                    <p class="light-text">Submit at least one (1) photo of you preparing each of the following dishes.
                    </p>

                    <div class="submit_dishes">
                        <h5 class="bg_grey">Submit at least one (1) photo of you preparing each of the following dishes.
                        </h5>
                        <ul class="green_bg">
                            <li class="green_inner_bg">Appetisers and salads</li>
                            <li>1. Two (2) different appetisers</li>
                            <li>2. Two (2) different salads</li>
                        </ul>
                        <ul class="green_bg">
                            <li class="green_inner_bg">Stocks and soups</li>
                            <li>3. Two (2) different stocks</li>
                            <li>4. Two (2) different soups</li>
                        </ul>
                        <ul class="green_bg">
                            <li class="green_inner_bg">Vegetarian and vegan dishes</li>
                            <li>5. One (1) vegetarian dish</li>
                            <li>6. One (1) vegan dish</li>
                        </ul>
                        <ul class="green_bg">
                            <li class="green_inner_bg">Desserts</li>
                            <li>7. Two (2) hot desserts</li>
                            <li>8. Two (2) cold desserts</li>
                        </ul>
                        <h5 class="bg_grey bg_border">In addition to the above, you must submit at least one (1) photo
                            or scan for each of the following
                            workplace documents you have created.</h5>
                        <ul class="green_bg">
                            <li class="green_inner_bg">Procedures, budgets and rosters</li>
                            <li>9. One (1) food safety procedure you have created </li>
                            <li>10. One (1) budget you have managed</li>
                            <li>11. One (1) staff roster you have prepared</li>
                        </ul>
                        <ul class="green_bg">
                            <li class="green_inner_bg">Recipes and menus</li>
                            <li>12. One (1) menu you have developed (including costings)</li>
                            <li>13. One (1) recipe you have developed (including costings)</li>
                            <li class="last_border">14. One (1) recipe you have developed to meet special dietary
                                requirements</li>
                        </ul>
                    </div>


                    <div class="employment-first-form">
                        <h2>The photos you submit must:</h2>
                        <div class="row mt-4">
                            <div class="col-md-6 col-12 employ_padding">
                                <div class="d-flex gap-3">
                                    <p class="light-text">clearly show it is you doing the work, not somebody else
                                    </p>
                                </div>
                                <div class="d-flex gap-3">
                                    <p class="light-text">show that you are performing tasks safely
                                    </p>
                                </div>
                                <div class="d-flex gap-3">
                                    <p class="light-text">When you save and name each photo file:
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="d-flex gap-3">
                                    <p class="light-text">include a description of what you are doing and why (you can
                                        add a description for each photo when you upload it)
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">

                        <div class="col-12 p-0">
                            <div v-if="document.evidence_image" class="mt-3 relative">
                                <div class="d-flex align-items-start all_image_close"><p class="btn btn-sm btn-danger justify-content-end close_mark" style="float:right;" @click="removeImage('evidence_image')"><i class="fas fa-times"></i></p>
                                <img :src="document.evidence_image" alt="" srcset="" width="250px"></div>
                                <p class="close_image_name">{{ image_name.evidence_image }}</p>
                            </div>
                            <div v-else class="file-inputs mt-3 relative">
                                <div class="dotted-bg">
                                    <img :src="document.evidence_image" alt="" srcset="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"
                                        fill="none">
                                        <path
                                            d="M54.0774 47.7783L54.0771 47.7778L43.0478 32.5166C43.047 32.5155 43.0463 32.5145 43.0455 32.5134C41.5448 30.4238 38.4396 30.4235 36.9386 32.5128C36.9377 32.5141 36.9368 32.5153 36.9359 32.5166L25.9066 47.7778L25.9062 47.7783C24.1017 50.2769 25.8784 53.7609 28.9661 53.7609H32.6383V67.1046H15.4721C8.09988 66.6655 2 59.6549 2 51.908C2 46.6514 4.84793 42.0611 9.08693 39.5752L10.5322 38.7276L9.951 37.1562C9.59374 36.1903 9.40499 35.1506 9.40499 34.0412C9.40499 29.0159 13.4626 24.9583 18.4879 24.9583C19.5794 24.9583 20.6192 25.1465 21.5866 25.5043L23.3067 26.1405L24.0892 24.4818C27.3185 17.6362 34.28 12.8951 42.3688 12.8945C52.8366 12.9101 61.4659 20.9279 62.4473 31.143L62.5934 32.664L64.0993 32.9228C71.9373 34.2702 78 41.5883 78 49.9301C78 58.8106 71.0858 66.4598 62.4369 67.1046H47.3453V53.7609H51.0176C54.0719 53.7609 55.8919 50.2907 54.0774 47.7783Z"
                                            stroke="#01796F" stroke-width="4"></path>
                                    </svg>
                                    <h2 class="choose-para">Upload Photo</h2>
                                    <p class="file-type">Max size 5MB</p>
                                    <input class="upload" type="file" id="banner"
                                        @change="show_document('evidence_image', $event)">
                                </div>
                            </div>
                            <InputError class="mt-2" :message="props.errors.evidence_image" />
                        </div>

                        <div class="file_size employ_padding">
                            <h2>File size for each photo must not exceed 5 MB</h2>
                            <p class="light-text">Photo file formats accepted include:</p>
                            <ul class="img_format">
                                <li>PDF (.pdf)</li>
                                <li>PNG (.png)</li>
                                <li>JPEG (.jpg or .jpeg)</li>
                                <li>TIFF (.tiff)</li>
                            </ul>
                            <p class="light-text">Photo files must be named 'Surname_First Name_Photo_number'. For
                                example: 'Smith_Peter_Photo_1'</p>
                            <p class="light-text">Upload your photos via the VETASSESS online portal when submitting
                                your application.</p>
                        </div>

                        <div class="d-flex justify-between align-items-start p-0">
                            <div class="flex items-start mt-4 ">
                                <PrimaryButton class="forms-btn-transparent step-form-back" @click="previous_div(6)">
                                    <span> <i class="bi bi-arrow-left"></i></span> Back
                                </PrimaryButton>
                            </div>
                            <div class="flex items-start mt-4" style="cursor:pointer;">
                                <p class="forms-btn" @click="show_next_div(6)">
                                    Next Step <span> <i class="bi bi-arrow-right"></i></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!------step seven----->
        <div class="login-bg-wrapper steps_form document-first-form step-form-7 application_guide" v-if="div_numbers == 'step-form-7'">
            <div class="container width_content">
                <div class="employment-first-form steps_55">
                    <h2>4. Resumé / CV</h2>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">personal details
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">education and training
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">employment
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text"> licences held.
                                </p>
                            </div>
                        </div>

                        <div class="col-12 p-0">
                            <div v-if="document.resume" class="mt-3 relative">
                                <div class="d-flex align-items-start all_image_close">
                                    <p class="btn btn-sm btn-danger justify-content-end close_mark" style="float:right;" @click="removeImage('resume')"><i class="fas fa-times"></i></p>
                                    <img :src="document.resume" alt="" srcset=""></div>
                                <p class="close_image_name">{{ image_name.resume }}</p>
                            </div>
                            <div v-else class="file-inputs mt-3 relative">
                                <div class="dotted-bg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"
                                        fill="none">
                                        <path
                                            d="M54.0774 47.7783L54.0771 47.7778L43.0478 32.5166C43.047 32.5155 43.0463 32.5145 43.0455 32.5134C41.5448 30.4238 38.4396 30.4235 36.9386 32.5128C36.9377 32.5141 36.9368 32.5153 36.9359 32.5166L25.9066 47.7778L25.9062 47.7783C24.1017 50.2769 25.8784 53.7609 28.9661 53.7609H32.6383V67.1046H15.4721C8.09988 66.6655 2 59.6549 2 51.908C2 46.6514 4.84793 42.0611 9.08693 39.5752L10.5322 38.7276L9.951 37.1562C9.59374 36.1903 9.40499 35.1506 9.40499 34.0412C9.40499 29.0159 13.4626 24.9583 18.4879 24.9583C19.5794 24.9583 20.6192 25.1465 21.5866 25.5043L23.3067 26.1405L24.0892 24.4818C27.3185 17.6362 34.28 12.8951 42.3688 12.8945C52.8366 12.9101 61.4659 20.9279 62.4473 31.143L62.5934 32.664L64.0993 32.9228C71.9373 34.2702 78 41.5883 78 49.9301C78 58.8106 71.0858 66.4598 62.4369 67.1046H47.3453V53.7609H51.0176C54.0719 53.7609 55.8919 50.2907 54.0774 47.7783Z"
                                            stroke="#01796F" stroke-width="4"></path>
                                    </svg>
                                    <h2 class="choose-para">Upload Document Or Scan Document </h2>
                                    <p class="file-type">Max size 20MB</p>
                                    <input class="upload" type="file" id="banner"
                                        @change="show_document('resume', $event)">
                                </div>
                            </div>
                            <InputError class="mt-2" :message="form.errors.resume" />
                        </div>

                        <div class="documents_bottom p-0">
                            <p class="light-text">At the end of this document we have provided a checklist that will
                                help you ensure you have all the evidence we need.</p>
                        </div>

                        <div class="col-12 p-0">
                            <div class="employ_note">
                                <h2>IMPORTANT:</h2>
                                <p>All employment and training documents must be high quality colour scans of the
                                    originals. If your documents are not in English, you must submit both the original
                                    documents and the English translations made by a registered translation service.</p>
                            </div>
                        </div>

                        <div class="documents_bottom p-0">
                            <p class="light-text">An assessor will review your documents to ensure that they meet the
                                employment and training requirements for your nominated occupation and indicate that you
                                have the necessary skills, knowledge and experience in your trade.</p>

                            <p class="light-text">The skills and knowledge required for your trade in Australia are
                                found in a Training Package for a qualification relevant to your nominated occupation.
                                They are called the units of competency.</p>

                            <p class="light-text">To see all the units of competency for a qualification relevant to
                                your occupation, download the Fact Sheet for your trade from: <a
                                    href="#" >https://www.vetassess.
                                    com.au/skills-assessment-for-migration/tradeoccupations/guides-and-factsheets.</a>
                            </p>

                        </div>


                        <div class="d-flex justify-between align-items-start p-0 end_form_part">
                            <div class="flex items-start mt-4 ">
                                <PrimaryButton class="forms-btn-transparent step-form-back" @click="previous_div(7)">
                                    <span> <i class="bi bi-arrow-left"></i></span> Back
                                </PrimaryButton>
                            </div>
                            <div class="flex items-start mt-4">
                                <PrimaryButton  class="forms-btn"  v-if="form.processing" :disabled="form.processing">
                                    Submitting....
                                    <img src="/images/loader.gif" style="width:20px; height:20px;">
                                </PrimaryButton>
                                <PrimaryButton class="forms-btn width_full" style="line-height: 20px;" type="submit" v-else>
                                    Pay Fee and Submit Application
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>




    <Footer />
</template>
<style scoped></style>