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
</script>

<template>

    <Head title="About us" />
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
                                    <TextInput  placeholder="Enter job title"
                                        class="form-control mt-2"/>
                                </div>
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">City<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <TextInput  placeholder="Enter city"
                                        class="form-control mt-2"/>
                                </div>
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Position type<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <TextInput  placeholder="Enter city"
                                        class="form-select mt-2"/>
                                </div>
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Zip code<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <TextInput  placeholder="Enter code"
                                        class="form-control mt-2"/>
                                </div>
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Seniority<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <TextInput  placeholder="Enter code"
                                        class="form-select mt-2"/>
                                </div>
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Seniority<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <TextInput  placeholder="Enter code"
                                        class="form-select mt-2"/>
                                </div>
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Discipline<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <TextInput  placeholder="Enter code"
                                        class="form-select mt-2"/>
                                </div>
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Industry<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <TextInput  placeholder="Enter code"
                                        class="form-select mt-2"/>
                                </div>
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Overall Work Experience</span>
                                <div class="eye-icon-div">
                                    <TextInput  placeholder="Enter code"
                                        class="form-select mt-2"/>
                                </div>
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Segment</span>
                                <div class="eye-icon-div">
                                    <TextInput  placeholder="Enter code"
                                        class="form-control mt-2"/>
                                </div>
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Skills</span>
                                <div class="eye-icon-div">
                                    <TextInput  placeholder="Search Skills"
                                        class="form-control mt-2"/>
                                </div>
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Positions</span>
                                <div class="eye-icon-div">
                                    <TextInput  placeholder="Enter segment"
                                        class="form-control mt-2"/>
                                </div>
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <Footer />
</template>
