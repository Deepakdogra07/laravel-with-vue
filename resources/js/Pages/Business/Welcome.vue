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
  <div class="container my-4">
    <h3>Welcome, {{ user.name }}:</h3>

    <!-- <table class="table table-responsive">
        <thead>
          <th>Name</th>
          <th>Job Title</th>
          <th>Status</th>
          <th>Country to Immigrate</th>
          <th>Profile</th>
          <th>Visa Status</th>
          <th>Skill Status</th>
          <th>Experience Summary</th>
          <th>Videos</th>
          <th>Interested</th>
        </thead>
        <tbody>

        </tbody>
      </table> -->
    <!-- <div class="p-6 text-black"> -->
      <DataTable class="display table-responsive" :key="refreshDataTable" style="border:2px black ;width:100%" >
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

    <!-- </div> -->

  </div>
  <Footer :footer_data="footer_data" />

</template>
<style scoped></style>
