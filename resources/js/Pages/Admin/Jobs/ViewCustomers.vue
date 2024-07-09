<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import * as countryStateCity from 'country-state-city';
import moment from 'moment';
import axios from 'axios';
import { toast } from 'vue3-toastify';


const props = defineProps({
    applied_customers: {
        type: Array
    },
    job_id: {
        type: String
    },
    status: {
        type: Array
    }
});
const appliedCustomers = ref([]);
const refreshDataTable = ref(0);
onMounted(() => {
    appliedCustomers.value = props.applied_customers;
    refreshDataTable.value++;
});
const activeSpan = ref(0);
const setActiveSpan = async (spanNumber) => {
    try {
        if (activeSpan.value === spanNumber || (spanNumber == 0)) {
            activeSpan.value = 0;
            location.reload();
        } else {
            const response = await axios.get(`/data-filteration/${props.job_id}/${spanNumber - 1}`);
            appliedCustomers.value = response.data.applied_customers;
            refreshDataTable.value++;
            activeSpan.value = spanNumber;
        }
    } catch (error) {
        console.error('Error:', error);
    }
};



const states = countryStateCity.State.getStatesOfCountry('IN');

function formatDateTime(date) {
    return moment(date).format('MMMM DD ');
}


const navbar_key = ref(0);
async function changeStatus(customer_id, job_id, event) {
    const newStatus = event.target.value;

    if (newStatus) {
        try {
            const response = await axios.post('/change-status', {
                customer_id: customer_id,
                job_id: job_id,
                status: newStatus
            });
            if(response.data.success){
                console.log('hereerrere');
                navbar_key.value++;
                toast('Status updated successfully.', {
                    autoClose: 2000,
                    theme: 'dark',
                });
                refreshDataTable.value++;
                setTimeout(() => {
                    location.reload();
                },3000);
            }else{
                toast('Status not updated/', {
                    autoClose: 2000,
                    theme: 'dark',
                }); 
            }
        } catch (error) {
            toast(error, {
                autoClose: 2000,
                theme: 'dark',
            });
        }
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-black-800 leading-tight">View Employees</h2>
            <div class="button-container">
            </div>

        </template>
        <div class="nav-container">
            <div class="form-navigation1 view_employee_tabs_wrapper">
                <div class="container container_full">
                    <ul class="row nav-underline pl-0 mb-0">
                        <div class="col-md-2 col-3 p-0 col_width">
                            <li class="nav-item">
                                <Link class="nav-link text-center view_link_tab" aria-current="page"
                                    :class="{ 'active': route().current('jobs.show', job_id) }"
                                    :href="route('jobs.show', job_id)">View Job</Link>
                            </li>
                        </div>
                        <div class="col-lg-2 col-md-3 col-5 p-0 col_width">
                            <li class="nav-item">
                                <Link class="nav-link text-center view_link_tab"
                                    :class="{ 'active': route().current('job_for_customers', job_id) }"
                                    :href="route('job_for_customers', job_id)">Applies</Link>
                                <!-- :class="{ 'active': route().current('register') }"   -->
                            </li>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
        <div class="py-12 employesss_tabs employesss_tabs_dd admin_appy_table">
            <div class="container">
                <div class="filter-status">
                    <div class="d-flex justify-between">
                        <ul class="d-flex align-items-center flex-wrap pl-0 view_employes_nav_wrapper" :key="navbar_key">
                            <li>
                                <span :class="{ 'active-filter': activeSpan === 0 }" @click="setActiveSpan(0)">{{
                                    status.all }}
                                    All</span>
                            </li>
                            <li>
                                <span :class="{ 'active-filter': activeSpan === 1 }" @click="setActiveSpan(1)">{{
                                    status.active
                                    }}
                                    Active</span>
                            </li>
                            <li>
                                <span :class="{ 'active-filter': activeSpan === 2 }" @click="setActiveSpan(2)">{{
                                    status.awaited
                                    }} Awaiting
                                    Review</span>
                            </li>
                            <li>
                                <span :class="{ 'active-filter': activeSpan === 3 }" @click="setActiveSpan(3)">{{
                                    status.reviewed }}
                                    Reviewed</span>
                            </li>
                            <li>
                                <span :class="{ 'active-filter': activeSpan === 4 }" @click="setActiveSpan(4)">{{
                                    status.contacted }}
                                    Contacted</span>
                            </li>
                            <li>
                                <span :class="{ 'active-filter': activeSpan === 5 }" @click="setActiveSpan(5)">{{
                                    status.hired
                                    }} Hired</span>
                            </li>
                            <li>
                                <span :class="{ 'active-filter': activeSpan === 6 }" @click="setActiveSpan(6)">{{
                                    status.rejected }}
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
            <div class="p-6 text-black-1024 padding_remove padding_table View_applies_wrapper table-responsive">
                    <DataTable class="display view_employ_table" :key="refreshDataTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Job Title</th>
                                <th>Status</th>
                                <!-- <th>Apply Date</th> -->
                                <th>Country to Immigrate</th>
                                <th>Profile</th>
                                <th>Visa Purpose</th>
                                <th>Country of Birth</th>
                                <th>Actions</th>
                                <th>View </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(customer, index) in appliedCustomers" :key="customer.id">
                                <td class="business_wrap_name">
                                    <!-- <input type="checkbox"> -->
                                    {{ customer?.customers?.first_name }}
                                </td>
                                <td> {{ customer?.jobs?.job_title }}</td>

                                <td class="status_business">
                                    <div v-if="customer?.status == 0" style="color:">Active </div>
                                    <div v-if="customer?.status == 1" style="color:">Awaiting Review </div>
                                    <div v-if="customer?.status == 2" style="color:">Reviewed </div>
                                    <div v-if="customer?.status == 3" style="color:">Contacted </div>
                                    <div v-if="customer?.status == 4" style="color:">Hired </div>
                                    <div v-if="customer?.status == 5" style="color:red">Rejected </div>
                                    <div>{{ formatDateTime(customer?.created_at) }}</div>
                                </td>
                                <!-- <td> <div>{{ formatDateTime(customer?.created_at) }}</div></td> -->
                                <td>
                                    {{ customer?.customers?.migrate_country }}
                                </td>
                                <td> <img :src="customer?.customers?.customer_image" alt=""></td>
                                <td v-html="customer?.customers?.travel_details?.purpose_of_stay"> </td>
                                <td v-html="customer?.customers?.country_of_birth"></td>
                                <td>

                                    <select class="form-control select_status_wra" style="width:172px;"
                                        v-model="customer.status"
                                        @change="changeStatus(customer?.customers?.id, customer?.jobs?.id, $event)">

                                        <option value="0"> Active</option>
                                        <option value="1"> Awaiting Review</option>
                                        <option value="2"> Reviewed</option>
                                        <option value="3"> Contacted</option>
                                        <option value="4"> Hired</option>
                                        <option value="5"> Rejected</option>
                                    </select>
                                </td>
                                <td>
                                    <Link class="btn btn-sm btn-success icon_eye"
                                        :href="route('view_applied_customer', [customer.customer_id, job_id])"><i
                                        class="fas fa-eye"></i> </Link>
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
.success {
    color: green;
}

.main-outer-section {
    background-color: #F2F2F2;
}

.active-filter {
    color: #1A9882;
    border-bottom: 2px solid #1A9882;
}

.text-danger {
    color: red;
}
</style>