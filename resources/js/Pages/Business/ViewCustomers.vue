<script setup>
import { router, Link } from '@inertiajs/vue3';
import { onMounted, reactive, ref } from 'vue';
import Swal from 'sweetalert2';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import * as countryStateCity from 'country-state-city';
import moment from 'moment';
import axios from 'axios';
import DataTables from 'datatables.net';
import Header from '@/Pages/Frontend/Header.vue'
import Footer from '@/Pages/Frontend/Footer.vue'
import SubHeading from '@/Pages/Frontend/SubHeading.vue'

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
    <Header />
    <SubHeading/>
       <div class="py-12">
            <div class="container">
                <div class="filter-status">
                    <div class="d-flex justify-between">
                        <ul class="d-flex align-items-center flex-wrap pl-0">
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
                    <div class="p-6 text-black-1024">
                        <DataTable class="display" :key="refreshDataTable"  style="border:2px black ;width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
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
                                        <div v-if="customer.status.status ==0" style="color:green">Active </div>
                                        <div v-if="customer.status.status ==1" style="color:green">Awaiting Review </div>
                                        <div v-if="customer.status.status ==2" style="color:green">Reviewed </div>
                                        <div v-if="customer.status.status ==3" style="color:green">Contacted </div>
                                        <div v-if="customer.status.status ==4" style="color:green">Hired </div>
                                        <div v-if="customer.status.status ==5" style="color:red">Rejected </div>
                                        <div>{{ formatDateTime(customer.status.created_at) }}</div>
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
                                        <div v-if="customer.status.status != 5">
                                            <button class="btn btn-sm btn-success"><i class="fas fa-check"></i></button>
                                            <button class="btn btn-sm btn-primary"><i class="fas fa-question"></i></button>
                                            <button class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button>
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