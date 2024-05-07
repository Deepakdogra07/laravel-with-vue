<script setup>
import Header from '@/Pages/Frontend/Header.vue'
import Footer from '@/Pages/Frontend/Footer.vue'
import SubHeading from '@/Pages/Frontend/SubHeading.vue'
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    job : {
        type:Object
    },
    created_time:{
        type:String
    }
})
</script>

<template>
    <Header />
    <SubHeading />
    <div class="login-bg-wrapper job-detail-page">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="view-main-image">
                        <img :src="job.job_image" alt="">
                    </div>
                </div>
                <div class="col-md-7">
                    <h2 class="semibold mb-3">{{ props.job.job_title }}</h2>
                    <p class="my-3"><span class="text-red"><i class="bi bi-geo-alt-fill pr-1"></i></span> {{ job?.city }}, {{ job?.job_country }}</p>
                    <div class="update-time mt-3 " style="display: inline-flex;">
                        <i class="bi bi-clock-fill"></i>
                        <p class="mb-0">{{ created_time }}...</p>
                    </div>
                    <!-- <div class=" col-md-4 view-job-btn mt-5">
                        <Link :href="`/view-job/${job.id}`" class="forms-btn w-100">View Job <span> <i
                                class="bi bi-arrow-right"></i></span></Link>
                    </div> -->
                </div>
            </div>

            <div class="job-detail-content mt-4">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <!-- <h2 class="mb-2 semibold">Details of the job</h2> -->
                            <div v-html="job.job_description"></div>
                            
                        </div>
                        <!-- <div class="col-md-6 col-12">
                            <h2 class="mb-2 semibold">Requirements</h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                            <ul style="list-style-type: disc;" class="mt-2">
                                <li class="mb-2">Lorem Ipsum is simply dummy text of the printing and typesetting
                                    industry.</li>
                                <li class="mb-2">Lorem Ipsum is simply dummy text of the printing and typesetting
                                    industry.</li>
                                <li class="mb-2">Lorem Ipsum is simply dummy text of the printing and typesetting
                                    industry.</li>
                                <li class="mb-2">Lorem Ipsum is simply dummy text of the printing and typesetting
                                    industry.</li>
                                <li class="mb-2">Lorem Ipsum is simply dummy text of the printing and typesetting
                                    industry.</li>
                            </ul>
                        </div>
                        <div class="col-md-6 col-12">
                            <h2 class="mb-2 semibold">Conditions</h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                            <ul style="list-style-type: disc;" class="mt-2">
                                <li class="mb-2">Lorem Ipsum is simply dummy text of the printing and typesetting
                                    industry.</li>
                                <li class="mb-2">Lorem Ipsum is simply dummy text of the printing and typesetting
                                    industry.</li>
                                <li class="mb-2">Lorem Ipsum is simply dummy text of the printing and typesetting
                                    industry.</li>
                            </ul>
                        </div> -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="company-section">
                            <h3 class="mb-2 semibold">Company</h3>
                            <div class="d-flex align-items-center mt-3 gap-4">
                                <div class="company-logo">
                                    <img src="/images/buildings1.png" alt="">
                                </div>  
                                <div class="company-name-loaction">
                                    <h3 class="mb-2 semibold">{{ job?.business?.company_name }}</h3>
                                    <p class="mb-0"><span class="text-red"><i class="bi bi-geo-alt-fill pr-1"></i></span> {{ job?.city }},
                                        {{ job?.job_country }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <Footer />
</template>