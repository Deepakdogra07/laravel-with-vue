<script setup>
import Footer from "../../Frontend/footer.vue";
import Header from "../../Frontend/header.vue";
import "../../../../css/frontend.css";
import { Head, Link, useForm } from '@inertiajs/vue3';
import CustomPagination from '@/Components/CustomPagination.vue';

const props = defineProps({
    news: Object
})

</script>
<template>
    <Header class="login-wrapper" />

    <Head title="About us" />
    <div class="about-us-bg-wrapper">
        <div class="container">
            <h1 class="mb-4 text-blue text-center">O que a imprensa diz sobre nós</h1>
        </div>
    </div>
    <div class="press-section">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-12" v-for="item in props.news.data" :key="item.id">
                    <div class="press-content mb-4">
                        <div class="press-image-sec">
                            <img :src="'/storage/news/'+item.image" alt="">
                        </div>
                        <div class="press-links">
                            <p class="mb-2">{{ item.content }}</p>
                            <a :href="item.link">Consulte Mais informação <span> <i class="fa-solid fa-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="d-flex justify-center align-items-center px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase sm:grid-cols-9">
                <CustomPagination :links="props.news.links" />
            </div>
        </div>
    </div>
    <Footer />
</template>
<style></style>