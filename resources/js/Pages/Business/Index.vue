<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import Header from '../Frontend/Header.vue';
import Footer from '../Frontend/Footer.vue';
import { ref } from 'vue';
import Swal from 'sweetalert2';



const props = defineProps({
    footer_data: {
        type: Object
    },
    jobs: {
        type: Array
    }
});

const activeSpan = ref(null);
const setActiveSpan = (spanNumber) => {
  if (activeSpan.value === spanNumber) {
    activeSpan.value = null; // Toggle off if clicking on the same span
  } else {
    activeSpan.value = spanNumber; // Set the clicked span as active
  }
};


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
            location.reload();
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

</script>

<template>
    <Header :logo_image="footer_data.logo_image" />
    <div class="main-outer-section">
        <div class="job-list-search">
            <div class="container">
                <div class="d-flex justify-between align-items-center flex-wrap gap-3 relative">
                    <div class="login-section-mob absolute top-0 right-0">
                        <Link class="btn btn-sm btn-success text-white" :href="route('business-jobs.create')">Add job</Link>
                    </div>
                    <div class="d-flex gap-5 align-items-center">
                        <Link class='active-nav'>Jobs</Link>
                        <Link>Employee</Link>
                    </div> 
                    
                    <div class="relative">
                        <i class="bi bi-search absolute top-[50%] left-[15px] translate-y-[-50%]"></i>
                        <input type="search" class="user-dashboard-search" placeholder="Search employe">
                    </div>
                </div>
            </div>
        </div>
        <div class="login-bg-wrapper">
            <div class="container">
                <div class="filter-status">
                    <div class="d-flex justify-between">
                        <ul class="d-flex align-items-center flex-wrap pl-0">
                            <li>
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
                            
                        </ul>
                        <div class="login-section-desk">
                            <Link class="btn btn-sm btn-success" :href="route('business-jobs.create')">Add job</Link>
                        </div>
                    </div>
                </div>
                <div class="main-job-filter mt-5">
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
                </div>
                <div class="main-job-filter mt-5">
                    <DataTable class="display job-data-table" :options="options" style="border:2px black ;width:100%">
                            <thead>
                                <tr class="th-row">
                                    <th>ID</th>
                                    <th>Job Title</th>
                                    <th>Positions</th>
                                    <th>Industry</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(job, index) in jobs" :key="job.id">
                                    <td>{{ index + 1 }}</td>
                                    <td>
                                        {{ job?.job_title }}
                                    </td>
                                    <td> {{ job?.position?.name }}</td>
                                    <td>
                                        {{ job?.industry?.name }}
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
 .main-outer-section{
        background-color: #F2F2F2;
    }
    .active-filter {
        color: #1A9882; /* Change color as per your requirement */
        border-bottom: 2px solid #1A9882;
    }
</style>
