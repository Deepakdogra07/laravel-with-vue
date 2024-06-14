<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import Header from '../Frontend/Header.vue';
import Footer from '../Frontend/Footer.vue';
import { onMounted, ref } from 'vue';
import Swal from 'sweetalert2';
import { Country } from 'country-state-city';



const props = defineProps({
    footer_data: {
        type: Object
    },
    jobs: {
        type: Array
    },
    seniorities: {
        type: Array
    },
    positions: {
        type: Array
    }
});
const deletejob = async (id) => {
    const { value: confirmed } = await Swal.fire({
        title: 'Are you sure?',
        text: 'You want to Delete Job Record?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    });

    try {
        if (confirmed) {
            router.delete(route('business-jobs.destroy', id));
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Job Deleted Successfully',
            });
            // location.reload();
        } else {
            Swal.fire({
                icon: 'info',
                title: 'Canceled',
                text: 'Deletion canceled.',
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error Deleting Job. Please try again.',
        });
    }
};
const refreshDataTable = ref(0);
const totaljobs = ref([]);


onMounted(() => {
    totaljobs.value = props.jobs;
    refreshDataTable.value++;
});

async function search_data(event) {
    let string = event.target.value;
    if (string.length > 0) {
        try {
            const response = await axios.get(route('jobs.search', string));
            totaljobs.value = response.data.jobs;
            refreshDataTable.value++;
        } catch (error) {
            console.error('Error:', error);
        }
    } else {
        location.reload();
    }
}

const countries = Country.getAllCountries();
function filterData(type, event) {
    let total_jobs = totaljobs.value;
    if (type == 'seniority') {
        totaljobs.value = total_jobs.filter(target => target.seniority_id == event.target.value);
        refreshDataTable.value++;
    }
    if (type == 'position') {
        totaljobs.value = total_jobs.filter(target => target.position_id == event.target.value);
        refreshDataTable.value++;
    }
    if (type == 'location') {
        totaljobs.value = total_jobs.filter(target => target.job_country == event.target.value);
        refreshDataTable.value++;
    }
    if (type == 'sort') {
        if (event.target.value == 'asc') {
            totaljobs.value = total_jobs.sort();
        } else if (event.target.value == 'desc') {
            totaljobs.value = total_jobs.reverse();
        }
        refreshDataTable.value++;
    }



    if (event.target.value == '') {
        totaljobs.value = props.jobs;
        refreshDataTable.value++;
    }
}



</script>

<template>
    <Header :logo_image="footer_data.logo_image" />
    <div class="main-outer-section">
        <div class="job-list-search srch_responsive business_srccc add_job_srchhs">
            <div class="container aboutt-width">
                <div class="d-flex justify-between align-items-center flex-wrap gap-3 relative srch_responsives">
                    <div class="login-section-mob absolute top-0 right-0 button_bs_ryt">
                        <Link class="btn btn-sm btn-success text-white business_btn_adds"
                            :href="route('business-jobs.create')">Add job</Link>
                    </div>
                    <div class="d-flex gap-5 align-items-center srch_navbar">
                        <Link class='active-nav'>Jobs</Link>
                        <Link :href="route('dashboard')">Employee</Link>
                        <!-- <Link>Messages</Link> -->
                    </div>

                    <div class="relative search_bar">
                        <i class="bi bi-search absolute top-[50%] left-[15px] translate-y-[-50%]"></i>
                        <input type="search" class="user-dashboard-search" @input="search_data($event)"
                            placeholder="Search job">
                    </div>
                </div>
            </div>
        </div>
        <div class="login-bg-wrapper business_job_details business_inner_dash">
            <div class="container about-width p-0">
                <div class="filter-status row business_ad_wrapper">
                    <div class="col-md-8 width_mobile p-0">
                        <div class="d-flex justify-between align-items-center">
                            <!-- <ul class="d-flex align-items-center flex-wrap pl-0 business_links">
                               <li class="active_menu">
                                    <span :class="{ 'active-filter': activeSpan === 1 }" @click="setActiveSpan(1)">17
                                        Active</span>
                                </li>
                                <li>
                                    <span :class="{ 'active-filter': activeSpan === 2 }" @click="setActiveSpan(2)">12 Awaiting
                                        Review</span>
                                </li>
                                <li>
                                    <span :class="{ 'active-filter': activeSpan === 3 }" @click="setActiveSpan(3)">2
                                        Reviewed</span>
                                </li>
                                <li>
                                    <span :class="{ 'active-filter': activeSpan === 4 }" @click="setActiveSpan(4)">2
                                        Contacted</span>
                                </li>
                                <li>
                                    <span :class="{ 'active-filter': activeSpan === 5 }" @click="setActiveSpan(5)">0 Hired</span>
                                </li>
                                <li>
                                    <span :class="{ 'active-filter': activeSpan === 6 }" @click="setActiveSpan(6)">22
                                        Rejected</span>
                                </li>
                                
                            </ul> -->
                        </div>
                    </div>

                    <div class="col-md-3 login-section-desk text-end width_mobileS business_btn_job p-0">
                        <Link class="btn btn-sm btn-success business_btn_adds" :href="route('business-jobs.create')">Add
                        job</Link>
                    </div>
                </div>
                <div class="main-job-filter mt-5">
                    <ul class="d-flex align-items-center flex-wrap pl-0 business_dash_navbar_wrapper business_inner_dash_wrap">
                        <!-- <li>
                            <span>Maybe (2)</span>
                        </li> -->
                        <li>
                            <span>Seniority:
                                <select class="job-filter_text any_select_box" @change="filterData('seniority', $event)">
                                    <option value="">Select</option>
                                    <option v-for="seniority in seniorities" :value="seniority.id">{{ seniority.name }}
                                    </option>
                                </select>
                            </span>
                        </li>
                        <li>
                            <span>Positions:
                                <select class="job-filter_text" @change="filterData('position', $event)">
                                    <option value="">Select</option>
                                    <option v-for="postion in positions" :value="postion.id">{{ postion.name }}</option>
                                </select>
                            </span>
                        </li>
                        <li>
                            <span>Location:
                                <select @change="filterData('location', $event)" class="job-filter_text">
                                    <option value="">Any</option>
                                    <option v-for="country in countries" :value="country.name">{{
                                        country.name }}</option>
                                </select>
                            </span>
                        </li>
                        <span>
                            Sort:
                            <select @change="filterData('sort', $event)" class="job-filter_text employes_selct_checkbox">
                                <option value="asc">Apply date (newest)</option>
                                <option value="desc">Apply date (oldest)</option>
                            </select>
                        </span>
                    </ul>
                </div>
                <div class="main-job-filter mt-5 spacing_nine business_tablesss_inner">
                    <DataTable :key="refreshDataTable"
                        class="display job-data-table business_table business_dash_table business_table_dashboard"
                        :options="options" style="border:2px black ;width:100%">
                        <thead>
                            <tr class="th-row">
                                <th>S.No</th>
                                <th>Job Title</th>
                                <th>Positions</th>
                                <th>Seniority</th>
                                <th class="sorting_icon">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(job, index) in totaljobs" :key="job.id">
                                <td>{{ index + 1 }}</td>
                                <td>
                                    {{ job?.job_title }}
                                </td>
                                <td> {{ job?.position?.name }}</td>
                                <td>
                                    {{ job?.seniority?.name }}
                                </td>

                                <td>
                                    <Link :href="route('business-jobs.show', job.id)" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                    </Link>
                                    &nbsp;
                                    <Link :href="route('business-jobs.edit', job.id)" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                    </Link>
                                    &nbsp;
                                    <button class="btn btn-danger btn-sm" @click="deletejob(job.id)"><i
                                            class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </DataTable>
                </div>
            </div>
        </div>
    </div>
    <Footer :footer_data="footer_data" />

</template>
<style scoped>
.main-outer-section {
    background-color: #F2F2F2;
}

.active-filter {
    color: #1A9882;
    /* Change color as per your requirement */
    border-bottom: 2px solid #1A9882;
}
</style>
