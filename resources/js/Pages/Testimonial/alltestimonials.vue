<script setup>
import Header from "../Frontend/Header.vue"
import Footer from "../Frontend/Footer.vue";
import SubHeading from '@/Pages/Frontend/SubHeading.vue'
import "../../../css/frontend.css";
import { Head, Link, useForm } from '@inertiajs/vue3';
import CustomPagination from '@/Components/CustomPagination.vue';


</script> 
<template>
    <Head title="About us" />
    <Header class="login-wrapper" />
    <SubHeading />
    <div class="login-bg-wrapper">
        <div class="about-us-bg-wrapper">
            <div class="container">
                <h1 class="mb-2 text-blue text-center">What Clients Says About us</h1>
                <p class=" text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
            </div>
        </div>
        <div class="viewAll-testimonial">
            <div class="testimonial-section">
                <div class="container">
                    <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-3">
                        <div class="testimonial">
                            <div class="testimonial-content">
                                <div class="text-end mb-2">
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                                <p class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                            </div>
                            <div class="testimonial-bg">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <p >- <span> <i class="bi bi-person-square pl-2"></i></span></p>
                                    <p>Simran</p>
                                </div>
                                <Link class="testimonial-video-btn"><span><i class="bi bi-play-circle"></i> </span> Video5463.mp4</Link>
                            </div>
                        </div>
                        <div class="testimonial">
                            <div class="testimonial-content">
                                <div class="text-end mb-2">
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                                <p class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                            </div>
                            <div class="testimonial-bg">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <p >- <span> <i class="bi bi-person-square pl-2"></i></span></p>
                                    <p>Simran</p>
                                </div>
                                <Link class="testimonial-video-btn"><span><i class="bi bi-play-circle"></i> </span> Video5463.mp4</Link>
                            </div>
                        </div>
                        <div class="testimonial">
                            <div class="testimonial-content">
                                <div class="text-end mb-2">
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                                <p class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                            </div>
                            <div class="testimonial-bg">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <p >- <span> <i class="bi bi-person-square pl-2"></i></span></p>
                                    <p>Simran</p>
                                </div>
                                <Link class="testimonial-video-btn"><span><i class="bi bi-play-circle"></i> </span> Video5463.mp4</Link>
                            </div>
                        </div>
                        <div class="testimonial">
                            <div class="testimonial-content">
                                <div class="text-end mb-2">
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                                <p class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                            </div>
                            <div class="testimonial-bg">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <p >- <span> <i class="bi bi-person-square pl-2"></i></span></p>
                                    <p>Simran</p>
                                </div>
                                <Link class="testimonial-video-btn"><span><i class="bi bi-play-circle"></i> </span> Video5463.mp4</Link>
                            </div>
                        </div>
                        <div class="testimonial">
                            <div class="testimonial-content">
                                <div class="text-end mb-2">
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                                <p class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                            </div>
                            <div class="testimonial-bg">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <p >- <span> <i class="bi bi-person-square pl-2"></i></span></p>
                                    <p>Simran</p>
                                </div>
                                <Link class="testimonial-video-btn"><span><i class="bi bi-play-circle"></i> </span> Video5463.mp4</Link>
                            </div>
                        </div>
                        <div class="testimonial">
                            <div class="testimonial-content">
                                <div class="text-end mb-2">
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                                <p class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                            </div>
                            <div class="testimonial-bg">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <p >- <span> <i class="bi bi-person-square pl-2"></i></span></p>
                                    <p>Simran</p>
                                </div>
                                <Link class="testimonial-video-btn"><span><i class="bi bi-play-circle"></i> </span> Video5463.mp4</Link>
                            </div>
                        </div>
                        <div class="testimonial">
                            <div class="testimonial-content">
                                <div class="text-end mb-2">
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                                <p class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                            </div>
                            <div class="testimonial-bg">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <p >- <span> <i class="bi bi-person-square pl-2"></i></span></p>
                                    <p>Simran</p>
                                </div>
                                <Link class="testimonial-video-btn"><span><i class="bi bi-play-circle"></i> </span> Video5463.mp4</Link>
                            </div>
                        </div>
                        <div class="testimonial">
                            <div class="testimonial-content">
                                <div class="text-end mb-2">
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                                <p class="text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                            </div>
                            <div class="testimonial-bg">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <p >- <span> <i class="bi bi-person-square pl-2"></i></span></p>
                                    <p>Simran</p>
                                </div>
                                <Link class="testimonial-video-btn"><span><i class="bi bi-play-circle"></i> </span> Video5463.mp4</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Footer />
</template>
