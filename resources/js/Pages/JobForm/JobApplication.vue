<script setup>
import Header from "../Frontend/Header.vue"
import Footer from "../Frontend/Footer.vue";
import SubHeading from '@/Pages/Frontend/SubHeading.vue'
import "../../../css/frontend.css";
import { Head, Link, useForm } from '@inertiajs/vue3';
import CustomPagination from '@/Components/CustomPagination.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Checkbox from '@/Components/Checkbox.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
</script>

<template>

    <Head title="Job Application Form" />
    <Header class="login-wrapper" />
    <SubHeading />
    <div class="login-bg-wrapper">
        <div class="about-us-bg-wrapper">
            <div class="container">
                <form action="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Job Title<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <TextInput placeholder="Enter job title" class="form-control mt-2" />
                                </div>
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">City<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <TextInput placeholder="Enter city" class="form-control mt-2" />
                                </div>
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Position type<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <TextInput placeholder="Enter city" class="form-select mt-2" />
                                </div>
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Zip code<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <TextInput placeholder="Enter code" class="form-control mt-2" />
                                </div>
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Seniority<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <TextInput placeholder="Enter code" class="form-select mt-2" />
                                </div>
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <label class="flex items-center">
                                    <Checkbox class="remember-me-check" name="remember" />
                                    <span class="label text-label pl-2">Remote Work</span>
                                </label>
                                <div class="d-flex align-items-center mt-3 gap-4">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" class="radio-new-btn" name="remote_work">
                                        <label class="pl-2" for="">Remote Work</label>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <input type="radio" class="radio-new-btn" name="remote_work">
                                        <label class="pl-2" for="">Hybrid</label>
                                    </div>
                                </div>
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Discipline<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <TextInput placeholder="Enter code" class="form-select mt-2" />
                                </div>
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Industry<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <TextInput placeholder="Enter code" class="form-select mt-2" />
                                </div>
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Overall Work Experience</span>
                                <div class="eye-icon-div">
                                    <TextInput placeholder="Enter code" class="form-select mt-2" />
                                </div>
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Segment</span>
                                <div class="eye-icon-div">
                                    <TextInput placeholder="Enter code" class="form-control mt-2" />
                                </div>
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Skills</span>
                                <div class="eye-icon-div">
                                    <TextInput placeholder="Search Skills" class="form-control mt-2" />
                                </div>
                                <div class="d-flex align-items-center gap-2 mt-2 flex-wrap">
                                    <div class="skill-selected">
                                        <p class="mb-0">FrameMaker <span><i class="bi bi-x"></i></span></p>
                                    </div>
                                    <div class="skill-selected">
                                        <p class="mb-0">FrameMaker <span><i class="bi bi-x"></i></span></p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <span class="label text-label">Recommend Skills</span>
                                    <div class="d-flex align-items-center gap-2 mt-2 flex-wrap">
                                        <div class="pre-skill-selected">
                                            <p class="mb-0">Dokumentation</p>
                                        </div>
                                        <div class="pre-skill-selected">
                                            <p class="mb-0">Mechanical</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Positions<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <TextInput placeholder="Enter segment" class="form-control mt-2" />
                                </div>
                            </div>
                            <div class="mt-4">
                                <span class="label text-label">Minimum and Maximum Salary<span style="color:red">
                                        *</span></span>
                                <div class="row">
                                    <div class="col-md-6 eye-icon-div">
                                        <TextInput placeholder="Enter Mini" class="form-control mt-2" />
                                    </div>
                                    <div class="col-md-6 eye-icon-div">
                                        <TextInput placeholder="Enter Max" class="form-control mt-2" />
                                    </div>

                                </div>
                            </div>
                            <div class="mt-4">
                                <span class="label text-label">Start Date<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <TextInput type="date" placeholder="Enter segment" class="form-control mt-2" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <div class="file-inputs mt-3 relative">
                                <div class="dotted-bg">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"
                                        fill="none">
                                        <path
                                            d="M54.0774 47.7783L54.0771 47.7778L43.0478 32.5166C43.047 32.5155 43.0463 32.5145 43.0455 32.5134C41.5448 30.4238 38.4396 30.4235 36.9386 32.5128C36.9377 32.5141 36.9368 32.5153 36.9359 32.5166L25.9066 47.7778L25.9062 47.7783C24.1017 50.2769 25.8784 53.7609 28.9661 53.7609H32.6383V67.1046H15.4721C8.09988 66.6655 2 59.6549 2 51.908C2 46.6514 4.84793 42.0611 9.08693 39.5752L10.5322 38.7276L9.951 37.1562C9.59374 36.1903 9.40499 35.1506 9.40499 34.0412C9.40499 29.0159 13.4626 24.9583 18.4879 24.9583C19.5794 24.9583 20.6192 25.1465 21.5866 25.5043L23.3067 26.1405L24.0892 24.4818C27.3185 17.6362 34.28 12.8951 42.3688 12.8945C52.8366 12.9101 61.4659 20.9279 62.4473 31.143L62.5934 32.664L64.0993 32.9228C71.9373 34.2702 78 41.5883 78 49.9301C78 58.8106 71.0858 66.4598 62.4369 67.1046H47.3453V53.7609H51.0176C54.0719 53.7609 55.8919 50.2907 54.0774 47.7783Z"
                                            stroke="#01796F" stroke-width="4" />
                                    </svg>
                                    <h2 class="choose-para">Upload a thumbnail of the job</h2>
                                    <p class="file-type">Max size 20MB</p>
                                    <input class="upload" type="file" id="banner"
                                        @change="selectFile($event, 'banner')" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 ">
                            <div class="flex items-center justify-center mt-4 login-btn-main">
                                <PrimaryButton class="forms-btn">
                                    Apply Now <span> <i class="bi bi-arrow-right"></i></span>
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <Footer />
</template>
