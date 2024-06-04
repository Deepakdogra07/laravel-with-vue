<script setup>
import Header from '@/Pages/Frontend/Header.vue'
import Footer from '@/Pages/Frontend/Footer.vue'
import SubHeading from '@/Pages/Frontend/SubHeading.vue'
import { Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import moment from 'moment';
import { Country } from 'country-state-city';


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
    }
})

const skill = ref(''),
language = ref(''),
industry = ref('');

onMounted( () => {
    const skillNames = [];
  props.skills.forEach(element => {
    if(props.job.skills_id.includes(element.id)){
        skillNames.push(element.name);
    }
  });
  skill.value = skillNames.join(',');
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
industry.value = indusArray.join(',');
});
const business_country = Country.getCountryByCode(props?.job?.business?.company_country_code);
const recommended_skills = sepratedString(props?.job?.recommended_skills);
function sepratedString(recommended_skills){
    let array = JSON.parse(recommended_skills);
    return array.join(", ");
}

const job_start_date = moment(props.job.job_start_date).format('DD/MMMM/YYYY');


function job_description(description){
    var job_description = description;
    return job_description;
}
</script>

<template>
    <Header />
    <SubHeading :job_id="job.id"/>
    <!-- <div class="main-outer-section">
        <div class="job-list-search">
            <div class="container">
                <div class="d-flex justify-between align-items-center flex-wrap gap-3 relative">
                    <div class="login-section-mob absolute top-0 right-0">
                        <Link class="btn btn-sm btn-success text-white" :href="route('business-jobs.create')">Add job</Link>
                    </div>
                    <div class="d-flex gap-5 align-items-center">
                        <Link class='active-nav'>Jobs</Link>
                        <Link>Employee</Link>
                    </div> 
                    
                    <div class="relative">
                        <i class="bi bi-search absolute top-[50%] left-[15px] translate-y-[-50%]"></i>
                        <input type="search" class="user-dashboard-search" placeholder="Search employee">
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="login-bg-wrapper job-detail-page Business_details_page">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="view-main-image">
                        <img :src="job.job_image" alt="">
                    </div>
                </div>
                <div class="col-md-7">
                    <h2 class="semibold mb-3">{{ props.job.job_title }}</h2>
                    <p class="my-3 text_job"><span class="text-red"><i class="bi bi-geo-alt-fill pr-1"></i></span> {{ job?.city }}, {{ job?.job_country }}</p>
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

            <div class="job-detail-content job_details_cnt mt-4">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="Details">
                                <h2>Details</h2>
                                <ul class="details_lists pl-0">
                                    <li><b>Position type</b> <span>{{ job?.position?.name }}</span></li>
                                    <li><b>Seniority</b><span>{{ job?.seniority?.name }}</span></li>
                                    <li><b>Discipline</b><span>{{ job?.discipline?.name }}</span></li>
                                    <li><b>Overall work experience</b><span>{{ job?.work_experience?.experience }}</span></li>
                                    <li><b>Recommended Skills</b><span>{{ recommended_skills }}</span></li>
                                    <li><b>Skills</b><span>{{ skill }}</span></li>
                                    <li><b>Languages</b><span>{{ language }}</span></li>
                                    <li><b>Postal Code</b><span>{{ job.pin_code }}</span></li>
                                    <li><b>Remote Work</b><span>{{ (job.remote_work !=0) ? job.remote_work:'-' }}</span></li>
                                    <li><b>Industry</b><span>{{ industry }}</span></li>
                                    <li><b>Segment</b><span>{{ job.segment }}</span></li>
                                    <li><b>Positions</b><span>{{ job.positions }}</span></li>
                                    <li><b>Min and Max Salary</b><span>{{ job.min_pay_range }} - {{ job.max_pay_range }}</span></li>
                                    <li><b>Start Date</b><span>{{ job_start_date }}</span></li>
                                    <li><b>City</b><span>{{ job.city }}</span></li>
                                    <li><b>Country</b><span>{{ job?.job_country }}</span></li>
                                </ul>
                            </div>
                            <div class="job_col2">
                                <h2 class="mb-2 semibold">Details of the job</h2>
                                <div v-html="job_description(job.job_description)"></div>
                                <div class="Posting_Summary">
                                <!-- <h2>Posting Summary:</h2> -->
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
                                                <p class="mb-0"><span class="text-red"><i class="bi bi-geo-alt-fill pr-1"></i></span> {{ job?.business?.company_city }},
                                                    {{ business_country?.name }}</p>
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