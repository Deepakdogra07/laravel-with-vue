<script setup>
import Header from "../Frontend/Header.vue"
import Footer from "../Frontend/Footer.vue";
import SubHeading from '@/Pages/Frontend/SubHeading.vue'
import "../../../css/frontend.css";
import { Link } from '@inertiajs/vue3';


const props = defineProps({
    testimonial:{
        type: Array
    },
    previous:{
        type:Number
    },
    next:{
        type:Number
    }
});


</script>

<template>
   

    <Head title="Our Testimonials" />
    <Header class="login-wrapper" />
    <SubHeading :testimonial_id="testimonial.id"/>

<section class="testimonials_page" >
    <div class="container modal-dialogs testimonials_width">
        <div class="popover-section  modal-content single_testimonial">
            <Link class="popup-cross cross_testimonials" data-bs-dismiss="modal">
            <i class="bi bi-x"></i>
            </Link>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-2 popup-quote-img">
                        <img src="/images/quotes.png" alt="">
                        <!-- <img :src="`/storage/testimonials/${testimonial?.image_link}`" alt=""> -->
                    </div>
                    <div class="col-md-10">
                        <h2 class="mb-3 testimonial-heading">{{ testimonial?.description }}
                        </h2>
                        <div class="d-flex align-items-center gap-2 mb-2 popup-profile-name">
                            <p><span><i class="bi bi-person-square"></i></span></p>
                            <p>{{ testimonial?.name }}</p>
                        </div>
                        <p class="name_profile_txt">{{ testimonial?.content }}</p>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-lg-10 col-md-10 col-sm-12">
                        <div class="popup-video-section">
                            <video :src="`${testimonial?.video_link}`" controls></video>
                            <!-- <span class="bi bi-play-circle"></span> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="previous_next"> 
                    <Link class="btn btn-secondary previous_btn" :href="previous" v-if="previous" > <i class="fa-solid fa-arrow-left"></i>Previous</Link>
                    <Link class="btn btn-success next_btn" v-if="next" style="float:right;" :href="next"  > Next<i class="fa-solid fa-arrow-right"></i></Link>
                </div>
            </div>
        </div>
    </div>
</section>

<Footer />
</template>