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

const props = defineProps({
    job_id: {
        type: Number,
        default: 0
    },
    customer_id: {
        type: Number,
        default: 0
    },
    step: {
        type: String
    },
    errors: {
        type: Object
    }
});


const image_name = reactive({
    'employer_statement': null,
    'financial_evidence': null,
    'evidence_self_employment': null,
    'formal_training_evidence': null,
    'evidence_self_employment_aus': null
});

const div_numbers = ref(`step-form-1`),
    document = reactive({}),
    data = { job_id: props.job_id, customer_id: props.customer_id };
const form = useForm({
    job_id: props.job_id,
    customer_id: props.customer_id,
    employer_statement: null,
    financial_evidence: null,
    evidence_self_employment: null,
    evidence_self_employment_aus: null,
    formal_training_evidence: null,
    step: 1
});
const errors = ref([]);
 function show_next_div(div_number) {
    form.step = div_number+1;
    div_numbers.value = `step-form-${form.step}`;
    window.scrollTo(0, 0);
    // try {
    //     const response = await axios.post(route('validate_employment_details'), form, {
    //         headers: {
    //             'Content-Type': 'multipart/form-data'
    //         }
    //     });
    //     if (response) {
    //         if (response.data.success) {
    //             div_numbers.value = `step-form-${response.data.step}`;
    //         } else {
    //             for (const key in response.data.error) {
    //                 if (Object.prototype.hasOwnProperty.call(response.data.error, key)) {
    //                     const errorMessageArray = response.data.error[key];
    //                     props.errors[key] = errorMessageArray[0]
    //                 }
    //             }
    //             div_numbers.value = `step-form-${response.data.step}`;
    //         }
    //         window.scrollTo(0, 0);
    //     }
    // } catch (error) {
    //     console.error('Error form validation:', error);
    //     div_numbers.value = `step-form-${div_number}`;

    // }

}

function previous_div(div_number) {
    div_numbers.value = `step-form-${div_number - 1}`
}

function show_document(type, event) {
    form[type] = event.target.files[0];
    document[type] = URL.createObjectURL(event.target.files[0]);
    image_name[type] = event.target.files[0].name;
    submit_Document(form.step)
}


function submit_form() {
    // form.post(route('submit_employment_details'), {
    //     onSuccess: () => {
    //         if (form.step == 4) {
    //             toast("Details Saved Successfully!", {
    //                 autoClose: 2000,
    //                 theme: 'dark',
    //             });
    //         }
    //     }
    // })
    window.location.href = route('document.details',[job_id,customer_id]);

};

