<script setup>
import Header from '@/Pages/Frontend/Header.vue'
import Footer from '@/Pages/Frontend/Footer.vue'
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const activeSpan = ref(null);

const setActiveSpan = (spanNumber) => {
  if (activeSpan.value === spanNumber) {
    activeSpan.value = null; // Toggle off if clicking on the same span
  } else {
    activeSpan.value = spanNumber; // Set the clicked span as active
  }
};


</script>
<template>
    <Header />
    <div class="main-outer-section">
        <div class="job-list-search">
            <div class="container">
                <div class="d-flex justify-between align-items-center flex-wrap gap-3">
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
                    <ul class="d-flex align-items-center flex-wrap pl-0">
                        <li>
                            <span :class="{'active-filter': activeSpan === 1 }" @click="setActiveSpan(1)">17 Active</span>
                        </li>
                        <li>
                            <span :class="{'active-filter': activeSpan === 2 }" @click="setActiveSpan(2)">12 Awaiting Review</span>
                        </li>
                        <li>
                            <span :class="{'active-filter': activeSpan === 3 }" @click="setActiveSpan(3)">2 Reviewed</span>
                        </li>
                        <li>
                            <span :class="{'active-filter': activeSpan === 4 }" @click="setActiveSpan(4)">2 Contacted</span>
                        </li>
                        <li>
                            <span :class="{'active-filter': activeSpan === 5 }" @click="setActiveSpan(5)">0 Hired</span>
                        </li>
                        <li>
                            <span :class="{'active-filter': activeSpan === 6 }" @click="setActiveSpan(6)">22 Rejected</span>
                        </li>
                    </ul>
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
            </div>
        </div>
    </div>
    <Footer />
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