<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import NumberInput from '@/Components/TextInput.vue';
import { Head, Link, useForm,router } from '@inertiajs/vue3';
import '@/../../resources/css/frontend.css';
import * as countryStateCity from 'country-state-city';
import { ref } from 'vue';
import { toast } from 'vue3-toastify';


const props = defineProps({
  seniorities:{
    type:Array
  },
  positions:{
    type:Array
  },
  work_experience:{
    type:Array
  },
  skills:{
    type:Array
  },
  industries:{
    type:Array
  },
  disciplines:{
    type:Array
  },
  job:{
    type:Object
  }
 
});


const form = useForm({
    id:props.job.id,
  job_title: props.job.job_title,
  position_type: props.job.position_type,
  seniority:props.job.seniority,
  discipline:props.job.discipline,
  work_experience:props.job.work_experience,
  skills: props.job.skills,
  remote_work: props.job.remote_work,
  industry: props.job.industry,
  segment: props.job.segment,
  positions: props.job.positions,
  pin_code: props.job.pin_code,
  state: props.job.state,
  pay_range: props.job.pay_range,
  job_start_date: props.job.job_start_date,
  application_link: props.job.application_link,
});
const submit = () => {
    form.put(route('jobs.update',form.id), {
      onSuccess: () => {
        toast("Job Updated Successfully!", {
          autoClose: 2000,
          theme: 'dark',
        }
        );
      },
    });
};
const states = countryStateCity.State.getStatesOfCountry('IN');
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
                            <select class="form-select mb-3 "  aria-label="Default select example" v-model="form.position_type" >
                                <option selected :value="null" >Select Type</option>
                                <option v-for="(position, index) in positions" :key="index" :value="position.id"  :selected ="form.position_type == position.id">{{ position.name }}</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.position_type" />
                        </div>   
                        <div class="mt-4 col-md-6">
                            <label for="Seniority">Seniority<span class="text-danger">*</span></label>
                            <select class="form-select mb-3 "  aria-label="Default select example" v-model="form.seniority" >
                                <option selected :value="null" >Select Seniority</option>
                                <option v-for="(position, index) in work_experience" :key="index" :value="position.id" :selected ="form.seniority.id == position.id">{{ position.experience }}</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.seniority" />
                        </div>   
                        <div class="mt-4 col-md-6">
                            <label for="discipline">Discipline<span class="text-danger">*</span></label>
                            <select class="form-select mb-3 "  aria-label="Default select example" v-model="form.discipline" >
                                <option selected :value="null" >Select Type</option>
                                <option v-for="(position, index) in disciplines" :key="index" :value="position.id" :selected ="form.discipline == position.id">{{ position.name }}</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.discipline" />
                        </div>   
                        <div class="mt-4 col-md-6">
                            <label for="work_exp">Work Experience<span class="text-danger">*</span></label>
                            <select class="form-select mb-3 "  aria-label="Default select example" v-model="form.work_experience" >
                                <option selected :value="null" >Select Type</option>
                                <option v-for="(position, index) in work_experience" :key="index" :value="position.id">{{ position.experience }}</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.work_experience" />
                        </div>   
                        <div class="mt-4 col-md-6">
                            <label for="skills">Skills<span class="text-danger">*</span></label>
                            <select class="form-select mb-3 " :multiple="true" aria-label="Default select example" v-model="form.skills" >
                                <option selected :value="null" >Select Type</option>
                                <option v-for="(position, index) in skills" :key="index" :value="position.id" :selected="form.skills[0] == position.id">{{ position.name }}</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.skills" />
                        </div>   
                        <!-- <div class="mt-4 col-md-6">
                            <label for="Work Experience">Work Experience<span class="text-danger">*</span></label>
                            <select class="form-select mb-3 "  aria-label="Default select example" v-model="form.work_experience" >
                                <option selected :value="null" >Select Type</option>
                                <option v-for="(position, index) in work_experience" :key="index" :value="position.id">{{ position.name }}</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.work_experience" />
                        </div>    -->
                        
                        <div class="mt-4 col-md-6">
                          <label for="postition_type">State/City<span class="text-danger">*</span></label>
                          <select class="form-select mb-3" aria-label="Default select example" v-model="form.state">
                            <option selected :value="null" >Select State</option>
                            <option v-for="country in states" :key="country.id" :value="country.isoCode">{{ country.name }}</option>
                          </select>
                          <InputError class="mt-2" :message="form.errors.state" />
                        </div>  
                        <div class="mt-4 col-md-6">
                            <label for="pin_code">Pin Code<span class="text-danger">*</span></label>
                            <TextInput id="pin_code" type="number" v-model="form.pin_code" placeholder="Enter job title" class="form-control mt-2 mb-3" />
                            <InputError class="mt-2" :message="form.errors.pin_code" />
                        </div> 
                        <div class="mt-4 col-md-6">                        
                            <div class="form-check form-switch">
                              <input class="form-check-input" v-model="form.remote_work" type="checkbox" id="flexSwitchCheckDefault">
                              <label class="form-check-label" for="flexSwitchCheckDefault">Remote Work</label>
                            </div>
                          <InputError class="mt-2" :message="form.errors.remote_work" />
                        </div>
                        <div class="mt-4 col-md-6">
                          <label for="industry">Industry<span class="text-danger">*</span></label>
                          <select class="form-select mb-3" aria-label="Default select example" v-model="form.industry">
                            <option selected :value="null" >Select Industry</option>
                            <option v-for="(position, index) in industries" :key="index" :value="position.id" :selected="form.industry == position.id">{{ position.name }}</option>
                          </select>
                          <InputError class="mt-2" :message="form.errors.industry" />
                        </div>  
                        <div class="mt-4 col-md-6">
                          <label for="positions">Positions<span class="text-danger">*</span></label>
                          <TextInput type="number" id="positions"  v-model="form.positions" placeholder="Enter Postions" class="form-control mt-2 mb-3" />
                          <InputError class="mt-2" :message="form.errors.positions" />
                        </div>  
                        <div class="mt-4 col-md-6">
                          <label for="Segment">Segment<span class="text-danger">*</span></label>
                          <TextInput type="text" id="Segment"  v-model="form.segment" placeholder="Enter Postions" class="form-control mt-2 mb-3" />
                          <InputError class="mt-2" :message="form.errors.segment" />
                        </div>  

                        <div class="mt-4 col-md-6">
                          <label for="salary_range">Pay Range<span class="text-danger">*</span></label>
                          <TextInput type="text" id="salary_range"  v-model="form.pay_range" placeholder="Enter Postions" class="form-control mt-2 mb-3" />
                          <InputError class="mt-2" :message="form.errors.pay_range" />
                        </div>  
                        <div class="mt-4 col-md-6">
                          <label for="start_Date">Start Date<span class="text-danger">*</span></label>
                          <TextInput type="date" id="start_Date"  v-model="form.job_start_date" placeholder="Enter Postions" class="form-control mt-2 mb-3" />
                          <InputError class="mt-2" :message="form.errors.job_start_date" />
                        </div>  
                        <div class="mt-4 col-md-6">
                          <div class="form-check form-switch">
                              <input class="form-check-input" v-model="form.application_link" type="checkbox" id="flexSwitchCheckDefault">
                              <label class="form-check-label" for="flexSwitchCheckDefault">Apply Link</label>
                            </div>
                            <InputError class="mt-2" :message="form.errors.application_link" />
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
