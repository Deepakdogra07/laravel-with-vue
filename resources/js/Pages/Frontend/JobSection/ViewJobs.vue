<script setup>
import Header from '@/Pages/Frontend/Header.vue'
import Footer from '@/Pages/Frontend/Footer.vue'
import SubHeading from '@/Pages/Frontend/SubHeading.vue'
import { Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import moment from 'moment';

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
    },
    industries:{
        type:Array
    },
    applied_jobs:{
        type:Array
    },
    user:{
        type:Object,
    }
})
function job_description(description){
    var job_description = description;
    return job_description;
}
const skills = ref(''),
language = ref(''),
industry = ref('');
onMounted( () => {
    const skillNames = [];
  props.skills.forEach(element => {
    if(props.job.skills_id.includes(element.id)){
        skillNames.push(element.name);
    }
  });
  skills.value = skillNames.join(',');
  const languagesArray = [];
  props.languages.forEach(element => {
    if(props.job.language_id.includes(element.id)){
        languagesArray.push(element.name);
    }
  });

  language.value = languagesArray.join(',');
  const indusArray = [];
  props.industries.forEach(element => {
    if(props.job.industry_id.includes(element.id)){
        indusArray.push(element.name)
    }
});
industry.value += indusArray.join(',');
});
const job_start_date = moment(props.job.job_start_date).format('DD/MMMM/YYYY');
console.log(job_start_date)
</script>

<template>
    <Header />
    <SubHeading />
    <div class="login-bg-wrapper job-detail-page">
        <div class="container about-width p-0 business_job_wrap">
            <p class="mb-0" style="display:inline-block;"><Link :href="route('job.listing')" class="step-form-back forms-btn-transparent mb-4"><i class="bi bi-arrow-left"></i>Back</Link></p>
            <div class="row align-items-start">
                <div class="col-md-5">
                    <div class="view-main-image">
                        <img :src="job.job_image" alt="">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="view-main-images pt-4">
                        <h2 class="semibold mb-3 pl-2">{{ props.job.job_title }}</h2>
                        <p class="my-3 text_job pl-2"><span class="text-red"><i class="bi bi-geo-alt-fill pr-1"></i></span> {{ job?.city }}, {{ job?.job_country }}</p>
                        <div class="update-time  ml-2" style="display: inline-flex;">
                            <i class="bi bi-clock-fill"></i>
                            <p class="mb-0">{{ created_time }}...</p>
                        </div>
                        <div class="col-md-4 view-job-btn mt-4 ml-2" v-if="user?.id != job.user_id">
                            <button v-if="applied_jobs.length > 0 && applied_jobs.includes(job.id)" class="forms-btn-transparent w-100" disabled>Already Applied
                                    </button>
                                    <Link v-else class="forms-btn w-100" :href="route('travel.details',job.id)" >Apply Now <span> <i
                                            class="bi bi-arrow-right"></i></span></Link>
                            <!-- <Link :href="route('travel.details',job.id)" class="forms-btn w-100">Apply Job <span> <i
                                    class="bi bi-arrow-right"></i></span></Link> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="job-detail-content job_details_cnt mt-4">
                <div class="container p-0 Details_wrap_z">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="Details">
                                <h2>Details</h2>
                                <ul class="details_lists pl-0">
                                    <li><b>Position type</b> <span>{{ job?.position?.name }}</span></li>
                                    <li><b>Seniority</b><span>{{ job?.seniority?.name }}</span></li>
                                    <li><b>Discipline</b><span>{{ job?.discipline?.name }}</span></li>
                                    <li><b>Overall work experience</b><span>{{ job?.work_experience?.experience }}</span></li>
                                    <li><b>Skills</b><span>{{ skills }}</span></li>
                                    <li><b>Languages</b><span>{{ language }}</span></li>
                                    <li><b>City</b><span>{{ job.city }}</span></li>
                                    <li><b>Postal Code</b><span>{{ job.pin_code }}</span></li>
                                    <li><b>Remote Work</b><span>{{ (job.remote_work !=0) ? job.remote_work:'No' }}</span></li>
                                    <li><b>Industry</b><span>{{ industry }}</span></li>
                                    <li><b>Segment</b><span>{{ job.segment }}</span></li>
                                    <li><b>Positions</b><span>{{ job.positions }}</span></li>
                                    <li><b>Minimum and Maximum Salary</b><span>{{ job.min_pay_range }} - {{ job.max_pay_range }}</span></li>
                                    <li><b>Start Date</b><span>{{ job_start_date }}</span></li>
                                </ul>
                            </div>
                            <div class="job_col2">
                                <h2 class="mb-2 semibold">Details of the job</h2>
                                <div v-html="job_description(job.job_description)"></div>
                                <div class="conditions">
                                <h2 class="mb-2 semibold">Posting Summary:</h2>
                                <div v-html="(job.posting_summary)"></div>
                            </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="conditions">
                                <h2>Conditions</h2>
                                <p><div v-html="(job.conditions)"></div></p>
                            </div>
                            <div class="requirement">
                                <h2>Requirements</h2>
                                <p><div v-html="(job.requirements)"></div></p>
                            </div>
                            <div class="compnay_box">
                                <div class="compnay_box_inner">
                                    <div class="company-section">
                                        <h3 class="mb-2">Company</h3>
                                        <div class="d-flex align-items-center mt-3 gap-4">
                                            <div class="company-logo">
                                                <img src="/images/buildings1.png" alt="">
                                            </div>  
                                            <div class="company-name-loaction">
                                                <h3 class="mb-1 semibold">{{ job?.business?.company_name }}</h3>
                                                <p class="mb-0"><span class="text-red"><i class="bi bi-geo-alt-fill pr-1"></i></span> {{ job?.city }},
                                                    {{ job?.job_country }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <!-- <div class="col-md-12 col-12 ">                        
                             <h2 class="mb-2 semibold">Details of the job</h2> 
                            <div class="Posting_Summary">
                                <h2>Posting Summary:</h2>
                                <div v-html="(job.posting_summary)"></div>
                            </div>
                        </div> -->
                       
                    </div>
                </div>
            </div>

        </div>
    </div>
    <Footer />
</template>