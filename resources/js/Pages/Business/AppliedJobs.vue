<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Header from '../Frontend/Header.vue';
import Footer from '../Frontend/Footer.vue';
import { ref } from 'vue';



const props = defineProps({
    footer_data: {
        type: Object
    },
    applied_jobs: {
        type: Array
    }

});



</script>

<template>
    <Header :logo_image="footer_data.logo_image" />
    <div class="main-outer-section">
        <div class="job-list-search srch_responsive business_srccc view_customer_listings customer_listing_wrpa">
            <div class="container aboutt-width ">
                <div class="d-flex justify-between align-items-center flex-wrap gap-3 relative src_bar">
                    <div class="d-flex gap-5 align-items-center srch_navbar" style="padding:0px !important;">
                        <Link :href="route('business-jobs.index')">Jobs</Link>
                        <Link :href="route('dashboard')">Employee</Link>
                        <Link class='active-nav' :href="route('applied-business-jobs')">Applied Jobs</Link>
                    </div>
                </div>
            </div>
        </div>
        <div class="Applied_job_wrapper ">
            <div class="container applied-container_wrapper">
                <h3 class="heading_applied" style="font-family: 'open sans' !important; font-size: 23px; font-weight: 700;">Applied
                    Jobs:</h3>
                <div class="main-job-filter mt-4  spacing_nine business_tablesss_inner table-responsive">
                    <DataTable
                        class="display applied_job business_table business_dash_table business_table_dashboard job-data-table"
                        :key="refreshDataTable">
                        <thead>
                            <tr>
                               <th>Title of Job</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Country to Immigrate</th>
                                <th>Company Name</th>
                                <th>Company Contact Number</th>
                                <th>Status</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <div class="overlap_hidden_white"><tr v-for="customer in applied_jobs">
                                <td v-html="customer?.jobs?.job_title"></td>
                                <td v-html="customer?.customers?.first_name + ' ' + customer?.customers?.last_name">
                                </td>
                                <td v-html="customer?.customers?.email"></td>
                                <td v-html="customer?.customers?.migrate_country"></td>
                                <td v-html="customer?.jobs?.business?.company_name"></td>
                                <td v-html="customer?.jobs?.business?.contact_number"></td>

                                <td class="status_business">
                                    <div v-if="customer?.status == 0" style="background-color:#d6fdd6; color:#008000; padding:3px 13px; border-radius:8px; margin-bottom:8px; font-weight: 600!important; font-size: 13px; border:1px solid #008000; text-align:center;">Active </div>

                                    <div v-if="customer?.status == 1" style="background-color:#fff4e1; color:#ffa500; padding:3px 13px; border-radius:8px; margin-bottom:8px; font-weight: 600 !important; font-size: 13px; border:1px solid #ffa500; text-align:center;">Awaiting Review </div>

                                    <div v-if="customer?.status == 2" style="background-color:#bddcff; color:#002f63; padding:3px 13px; border-radius:8px; margin-bottom:8px; font-weight: 600 !important; font-size: 13px; border:1px solid #002f63; text-align:center;">Reviewed </div>

                                    <div v-if="customer?.status == 3" style="background-color:#e7e7ff; color:#111154; padding:3px 13px; border-radius:8px; margin-bottom:8px; font-weight: 600 !important; font-size: 13px; border:1px solid #111154; text-align:center;">Contacted </div>

                                    <div v-if="customer?.status == 4" style="background-color:#deffef; color:#198754; padding:3px 13px; border-radius:8px; margin-bottom:8px; font-weight: 600 !important; font-size: 13px; border:1px solid #198754; text-align:center;">Hired </div>

                                    <div v-if="customer?.status == 5" style="background-color:#ffebeb; color:#FF0000; padding:3px 13px; border-radius:8px; font-weight: 600 !important; font-size: 13px; margin-bottom:8px; border:1px solid #FF0000; text-align:center;">Rejected </div>
                                    <div>{{ formatDateTime(customer?.created_at) }}</div>
                                </td>

                                <!-- <td>
                                    <div v-if="customer?.status == 0" style="color:green">Active </div>
                                    <div v-if="customer?.status == 1" style="color:green">Awaiting Review </div>
                                    <div v-if="customer?.status == 2" style="color:green">Reviewed </div>
                                    <div v-if="customer?.status == 3" style="color:green">Contacted </div>
                                    <div v-if="customer?.status == 4" style="color:green">Hired </div>
                                    <div v-if="customer?.status == 5" style="color:red">Rejected </div>
                                </td> -->
                                <td>
                                    <Link class="btn btn-sm btn-success" :href="route('view_customer',customer.customer_id)"><i class="fas fa-eye"></i></Link>
                                </td>
                            </tr></div>
                        </tbody>
                    </DataTable>
                </div>
            </div>
        </div>
    </div>

    <Footer :footer_data="footer_data" />

</template>
<style scoped></style>
