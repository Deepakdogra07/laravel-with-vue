<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Header from '../Frontend/Header.vue';
import Footer from '../Frontend/Footer.vue';
import moment from 'moment';
// import DataTable from 'datatables.net-bs4';


const props = defineProps({
  footer_data: {
    type: Object
  },
  user: {
    type: Object
  },
  customers: {
    type: Array
  }
});
function formatDateTime(date){
    return moment(date).format('MMMM DD ');
}
// console.log(props.customers);

</script>

<template>
  <Header :logo_image="footer_data.logo_image" />
  
 
    <div class="main-outer-section">
        <div class="job-list-search srch_responsive business_srccc">
            <div class="container aboutt-width ">
                <div class="d-flex justify-between align-items-center flex-wrap gap-3 relative src_bar">
                    <!-- <div class="login-section-mob absolute top-0 right-0 button_bs_ryt">
                        <Link class="btn btn-sm btn-success text-white" :href="route('business-jobs.create')">Add job</Link>
                    </div> -->
                    <div class="d-flex gap-5 align-items-center srch_navbar">
                        <Link class='active-nav'>Jobs</Link>
                        <Link>Employee</Link>
                        <Link>Messages</Link>
                    </div> 
                    
                    <div class="relative search_bar">
                        <i class="bi bi-search absolute top-[50%] left-[15px] translate-y-[-50%]"></i>
                        <input type="search" class="user-dashboard-search" placeholder="Search employee">
                    </div>
                </div>
            </div>
        </div>
        <div class="login-bg-wrapper business_job_details business_inner_dash">
            <div class="container about-width p-0">
                <div class="filter-status row">
                    <div class="col-md-8 width_mobile p-0">
                        <div class="d-flex justify-between align-items-center">
                            <ul class="d-flex align-items-center flex-wrap pl-0 business_links">
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
                                
                            </ul>
                        </div>
                    </div>

                    

                    <!-- <div class="col-md-1 login-section-desk text-end width_mobileS">
                        <Link class="btn btn-sm btn-success" :href="route('business-jobs.create')">Add job</Link>
                    </div> -->
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
                            <span>Assessment: <span class="job-filter_text">Any</span> <i class="bi bi-chevron-down pl-3"></i></span>
                        </li>
                        <li>
                            <span>Location: <span class="job-filter_text">Any</span> <i class="bi bi-chevron-down pl-3"></i></span>
                        </li>
                        <li>
                            <span>Sort: <span class="job-filter_text">Apply date (newest)</span> <i class="bi bi-chevron-down pl-3"></i></span>
                        </li>
                    </ul>
                </div>
                <div class="main-job-filter mt-5 spacing_nine business_tablesss_inner">
                        <!-- business_dashboard_tabel -->
                        <DataTable class="display table-responsive job-data-table business_table_dashboard business_dash_table" :key="refreshDataTable" style="border:2px black ;width:100%" >
        <thead>
          <tr>
            <th>Name</th>
            <th>Job Title</th>
            <th>Status</th>
            <th>Country to Immigrate</th>
            <th>Profile</th>
            <th>Visa Status</th>
            <th>Experience Summary</th>
            <th>Videos</th>
            <th>Intersts</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(customer, index) in customers" :key="customer.id">
            <td>
              <input type="checkbox">
              {{ customer?.first_name }}
            </td>
            <td> {{ customer?.jobs.job_title }}</td>

            <td>
              <div v-if="customer?.status?.status == 0" style="color:green">Active </div>
              <div v-if="customer?.status?.status == 1" style="color:green">Awaiting Review </div>
              <div v-if="customer?.status?.status == 2" style="color:green">Reviewed </div>
              <div v-if="customer?.status?.status == 3" style="color:green">Contacted </div>
              <div v-if="customer?.status?.status == 4" style="color:green">Hired </div>
              <div v-if="customer?.status?.status == 5" style="color:red">Rejected </div>
              <div>{{ formatDateTime(customer?.status?.created_at) }}</div>
            </td>
            <td>
              {{ customer?.migrate_country }}
            </td>
            <td> <img :src="customer?.customer_image" alt=""></td>
            <td> {{ 'Student' }}</td>

            <td>
              {{ '2 Years' }}
            </td>
            <td>
                                        <video src="/images/new-video.mp4" controls></video>
                                    </td>
            <td>
              <div v-if="customer?.status?.status != 5">
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
            </div>
        </div>
    </div>
 
  <Footer :footer_data="footer_data" />

</template>
<style scoped></style>
