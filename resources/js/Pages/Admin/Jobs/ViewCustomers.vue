<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Link } from '@inertiajs/vue3';
import { onMounted, reactive } from 'vue';
import Swal from 'sweetalert2';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import * as countryStateCity from 'country-state-city';

const props = defineProps({
    applied_customers: {
        type: Array
    },
    job_id:{
        type:String
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
                <h2 class="font-semibold text-xl text-black-800 leading-tight">View Employees</h2>
            <div class="button-container">
            </div>
            
        </template>
        <div class="nav-container">
            <div class="form-navigation1" >
                <div class="container">
                    <ul class="row nav-underline pl-0 mb-0">
                        <div class="col-md-1 col-3">
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
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;">
                    <div class="p-6 text-black-900">
                        <DataTable class="display" :options="options" style="border:2px black ;width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer Name</th>
                                    <th>Customer Email</th>
                                    <th>Date of Birth</th>
                                    <th>City/Country</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(customer, index) in applied_customers" :key="customer.id">
                                    <td>{{ index + 1 }}</td>
                                    <td>
                                        {{ customer?.first_name }}
                                    </td>
                                    <td> {{ customer?.email }}</td>
                                    <td>
                                        {{ customer?.date_of_birth }}
                                    </td>
                                    <td>
                                        {{ customer?.city_of_birth }}/{{ customer?.country_of_birth }}
                                    </td>
                                    <td>
                                        <!-- <Link :href="route('jobs.show', job.id)" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                        </Link>
                                        &nbsp;
                                        <Link :href="route('jobs.edit', job.id)" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                        </Link>
                                        &nbsp;
                                        <button class="btn btn-danger btn-sm" @click="deletejob(job.id)"><i
                                                class="fas fa-trash"></i></button> -->
                                    </td>
                                </tr>
                            </tbody>
                        </DataTable>
                                           
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
