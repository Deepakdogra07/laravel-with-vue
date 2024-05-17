<script setup>
import Header from '@/Pages/Frontend/Header.vue'
import Footer from '@/Pages/Frontend/Footer.vue'
import SubHeading from '@/Pages/Frontend/SubHeading.vue'
import { Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const props = defineProps({
    job : {
        type:Object
    },
    created_time:{
        type:String
    },
    skills:{
        type:Array
    },
    languages:{
        type:Array
    }
})
function job_description(description){
    var job_description = description;
    return job_description;
}
const skills = ref(''),
language = ref('');
onMounted( () => {
  props.skills.forEach(element => {
    if(props.job.skills_id.includes(element.id)){
        skills.value += element.name +',';
    }
  });
  props.languages.forEach(element => {
    if(props.job.language_id.includes(element.id)){
        language.value += element.name +',';
    }
  });
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
                    <div class=" col-md-4 view-job-btn mt-5">
                        <Link :href="`/job-introduction?job_id=${job.id}`" class="forms-btn w-100">Apply Job <span> <i
                                class="bi bi-arrow-right"></i></span></Link>
                    </div>
                </div>
            </div>

            <div class="job-detail-content mt-4">
                <div class="container">
                    <div class="row">

                        <div class="col-md-12 col-12">
                            <div class="Details">
                                <h2>Details:</h2>
                                <b>Position type</b>: <span>{{ job.position.name }}</span><br>
                                <b>Seniority</b>:<span>{{ job.seniority.name }}</span><br>
                                <b>Discipline</b>:<span>{{ job.discipline.name }}</span><br>
                                <b>Overall work experience</b>:<span>{{ job.work_experience.experience }}</span><br>
                                <b>Skills</b>:<span>{{ skills }}</span><br>
                                <b>Languages</b>:<span>{{ language }}</span><br>
                                <b>City</b>:<span>{{ job.city }}</span><br>
                                <b>Postal Code</b>:<span>{{ job.pin_code }}</span><br>
                                <b>Remote Work</b>:<span>{{ job.remote_work }}</span><br>
                                <b>Industry</b>:<span>{{ job.industry.name }}</span><br>
                                <b>Segment</b>:<span>{{ job.segment }}</span><br>
                                <b>Positions</b>:<span>{{ job.positions }}</span><br>
                                <b>Minimum and Maximum Salary</b>:<span>{{ job.min_pay_range }} - {{ job.max_pay_range }}</span><br>
                                <b>Start Date</b>:<span>{{ job.job_start_date }}</span><br>
                            </div>
                            <!-- <h2 class="mb-2 semibold">Details of the job</h2> -->
                            <div v-html="job_description(job.job_description)"></div>
                            
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