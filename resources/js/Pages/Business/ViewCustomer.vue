<script setup>
import 'vue3-toastify/dist/index.css';
import Header from '@/Pages/Frontend/Header.vue'
import Footer from '@/Pages/Frontend/Footer.vue'
import SubHeading from '@/Pages/Frontend/SubHeading.vue'
import { Link } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';
import fslightbox from 'fslightbox';
const props = defineProps({
    customer:{
        type:Object
    },
    user_type:{
        type:Number,
        default:0
    }
});
function getLast_name(name){
    let filename = '';
    if(name){
        const lastSlashPosition = name.lastIndexOf('/');
        if (lastSlashPosition !== -1) {
            filename = name.substring(lastSlashPosition + 1);
          } else {
            filename = 'No Data Available';
          }
    }
    return filename;
}


const lightbox = reactive({
      toggler: false,
      sources: []
    });
function toggler(type,source){
    lightbox.toggler = type;
    lightbox.sources = [source];
}


</script>

<template>
    <Header />
    <div v-if="user_type < 3 ">
        <div class="job-list-search srch_responsive business_srccc view_customer_listings">
            <div class="container about-width">
                <div class="d-flex justify-between align-items-center flex-wrap gap-3 relative">
                    <div class="d-flex gap-5 align-items-center srch_navbar">
                        <Link :href="route('business-jobs.index')">Jobs</Link>
                        <Link :href="route('business-dash')" class='active-nav'>Employees</Link>
                        <Link :href="route('applied-business-jobs')">Applied Jobs</Link>
                    </div>
                </div>
                 </div>
                </div>
            </div>
            <div v-else>
                <SubHeading :customer_id="customer.id"/>        
     </div>
    <section class="view_customer_wrapper">
        <div class="container py-12 view_customer_inner">
            <div class="inner_spacing_wrapper">
                <div class="customer_card pb-4">
                    <div class="card-image">
                        <img :src="customer.customer_image" alt="" width="450px" >   
                    </div>
                    <div class="inner_card_wrapper">
                        <h1>{{ customer.first_name }} {{ customer.last_name }}</h1>
                            <div class="card-body">
                                <!-- <h2>Other Details:</h2> -->
                                <p><b>Date of Birth</b><span class="travel_inner">{{ customer.date_of_birth }}</span></p>
                                <p><b>County of birth</b><span class="travel_inner">{{ customer.country_of_birth }}</span></p>
                                <p><b>City of birth</b><span class="travel_inner">{{ customer.city_of_birth }}</span></p>
                                <p><b>martial_status</b><span class="travel_inner">{{ (customer.martial_status) ? 'Married':'Unmarried' }}</span></p>
                                <p><b>Country to immigrate</b><span class="travel_inner">{{ customer.migrate_country }}</span></p>
                                <p><b>Gender</b><span class="travel_inner">{{ (customer.gender == 0) ? 'Male' : 'Female' }}</span></p>
                            </div>
                    </div>   
                </div> 
                <Link :href="route('downloadZip',customer.id)" class="btn btn-primary btn-sm"> Download</Link>
                <div class="pass_travel_details_wrapper border-top border-bottom">
                    <div class="row">
                        <div class="col-xl-6 xol-lg-6 col-md-12 col-sm-12 p-0">
                            <div class="Travel_details">
                                <h2>Travel Details</h2>
                                <div class="card-body">
                                    <p><b>Purpose of stay</b><span class="travel_inner">{{ customer?.travel_details?.purpose_of_stay }}</span></p>
                                    <p><b>Type of visa</b><span class="travel_inner">{{ customer?.travel_details?.type_of_visa }}</span></p>
                                    <p><b>Date of travel</b><span class="travel_inner">{{ customer?.travel_details?.date_of_travel }}</span></p>
                                    <p><b>Passenger nationality </b><span class="travel_inner">{{ customer?.travel_details?.passenger_nationality }}</span></p>
                                    <p><b>Port of arrival</b><span class="travel_inner">{{ customer?.travel_details?.port_of_arrival }}</span></p>
                                </div>
                            </div> 
                        </div>
                        <div class="col-xl-6 xol-lg-6 col-md-12 col-sm-12 p-0">
                            <div class="Travel_details passport_details">
                                <h2>Passport details</h2>
                                <div class="card-body">
                                    <p><b>Passport number</b><span class="travel_inner">{{ customer?.passport_number }}</span></p>
                                    <p><b>Issuing authority</b><span class="travel_inner">{{ customer?.issuing_authority }}</span></p>
                                    <p><b>Citizen of more than one country</b><span class="travel_inner">{{ customer.citizen_of_more_than_one_country == 0 ? 'No': 'Yes' }} </span></p>
                                    <p><b>Have you ever obtained an visa using current or previous passport? </b><span class="travel_inner">{{ customer.visa_available == 0 ? 'No': 'Yes' }}</span></p>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div> 
                <div class="video_image_wrapper pt-5 mbile_padding">
                    <h2>Videos</h2>
                    <div class="row">
                        <div class="col column_width">
                            <div class="img_inner_wrapper ">
                                <div class="img_overlay relative">
                                    <!-- <img scr="http://127.0.0.1:8000/storage/categories/664722250a432_1715937829_.png"> -->
                                     <video :src="customer?.documents?.kitchen_area" controls></video>
                                    <!-- <div class="video_icon absolute w-100">
                                        <i class="fas fa-play-circle"></i>
                                    </div> -->
                                </div>
                                <div class="wrapper_name">
                                    <a :href="customer?.documents?.kitchen_area" target="_blank" download="kitchenArea"> <p class="mb-0 text-white text-center"  v-html="getLast_name(customer?.documents?.kitchen_area)"></p></a>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col column_width">
                            <div class="img_inner_wrapper ">
                                <div class="img_overlay relative">
                                    <!-- <img src="http://127.0.0.1:8000/storage/categories/664722250a432_1715937829_.png"> -->
                                    <video :src="customer?.documents?.ingredients" controls></video>
                                    <!-- <div class="video_icon absolute w-100">
                                        <i class="fas fa-play-circle"></i>
                                    </div> -->
                                </div>
                                <div class="wrapper_name">
                                    <a :href="customer?.documents?.ingredients" target="_blank" download="ingredients">
                                        <p class="mb-0 text-white text-center"  v-html="getLast_name(customer?.documents?.ingredients)"></p>
                                    </a> 
                                </div>
                                
                            </div>
                        </div>
                        <div class="col column_width">
                            <div class="img_inner_wrapper ">
                                <div class="img_overlay relative">
                                    <!-- <img scr="http://127.0.0.1:8000/storage/categories/664722250a432_1715937829_.png"> -->
                                    <video :src="customer?.documents?.cooking_tech" controls></video>
                                    <!-- <div class="video_icon absolute w-100">
                                        <i class="fas fa-play-circle"></i>
                                    </div> -->
                                </div>
                                <div class="wrapper_name">
                                    <a :href="customer?.documents?.cooking_tech" target="_blank" download="cookingTechnique">
                                    <p class="mb-0 text-white text-center" v-html="getLast_name(customer?.documents?.cooking_tech)"></p>
                                    </a>
                                </div>
                                
                            </div>
                        </div>
                        <!-- {{ customer }} -->
                        <div class="col column_width">
                            <div class="img_inner_wrapper ">
                                <div class="img_overlay relative">
                                    <video :src="customer?.documents?.dish" controls></video>
                                    <!-- <div class="video_icon absolute w-100">
                                        <i class="fas fa-play-circle"></i>
                                    </div> -->
                                </div>
                                <div class="wrapper_name">
                                    <a :href="customer?.documents?.dish"  target="_blank" download="dish">
                                    <p class="mb-0 text-white text-center" v-html="getLast_name(customer?.documents?.dish)"></p>
                                    </a>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col column_width">
                            <div class="img_inner_wrapper ">
                                <div class="img_overlay relative">
                                    <video :src="customer?.documents?.clean_up" controls></video>
                                </div>
                                <div class="wrapper_name">
                                    <a :href="customer?.documents?.cleanup"  target="_blank" download="cleanup">
                                    <p class="mb-0 text-white text-center" v-html="getLast_name(customer?.documents?.clean_up)"></p>
                                    </a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="video_image_wrapper ">
                    <h2>Image</h2>
                    <div class="row">
                        <div class="col column_width">
                            <div class="img_inner_wrapper">
                                <img :src="customer?.employments?.evidence_self_employment_aus">
                                <div class="wrapper_name">
                                    <a :href="customer?.documents?.evidence_self_employment_aus" target="_blank" download="ausSelf">
                                    <p class="mb-0 text-white text-center" v-html="getLast_name(customer?.employments?.evidence_self_employment_aus)"></p>
                                </a>
                                </div>
                            </div>
                        </div>
                        <div class="col column_width">
                        </div>
                        <div class="col column_width">
                        </div>
                    </div>
                </div>      
                <div class="video_image_wrapper text_over_flow">
                    <div class="row">
                        <div class="col column_width column_mine_width">
                                <H2>Passport</H2>
                                <div class="img_inner_wrapper">
                                <img :src="customer?.customer_image">
                                <div class="wrapper_name">
                                    <p class="mb-0 text-white text-center" v-html="getLast_name(customer?.customer_image)"></p>
                                    <a :href="customer?.customer_image" target="_blank" download="passport">
                                    <img src="/images/download-icon.svg" alt="download" class="download-icon" >
                                    </a>
                                </div>
                            </div>
                            </div>
                        <!-- <div class="col col-one">
                            <h2>Passport</h2>
                            <div class="img_inner_wrapper">
                                 <img :src="customer.passport_image" alt=" No image">
                                <div class="wrapper_name">
                                    <p class="mb-0 text-white text-center">{{ customer.passport_image }}</p>
                                </div>
                            </div>
                        </div> -->
                        <div class="col col-two">
                            <h2>Employer statement</h2>
                            <div class="img_inner_wrapper">
                                <img :src="customer?.employments?.employer_statement" @click="toggler('employer_statement',customer?.employments?.employer_statement)">
                                <div class="wrapper_name">
                                    <p class="mb-0 text-white text-center" v-html="getLast_name(customer?.employments?.employer_statement)"></p>
                                    <a :href="customer?.employments?.employer_statement" target="_blank" download="EmployerStatement">
                                    <img src="/images/download-icon.svg" alt="download" class="download-icon" >
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col col-three">
                            <h2>Financial evidence</h2>
                            <div class="img_inner_wrapper">
                                <img :src="customer?.employments?.financial_evidence">
                                <div class="wrapper_name">
                                        <p class="mb-0 text-white text-center" v-html="getLast_name(customer?.employments?.financial_evidence)" ></p>
                                         <a :href="customer?.employments?.financial_evidence" target="_blank" download="FinancialEvidence">
                                        <img src="/images/download-icon.svg" alt="download" class="download-icon" >
                                        </a>
                                </div>
                            </div>
                        </div>
                        <div class="col col-four text-full-block">
                            <h2>Evidence of self-employment</h2>
                                    <div class="img_inner_wrapper">
                                        <img :src="customer?.employments?.formal_training_evidence">
                                        <div class="wrapper_name">
                                            <p class="mb-0 text-white text-center"  v-html="getLast_name(customer?.employments?.formal_training_evidence)" ></p>
                                            <a :href="customer?.employments?.formal_training_evidence" target="_blank" download="TrainingEvidence">
                                                <img src="/images/download-icon.svg" alt="download" class="download-icon" >
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col column_width col-five">
                                    <h2 style="visibility: hidden;" class="mobile_none">Evidence of self-employment</h2>
                                    <div class="img_inner_wrapper">
                                        <img :src="customer?.employments?.evidence_self_employment">
                                        <div class="wrapper_name">
                                        <p class="mb-0 text-white text-center"  v-html="getLast_name(customer?.employments?.evidence_self_employment)"></p>
                                        <a :href="customer?.employments?.evidence_self_employment" target="_blank" download="SelfEmploymentEvidence">
                                        <img src="/images/download-icon.svg" alt="download" class="download-icon" >
                                        </a>
                                        </div>
                                    </div>
                                </div>
                    </div>
                </div> 
                <div class="video_image_wrapper text_over_flow">
                    <div class="row">
                        <div class="col column_width">
                            <h2>Formal Training</h2>
                            <div class="img_inner_wrapper">
                                <img :src="customer?.documents?.evidence_image">
                                <div class="wrapper_name">
                                        <p class="mb-0 text-white text-center"  v-html="getLast_name(customer?.documents?.evidence_image)"></p>
                                        <a :href="customer?.documents?.evidence_image" target="_blank" download="Evidence">
                                        <img src="/images/download-icon.svg" alt="download" class="download-icon" >
                                        </a>
                                </div>
                            </div>
                        </div>
                        <div class="col column_width">
                            <h2>Supporting employee</h2>
                            <div class="img_inner_wrapper">
                                <img :src="customer?.documents?.employment_evidence">
                                <div class="wrapper_name">
                                        <p class="mb-0 text-white text-center"  v-html="getLast_name(customer?.documents?.employment_evidence)"></p>
                                        <a :href="customer?.documents?.employment_evidence" target="_blank" download="EmploymentEvidence">
                                            <img src="/images/download-icon.svg" alt="download" class="download-icon" >
                                    </a>

                                </div>
                            </div>
                        </div>
                        <div class="col column_width">
                            <h2>Licences</h2>
                            <div class="img_inner_wrapper">
                                <img :src="customer?.documents?.licences">
                                <div class="wrapper_name">
                                    <p class="mb-0 text-white text-center" v-html="getLast_name(customer?.documents?.licences)"></p>
                                    <a :href="customer?.documents?.licences" target="_blank" download="Licence">
                                    <img src="/images/download-icon.svg" alt="download" class="download-icon" >
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col column_width">
                        </div>
                        <div class="col column_width">
                        </div>
                    </div>
                </div>


                <fslightbox
                    :toggler="lightbox.toggler"
                    :sources="lightbox.sources"
                    />
                <div class="video_image_wrapper bg-white resume_div text_over_flow">
                    <div class="row">
                        <div class="col column_width">
                            <h2>Resume </h2>
                            <div class="img_inner_wrapper">
                                <!-- <img scr="https://img.freepik.com/free-photo/bed-arrangements-still-life_23-2150533025.jpg?t=st=1718704104~exp=1718707704~hmac=88563627312c7e6cd5ec680570142671ec70c1320189a41165936c805097543a&w=740"> -->
                                <div class="wrapper_name resume_btn">     
                                    <p class="mb-0 text-white text-center">Download Resume </p>
                                    <a :href="customer?.documents?.resume" target="_blank" download="resume">
                                        <img src="/images/download-icon.svg" alt="download" class="download-icon" >
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col column_width">
                        </div>
                        <div class="col column_width">
                        </div>
                        <div class="col column_width">
                        </div>
                        <div class="col column_width">
                        </div>
                    </div>
                </div> 
            </div>       
        </div>
    </section>
    
    <Footer/>
</template>

<style scoped>
.success{
    color:green;
}
.main-outer-section{
    background-color: #F2F2F2;
}
.active-filter {
    color: #1A9882; /* Change color as per your requirement */
    border-bottom: 2px solid #1A9882;
}
.text-danger{
    color:red;
}
.download-icon{
    height: 29px;
    background: transparent;
    object-fit: fill;
    width: 37px;
}
.download-icon:hover {
    transform: scale(1.2);
    transition: all .10s;
}
.resume_btn .download-icon{
    width: 20px;
}
</style>