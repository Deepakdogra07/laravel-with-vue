<script setup>
import Header from '@/Pages/Frontend/Header.vue'
import Footer from '@/Pages/Frontend/Footer.vue'
import SubHeading from '@/Pages/Frontend/SubHeading.vue'
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    jobs: {
        type: Array
    },
    applied_jobs:{
        type:Array
    },
    industry:{
        type:String
    },
    user:{
        type:Object
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
        <div class="container about-width">
            <div class="industryFilter" v-if="industry">
                <span class="industry-data list_job_category forms-btn mb-4">
                    {{ industry }}
                   <Link :href="route('job.listing')" class="text-dark"><i class="fas fa-times"></i></Link>
                </span>
            </div>
            
            <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-3  mt-2" v-if="jobs.data.length > 0"  >
                <div class="job-listing-cards relative" v-for="(job) in jobs.data" :key="job.id">
                    <div class="update-time absolute top-4 right-4">
                        <i class="bi bi-clock-fill"></i>
                        <p class="mb-0" v-html="dateTime(job?.created_at)"></p>
                    </div>
                    <div class="card-img">
                        <Link :href="`/view-job/${job.id}`"><img :src="job.job_image" alt=""></Link>
                    </div>
                    <div class="cards-content">
                        <Link :href="`/view-job/${job.id}`"><h2>{{ job?.job_title }}</h2></Link>
                        <p class="my-3 listing_txt"><span class="text-red"><i class="bi bi-geo-alt-fill pr-1"></i></span>
                            Chandigarh, India</p>
                        <div class="cards-bio">
                            <Link :href="`/view-job/${job.id}`"><p>{{ job?.posting_summary }}</p></Link>
                        </div>
                        <div class="row mt-3 buttons_div">
                            <div class=" col-6 login-btn-main">
                                <Link :href="`/view-job/${job.id}`" class="forms-btn w-100">View Job <span> <i
                                        class="bi bi-arrow-right"></i></span></Link>
                            </div>
                            <div class="col-6 login-btn-main" v-if="user?.id != job.user_id">
                                
                                <button v-if="applied_jobs.length > 0 && applied_jobs.includes(job.id)" disabled class="forms-btn-transparent w-100">Already Applied
                                </button>
                                <Link v-else class="forms-btn-transparent w-100" :href="route('travel.details',job.id)" >Apply Now <span> <i
                                        class="bi bi-arrow-right"></i></span></Link>
                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="login-bg-wrapper 403_error_main">
                <div class="container">
                    <div   class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-3 403_page_top" >
                        <h1 style="text-align: center;color: #09332B;"> No Records Found</h1>
                    </div>
                </div>
            </div>
            <div v-if="jobs.links.length > 3" >
                <div class="d-flex justify-content-center w-100 mt-3 job_listing_button">
                    <div class="flex  mt-2 mb-1 job_listing_inner">
                        <template v-for="(link, p) in jobs.links" :key="p">
                            <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 rounded prevoius_left"
                                v-html="link.label" />
                            <Link v-else
                                class="mr-1 mb-1 px-4 py-3 text-sm leading-4 rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500 previous_next_btn"
                                :class="{ 'bg-blue-700 text-white': link.active }" :href="link.url" v-html="link.label" />
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Footer />
</template>

<style scoped>
.industry-data{
    border: 1px solid #09332b;
    border-radius: 8px;
    padding: 8px 20px 8px 20px;
    display: flex;
    align-items: center;
    gap: 20px;
    width: fit-content;
}
</style>