<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Link } from '@inertiajs/vue3';
import { onMounted, reactive } from 'vue';
import Swal from 'sweetalert2';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';


    
</script>
<template>
    <AuthenticatedLayout>
        <template #header>
                <h2 class="font-semibold text-xl text-black-800 leading-tight">Other Pages</h2>
            <!-- <div class="button-container"> -->
               
            <!-- </div> -->
            
        </template>
        <div class="py-12 row">
                <div  class="col-lg-3 col-md-6 col-xl-3 mb-3">
                            <Link :href="route('edit-logo')">
                            <div class="card bg-success text-white mb-3 card-flex py-2">
                                <div class="card-header">
                                    <h4>Images</h4>
                                </div>
                                 <div class="card-body">
                                    <h4>Click here to view Image section</h4>
                                </div>
                            </div>
                            </Link>
                        </div>
                        <div  class="col-lg-3 col-md-6 col-xl-3 mb-3">
                            <Link  :href="route('countries.index')">
                            <div class="card bg-info text-white mb-3 card-flex py-2">
                                <div class="card-header">
                                    <h4>Countries</h4>
                                </div>
                                 <div class="card-body">
                                    <h4>Click here to view countries section</h4>
                                </div>
                            </div>
                            </Link>
                        </div>
                        <div  class="col-lg-3 col-md-6 col-xl-3 mb-3">
                            <Link >
                            <div class="card bg-primary text-white mb-3 card-flex py-2">
                                <div class="card-header">
                                    <h4>Video Section</h4>
                                </div>
                                 <div class="card-body">
                                    <h4>Click here to view Video Section</h4>
                                </div>
                            </div>
                            </Link>
                        </div>
            </div>
        
    </AuthenticatedLayout>
</template>

<style scoped>
  
</style>