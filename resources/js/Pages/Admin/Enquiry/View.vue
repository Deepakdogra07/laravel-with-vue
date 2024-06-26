<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Link } from '@inertiajs/vue3';
import { reactive } from 'vue';
import Swal from 'sweetalert2';
import axios from 'axios';

const props = defineProps({
    enquiry: {
        type: Object
    },
});




    
    

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
                <h2 class="font-semibold text-xl text-black-800 leading-tight">View Detailed Enquiry</h2>
            <div class="button-container">
            </div>
            
        </template>
        <div class="py-12 View_Detailed_Enquiry_box">
                <div class="px-2 view_padding">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up ">
                    <div class="text-black-900">
                    <div class="">
                        <div class = "card">                  
                            <div class="card-header view_detailed_header">         
                                <div class="card-header-caption">  
                                    <div class="card-header-title">
                                        <h2><b>Person Name:</b>{{ props.enquiry.user_name }}</h2>
                                        
                                        <h4><b>Person Email:</b>{{ props.enquiry.user_email }}</h4>
                                       
                                        <p><b>Person Mobile Number:</b>{{ props.enquiry.user_mobile }}</p>   
                                        
                                        <p><b>Message:</b>{{ props.enquiry.user_message }}</p>                                 </div> 
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