<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Link } from '@inertiajs/vue3';
import { onMounted, reactive } from 'vue';
import Swal from 'sweetalert2';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import * as countryStateCity from 'country-state-city';

const props = defineProps({
    jobs: {
        type: Array
    },
    applied_customers:{
        type: Array
    }
});

const states = countryStateCity.State.getStatesOfCountry('IN');

// function getStateName(code){
//     var state = states.find(state => state.isoCode == isoCode);
//     return state ? state.name : '';
// }
// console.log(props.applied_customers,'123456789');
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
                <h2 class="font-semibold text-xl text-black-800 leading-tight">View Job</h2>
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
                                            <h2><b>Job Title:</b>{{ jobs?.job_title }}</h2>
                                            <br>
                                            <h4><b>Positions:</b>{{ jobs?.positions }}</h4>
                                            <br>
                                            <p><b>Postion Type:</b>{{ jobs?.position?.name }}</p>    
                                        </div> 
                                    </div>
                                    <div class="card-content">
                                        <p> <b>Seniority:</b>{{ jobs?.seniority?.name }}
                                            &nbsp;
                                            <b>Discipline:</b>{{ jobs?.discipline?.name }}
                                            &nbsp;
                                            <b>Work Experience:</b>{{ jobs?.work_experience?.experience }}
                                            &nbsp;
                                            <b>Skills:</b>{{ jobs?.skills?.name }}
                                            &nbsp;
                                            <b>Remote Work:</b>
                                            <p v-if="jobs.remote_work">Yes</p>
                                            <p v-else>No</p>
                                            &nbsp;
                                            <b>Industry:</b>{{ jobs?.industry?.name }}
                                            &nbsp;
                                            <b>Segment:</b>{{ jobs?.segment }}
                                            &nbsp;
                                            <b>Pin Code:</b>{{ jobs?.pin_code }}
                                            &nbsp;
                                            <b>City:</b>{{ jobs.state }}
                                            &nbsp;
                                            <b>Pay Range:</b>{{ jobs?.pay_range }}
                                            &nbsp;
                                            <b>Job Start Date:</b>{{ jobs?.job_start_date }}
                                            <br>
                                            <b>Created By:</b>{{ jobs?.createdby?.name }}
                                        </p>   
                                    </div>       
                                </div>
                            </div>

                            <div class = "card mt-5">                  
                                <div class="card-header">         
                                    <div class="card-header-caption">  
                                        <div class="card-header-title">
                                            <h1>Applied Customers:</h1>
                                        </div> 
                                        <div class="card-body">
                                            <DataTable class="display" :options="options" style="border:2px black ;width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Customer Name</th>
                                                        <th>Email</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   
                                                    <tr v-if="applied_customers.length > 0"  v-for="(customer, index) in applied_customers" :key="customer.id">
                                                        <td>{{ index + 1 }}</td>
                                                        <td>
                                                            {{ customer?.first_name }} {{ customer?.last_name }}
                                                        </td>
                                                        <td> {{ customer?.email }}</td>
                                                        <td class="success">
                                                            Active
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </DataTable>
                                        </div>
                                    </div>          
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
.success{
    color:green;
}
</style>
