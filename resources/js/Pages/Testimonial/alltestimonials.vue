<script setup>
import Header from "../Frontend/Header.vue"
import Footer from "../Frontend/Footer.vue";
import SubHeading from '@/Pages/Frontend/SubHeading.vue'
import "../../../css/frontend.css";
import { Head, Link, useForm } from '@inertiajs/vue3';
import CustomPagination from '@/Components/CustomPagination.vue';


const props = defineProps({
    testimonials: Array
});
console.log(props.testimonials);



</script>
<template>
   

    <Head title="Our Testimonials" />
    <Header class="login-wrapper" />
    <SubHeading />
    <div class="login-bg-wrapper">
        <div class="about-us-bg-wrapper testimonials_wrapper">
            <div class="container all-testimonial_width">
                <h1 class="mb-2 text-blue text-center">What Clients Says About us</h1>
                <p class=" text-center">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                    Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took
                    a galley of type and scrambled it to make a type specimen book. It has survived not only five
                    centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
            </div>
        </div>
        <div class="viewAll-testimonial">
            <div class="testimonial-section">
                <div class="container">
                    <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-3">
                        <div class="testimonial" v-for="testimonial in props.testimonials" :key="testimonial.id">
                            <Link :href="route('show.testimonial',testimonial.id)"> 
                            
                                <div class="testimonial-content">
                                <div class="text-end mb-2">
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                                <p class="text-center">{{ testimonial?.description }}</p>
                            </div>
                            <div class="testimonial-bg">
                                <div class="d-flex align-items-center gap-2 mb-2 popup-person">
                                    <p>- <span> <i class="bi bi-person-square pl-2"></i></span></p>
                                    <p>{{ testimonial?.name }}</p>
                                </div>
                                <span data-bs-toggle="modal" :data-bs-target="`#newAdvertModal-${testimonial?.id}`" 
                                    class="testimonial-video-btn">
                                    <span class="video_txt">
                                        
                                        <i class="bi bi-play-circle"></i>
                                        <span class="video_hd" v-html="testimonial?.video_name"></span> 
                                    </span>
                                    
                                </span>
                            </div>
                        </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Footer />
</template>
