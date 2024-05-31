<script setup>
import { Head, Link } from '@inertiajs/vue3';
import Header from '../Frontend/Header.vue';
import Footer from '../Frontend/Footer.vue';



const props = defineProps({
  footer_data: {
    type: Object
  },
  user: {
    type: Object
  },
  jobs_created: {
    type: Number
  },
  total_customers:{
    type:Number
  }
});


</script>

<template>
  <Header :logo_image="footer_data.logo_image" />
  <div class="container my-4">
    <h3>Welcome, {{ user.name }}:</h3>
      <div class="d-flex">
        <div class="col-lg-3 col-md-6 col-xl-3 mb-3">
          <Link :href="route('business-jobs.index')">
            <div class="card bg-success text-white mb-3 card-flex py-2">
                <div class="card-header">
                  <h4>Total Jobs Created</h4>
                </div>
                <div class="card-body">
                  <h3 class="card-text text-center">
                    {{ jobs_created }}
                  </h3>
                </div>
            </div>
          </Link>
        </div>
        <div class="col-lg-3 col-md-6 col-xl-3 mb-3 mx-2">
          <Link :href="route('business-jobs.index')">
            <div class="card  text-white mb-3 card-flex py-2" style="background-color:#060d1a;">
                <div class="card-header">
                  <h4>Total Candidates Applied</h4>
                </div>
                <div class="card-body">
                  <h3 class="card-text text-center">
                    {{ total_customers }}
                  </h3>
                </div>
            </div>
          </Link>
        </div>
      </div>
  </div>
  <Footer :footer_data="footer_data" />

</template>
<style scoped></style>
