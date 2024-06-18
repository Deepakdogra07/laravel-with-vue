<script setup>
import 'vue3-toastify/dist/index.css';
import Header from '@/Pages/Frontend/Header.vue'
import Footer from '@/Pages/Frontend/Footer.vue'
import SubHeading from '@/Pages/Frontend/SubHeading.vue'

const props = defineProps({
    customer:{
        type:Object
    }
});
</script>

<template>
    <Header />
    <SubHeading :job_id ="job_id"/>
    <section class="view_customer_wrapper">
        <div class="container py-12 view_customer_inner">
            <div class="inner_spacing_wrapper">
                <div class="customer_card pb-4">
                    <div class="card-image">
                        <img :src="customer.customer_image" alt="" width="450px">
                    </div>
                    <div class="inner_card_wrapper">
                        <h1>{{ customer.first_name }} {{ customer.last_name }}</h1>
                            <div class="card-body">
                                <!-- <h2>Other Details:</h2> -->
                                <p><b>Date of Birth</b>{{ customer.date_of_birth }}</p>
                                <p><b>County of birth</b>{{ customer.country_of_birth }}</p>
                                <p><b>City of birth</b>{{ customer.city_of_birth }}</p>
                                <p><b>martial_status</b>{{ customer.martial_status }}</p>
                                <p><b>Country to immigrate</b>{{ customer.migrate_country }}</p>
                                <p><b>Gender</b>{{ customer.gender }}</p>
                                <!-- {{ customer.martial_status }} -->
                            </div>
                    </div>   
                </div>  
                <div class="pass_travel_details_wrapper border-top border-bottom">
                    <div class="row">
                        <div class="col-xl-6 xol-lg-6 col-md-12 col-sm-12 p-0">
                            <div class="Travel_details">
                                <h2>Travel Details</h2>
                                <div class="card-body">
                                    <p><b>Purpose of stay</b>Transit</p>
                                    <p><b>Purpose of stay</b>Other (consultation)</p>
                                    <p><b>Type of visa</b>Tourist </p>
                                    <p><b>Date of travel</b>22/07/2024</p>
                                    <p><b>Passenger nationality </b>Chandigarh, India</p>
                                    <p><b>Port of arrival</b>Chandigarh, India</p>
                                </div>
                            </div> 
                        </div>
                        <div class="col-xl-6 xol-lg-6 col-md-12 col-sm-12 p-0">
                            <div class="Travel_details passport_details">
                                <h2>Passport details</h2>
                                <div class="card-body">
                                    <p><b>Passport number</b>abc5498aaf260</p>
                                    <p><b>Issuing authority</b>Ministry of external affairs</p>
                                    <p><b>Citizen of more than one country</b>No </p>
                                    <p><b>Have you ever obtained an visa using current or previous passport? </b>Yes</p>
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
                                    <img scr="http://127.0.0.1:8000/storage/categories/664722250a432_1715937829_.png">
                                    <div class="video_icon absolute w-100">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                </div>
                                <div class="wrapper_name">
                                    <p class="mb-0 text-white text-center">Video54842...65.mp4</p>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col column_width">
                            <div class="img_inner_wrapper ">
                                <div class="img_overlay relative">
                                    <img scr="http://127.0.0.1:8000/storage/categories/664722250a432_1715937829_.png">
                                    <div class="video_icon absolute w-100">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                </div>
                                <div class="wrapper_name">
                                    <p class="mb-0 text-white text-center">Video54842...65.mp4</p>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col column_width">
                            <div class="img_inner_wrapper ">
                                <div class="img_overlay relative">
                                    <img scr="http://127.0.0.1:8000/storage/categories/664722250a432_1715937829_.png">
                                    <div class="video_icon absolute w-100">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                </div>
                                <div class="wrapper_name">
                                    <p class="mb-0 text-white text-center">Video54842...65.mp4</p>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col column_width">
                            <div class="img_inner_wrapper ">
                                <div class="img_overlay relative">
                                    <img scr="http://127.0.0.1:8000/storage/categories/664722250a432_1715937829_.png">
                                    <div class="video_icon absolute w-100">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                </div>
                                <div class="wrapper_name">
                                    <p class="mb-0 text-white text-center">Video54842...65.mp4</p>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col column_width">
                            <div class="img_inner_wrapper ">
                                <div class="img_overlay relative">
                                    <img scr="http://127.0.0.1:8000/storage/categories/664722250a432_1715937829_.png">
                                    <div class="video_icon absolute w-100">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                </div>
                                <div class="wrapper_name">
                                    <p class="mb-0 text-white text-center">Video54842...65.mp4</p>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="video_image_wrapper">
                    <h2>Image</h2>
                    <div class="row">
                        <div class="col column_width">
                            <div class="img_inner_wrapper">
                                <img scr="https://img.freepik.com/free-photo/bed-arrangements-still-life_23-2150533025.jpg?t=st=1718704104~exp=1718707704~hmac=88563627312c7e6cd5ec680570142671ec70c1320189a41165936c805097543a&w=740">
                                <div class="wrapper_name">
                                    <p class="mb-0 text-white text-center">Video54842...65.mp4</p>
                                </div>
                            </div>
                        </div>
                        <div class="col column_width">
                            <div class="img_inner_wrapper">
                                <img scr="https://img.freepik.com/free-photo/bed-arrangements-still-life_23-2150533025.jpg?t=st=1718704104~exp=1718707704~hmac=88563627312c7e6cd5ec680570142671ec70c1320189a41165936c805097543a&w=740">
                                <div class="wrapper_name">
                                    <p class="mb-0 text-white text-center">Video54842...65.mp4</p>
                                </div>
                            </div>
                        </div>
                        <div class="col column_width">
                            <div class="img_inner_wrapper">
                                <img scr="https://img.freepik.com/free-photo/bed-arrangements-still-life_23-2150533025.jpg?t=st=1718704104~exp=1718707704~hmac=88563627312c7e6cd5ec680570142671ec70c1320189a41165936c805097543a&w=740">
                                <div class="wrapper_name">
                                    <p class="mb-0 text-white text-center">Video54842...65.mp4</p>
                                </div>
                            </div>
                        </div>
                        <div class="col column_width">
                        </div>
                        <div class="col column_width">
                        </div>
                    </div>
                </div>      
                <div class="video_image_wrapper">
                    <div class="row">
                        <div class="col col-one">
                            <h2>Passport</h2>
                            <div class="img_inner_wrapper">
                                <img scr="https://img.freepik.com/free-photo/bed-arrangements-still-life_23-2150533025.jpg?t=st=1718704104~exp=1718707704~hmac=88563627312c7e6cd5ec680570142671ec70c1320189a41165936c805097543a&w=740">
                                <div class="wrapper_name">
                                    <p class="mb-0 text-white text-center">Video54842...65.mp4</p>
                                </div>
                            </div>
                        </div>
                        <div class="col col-two">
                            <h2>Employer statement</h2>
                            <div class="img_inner_wrapper">
                                <img scr="https://img.freepik.com/free-photo/bed-arrangements-still-life_23-2150533025.jpg?t=st=1718704104~exp=1718707704~hmac=88563627312c7e6cd5ec680570142671ec70c1320189a41165936c805097543a&w=740">
                                <div class="wrapper_name">
                                    <p class="mb-0 text-white text-center">Video54842...65.mp4</p>
                                </div>
                            </div>
                        </div>
                        <div class="col col-three">
                            <h2>Financial evidence</h2>
                            <div class="img_inner_wrapper">
                                <img scr="https://img.freepik.com/free-photo/bed-arrangements-still-life_23-2150533025.jpg?t=st=1718704104~exp=1718707704~hmac=88563627312c7e6cd5ec680570142671ec70c1320189a41165936c805097543a&w=740">
                                <div class="wrapper_name">
                                    <p class="mb-0 text-white text-center">Video54842...65.mp4</p>
                                </div>
                            </div>
                        </div>
                        <div class="col col-four">
                            <h2>Evidence of self-employment</h2>
                                    <div class="img_inner_wrapper">
                                        <img scr="https://img.freepik.com/free-photo/bed-arrangements-still-life_23-2150533025.jpg?t=st=1718704104~exp=1718707704~hmac=88563627312c7e6cd5ec680570142671ec70c1320189a41165936c805097543a&w=740">
                                        <div class="wrapper_name">
                                            <p class="mb-0 text-white text-center">Video54842...65.mp4</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col column_width">
                                    <h2 style="visibility: hidden;" class="mobile_none">Evidence of self-employment</h2>
                                    <div class="img_inner_wrapper">
                                        <img scr="https://img.freepik.com/free-photo/bed-arrangements-still-life_23-2150533025.jpg?t=st=1718704104~exp=1718707704~hmac=88563627312c7e6cd5ec680570142671ec70c1320189a41165936c805097543a&w=740">
                                        <div class="wrapper_name">
                                            <p class="mb-0 text-white text-center">Video54842...65.mp4</p>
                                        </div>
                                    </div>
                                </div>
                    </div>
                </div> 
                <div class="video_image_wrapper">
                    <div class="row">
                        <div class="col column_width">
                            <h2>Formal Training</h2>
                            <div class="img_inner_wrapper">
                                <img scr="https://img.freepik.com/free-photo/bed-arrangements-still-life_23-2150533025.jpg?t=st=1718704104~exp=1718707704~hmac=88563627312c7e6cd5ec680570142671ec70c1320189a41165936c805097543a&w=740">
                                <div class="wrapper_name">
                                    <p class="mb-0 text-white text-center">Video54842...65.mp4</p>
                                </div>
                            </div>
                        </div>
                        <div class="col column_width">
                            <h2>Supporting employee</h2>
                            <div class="img_inner_wrapper">
                                <img scr="https://img.freepik.com/free-photo/bed-arrangements-still-life_23-2150533025.jpg?t=st=1718704104~exp=1718707704~hmac=88563627312c7e6cd5ec680570142671ec70c1320189a41165936c805097543a&w=740">
                                <div class="wrapper_name">
                                    <p class="mb-0 text-white text-center">Video54842...65.mp4</p>
                                </div>
                            </div>
                        </div>
                        <div class="col column_width">
                            <h2>Licences</h2>
                            <div class="img_inner_wrapper">
                                <img scr="https://img.freepik.com/free-photo/bed-arrangements-still-life_23-2150533025.jpg?t=st=1718704104~exp=1718707704~hmac=88563627312c7e6cd5ec680570142671ec70c1320189a41165936c805097543a&w=740">
                                <div class="wrapper_name">
                                    <p class="mb-0 text-white text-center">Video54842...65.mp4</p>
                                </div>
                            </div>
                        </div>
                        <div class="col column_width">
                        </div>
                        <div class="col column_width">
                        </div>
                    </div>
                </div>
                <div class="video_image_wrapper bg-white">
                    <div class="row">
                        <div class="col column_width">
                            <h2>Resume </h2>
                            <div class="img_inner_wrapper">
                                <img scr="https://img.freepik.com/free-photo/bed-arrangements-still-life_23-2150533025.jpg?t=st=1718704104~exp=1718707704~hmac=88563627312c7e6cd5ec680570142671ec70c1320189a41165936c805097543a&w=740">
                                <div class="wrapper_name">
                                    <p class="mb-0 text-white text-center">Video54842...65.mp4</p>
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
</style>