<script setup>
import Header from "../Frontend/Header.vue"
import Footer from "../Frontend/Footer.vue";
import SubHeading from '@/Pages/Frontend/SubHeading.vue'
import "../../../css/frontend.css";


const props = defineProps({
    testimonial: Array
});
console.log(props.testimonials);


</script>

<template>
   

    <Head title="Our Testimonials" />
    <Header class="login-wrapper" />
    <!-- <SubHeading /> -->

<section class="testimonials_page" >
    <div class="container modal-dialogs">
        <div class="popover-section  modal-content single_testimonial">
            <Link class="popup-cross" data-bs-dismiss="modal">
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
                    <div class="col-12">
                        <div class="popup-video-section">
                            <video :src="`${testimonial?.video_link}`" controls></video>
                            <!-- <span class="bi bi-play-circle"></span> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<Footer />
</template>