async function submit_Document(step){
    try {
        const response = await axios.post(route('submit_customers_data'), form, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
        if (response) {
            if (!response.data.success) {
                for (const key in response.data.error) {
                    if (Object.prototype.hasOwnProperty.call(response.data.error, key)) {
                        const errorMessageArray = response.data.error[key];
                        props.errors[key] = errorMessageArray[0]
                    }
                }
                
            }
            
        }
    } catch (error) {
        console.error('Error form validation:', error);
        form.step = `step-form-${step}`;
    }
}


function removeImage(type) {
    form[type] = null;
    document[type] = null;
    image_name[type] = null;
}

</script>
<template>
    <Header />

    <SubHeading :data="data" />

    <form @submit.prevent="submit_form()">
        <!-------step one----------->

        <div class="login-bg-wrapper steps_form employment-first-form step-form-1 employment_next"
            v-if="div_numbers == 'step-form-1'">
            <div class="container width_content">
                <!-- 1 -->
                <div class="employment-first-form">
                    <p class="light-text  mobile_padding">You must provide official employment evidence to demonstrate that you
                        meet the

                        minimum
                        employment experience requirements for your nominated occupation.Each period of employment
                        submitted for
                        assessment must be supported by the following two forms of evidence:</p>
                    <h2 class="mobile_padding ">1. An employer statement that includes all the following details:</h2>
                    <div class="row mt-4">
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">your exact employment period (start and finish dates, including
                                    day and
                                    month)
                                </p>
                            </div>

                        </div>
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">the nature of your employment (full-time,part-time, casual)</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">your normal hours of work</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">your job title(s)</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">a detailed description of the tasks that you perform</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">the name and address of the business on official business
                                    letterhead</p>
                            </div>
                        </div>
                        <div class="col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text"> the name, position, contact details (business phone number and
                                    email
                                    address), date and signature of the person authorised to make the employer statement
                                    and the
                                    length of time they supervised your work. This person, known as your ‘referee’, must
                                    be your
                                    manager, supervisor or human resources department representative.</p>
                            </div>
                        </div>
                        <div v-if="document.employer_statement" class="mt-3 relative">
                            <div class="d-flex align-items-start all_image_close"><p class="btn btn-sm btn-danger justify-content-end close_mark" style="float:right;" @click="removeImage('employer_statement')"><i class="fas fa-times"></i></p>
                            <img :src="document.employer_statement" alt="" srcset="" width="250px" class="close_image_wrapper"></div>
                            <p class="close_image_name">{{ image_name.employer_statement }}</p>
                        </div>
                        <div v-else class="col-12 p-0">
                            <div  class="file-inputs mt-3 relative">
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
                                        @change="show_document('employer_statement', $event)" >

                                </div>
                            </div>
                        </div>
                        <InputError class="mt-2" :message="props.errors.employer_statement" />
                        <div class="d-flex justify-between align-items-start mt-4 p-0">
                            <div class="flex items-start">
                                <PrimaryButton class="forms-btn-transparent step-form-back">
                                    <span> <i class="bi bi-arrow-left"></i></span> Back
                                </PrimaryButton>
                            </div>
                            <div class="flex items-start" style="cursor:pointer;">
                                <p class="forms-btn" id="1" @click="show_next_div(1)">
                                    Next Step <span> <i class="bi bi-arrow-right"></i></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2 -->

            </div>
        </div>

        <!-------step two----------->

        <div class="login-bg-wrapper steps_form employment-first-form step-form-2 application_guide"
            v-if="div_numbers == 'step-form-2'">
            <div class="container width_content">

                <!-- 1 -->
                <div class="employment-first-form">
                    <h2>2. Financial evidence including at least 2 of the following items per year of employment
                        claimed:</h2>
                    <div class="row mt-4">
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">official government tax records such as income statements, payment
                                    summaries, tax group certificates or tax notices of assessment (listing the names of
                                    the employer and employee)
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">three pay slips listing the names of the employer and employee
                                    (pay slips should be from the start, middle and end of each year claimed)</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">superannuation (pension) documents citing the names of the
                                    employer and employee</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">bank statements clearly showing the employer’s name and income
                                    deposited (please highlight relevant deposits).</p>
                            </div>
                        </div>

                        <div class="col-12 p-0">
                            <div v-if="document.financial_evidence" class="mt-3 relative">
                                <div class="d-flex align-items-start all_image_close"><p class="btn btn-sm btn-danger justify-content-end close_mark" style="float:right;" @click="removeImage('financial_evidence')"><i class="fas fa-times"></i></p>
                            <img :src="document.financial_evidence" alt="" srcset="" width="250px"></div>
                            <p class="close_image_name">{{ image_name.financial_evidence }}</p>
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
                                        @change="show_document('financial_evidence', $event)">

                                </div>
                            </div>
                            <InputError class="mt-2" :message="props.errors.financial_evidence" />
                        </div>

                        <div class="col-12 p-0 mt-3">
                            <div class="employ_note">
                                <h2>Please Note —</h2>
                                <p>We cannot accept statutory declarations (affidavits) about your employment experience
                                    in the absence of third-party evidence (such as an employer statement or financial
                                    records).</p>
                                <p>Your employment evidence must be verifiable. Ensure that the contact details provided
                                    on your employer statements are up-to-date and correct as we will contact your
                                    referees to verify their reference is genuine.</p>
                            </div>
                        </div>


                        <div class="d-flex justify-between align-items-start buttons_mine p-0">
                            <div class="flex items-center mt-4 ">
                                <PrimaryButton class="forms-btn-transparent step-form-back" @click="previous_div(2)">
                                    <span> <i class="bi bi-arrow-left"></i></span> Back
                                </PrimaryButton>
                            </div>
                            <div class="flex items-start mt-4" style="cursor:pointer">
                                <p class="forms-btn" id="2" @click="show_next_div(2)">
                                    Next Step <span> <i class="bi bi-arrow-right"></i></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2 -->

            </div>
        </div>

        <!-------step three----------->
        <div class="login-bg-wrapper steps_form employment-first-form step-form-3 application_guide"
            v-if="div_numbers == 'step-form-3'">
            <div class="container employ_width_wrap">

                <!-- 1 -->
                <div class="employment-first-form">
                    <h2 class="mb-3">3 Evidence of self-employment</h2>
                    <p class="light-text">If you are, or have been, self-employed, you must provide the following
                        evidence for each year of self-employment claimed:</p>
                    <h3>3.1 Evidence of self-employment not undertaken in Australia:</h3>
                    <div class="row mt-4">
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">business registration documents
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">annual business returns</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">relevant occupation or business licences</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">a statement from a registered/certified accountant</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">taxation documents citing the name of the business.</p>
                            </div>
                        </div>

                        <div class="col-12">
                            <div v-if="document.evidence_self_employment" class="mt-3 relative">
                                    <div class="d-flex align-items-start all_image_close">
                                        <p class="btn btn-sm btn-danger justify-content-end close_mark" style="float:right;" @click="removeImage('evidence_self_employment')"><i class="fas fa-times"></i></p>
                                    <img :src="document.evidence_self_employment" alt="" srcset="" width="250px">
                                    </div>
                            <p class="close_image_name">{{ image_name.evidence_self_employment }}</p>
                        </div>

                        <div  v-else  class="col-12 employ_padding">
                            <div class="file-inputs mt-3 relative">
                                <div class="dotted-bg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"
                                        fill="none">
                                        <path
                                            d="M54.0774 47.7783L54.0771 47.7778L43.0478 32.5166C43.047 32.5155 43.0463 32.5145 43.0455 32.5134C41.5448 30.4238 38.4396 30.4235 36.9386 32.5128C36.9377 32.5141 36.9368 32.5153 36.9359 32.5166L25.9066 47.7778L25.9062 47.7783C24.1017 50.2769 25.8784 53.7609 28.9661 53.7609H32.6383V67.1046H15.4721C8.09988 66.6655 2 59.6549 2 51.908C2 46.6514 4.84793 42.0611 9.08693 39.5752L10.5322 38.7276L9.951 37.1562C9.59374 36.1903 9.40499 35.1506 9.40499 34.0412C9.40499 29.0159 13.4626 24.9583 18.4879 24.9583C19.5794 24.9583 20.6192 25.1465 21.5866 25.5043L23.3067 26.1405L24.0892 24.4818C27.3185 17.6362 34.28 12.8951 42.3688 12.8945C52.8366 12.9101 61.4659 20.9279 62.4473 31.143L62.5934 32.664L64.0993 32.9228C71.9373 34.2702 78 41.5883 78 49.9301C78 58.8106 71.0858 66.4598 62.4369 67.1046H47.3453V53.7609H51.0176C54.0719 53.7609 55.8919 50.2907 54.0774 47.7783Z"
                                            stroke="#01796F" stroke-width="4"></path>
                                    </svg>
                                    <h2 class="choose-para">Upload Document Or Scan Document </h2>
                                    <p class="file-type">Max size 20MB</p>
                                    <input class="upload" type="file" id="banner" @change="show_document('evidence_self_employment',$event)">

                                    </div>
                                </div>
                            </div>
                            <InputError class="mt-2" :message="props.errors.evidence_self_employment" />

                            <h3 class="spacing_hd">3.2 Evidence of self-employment undertaken in Australia:</h3>

                            <div class="row">
                                <div class="col-md-6 col-12 employ_padding">
                                <div class="d-flex gap-3">
                                    <i class="fa-solid fa-circle-check green-text"></i>
                                    <p class="light-text">your Australian Business Number (ABN)</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 employ_padding">
                                <div class="d-flex gap-3">
                                    <i class="fa-solid fa-circle-check green-text"></i>
                                    <p class="light-text">a payment summary information statement</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 employ_padding">
                                <div class="d-flex gap-3">
                                    <i class="fa-solid fa-circle-check green-text"></i>
                                    <p class="light-text">a Business Activity Statement (BAS)</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 employ_padding">
                                <div class="d-flex gap-3">
                                    <i class="fa-solid fa-circle-check green-text"></i>
                                    <p class="light-text">a Notice of Assessment from the Australian Taxation Office
                                        (ATO)
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 employ_padding">
                                <div class="d-flex gap-3">
                                    <i class="fa-solid fa-circle-check green-text"></i>
                                    <p class="light-text">a statement from a registered/certified accountant. </p>
                                </div>
                            </div>
                            </div>

                            


                            <div class="col-12 employment_next">
                                <div v-if="document.evidence_self_employment_aus" class="mt-3 relative">
                                    <div class="d-flex align-items-start all_image_close"><p class="btn btn-sm btn-danger justify-content-end close_mark" style="float:right;" @click="removeImage('evidence_self_employment_aus')"><i class="fas fa-times"></i></p>
                            <img :src="document.evidence_self_employment_aus" alt="" srcset="" width="250px"></div>
                            <p class="close_image_name">{{ image_name.evidence_self_employment_aus }}</p>
                        </div>
                        <div v-else class="col-12 employ_padding">
                            <div class="file-inputs mt-3 relative">
                                <div class="dotted-bg">
                                    <img :src="document.evidence_self_employment_aus" alt="" srcset="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"
                                        fill="none">
                                        <path
                                            d="M54.0774 47.7783L54.0771 47.7778L43.0478 32.5166C43.047 32.5155 43.0463 32.5145 43.0455 32.5134C41.5448 30.4238 38.4396 30.4235 36.9386 32.5128C36.9377 32.5141 36.9368 32.5153 36.9359 32.5166L25.9066 47.7778L25.9062 47.7783C24.1017 50.2769 25.8784 53.7609 28.9661 53.7609H32.6383V67.1046H15.4721C8.09988 66.6655 2 59.6549 2 51.908C2 46.6514 4.84793 42.0611 9.08693 39.5752L10.5322 38.7276L9.951 37.1562C9.59374 36.1903 9.40499 35.1506 9.40499 34.0412C9.40499 29.0159 13.4626 24.9583 18.4879 24.9583C19.5794 24.9583 20.6192 25.1465 21.5866 25.5043L23.3067 26.1405L24.0892 24.4818C27.3185 17.6362 34.28 12.8951 42.3688 12.8945C52.8366 12.9101 61.4659 20.9279 62.4473 31.143L62.5934 32.664L64.0993 32.9228C71.9373 34.2702 78 41.5883 78 49.9301C78 58.8106 71.0858 66.4598 62.4369 67.1046H47.3453V53.7609H51.0176C54.0719 53.7609 55.8919 50.2907 54.0774 47.7783Z"
                                            stroke="#01796F" stroke-width="4"></path>
                                    </svg>
                                    <h2 class="choose-para">Upload Document Or Scan Document </h2>
                                    <p class="file-type">Max size 20MB</p>
                                    <input class="upload" type="file" id="banner" @change="show_document('evidence_self_employment_aus',$event)">

                                        </div>
                                    </div>
                                </div>
                                <InputError class="mt-2" :message="props.errors.evidence_self_employment_aus" />


                                <div class="d-flex justify-between align-items-start employ_padding">
                                    <div class="flex align-items-start mt-4 ">
                                        <PrimaryButton class="forms-btn-transparent step-form-back"
                                            @click="previous_div(3)">
                                            <span> <i class="bi bi-arrow-left"></i></span> Back
                                        </PrimaryButton>
                                    </div>
                                    <div class="flex align-items-start mt-4 login-btn-main" style="cursor:pointer">
                                        <p class="forms-btn" id="3" @click="show_next_div(3)">
                                            Next Step <span> <i class="bi bi-arrow-right"></i></span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <InputError class="mt-2" :message="props.errors.evidence_self_employment_aus"/>
                        </div>

                        <!-- 2 -->

                    </div>
                </div>
            </div>
        </div>
        


        <!-------step four----------->

        <div class="login-bg-wrapper steps_form employment-first-form step-form-4 application_guide"
            v-if="div_numbers == 'step-form-4'">
            <div class="container widthcontent">

                <!-- 1 -->
                <div class="employment-first-form">
                    <h2>4 Formal Training Evidence</h2>
                    <p class="light-text">If you have completed formal training related to your trade, you must
                        submit
                        official evidence including:</p>
                    <div class="row mt-4">
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">a qualification certificate or statementof completion</p>
                            </div>
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">a full academic transcript or other documents that include
                                    the
                                    start and end date of training and details of the program of study</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">apprenticeship documents, such as the contract of
                                    apprenticeship,
                                    journal or any other relevant document from the employer, governing body or
                                    training
                                    institution relating to the apprenticeship (if applicable). </p>
                            </div>
                        </div>

                        <div class="col-12 employ_padding">
                            <div v-if="document.formal_training_evidence" class="mt-3 relative">
                                <div class="d-flex align-items-start all_image_close"><p class="btn btn-sm btn-danger justify-content-end close_mark" style="float:right;" @click="removeImage('formal_training_evidence')"><i class="fas fa-times"></i></p>
                            <img :src="document.formal_training_evidence" alt="" srcset="" width="250px"></div>
                            <p class="close_image_name">{{ image_name.formal_training_evidence }}</p>
                        </div>
  
                            <div v-else class="file-inputs mt-3 relative">

                                <div class="dotted-bg">
                                    <img :src="document.formal_training_evidence" alt="" srcset="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"
                                        fill="none">
                                        <path
                                            d="M54.0774 47.7783L54.0771 47.7778L43.0478 32.5166C43.047 32.5155 43.0463 32.5145 43.0455 32.5134C41.5448 30.4238 38.4396 30.4235 36.9386 32.5128C36.9377 32.5141 36.9368 32.5153 36.9359 32.5166L25.9066 47.7778L25.9062 47.7783C24.1017 50.2769 25.8784 53.7609 28.9661 53.7609H32.6383V67.1046H15.4721C8.09988 66.6655 2 59.6549 2 51.908C2 46.6514 4.84793 42.0611 9.08693 39.5752L10.5322 38.7276L9.951 37.1562C9.59374 36.1903 9.40499 35.1506 9.40499 34.0412C9.40499 29.0159 13.4626 24.9583 18.4879 24.9583C19.5794 24.9583 20.6192 25.1465 21.5866 25.5043L23.3067 26.1405L24.0892 24.4818C27.3185 17.6362 34.28 12.8951 42.3688 12.8945C52.8366 12.9101 61.4659 20.9279 62.4473 31.143L62.5934 32.664L64.0993 32.9228C71.9373 34.2702 78 41.5883 78 49.9301C78 58.8106 71.0858 66.4598 62.4369 67.1046H47.3453V53.7609H51.0176C54.0719 53.7609 55.8919 50.2907 54.0774 47.7783Z"
                                            stroke="#01796F" stroke-width="4"></path>
                                    </svg>
                                    <h2 class="choose-para">Upload Document Or Scan Document </h2>
                                    <p class="file-type">Max size 20MB</p>
                                    <input class="upload" type="file" id="banner"
                                        @change="show_document('formal_training_evidence', $event)">
                                    <p>{{ image_name.formal_training_evidence }}</p>
                                </div>
                            </div>
                            <InputError class="mt-2" :message="props.errors.formal_training_evidence" />
                        </div>

                        <h2 class="spacing_hd">Formal training does not include: </h2>

                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text"> short courses</p>
                            </div>
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text"> training that lacks official recognition by the relevant
                                    educational authorities in the country where it was undertaken.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 employ_padding">
                            <div class="d-flex gap-3">
                                <i class="fa-solid fa-circle-check green-text"></i>
                                <p class="light-text">qualifications where most of the training was not directly
                                    related
                                    to your nominated occupation</p>
                            </div>
                        </div>

                        <div class="d-flex justify-between align-items-center p-0">
                            <div class="flex items-center mt-4 ">
                                <PrimaryButton class="forms-btn-transparent step-form-back" @click="previous_div(4)">
                                    <span> <i class="bi bi-arrow-left"></i></span> Back
                                </PrimaryButton>
                            </div>
                            <div class="flex items-center mt-4 login-btn-main">
                                <PrimaryButton  class="forms-btn"  v-if="form.processing" :disabled="form.processing">
                                    Submitting....
                                    <img src="/images/loader.gif" style="width:20px; height:20px;">
                                </PrimaryButton>
                                <PrimaryButton class="forms-btn" id="4" type="submit" v-else>
                                    Next Step <span> <i class="bi bi-arrow-right"></i></span>
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2 -->

            </div>
        </div>
    </form>

    <Footer />
</template>
<style scoped></style>