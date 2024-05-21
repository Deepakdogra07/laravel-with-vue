<script setup>
import Header from '@/Pages/Frontend/Header.vue'
import Footer from '@/Pages/Frontend/Footer.vue'
import SubHeading from '@/Pages/Frontend/SubHeading.vue'
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    jobs: {
        type: Array
    }
})
function dateTime(created_at) {
    const currentDateTime = new Date();
    const jobCreatedAt = new Date(created_at);

    // Calculate the difference in milliseconds
    const diffInMs = currentDateTime - jobCreatedAt;
    const diffInMinutes = Math.floor(diffInMs / (1000 * 60));
    const diffInHours = Math.floor(diffInMs / (1000 * 60 * 60));
    const diffInDays = Math.floor(diffInMs / (1000 * 60 * 60 * 24));

    let time = '';
    if (diffInDays > 0) {
        time = `${diffInDays} days ago...`;
    } else if (diffInHours > 0) {
        time = `${diffInHours} hours ago...`;
    } else if (diffInMinutes > 0) {
        time = `${diffInMinutes} minutes ago...`;
    } else {
        time = 'Just now...';
    }

    return time;
}
</script>
<template>
    <Header />
    <SubHeading />
    <div class="login-bg-wrapper list_of_jobs">
        <div class="container">
            <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-3" >
                <div class="job-listing-cards relative" v-if="jobs.length > 0" v-for="(job) in props.jobs" :key="job.id">
                    <div class="update-time absolute top-4 right-4">
                        <i class="bi bi-clock-fill"></i>
                        <p class="mb-0" v-html="dateTime(job?.created_at)"></p>
                    </div>
                    <div class="card-img">
                        <Link><img :src="job.job_image" alt=""></Link>
                    </div>
                    <div class="cards-content">
                        <h2>{{ job?.job_title }}</h2>
                        <p class="my-3"><span class="text-red"><i class="bi bi-geo-alt-fill pr-1"></i></span>
                            Chandigarh, India</p>
                        <div class="cards-bio">
                            <p>{{ job?.posting_summary }}</p>
                        </div>
                        <div class="row mt-3 buttons_div">
                            <div class=" col-md-6 login-btn-main">
                                <Link :href="`/view-job/${job.id}`" class="forms-btn w-100">View Job <span> <i
                                        class="bi bi-arrow-right"></i></span></Link>
                            </div>
                            <div class="col-md-6 login-btn-main">
                                <Link class="forms-btn-transparent w-100" :href="`/job-introduction?job_id=${job.id}`">Apply Now <span> <i
                                        class="bi bi-arrow-right"></i></span></Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Footer />
</template>