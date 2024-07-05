<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Header from '../Frontend/Header.vue';
import Footer from '../Frontend/Footer.vue';
import moment from 'moment';
import { onMounted, ref } from 'vue';
import { Country } from 'country-state-city';
import { toast } from 'vue3-toastify';


const props = defineProps({
  footer_data: {
    type: Object
  },
  user: {
    type: Object
  },
  applied_customers: {
    type: Array
  },
  status: {
    type: Array
  },
  jobs: {
    type: Array
  }
});
function formatDateTime(date) {
  return moment(date).format('MMMM-DD-YYYY');
}

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
      activeSpan.value = null;
      location.reload();
    } else {
      const response = await axios.get(`/customer-filteration/${spanNumber - 1}`);
      appliedCustomers.value = response.data.applied_customers;
      refreshDataTable.value++;
      activeSpan.value = spanNumber;
    }
  } catch (error) {
    console.error('Error:', error);
  }
};
async function search_datatable(event) {
  let string = event.target.value;
  if (string.length > 0) {
    try {
      const response = await axios.get(route('customer.search', string));
      appliedCustomers.value = response.data.applied_customers;
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
  let customers_data = props.applied_customers;
  if (event.target.value != '') {

    if (type == 'location') {
      appliedCustomers.value = customers_data.filter(customer => customer.customers.migrate_country == event.target.value);
      refreshDataTable.value++;
    }
    if (type == 'job_title') {
      appliedCustomers.value = customers_data.filter(jobs => jobs.job_id == event.target.value);
      refreshDataTable.value++;
    }
    if (type == 'applied_date') {
      if (event.target.value == 'desc') {
        appliedCustomers.value = customers_data.sort((a, b) => b.job_id - a.job_id);
      } else {
        appliedCustomers.value = customers_data.sort((a, b) => a.job_id - b.job_id);
      }
    }
  } else {
    appliedCustomers.value = customers_data;
    refreshDataTable.value++;
  }

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
      navbar_key.value++;
      toast('Status updated successfully', {
        autoClose: 2000,
        theme: 'dark',
      });
      refreshDataTable.value++;
      setTimeout(() => {
        location.reload();
      }, 3000);
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
  <Header :logo_image="footer_data.logo_image" />


  <div class="main-outer-section">
    <div class="job-list-search srch_responsive business_srccc customer_listing_wrpa">
      <div class="container aboutt-width ">
        <div class="d-flex justify-between align-items-center flex-wrap gap-3 relative src_bar">
          <!-- <div class="login-section-mob absolute top-0 right-0 button_bs_ryt">
                        <Link class="btn btn-sm btn-success text-white" :href="route('business-jobs.create')">Add job</Link>
                    </div> -->
          <div class="d-flex gap-5 align-items-center srch_navbar">
            <Link :href="route('business-jobs.index')">Jobs</Link>
            <Link class='active-nav'>Employee</Link>
            <Link :href="route('applied-business-jobs')">Applied Jobs</Link>
            <!-- <Link>Messages</Link> -->
          </div>

          <div class="relative search_bar">
            <i class="bi bi-search absolute top-[50%] left-[15px] translate-y-[-50%]"></i>
            <input type="search" class="user-dashboard-search" @input="search_datatable($event)"
              placeholder="Search employee">
          </div>
        </div>
      </div>
    </div>
    <div class="login-bg-wrapper business_job_details business_inner_dash business-wrapper customer_listing_wrpa_front">
      <div class="container about-width p-0">
        <div class="filter-status row">
          <div class="col-md-8 width_mobile p-0">
            <div class="d-flex justify-between align-items-center">
              <ul class="d-flex align-items-center flex-wrap pl-0 business_links" :key="navbar_key">
                <li>
                  <span :class="{ 'active-filter': activeSpan === 0 }" @click="setActiveSpan(0)">{{ status.all }}
                    All</span>
                </li>
                <li>
                  <span :class="{ 'active-filter': activeSpan === 1 }" @click="setActiveSpan(1)">{{ status.active }}
                    Active</span>
                </li>
                <li>
                  <span :class="{ 'active-filter': activeSpan === 2 }" @click="setActiveSpan(2)">{{ status.awaited }}
                    Awaited Review</span>
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
                  <span :class="{ 'active-filter': activeSpan === 5 }" @click="setActiveSpan(5)">{{ status.hired }}
                    Hired</span>
                </li>
                <li>
                  <span :class="{ 'active-filter': activeSpan === 6 }" @click="setActiveSpan(6)">{{ status.rejected }}
                    Rejected</span>
                </li>

              </ul>
            </div>
          </div>



          <!-- <div class="col-md-1 login-section-desk text-end width_mobileS">
                        <Link class="btn btn-sm btn-success" :href="route('business-jobs.create')">Add job</Link>
                    </div> -->
        </div>
        <div class="main-job-filter mt-4">
          <ul class="d-flex align-items-center flex-wrap pl-0 business_dash_navbar_wrapper ">
            <!-- <li>
              <span>Yes (2)</span>
            </li>
            <li>
              <span>Maybe (2)</span>
            </li> -->
            <li>
              <span>Job:
                <select class="job-filter_text any_select_box" @change="filterData('job_title', $event)">
                  <option value=""> Any</option>
                  <option v-for="job in jobs" :value="job.id"> {{ job.job_title }}</option>
                </select>
              </span>
            </li>
            <!-- <li>
              <span>Assessment: <span class="job-filter_text">Any</span> <i class="bi bi-chevron-down pl-3"></i></span>
            </li> -->
            <li class="business_location_list">
              <span>
                Location:
                <select @change="filterData('location', $event)" class="job-filter_text">
                  <option value="" class="any_option">Any</option>
                  <option v-for="country in countries" :value="country.name">{{
                    country.name }}</option>
                </select>
              </span>
            </li>
            <li>
              <span class="sort_nav">Sort:
                <span class="job-filter_textss">
                  <select class="job-filter_text" @change="filterData('applied_date', $event)">
                    <option value="">Any</option>
                    <option value="desc">Apply Date(newest)</option>
                    <option value="asc">Apply Date(oldest)</option>
                  </select>
                </span>
              </span>
            </li>
          </ul>
        </div>

        <div class="main-job-filter mt-5 spacing_nine business_tablesss_inner table-responsive applied_main-wrap">
          <DataTable class="display business_dash_tables_wrapper applied_frontend_table "
            :key="refreshDataTable">
            <thead>
              <tr>
                <th>Name</th>
                <th>Job Title</th>
                <th>Status</th>
                <!-- <th>Apply Date</th> -->
                <th>Country to Immigrate</th>
                <th>Profile</th>
                <th>Visa Purpose</th>
                <th>Visa Type</th>
                <th>Country of Birth</th>
                <th>Intersts</th>
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
                <td v-html="customer?.customers?.travel_details?.type_of_visa"> </td>
                <td v-html="customer?.customers?.country_of_birth"></td>
                <td>


                  <select class="form-control select_status_wra" style="width:172px;" v-model="customer.status"
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
                  <Link class="btn btn-sm btn-success icon_eye" :href="route('view_customer', customer.customer_id)"><i
                    class="fas fa-eye"></i> </Link>
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
.success {
  color: green;
}

.main-outer-section {
  background-color: #F2F2F2;
}

.active-filter {
  color: #1A9882;
  /* Change color as per your requirement */
  border-bottom: 2px solid #1A9882;
}

.text-danger {
  color: red;
}
</style>
