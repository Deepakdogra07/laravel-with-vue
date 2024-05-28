<script setup>
import Header from "../Frontend/Header.vue"
import Footer from "../Frontend/Footer.vue";
import SubHeading from '@/Pages/Frontend/SubHeading.vue'
import "@@/frontend.css";
import { Head, Link, useForm } from '@inertiajs/vue3';
import CustomPagination from '@/Components/CustomPagination.vue';
</script>

<template>

    <Head title="About us" />
    <Header class="login-wrapper" />
    <SubHeading />
    <div class="login-bg-wrapper">
        <div class="about-us-bg-wrapper about_uss_wrapper">
            <div class="container">
                <h1 class="mb-2 text-blue text-center">We're Here For You</h1>
                <p class=" text-center">Our team will provide you with the most experienced and committed representation. We know that the immigration process can be stressful, emotional and overwhelming. However, we will ensure that you understand what your options are and what you need to do. Whatever your situation, let us take the lead – because we’re here to help you.</p>
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
                                    featured on the recent SBS documentary, “Who Gets To Stay in Australia?”<br>
                                    Paul is a second-generation Australian of Filipino descent.</p>
                                <div class="about-profile">
                                    <img src="/images/about-us/abt_1.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="aboutus-card-outer">
                            <div class="about-us-cards">
                                <span class="profile-posts">SENIOR ASSOCIATE</span>
                                <h2 class="mb-3">Oliver Christensen</h2>
                                <p>Oliver holds a Bachelor of Laws (Hons), a Bachelor of Arts (International Relations & Spanish), a Graduate Diploma in Legal Practice and a Graduate Certificate in Australian Migration Law and Practice. He is an Australian Registered Migration Agent (MARA No. 1683569). His strong legal aptitude has resulted in high success rates in complex cases and cancellation matters, including at the Administrative Appeals Tribunal. He also regularly volunteers at an asylum seeker centre in Melbourne where he provides migration assistance to asylum seekers and protection visa holders. Oliver speaks fluent Spanish and intermediate level Mandarin.Oliver is a third-generation Australian of Irish, English, Scottish and Scandinavian descent.</p>
                                <div class="about-profile">
                                    <img src="/images/about-us/abt-2.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="aboutus-card-outer aboutcard_align">
                            <div class="about-us-cards">
                                <span class="profile-posts">LEGAL CONSULTANT</span>
                                <h2 class="mb-3">Julian Hayden</h2>
                                <p>Julian holds a Bachelor of Science, Bachelor of Laws and Master of Laws. He is a solicitor and Australian Registered Migration Agent. Julian provides specialist legal advice to Dizon & Associates on complex migration matters at the Administrative Appeals Tribunal and Federal Court.<br>

                                Julian is a second-generation Australian of Hungarian and Irish descent.</p>
                                <div class="about-profile">
                                    <img src="/images/about-us/abt-3.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="aboutus-card-outer aboutcard_align">
                            <div class="about-us-cards">
                                <span class="profile-posts">CLIENT SERVICES</span>
                                <h2 class="mb-3">Marie Macdonald</h2>
                                <p>Marie holds vocational certificates in Business & Financial Services, Education and Aged Care. She has worked across several industries in a variety of office management and administrative roles. Marie is responsible for preparing and completing client applications and file management. She is of Australian descent.</p>
                                <div class="about-profile">
                                    <img src="/images/about-us/abt_4.jpg" alt="">
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="container-fluid">
                <div class="about-us-bg about_us_section">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-md-8">
                                <h2 class="mb-3 text-white">We Speak the Language of Immigration.</h2>
                                <div class="mt-4">
                                    <Link class="main-btn" :href="route('contact.us')">Contact Us</Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="login-bg-wrapper pb-0 internationa_partners">
                <div class="container">
                    <h1 class="mb-2 text-blue text-center">Our International Partners</h1>
                    <div class="grid lg:grid-cols-2 grid-cols-1 gap-5 about-section-cards login-bg-wrapper">
                        <div class="aboutus-card-outer">
                            <div class="about-us-cards">
                                <span class="profile-posts">VERBATUM CONSULTANCY</span>
                                <h2 class="mb-3">Lorie Selga Ferdinand Tercero</h2>
                                <p>Verbatum Consultancy and Proficiency Center Co. has worked with Dizon & Associates to help assist Filipinos secure their Australian visas and permanent residency. Lorie and Ferdinand are the co-owners of the Philippines based company. Both Lorie Ann and Ferdinand  hold Bachelor of Science in Nursing degrees and are registered nurses in the Philippines. Lorie Ann is the operations manager and Ferdinand heads the sales and marketing division. </p>
                                <div class="about-profile">
                                    <img src="/images/about-us/abt_1.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="aboutus-card-outer">
                            <div class="about-us-cards">
                                <span class="profile-posts">STEVENS & ASSOCIATES</span>
                                <h2 class="mb-3">Don Stevens</h2>
                                <p>Based in Vancouver, Stevens and Associates has been assisting suitably qualified persons to migrate to Canada since 1989. Don Stevens is a Regulated Canadian Immigration Consultant (RCIC) and has been in practice for over 30 years. Stevens and Associates works together with Dizon & Associates as counterparts in Canadian, Australian and New Zealand immigration services.</p>
                                <div class="about-profile">
                                    <img src="/images/about-us/abt-2.jpg" alt="">
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
