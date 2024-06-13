<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {  Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import 'vue3-toastify/dist/index.css';
import * as countryStateCity from 'country-state-city';
import moment from 'moment';
import axios from 'axios';


const props = defineProps({
    applied_customers: {
        type: Array
    },
    job_id:{
        type:String
    },
    status:{
        type:Array
    }
});
const appliedCustomers = ref([]);
const refreshDataTable = ref(0);
onMounted(()=>{
    appliedCustomers.value = props.applied_customers;
    refreshDataTable.value++;
});
const activeSpan = ref(null);
const setActiveSpan = async (spanNumber) => {
  try {
    if (activeSpan.value === spanNumber) {
      activeSpan.value = null;
      location.reload();
    } else {
      const response = await axios.get(`/data-filteration/${props.job_id}/${spanNumber-1}`); 
      appliedCustomers.value = response.data.applied_customers;
      refreshDataTable.value++;
      activeSpan.value = spanNumber;
    }
  } catch (error) {
    console.error('Error:', error);
  }
};


   
const states = countryStateCity.State.getStatesOfCountry('IN');

function formatDateTime(date){
    return moment(date).format('MMMM DD ');
}
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
                <h2 class="font-semibold text-xl text-black-800 leading-tight">View Employees</h2>
            <div class="button-container">
            </div>
            
        </template>
        <div class="nav-container jobs_tabss">
            <div class="form-navigation1" >
                <div class="container">
                    <ul class="row nav-underline pl-0 mb-0">
                        <div class="col-md-2 col-3">
                            <li class="nav-item">
                                <Link class="nav-link text-center" 
                                    aria-current="page" 
                                    :class="{ 'active': route().current('jobs.show',job_id) }"
                                    :href="route('jobs.show',job_id)"
                                >View Job</Link>
                            </li>
                        </div>
                        <div class="col-lg-2 col-md-3 col-5">
                            <li class="nav-item">
                                <Link class="nav-link text-center"  
                                    :class="{ 'active': route().current('jobs-customers',job_id) }"
                                    :href="route('job_for_customers',job_id)"
                                >Employees</Link>
                                <!-- :class="{ 'active': route().current('register') }"   -->
                            </li>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
        <div class="py-12 employesss_tabs employesss_tabs_dd">
            <div class="container">
                <div class="filter-status">
                    <div class="d-flex justify-between">
                        <ul class="d-flex align-items-center flex-wrap pl-0 view_employes_nav_wrapper">
                            <li>
                                <span :class="{ 'active-filter': activeSpan === 1 }" @click="setActiveSpan(1)">{{ status.active }}
                                    Active</span>
                            </li>
                            <li>
                                <span :class="{ 'active-filter': activeSpan === 2 }" @click="setActiveSpan(2)">{{ status.awaited }} Awaiting
                                    Review</span>
                            </li>
                            <li>
                                <span :class="{ 'active-filter': activeSpan === 3 }" @click="setActiveSpan(3)">{{ status.reviewed }}
                                    Reviewed</span>
                            </li>
                            <li>
                                <span :class="{ 'active-filter': activeSpan === 4 }" @click="setActiveSpan(4)">{{ status.contacted }}
                                    Contacted</span>
                            </li>
                            <li>
                                <span :class="{ 'active-filter': activeSpan === 5 }" @click="setActiveSpan(5)">{{ status.hired }} Hired</span>
                            </li>
                            <li>
                                <span :class="{ 'active-filter': activeSpan === 6 }" @click="setActiveSpan(6)">{{ status.rejected }}
                                    Rejected</span>
                            </li>
                            
                        </ul>
                    </div>
                </div>
                <!-- <div class="main-job-filter mt-5">
                    <ul class="d-flex align-items-center flex-wrap pl-0">
                        <li>
                            <span>Yes (2)</span>
                        </li>
                        <li>
                            <span>Maybe (2)</span>
                        </li>
                        <li>
                            <span>Expiring (2)</span>
                        </li>
                        <li>
                            <span>Assessment: Any <i class="bi bi-chevron-down pl-3"></i></span>
                        </li>
                        <li>
                            <span>Location: Any <i class="bi bi-chevron-down pl-3"></i></span>
                        </li>
                        <li>
                            <span>Sort: Apply date (newest) <i class="bi bi-chevron-down pl-3"></i></span>
                        </li>
                    </ul>
                </div> -->
            </div>
            <!-- <div class="max-w-7xl mx-auto px-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;"> -->
                    <div class="p-6 text-black-1024 padding_remove padding_table">
                        <DataTable class="display employ_table" :key="refreshDataTable" >
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Country to Immigrate</th>
                                    <th>Profile</th>
                                    <th>Visa Status</th>
                                    <th>Experience Summary</th>
                                    <!-- <th>Videos</th> -->
                                    <th>Intersts</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(customer, index) in appliedCustomers" :key="customer.id">
                                    <td>
                                        {{ customer?.first_name }}
                                    </td>
                                    <td>
                                        {{ customer?.email }}
                                    </td>

                                    <td>
                                        <div v-if="customer?.status?.status ==0" style="color:green">Active </div>
                                        <div v-if="customer?.status?.status ==1" style="color:green">Awaiting Review </div>
                                        <div v-if="customer?.status?.status ==2" style="color:green">Reviewed </div>
                                        <div v-if="customer?.status?.status ==3" style="color:green">Contacted </div>
                                        <div v-if="customer?.status?.status ==4" style="color:green">Hired </div>
                                        <div v-if="customer?.status?.status ==5" style="color:red">Rejected </div>
                                        <div>{{ formatDateTime(customer?.status?.created_at) }}</div>
                                    </td>
                                    <td>
                                        {{ customer.migrate_country }}
                                    </td>
                                    <td> <img :src="customer?.customer_image" alt=""></td>
                                    <td> {{ 'Student'}}</td>
                                   
                                    <td>
                                        {{ '2 Years' }}
                                    </td>
                                    <!-- <td>
                                        <video src="/images/new-video.mp4" controls></video>
                                    </td> -->
                                    <td >
                                        <div v-if="customer?.status?.status != 5 " class="employ_all_btn_wrapper">
                                            <button class="btn btn-sm btn-success employ_btn"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-sm btn-primary employ_btn_mid"><i class="fas fa-question"></i></button>
                                            <button class="btn btn-sm btn-danger employ_btn_bottom"><i class="fas fa-times"></i></button>
                                        </div>
                                        <div v-else>
                                            <span class="text-danger">Rejected</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </DataTable>
                                           
                    </div>
                <!-- </div>
            </div> -->
        </div>
    </AuthenticatedLayout>
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