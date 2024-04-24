<script setup>
import Header from '@/Pages/Frontend/Header.vue'
import Footer from '@/Pages/Frontend/Footer.vue'
import SubHeading from '@/Pages/Frontend/SubHeading.vue'
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Header />
    <SubHeading />
    <div class="login-bg-wrapper job-detail-page">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="view-main-image">
                        <img src="/images/main-img.png" alt="">
                    </div>
                </div>
                <div class="col-md-7">
                    <h2 class="semibold mb-3">Female Senior Graphic Designer</h2>
                    <p class="my-3"><span class="text-red"><i class="bi bi-geo-alt-fill pr-1"></i></span> Chandigarh,
                        India</p>
                    <div class="update-time mt-3 " style="display: inline-flex;">
                        <i class="bi bi-clock-fill"></i>
                        <p class="mb-0">2 hours ago...</p>
                    </div>
                    <div class=" col-md-4 view-job-btn mt-5">
                        <Link href="/view-job" class="forms-btn w-100">View Job <span> <i
                                class="bi bi-arrow-right"></i></span></Link>
                    </div>
                </div>
            </div>

            <div class="job-detail-content mt-4">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <h2 class="mb-2 semibold">Details of the job</h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text ever since the 1500s, when an unknown
                                printer took a galley of type and scrambled it to make a type specimen book. It has
                                survived not only five centuries, but also the leap into electronic typesetting,
                                remaining essentially unchanged. It was popularised in the 1960s with the release of
                                Letraset sheets containing Lorem Ipsum passages, and more recently with desktop
                                publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                            <ul style="list-style-type: disc;" class="mt-2">
                                <li class="mb-2">Lorem Ipsum is simply dummy text of the printing and typesetting
                                    industry.</li>
                                <li class="mb-2">Lorem Ipsum is simply dummy text of the printing and typesetting
                                    industry.</li>
                                <li class="mb-2">Lorem Ipsum is simply dummy text of the printing and typesetting
                                    industry.</li>
                            </ul>
                        </div>
                        <div class="col-md-6 col-12">
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
                        </div>
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
                                    <h3 class="mb-2 semibold">Company</h3>
                                    <p class="mb-0"><span class="text-red"><i class="bi bi-geo-alt-fill pr-1"></i></span> Chandigarh,
                        India</p>
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