<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm,router } from '@inertiajs/vue3';
import '@/../../resources/css/frontend.css';
import * as countryStateCity from 'country-state-city';
import { ref } from 'vue';




const form = useForm({
    job_title: null,
    position_type: null,
    seniority:null,
    discipline:null,
    work_experience:null,
    skills: null,
    remote_work: null,
    industry: null,
    segment: null,
    positions: null,
    pin_code: null,
    city: null,
    state: null,
    pay_range: null,
    job_start_date: null,
    application_link: null,
});

defineProps({
  errors: Object,
  testimonialRecords: Array,
})

function submit() {
  router.post('/jobs', form, {
    onSuccess: page => {
      toast("Testimonial Added Successfully!", {
        autoClose: 2000,
        theme: 'dark',
      });
    },
  });
}
const states = countryStateCity.State.getAllStates();
</script>
<template>
    <AuthenticatedLayout>
          <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Job</h2>
          </template>

          <div class="flex items-center justify-center">
            <div class="w-full px-2">
                <form @submit.prevent="submit" enctype="multipart/form-data">
                    <div class="row">
                        <div class="mt-4 col-md-6">
                            <label for="job_title">Job Title<span class="text-danger">*</span></label>
                            <TextInput id="job_title" type="text" v-model="form.job_title" placeholder="Enter job title" class="form-control mt-2 mb-3" />
                            <InputError class="mt-2" :message="form.errors.job_title" />
                        </div> 
                        <div class="mt-4 col-md-6">
                            <label for="postition_type">Position Type<span class="text-danger">*</span></label>
                            <select class="form-select mb-3" aria-label="Default select example" v-model="form.position_type">
                                <option selected :value="null" >Select Type</option>
                                <option value="fresher">Fresher</option>
                                <option value="associate">Associate</option>
                                <option value="mid_senior">Mid Senior Level</option>
                                <option value="senior">Senior Level</option>
                                <option value="team_lead"> Team Lead</option>
                                <option value="project_manager">Project Manager</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.state" />
                        </div>   
                        <div class="mt-4 col-md-6">
                            <label for="postition_type">State<span class="text-danger">*</span></label>
                            <select class="form-select mb-3" @change="select_country($event)" aria-label="Default select example" v-model="form.state">
                                <option selected :value="null" >Select State</option>
                                <option v-for="country in states" :key="country.id" :value="country.isoCode">{{ country.name }}</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.state" />
                        </div>  
                        
                        <div class="mt-4 col-md-12">
                               <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <div></div><br>
                    </div>
                </form>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
<style>

</style>
