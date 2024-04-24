<script setup>
    import Header from '@/Pages/Frontend/Header.vue'
    import Footer from '@/Pages/Frontend/Footer.vue'
    import SubHeading from '@/Pages/Frontend/SubHeading.vue'
    import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Header />
    <SubHeading />
    <div class="login-bg-wrapper">
        <div class="container">
            <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-3">
                <div class="job-listing-cards relative">
                    <div class="update-time absolute top-4 right-4">
                        <i class="bi bi-clock-fill"></i>
                        <p class="mb-0">2 hours ago...</p>
                    </div>
                    <div class="card-img">
                        <Link><img src="/images/australia.jpg" alt=""></Link>
                    </div>
                    <div class="cards-content">
                        <h2>Female Senior Graphic Designer</h2>
                        <p class="my-3"><span class="text-red"><i class="bi bi-geo-alt-fill pr-1"></i></span> Chandigarh, India</p>
                        <div class="cards-bio">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text....</p>
                        </div>
                        <div class="row mt-3">
                            <div class=" col-md-6 login-btn-main">
                                <Link href="/view-job" class="forms-btn w-100">View Job <span> <i class="bi bi-arrow-right"></i></span></Link>
                            </div>
                            <div class="col-md-6 login-btn-main">
                                <Link class="forms-btn-transparent w-100">Apply Now <span> <i class="bi bi-arrow-right"></i></span></Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Footer />
</template>