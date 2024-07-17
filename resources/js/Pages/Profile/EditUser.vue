<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import UpdateBusiness from './Partials/UpdateBusiness.vue';
import { Head } from '@inertiajs/vue3';
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

import Header from '../Frontend/Header.vue';
import Footer from '../Frontend/Footer.vue';

const props = defineProps({
  mustVerifyEmail: Boolean,
  status: String,
  business: {
    type:Object,
    default:null
  },
  auth_type: String,
  footer_data: {
    type: Object
  }
});








</script>

<template>
  <!-- <Head title="Profile" /> -->
  <Header :logo_image="footer_data.logo_image" />

  <GuestLayout>
    <template #header>
      <div class="d-flex justify-between w-100">
        <h3>Profile</h3>

        <!-- <div v-if="auth_type == 1">
                    <button @click="copyReferralCode" class="copy-code">
                <i class="fa-solid fa-copy"></i> &nbsp;Copy discount code</button>
                </div> -->

        <!-- <div v-if="auth_type == 2">
                    <button @click="copyReferralCode" class="copy-code">
                <i class="fa-solid fa-copy"></i> &nbsp;Copy Referral code</button>
                </div> -->
      </div>
    </template>




    <div class="sm:px-6 md:px-0 lg:px-0 space-y-6 profile_update_page">
      <div class="container Profile_cnt">
        <div class="row">
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 profile_col">
            <div class="p-4 sm:p-8 bg-white shadows sm:rounded-lg admins_boxx">
              <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status" class="max-w-xl" />
            </div>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 update_pass_col">
            <div class="p-4 sm:p-8 bg-white shadows sm:rounded-lg admins_boxx">
              <UpdatePasswordForm class="max-w-xl" />
            </div>
          </div>
          <div v-if="auth_type == 2"class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-5 business_boxx">
            <div class="p-4 sm:p-8 bg-white shadows sm:rounded-lg admins_boxx">
              <UpdateBusiness :business="business" class="max-w-xl" />
            </div>
          </div>
          <!-- <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-5">
            <div class="p-4 sm:p-8 bg-white shadows sm:rounded-lg admins_boxx">
              <DeleteUserForm class="max-w-xl" />
            </div>
          </div> -->
        </div>
      </div>
    </div>
  </GuestLayout>
  <Footer :footer_data="footer_data" />
</template>
