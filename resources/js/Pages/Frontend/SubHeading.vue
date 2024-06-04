<script setup>
import { Link } from '@inertiajs/vue3';
const props=defineProps({
    job_id:{
        type:Number,
        required:true,
        default:0
    },
    data:{
        type:Object,
        required:true,
    },
    testimonial_id:{
        type:Number,
        required:true,
        default:0
    }
})
// console.log(route().current('business_job_for_customers',props.job_id),route().current());

</script>
<template>
    <div class="container-fluid subheading_Sec">
        <div class="sub-heading-section" :class="{'!pb-[50px]' : !route().current('login') || !route().current('password.request')}">
            <div class="container subheading_cn">
                <h1 class="mb-0" v-if="route().current('login') || route().current('password.request') || route().current('password.reset') ">Welcome to Login</h1>
                <h1 class="mb-0" v-if="route().current('job.listing') || route().current('view.job')">List of Jobs</h1>
                <h1 class="mb-0" v-if="route().current('register')">Create New Account For Business</h1>
                <h1 class="mb-0" v-if="route().current('contact.us')">Contact us</h1>
                <h1 class="mb-0" v-if="route().current('about.us')">About us</h1>
                <h1 class="mb-0" v-if="route().current('business-jobs.create')">Job Posting</h1>
                <h1 class="mb-0" v-if="route().current('business-jobs.edit',job_id)">Edit Job Posting</h1>
                <h1 class="mb-0" v-if="route().current('testimonial.main') || route().current('show.testimonial',testimonial_id)">Testimonial</h1>
                <h1 class="mb-0" v-if="route().current('job.introduction') || route().current('employment.details') || route().current('document.details')">Your Application Guide</h1>
                <h1 class="mb-0" v-if="route().current('travel.details') || route().current('personal.details')">Questions</h1>
                <h1 class="mb-0" v-if="route().current('term.condition')">Terms and Conditions</h1>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="form-navigation login_nav" v-if="route().current('login') || route().current('password.request') || route().current('register') || route().current('password.reset')">
            <div class="container login_inner_cn">
                <ul class="row nav-underline pl-0 mb-0 second_navbar">
                    <div class="col-md-1 col-3 column_nav_one">
                        <li class="nav-item">
                            <Link class="nav-link text-center" 
                                :class="{ 'active': route().current('login') || route().current('password.request') }" 
                                aria-current="page" 
                                :href="route('login')"
                            >Login</Link>
                        </li>
                    </div>
                    <div class="col-lg-2 col-md-3 col-5 column_nav_two">
                        <li class="nav-item">
                            <Link class="nav-link text-center"  
                                :class="{ 'active': route().current('register') }"  
                                :href="route('register')"
                            >Create account</Link>
                        </li>
                    </div>
                </ul>
            </div>
        </div>

        <div class="form-navigation" v-else-if="route().current('job.introduction') || route().current('employment.details') || route().current('document.details')">
            <div class="container">
                <ul class="row nav-underline pl-0 mb-0">
                    <div class="col-md-2 col-4">
                        <li class="nav-item">
                            <Link href="/job-introduction" class="nav-link text-center" 
                                :class="{ 'active': route().current('job.introduction') }" 
                            >Introduction</Link>
                        </li>
                    </div>
                    <div class="col-lg-2 col-md-3 col-4">
                        <li class="nav-item">
                            <Link :href="`/employment-details/${job_id}`" class="nav-link text-center"  
                                :class="{ 'active': route().current('employment.details') }"  
                            >Employment</Link>
                        </li>
                    </div>
                    <div class="col-lg-2 col-md-3 col-4">
                        <li class="nav-item">
                            <Link :href="`/document-details/${data?.job_id}/${data?.customer_id}`" class="nav-link text-center"  
                                :class="{ 'active': route().current('document.details') }"  
                            >Document</Link>
                        </li>
                    </div>
                </ul>
            </div>
        </div>

        <div class="form-navigation" v-else-if="route().current('travel.details') || route().current('personal.details')">
            
            <div class="container">
                <ul class="row nav-underline pl-0 mb-0">
                    <div class="col-lg-2 col-md-3 col-5">
                        <li class="nav-item">
                            <Link :href="`/travel-details/${job_id}`" class="nav-link text-center" :class="{ 'active': route().current('travel.details') }">Travel details </Link>
                        </li>
                    </div>
                    <div class="col-lg-2 col-md-3 col-5">
                        <li class="nav-item">
                            <Link :href="`/personal-details/${job_id}`"  class="nav-link text-center"  :class="{ 'active': route().current('personal.details') }">Personal details</Link>
                        </li>
                    </div>
                </ul>
            </div>
        </div>
        <!-- v-if="$page.props.auth.user.user_type <= 2" -->

        <div class="form-navigation"  v-else-if="route().current('business_job_for_customers')  || route().current('business-jobs.show',job_id)"  >
            <div class="container">
                <ul class="row nav-underline pl-0 mb-0">
                    <div class="col-lg-2 col-md-3 col-5">
                        <li class="nav-item">
                          
                            <Link :href="route('business-jobs.show',job_id)" class="nav-link text-center" :class="{ 'active': route().current('business-jobs.show',job_id) }">Jobs</Link>
                        </li>
                    </div>
                    <div class="col-lg-2 col-md-3 col-5">
                        <li class="nav-item">
                            <Link :href="route('business_job_for_customers',job_id)" class="nav-link text-center"  :class="{ 'active': route().current('business_job_for_customers') }">Employees</Link>
                        </li>
                    </div>
                </ul>
            </div>
        </div>
    </div>
</template>

<style scoped>

.sub-heading-section h1{
    color: #fff;
    font-size: 40px !important;
}

.form-navigation li a{
    font-size: 18px !important;
}

@media(max-width: 992px){
    .sub-heading-section h1{
        font-size: 30px !important;
    }
}

</style>