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
        <div class="Applied_job_wrapper">
          <div class="container applied-container_wrapper">
              <h3 class="pt-3 heading_applied" style="font-family: 'open sans' !important; font-size: 23px;">Applied Jobs:</h3>
              <div class="main-job-filter mt-4  spacing_nine business_tablesss_inner">
            <DataTable class="display applied_job business_table business_dash_table business_table_dashboard job-data-table" :key="refreshDataTable">
              <thead>
                <tr>
                  <th>Title of Job</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Country to Immigrate</th>
                  <th>Company Name</th>
                  <th>Company Contact Number</th>
                  <th>Status</th>
                  <th>View Details</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="customer in applied_jobs">
                                <td v-html="customer?.jobs?.job_title"></td>
                                <td v-html="customer?.customers?.first_name + ' ' + customer?.customers?.last_name">
                                </td>
                                <td v-html="customer?.customers?.email"></td>
                                <td v-html="customer?.customers?.migrate_country"></td>
                                <td v-html="customer?.jobs?.business?.company_name"></td>
                                <td v-html="customer?.jobs?.business?.contact_number"></td>
                                <td>
                                    <div v-if="customer?.status == 0" style="color:green">Active </div>
                                    <div v-if="customer?.status == 1" style="color:green">Awaiting Review </div>
                                    <div v-if="customer?.status == 2" style="color:green">Reviewed </div>
                                    <div v-if="customer?.status == 3" style="color:green">Contacted </div>
                                    <div v-if="customer?.status == 4" style="color:green">Hired </div>
                                    <div v-if="customer?.status == 5" style="color:red">Rejected </div>
                                </td>
                                <td>
                                    <Link class="btn btn-sm btn-success" :href="route('view_customer_data',customer.customer_id)"><i class="fas fa-eye"></i></Link>
                                </td>
                            </tr>
              </tbody>
            </DataTable>
            </div>
          </div>
        </div>
         
        <Footer :footer_data="footer_data" />

</template>
<style scoped>
   
</style>
