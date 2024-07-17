<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import 'vue3-toastify/dist/index.css';
import * as countryStateCity from 'country-state-city';
import moment from 'moment';
import axios from 'axios';
import { toast } from 'vue3-toastify';


const props = defineProps({
    customer: {
        type: Object
    },
    job_id:{
        type:Number
    }
});
function getLast_name(name) {
    let filename = '';
    if (name) {
        const lastSlashPosition = name.lastIndexOf('/');
        if (lastSlashPosition !== -1) {
            filename = name.substring(lastSlashPosition + 1);
        } else {
            filename = 'No Data Available';
        }
    }
    return filename;
}
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-black-800 leading-tight">View Customer</h2>
            <div class="button-container">
            </div>

        </template>
        <div class="nav-container">
            <div class="form-navigation1 view_employee_tabs_wrapper">
                <div class="container container_full">
                    <ul class="row nav-underline pl-0 mb-0">
                        <div class="col-md-2 col-3 p-0 col_width">
                            <li class="nav-item">
                                <Link class="nav-link text-center view_link_tab" aria-current="page"
                                    :class="{ 'active': route().current('jobs.show', job_id) }"
                                    :href="route('jobs.show', job_id)">View Job</Link>
                            </li>
                        </div>
                        <div class="col-lg-2 col-md-3 col-5 p-0 col_width">
                            <li class="nav-item">
                                <Link class="nav-link text-center view_link_tab"
                                    :class="{ 'active': route().current('job_for_customers', job_id) }"
                                    :href="route('job_for_customers', job_id)">Applies</Link>
                            </li>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
        <div class="py-12 employesss_tabs_dd Admin_view_employ">
            <div class="container-fluid p-0 width_contents">
                <div class="inner_spacing_wrappers">
                    <div class="customer_card pb-5">
                        <div class="card-image">
                            <img :src="customer.customer_image" alt="" width="150px;">
                        </div>
                        <div class="inner_card_wrapper">
                            <h1>{{ customer.first_name }} {{ customer.last_name }}</h1>
                            <div class="card-body">
                                <!-- <h2>Other Details:</h2> -->
                                <p><b>Date of Birth</b>{{ customer.date_of_birth }}</p>
                                <p><b>County of birth</b>{{ customer.country_of_birth }}</p>
                                <p><b>City of birth</b>{{ customer.city_of_birth }}</p>
                                <p><b>martial_status</b>{{ (customer.martial_status) ? 'Married' : 'Unmarried' }}</p>
                                <p><b>Country to immigrate</b>{{ customer.migrate_country }}</p>
                                <p><b>Gender</b>{{ (customer.gender == 0) ? 'Male' : 'Female' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="pass_travel_details_wrapper border-top border-bottom">
                        <div class="row">
                            <div class="col-xl-6 xol-lg-6 col-md-12 col-sm-12 p-0">
                                <div class="Travel_details">
                                    <h2>Travel Details</h2>
                                    <div class="card-body">
                                        <p><b>Purpose of stay</b>{{ customer?.travel_details?.purpose_of_stay }}</p>
                                        <p><b>Type of visa</b>{{ customer?.travel_details?.type_of_visa }} </p>
                                        <p><b>Date of travel</b>{{ customer?.travel_details?.date_of_travel }}</p>
                                        <p><b>Passenger nationality </b>{{
                                            customer?.travel_details?.passenger_nationality }}
                                        </p>
                                        <p><b>Port of arrival</b>{{ customer?.travel_details?.port_of_arrival }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 xol-lg-6 col-md-12 col-sm-12 p-0">
                                <div class="Travel_details passport_details">
                                    <h2>Passport details</h2>
                                    <div class="card-body">
                                        <p><b>Passport number</b>{{ customer?.passport_number }}</p>
                                        <p><b>Issuing authority</b>{{ customer?.issuing_authority }}</p>
                                        <p><b>Citizen of more than one country</b>{{
                                            customer.citizen_of_more_than_one_country
                                            == 0 ? 'No': 'Yes' }} </p>
                                        <p><b>Have you ever obtained an visa using current or previous passport? </b>{{
                                            customer.visa_available == 0 ? 'No': 'Yes' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="video_image_wrapper pt-5 mbile_padding">
                        <h2 class="px-1">Videos</h2>
                            <div class="">
                                <div class="row justify-content-between row_start_content">
                                <div class="col column_width column_mine_width">
                                    <div class="img_inner_wrapper ">
                                        <div class="img_overlay relative">
                                            <!-- <img scr="http://127.0.0.1:8000/storage/categories/664722250a432_1715937829_.png"> -->
                                            <video :src="customer?.documents?.kitchen_area" controls></video>
                                            <!-- <div class="video_icon absolute w-100">
                                            <i class="fas fa-play-circle"></i>
                                        </div> -->
                                        </div>
                                        <div class="wrapper_name">
                                            <p class="mb-0 text-white text-center"
                                                v-html="getLast_name(customer?.documents?.kitchen_area)"></p>
                                        </div>

                                    </div>
                                </div>
                                <div class="col column_width column_mine_width">
                                    <div class="img_inner_wrapper ">
                                        <div class="img_overlay relative">
                                            <!-- <img src="http://127.0.0.1:8000/storage/categories/664722250a432_1715937829_.png"> -->
                                            <video :src="customer?.documents?.ingredients" controls></video>
                                            <!-- <div class="video_icon absolute w-100">
                                            <i class="fas fa-play-circle"></i>
                                        </div> -->
                                        </div>
                                        <div class="wrapper_name">
                                            <p class="mb-0 text-white text-center"
                                                v-html="getLast_name(customer?.documents?.ingredients)"></p>
                                        </div>

                                    </div>
                                </div>
                                <div class="col column_width column_mine_width">
                                    <div class="img_inner_wrapper ">
                                        <div class="img_overlay relative">
                                            <!-- <img scr="http://127.0.0.1:8000/storage/categories/664722250a432_1715937829_.png"> -->
                                            <video :src="customer?.documents?.cooking_tech" controls></video>
                                            <!-- <div class="video_icon absolute w-100">
                                            <i class="fas fa-play-circle"></i>
                                        </div> -->
                                        </div>
                                        <div class="wrapper_name">
                                            <p class="mb-0 text-white text-center"
                                                v-html="getLast_name(customer?.documents?.cooking_tech)"></p>
                                        </div>

                                    </div>
                                </div>
                                <!-- {{ customer }} -->
                                <div class="col column_width column_mine_width">
                                    <div class="img_inner_wrapper ">
                                        <div class="img_overlay relative">
                                            <video :src="customer?.documents?.dish" controls></video>
                                            <!-- <div class="video_icon absolute w-100">
                                            <i class="fas fa-play-circle"></i>
                                        </div> -->
                                        </div>
                                        <div class="wrapper_name">
                                            <p class="mb-0 text-white text-center"
                                                v-html="getLast_name(customer?.documents?.dish)">
                                            </p>
                                        </div>

                                    </div>
                                </div>
                                <div class="col column_width column_mine_width">
                                    <div class="img_inner_wrapper ">
                                        <div class="img_overlay relative">
                                            <!-- <img scr="http://127.0.0.1:8000/storage/categories/664722250a432_1715937829_.png">/ -->
                                            <video :src="customer?.documents?.clean_up" controls></video>
                                            <!-- <div class="video_icon absolute w-100">
                                            <i class="fas fa-play-circle"></i>
                                        </div> -->
                                        </div>
                                        <div class="wrapper_name">
                                            <p class="mb-0 text-white text-center"
                                                v-html="getLast_name(customer?.documents?.clean_up)"></p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            </div>
                           
                    </div>
                    <div class="video_image_wrapper">
                        <h2 class="px-1">Image</h2>
                        <div class="row justify-content-between row_start_content">
                            <div class="col column_width column_mine_width">
                                <div class="img_inner_wrapper">
                                    <img :src="customer?.employments?.evidence_self_employment_aus">
                                    <div class="wrapper_name">
                                        <p class="mb-0 text-white text-center"
                                            v-html="getLast_name(customer?.employments?.evidence_self_employment_aus)">
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col column_width column_mine_width">
                            </div>
                            <div class="col column_width column_mine_width">
                            </div>
                        </div>
                    </div>
                    <div class="video_image_wrapper">
                        <div class="row justify-content-between">
                            <div class="col col-one">
                            <h2>Passport</h2>
                            <div class="img_inner_wrapper">
                                 <img :src="customer.passport_image" alt=" No image">
                                <div class="wrapper_name">
                                    <p class="mb-0 text-white text-center">{{ customer.passport_image }}</p>
                                </div>
                            </div>
                        </div>
                            <div class="col col-two column_mine_width">
                                <h2>Employer statement</h2>
                                <div class="img_inner_wrapper" data-bs-toggle="modal" data-bs-target="#business_apply_modal">
                                    <img :src="customer?.employments?.employer_statement">
                                    <div class="wrapper_name">
                                        <p class="mb-0 text-white text-center"
                                             v-html="getLast_name(customer?.employments?.employer_statement)"></p>
                                    </div>
                                </div>

                                <div class="modal fade modal_main" id="business_apply_modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal_inner">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ModalLabel">Employer statement</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img :src="customer?.employments?.employer_statement">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-three column_mine_width">
                                <h2>Financial evidence</h2>
                                <div class="img_inner_wrapper" data-bs-toggle="modal" data-bs-target="#financial_evidences">
                                    <img :src="customer?.employments?.financial_evidence">
                                    <div class="wrapper_name">
                                        <p class="mb-0 text-white text-center"
                                            v-html="getLast_name(customer?.employments?.financial_evidence)"></p>
                                    </div>
                                </div>
                                <div class="modal fade modal_main" id="financial_evidences" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal_inner">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ModalLabel">Financial evidence</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img :src="customer?.employments?.financial_evidence">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-four text-full-block column_mine_width">
                                <h2>Evidence of self-employment</h2>
                                <div class="img_inner_wrapper" data-bs-toggle="modal" data-bs-target="#evidence_selfemployment">
                                    <img :src="customer?.employments?.formal_training_evidence">
                                    <div class="wrapper_name">
                                        <p class="mb-0 text-white text-center"
                                            v-html="getLast_name(customer?.employments?.formal_training_evidence)"></p>
                                    </div>
                                </div>
                                <div class="modal fade modal_main" id="evidence_selfemployment" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal_inner">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ModalLabel">Evidence of self-employment</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img :src="customer?.employments?.formal_training_evidence">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col column_width col-five column_mine_width col_hd_blnk">
                                <h2 style="visibility: hidden;" class="mobile_none">Evidence of self-employment</h2>
                                <div class="img_inner_wrapper" data-bs-toggle="modal" data-bs-target="#business_apply_modals">
                                    <img :src="customer?.employments?.evidence_self_employment">
                                    <div class="wrapper_name">
                                        <p class="mb-0 text-white text-center"
                                            v-html="getLast_name(customer?.employments?.evidence_self_employment)"></p>
                                    </div>
                                </div>
                                <div class="modal fade modal_main" id="business_apply_modals" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal_inner">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ModalLabel">Evidence of self-employment</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img :src="customer?.employments?.evidence_self_employment">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-three column_mine_width"></div>
                        </div>
                    </div>
                    <div class="video_image_wrapper">
                        <div class="row justify-content-between row_start_content">
                            <div class="col column_width column_mine_width">
                                <h2>Formal Training</h2>
                                <div class="img_inner_wrapper" data-bs-toggle="modal" data-bs-target="#formal_training">
                                    <img :src="customer?.documents?.evidence_image">
                                    <div class="wrapper_name">
                                        <p class="mb-0 text-white text-center"
                                            v-html="getLast_name(customer?.documents?.evidence_image)"></p>
                                    </div>
                                </div>
                                <div class="modal fade modal_main" id="formal_training" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal_inner">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ModalLabel">Formal Training</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img :src="customer?.documents?.evidence_image">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col column_width column_mine_width">
                                <h2>Supporting employee</h2>
                                <div class="img_inner_wrapper" data-bs-toggle="modal" data-bs-target="#supporting_employee_modal">
                                    <img :src="customer?.documents?.employment_evidence">
                                    <div class="wrapper_name">
                                        <p class="mb-0 text-white text-center"
                                            v-html="getLast_name(customer?.documents?.employment_evidence)"></p>
                                    </div>
                                </div>
                                <div class="modal fade modal_main" id="supporting_employee_modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal_inner">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ModalLabel">Supporting employee</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img :src="customer?.documents?.employment_evidence">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col column_width column_mine_width">
                                <h2>Licences</h2>
                                <div class="img_inner_wrapper" data-bs-toggle="modal" data-bs-target="#licence_modal">
                                    <img :src="customer?.documents?.licences">
                                    <div class="wrapper_name">
                                        <p class="mb-0 text-white text-center"
                                            v-html="getLast_name(customer?.documents?.licences)"></p>
                                    </div>
                                </div>
                                <div class="modal fade modal_main" id="licence_modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal_inner">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="ModalLabel">Licences</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <img :src="customer?.documents?.licences">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col column_width column_mine_width">
                            </div>
                            <div class="col column_width column_mine_width">
                            </div>
                        </div>
                    </div>
                    <div class="video_image_wrapper bg-white resume_div">
                        <div class="row justify-content-between row_start_content">
                            <div class="col column_width column_mine_width">
                                <h2>Resume </h2>
                                <div class="img_inner_wrapper">
                                    <div class="wrapper_name resume_btn">

                                        <p class="mb-0 text-white text-center"><a :href="customer?.documents?.resume"
                                                target="_blank" download="resume">Download Resume</a></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col column_width column_mine_width">
                            </div>
                            <div class="col column_width column_mine_width">
                            </div>
                            <div class="col column_width column_mine_width">
                            </div>
                            <div class="col column_width column_mine_width">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.success {
    color: green;
}

.main-outer-section {
    background-color: #F2F2F2;
}

.active-filter {
    color: #1A9882;
    /* Change color as per your requirement */
    border-bottom: 2px solid #1A9882;
}

.text-danger {
    color: red;
}
</style>