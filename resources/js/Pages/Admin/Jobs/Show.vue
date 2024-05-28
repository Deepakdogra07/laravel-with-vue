<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Link } from '@inertiajs/vue3';
import { onMounted, reactive, ref } from 'vue';
import Swal from 'sweetalert2';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import * as countryStateCity from 'country-state-city';

const props = defineProps({
    jobs: {
        type: Array
    },
    skills: {
        type: Array
    },
    industries: {
        type: Array
    },
    languages: {
        type: Array
    }

});
const skills = ref(''),
    language = ref(''),
    industry = ref('');
onMounted(() => {
    props.skills.forEach(element => {
        if (props.jobs.skills_id.includes(element.id)) {
            skills.value += element.name + ',';
        }
    });
    props.languages.forEach(element => {
        if (props.jobs.language_id.includes(element.id)) {
            language.value += element.name + ',';
        }
    });
    props.industries.forEach(element => {
        if (props.jobs.industry_id.includes(element.id)) {
            industry.value += element.name + ',';
        }
    });
});

const states = countryStateCity.State.getStatesOfCountry('IN');

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-black-800 leading-tight">View Job</h2>
            <div class="button-container">
            </div>

        </template>

        <div class="nav-container jobs_tabss">
            <div class="form-navigation1">
                <div class="container">
                    <ul class="row nav-underline pl-0 mb-0">
                        <div class="col-md-2 col-3">
                            <li class="nav-item">
                                <Link class="nav-link text-center" aria-current="page"
                                    :class="{ 'active': route().current('jobs.show', jobs.id) }"
                                    :href="route('jobs.show', jobs.id)">View Job</Link>
                            </li>
                        </div>
                        <div class="col-lg-2 col-md-3 col-5">
                            <li class="nav-item">
                                <Link class="nav-link text-center"
                                    :class="{ 'active': route().current('jobs.show', jobs.id) }"
                                    :href="route('job_for_customers', jobs.id)">Employees</Link>
                                <!-- :class="{ 'active': route().current('register') }"   -->
                            </li>
                        </div>
                    </ul>
                </div>
            </div>
        </div>

        <div class="py-12 spacing_sshhow">
            <div class="max-w-7xl mx-auto px-2 view_job_page">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;">
                    <div class="p-6 text-black-900 padding_iiii">
                        <div class="container">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-header-caption">
                                        <div class="card-header-title">
                                            <h2><b>Job Title:</b>{{ jobs?.job_title }}</h2>
                                            <br>
                                            <h4><b>Positions:</b>{{ jobs?.positions }}</h4>
                                            <br>
                                            <p><b>Postion Type:</b>{{ jobs?.position?.name }}</p>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <ul class="card_ullist card_ullist_2nd">
                                                    <li><b>Seniority:</b>{{ jobs?.seniority?.name }}</li>
                                                    <li><b>Discipline:</b>{{ jobs?.discipline?.name }}</li>
                                                    <li><b>Work Experience:</b>{{ jobs?.work_experience?.experience }}
                                                    </li>
                                                    <li><b>Skills:</b>{{ skills }}</li>
                                                    <li><b>Remote Work:</b>
                                                        <p v-if="jobs.remote_work">Yes</p>
                                                        <p v-else>No</p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-12">
                                                <ul class="card_ullist  card_ullist_2nd">
                                                    <li> <b>Industry:</b>{{ industry }}</li>
                                                    <li><b>Segment:</b>{{ jobs?.segment }}</li>
                                                    <li> <b>Pin Code:</b>{{ jobs?.pin_code }}</li>
                                                    <li><b>City:</b>{{ jobs.city }}</li>
                                                    <li><b>Pay Range:</b>{{ jobs?.min_pay_range }}-{{
                                                        jobs?.max_pay_range }}
                                                    </li>
                                                    <li><b>Job Start Date:</b>{{ jobs?.job_start_date }}</li>
                                                    <li> <b>Languages:</b>{{ language }}</li>
                                                    <li><b>Created By:</b>{{ jobs?.createdby?.name }}</li>
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="card-content mt-5">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="details_job">
                                                    <h2>Requirements:</h2>
                                                    <p v-html="jobs?.requirements"></p>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="details_job">
                                                    <h2>Conditions:</h2>
                                                    <p v-html="jobs?.conditions"></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 mt-5">
                                            <div class="details_job">
                                                <h2>Details of The Job:</h2>
                                                <p v-html="jobs?.job_description"></p>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- <div class="card-content">
                                        <p> <b>Seniority:</b>{{ jobs?.seniority?.name }}
                                            &nbsp;
                                            <b>Discipline:</b>{{ jobs?.discipline?.name }}
                                            &nbsp;
                                            <b>Work Experience:</b>{{ jobs?.work_experience?.experience }}
                                            &nbsp;
                                            <b>Skills:</b>{{ jobs?.skills?.name }}
                                            &nbsp;
                                            <b>Remote Work:</b>
                                            <p v-if="jobs.remote_work">Yes</p>
                                            <p v-else>No</p>
                                            &nbsp;
                                            <b>Industry:</b>{{ jobs?.industry?.name }}
                                            &nbsp;
                                            <b>Segment:</b>{{ jobs?.segment }}
                                            &nbsp;
                                            <b>Pin Code:</b>{{ jobs?.pin_code }}
                                            &nbsp;
                                            <b>City:</b>{{ jobs.state }}
                                            &nbsp;
                                            <b>Pay Range:</b>{{ jobs?.pay_range }}
                                            &nbsp;
                                            <b>Job Start Date:</b>{{ jobs?.job_start_date }}
                                            <br>
                                            <b>Created By:</b>{{ jobs?.createdby?.name }}
                                        </p>   
                                    </div>        -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.success {
    color: green;
}
</style>
