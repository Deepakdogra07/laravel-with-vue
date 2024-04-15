<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Link } from '@inertiajs/vue3';
import { reactive } from 'vue';
import Swal from 'sweetalert2';
import axios from 'axios';

const props = defineProps({
    slider: {
        type: Object
    },
});




    
    

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
                <h2 class="font-semibold text-xl text-black-800 leading-tight">View Slider</h2>
            <div class="button-container">
            </div>
            
        </template>
        <div class="py-12">
                <div class="max-w-7xl mx-auto px-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;">
                    <div class="p-6 text-black-900">
                    <div class="container">
                        <div class = "card">                  
                            <div class="card-header">         
                                <div class="card-header-caption">  
                                    <div class="card-header-title">
                                        <img :src="'/storage/slider/' + slider.slider_image" :alt=" props.slider.slider_name" style="height:350px">
                                        <h2><b>Slider Name:</b>{{ props.slider.slider_name }}</h2>
                                        <br>
                                        <h4><b>Slider heading:</b>{{ props.slider.slider_description }}</h4>
                                        <br>
                                        <p><b>Slider Description:</b>{{ props.slider.slider_heading }}</p>                                    </div> 
                                </div>
                                <div class="card-content"></div>       
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
    </AuthenticatedLayout>
</template>
<style scoped>
  .error-message{
    color:red;
  }
  
</style>