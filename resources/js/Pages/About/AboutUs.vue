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
                <h1 class="mb-2 text-blue text-center">We're Here For You</h1>
                <p class=" text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                    Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took
                    a galley of type and scrambled it to make a type specimen book. It has survived not only five
                    centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                <div class="grid lg:grid-cols-2 grid-cols-1 gap-5 about-section-cards login-bg-wrapper">
                    <div class="aboutus-card-outer">
                        <div class="about-us-cards">
                            <span class="profile-posts">PRINCIPAL DIRECTOR</span>
                            <h2 class="mb-3">Paul Dizon</h2>
                            <p>Paul holds a Bachelor of Laws, Bachelor of Arts (Cultural Studies), Master of Business
                                Administration and Graduate Certificate in Migration Law & Practice. He is an Australian
                                Registered Migration Agent (MARA No.1067203) and a New Zealand Immigration Advisor (IAA
                                No.201502038). With over 10 years of practice, his experience has covered all aspects of
                                immigration law with particular success in strategic and corporate matters. Paul has
                                appeared on Australian national television, radio and online media – he was also
                                featured on the recent SBS documentary, “Who Gets To Stay in Australia?”
                                Paul is a second-generation Australian of Filipino descent.</p>
                            <div class="about-profile">
                                <img src="/images/profile1.jpg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="aboutus-card-outer">
                        <div class="about-us-cards">
                            <span class="profile-posts">PRINCIPAL DIRECTOR</span>
                            <h2 class="mb-3">Paul Dizon</h2>
                            <p>Paul holds a Bachelor of Laws, Bachelor of Arts (Cultural Studies), Master of Business
                                Administration and Graduate Certificate in Migration Law & Practice. He is an Australian
                                Registered Migration Agent (MARA No.1067203) and a New Zealand Immigration Advisor (IAA
                                No.201502038). With over 10 years of practice, his experience has covered all aspects of
                                immigration law with particular success in strategic and corporate matters. Paul has
                                appeared on Australian national television, radio and online media – he was also
                                featured on the recent SBS documentary, “Who Gets To Stay in Australia?”
                                Paul is a second-generation Australian of Filipino descent.</p>
                            <div class="about-profile">
                                <img src="/images/profile1.jpg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="aboutus-card-outer">
                        <div class="about-us-cards">
                            <span class="profile-posts">PRINCIPAL DIRECTOR</span>
                            <h2 class="mb-3">Paul Dizon</h2>
                            <p>Paul holds a Bachelor of Laws, Bachelor of Arts (Cultural Studies), Master of Business
                                Administration and Graduate Certificate in Migration Law & Practice. He is an Australian
                                Registered Migration Agent (MARA No.1067203) and a New Zealand Immigration Advisor (IAA
                                No.201502038). With over 10 years of practice, his experience has covered all aspects of
                                immigration law with particular success in strategic and corporate matters. Paul has
                                appeared on Australian national television, radio and online media – he was also
                                featured on the recent SBS documentary, “Who Gets To Stay in Australia?”
                                Paul is a second-generation Australian of Filipino descent.</p>
                            <div class="about-profile">
                                <img src="/images/profile1.jpg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="about-us-bg">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-md-8">
                                <h2 class="mb-3 text-white">We Speak the Language of Immigration.</h2>
                                <div class="mt-4">
                                    <Link class="main-btn">Contact Us</Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="login-bg-wrapper pb-0">
                <div class="container">
                    <h1 class="mb-2 text-blue text-center">Our International Partners</h1>
                    <div class="grid lg:grid-cols-2 grid-cols-1 gap-5 about-section-cards login-bg-wrapper">
                        <div class="aboutus-card-outer">
                            <div class="about-us-cards">
                                <span class="profile-posts">PRINCIPAL DIRECTOR</span>
                                <h2 class="mb-3">Paul Dizon</h2>
                                <p>Paul holds a Bachelor of Laws, Bachelor of Arts (Cultural Studies), Master of Business
                                    Administration and Graduate Certificate in Migration Law & Practice. He is an Australian
                                    Registered Migration Agent (MARA No.1067203) and a New Zealand Immigration Advisor (IAA
                                    No.201502038). With over 10 years of practice, his experience has covered all aspects of
                                    immigration law with particular success in strategic and corporate matters. Paul has
                                    appeared on Australian national television, radio and online media – he was also
                                    featured on the recent SBS documentary, “Who Gets To Stay in Australia?”
                                    Paul is a second-generation Australian of Filipino descent.</p>
                                <div class="about-profile">
                                    <img src="/images/profile1.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="aboutus-card-outer">
                            <div class="about-us-cards">
                                <span class="profile-posts">PRINCIPAL DIRECTOR</span>
                                <h2 class="mb-3">Paul Dizon</h2>
                                <p>Paul holds a Bachelor of Laws, Bachelor of Arts (Cultural Studies), Master of Business
                                    Administration and Graduate Certificate in Migration Law & Practice. He is an Australian
                                    Registered Migration Agent (MARA No.1067203) and a New Zealand Immigration Advisor (IAA
                                    No.201502038). With over 10 years of practice, his experience has covered all aspects of
                                    immigration law with particular success in strategic and corporate matters. Paul has
                                    appeared on Australian national television, radio and online media – he was also
                                    featured on the recent SBS documentary, “Who Gets To Stay in Australia?”
                                    Paul is a second-generation Australian of Filipino descent.</p>
                                <div class="about-profile">
                                    <img src="/images/profile1.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="aboutus-card-outer">
                            <div class="about-us-cards">
                                <span class="profile-posts">PRINCIPAL DIRECTOR</span>
                                <h2 class="mb-3">Paul Dizon</h2>
                                <p>Paul holds a Bachelor of Laws, Bachelor of Arts (Cultural Studies), Master of Business
                                    Administration and Graduate Certificate in Migration Law & Practice. He is an Australian
                                    Registered Migration Agent (MARA No.1067203) and a New Zealand Immigration Advisor (IAA
                                    No.201502038). With over 10 years of practice, his experience has covered all aspects of
                                    immigration law with particular success in strategic and corporate matters. Paul has
                                    appeared on Australian national television, radio and online media – he was also
                                    featured on the recent SBS documentary, “Who Gets To Stay in Australia?”
                                    Paul is a second-generation Australian of Filipino descent.</p>
                                <div class="about-profile">
                                    <img src="/images/profile1.jpg" alt="">
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
