<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Header from '../Frontend/Header.vue';
import Footer from '../Frontend/Footer.vue';
import { ref } from 'vue';



const props = defineProps({
  footer_data: {
    type: Object
  },
  applied_jobs:{
    type:Array
  }
});



</script>

<template>
        <Header :logo_image="footer_data.logo_image" />
        <div class="container my-3">
            <h1>Applied Jobs:</h1>
            <div class="main-job-filter mt-5 spacing_nine business_tablesss_inner">
          <DataTable class="display " :key="refreshDataTable">
            <thead>
              <tr>
                <th>Position Applied For</th>
                <th>Name</th>
                <th>Email</th>
                <th>Country to Immigrate</th>
                <th>Company Name</th>
                <th>Company Contact Number</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="customer in applied_jobs">
                <td v-html="customer?.jobs.job_title"></td>
                <td v-html="customer?.first_name + ' ' +customer?.last_name"> </td>
                <td v-html="customer?.email"></td>
                <td v-html="customer?.migrate_country"></td>
                <td v-html="customer?.jobs?.business?.company_name"></td>
                <td v-html="customer?.jobs?.business?.contact_number"></td>
                <td>
                  <div v-if="customer?.status?.status == 0" style="color:green">Active </div>
                  <div v-if="customer?.status?.status == 1" style="color:green">Awaiting Review </div>
                  <div v-if="customer?.status?.status == 2" style="color:green">Reviewed </div>
                  <div v-if="customer?.status?.status == 3" style="color:green">Contacted </div>
                  <div v-if="customer?.status?.status == 4" style="color:green">Hired </div>
                  <div v-if="customer?.status?.status == 5" style="color:red">Rejected </div>
                </td>
              </tr>
            </tbody>
          </DataTable>
          </div>
        </div>
        <Footer :footer_data="footer_data" />

</template>
<style scoped>
   
</style>
