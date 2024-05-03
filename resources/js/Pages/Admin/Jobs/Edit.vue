<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import NumberInput from '@/Components/TextInput.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import '@/../../resources/css/frontend.css';
import * as countryStateCity from 'country-state-city';
import { onMounted, ref } from 'vue';
import Multiselect from 'vue-multiselect';
import '@/../../resources/css/multiselect.css';
import { toast } from 'vue3-toastify';

const props = defineProps({
  seniorities: {
    type: Array
  },
  positions: {
    type: Array
  },
  work_experience: {
    type: Array
  },
  skills: {
    type: Array
  },
  industries: {
    type: Array
  },
  disciplines: {
    type: Array
  },
  job: {
    type: Object
  }

});



const form = useForm({
  id: props.job.id,
  job_title: props.job.job_title,
  job_image: props.job.job_image,
  job_description: props.job.job_description,
  position_id: props.job.position_id,
  seniority_id: props.job.seniority_id,
  discipline_id: props.job.discipline_id,
  work_experience_id: props.job.work_experience_id,
  skills_id: [],
  remote_work: (props.job.remote_work == 1) ? true : false,
  industry_id: props.job.industry_id,
  segment: props.job.segment,
  positions: props.job.positions,
  pin_code: props.job.pin_code,
  state: props.job.state,
  min_pay_range: props.job.min_pay_range,
  max_pay_range: props.job.max_pay_range,
  job_start_date: props.job.job_start_date,
  city: props.job.city,
  job_country: props.job.job_country,
});

onMounted( () => {
  props.skills.forEach(element => {
    if(props.job.skills_id.includes(element.id)){
      form.skills_id.push(element);
    }
  });
})

const countries = countryStateCity.Country.getAllCountries(),
image = ref(form.job_image);
function selectFile(event){
    form.job_image = event.target.files[0]
    image.value = URL.createObjectURL(form.job_image);
}

const submit = () => {
  console.log(form,'123')
    form.post(route('jobs.updates',form.id), {
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
              <TextInput id="job_title" type="text" v-model="form.job_title" placeholder="Enter job title"
                class="form-control mt-2 mb-3" />
              <InputError class="mt-2" :message="form.errors.job_title" />
            </div>
            <div class="mt-4 col-md-6">
              <label for="job_description">Job Description<span class="text-danger">*</span></label>
              <textarea id="job_description" type="text" v-model="form.job_description" placeholder="Enter job description"
                class="form-control mt-2 mb-3" /> 
              <InputError class="mt-2" :message="form.errors.job_description" />
            </div>
            <div class="mt-4 col-md-6">
              <label for="postition_type">Position Type<span class="text-danger">*</span></label>
              <select class="form-select mb-3 " aria-label="Default select example" v-model="form.position_id">
                <option selected :value="null">Select Type</option>
                <option v-for="(position, index) in positions" :key="index" :value="position.id">{{ position.name }}
                </option>
              </select>
              <InputError class="mt-2" :message="form.errors.position_id" />
            </div>
            <div class="mt-4 col-md-6">
              <label for="Seniority">Seniority<span class="text-danger">*</span></label>
              <select class="form-select mb-3 " aria-label="Default select example" v-model="form.seniority_id">
                <option selected :value="null">Select Seniority</option>
                <option v-for="(position, index) in work_experience" :key="index" :value="position.id">{{
                  position.experience }}</option>
              </select>
              <InputError class="mt-2" :message="form.errors.seniority_id" />
            </div>
            <div class="mt-4 col-md-6">
              <label for="discipline">Discipline<span class="text-danger">*</span></label>
              <select class="form-select mb-3 " aria-label="Default select example" v-model="form.discipline_id">
                <option selected :value="null">Select Type</option>
                <option v-for="(position, index) in disciplines" :key="index" :value="position.id">{{ position.name }}
                </option>
              </select>
              <InputError class="mt-2" :message="form.errors.discipline_id" />
            </div>
            <div class="mt-4 col-md-6">
              <label for="work_exp">Work Experience<span class="text-danger">*</span></label>
              <select class="form-select mb-3 " aria-label="Default select example" v-model="form.work_experience_id">
                <option selected :value="null">Select Type</option>
                <option v-for="(position, index) in work_experience" :key="index" :value="position.id">{{
                  position.experience }}</option>
              </select>
              <InputError class="mt-2" :message="form.errors.work_experience_id" />
            </div>
            <div class="mt-4 col-md-6">
              <label for="skills">Skills<span class="text-danger">*</span></label>
                <multiselect v-model="form.skills_id" :options="props.skills" :multiple="true" :close-on-select="false" :clear-on-select="false"
                 :preserve-search="true" placeholder="Select Skills" label="name" track-by="name">
              </multiselect>
              <InputError class="mt-2" :message="form.errors.skills_id" />
            </div>
            <div class="mt-4 col-md-6">
              <label for="postition_type">Country<span class="text-danger">*</span></label>
              <select class="form-select mb-3"  aria-label="Default select example" v-model="form.job_country">
                <option selected :value="null">Select Country</option>
                <option v-for="country in countries" :key="country.id" :value="country.name" :selected="country.name ==form.job_country">{{ country.name }}</option>
              </select>
              <InputError class="mt-2" :message="form.errors.job_country" />
            </div>
            <div class="mt-4 col-md-6">
              <label for="city">City<span class="text-danger">*</span></label>
             <TextInput id="city" type="text" v-model="form.city" placeholder="Enter City"
                class="form-control mt-2 mb-3"/>
              <InputError class="mt-2" :message="form.errors.city" />
            </div>
            <div class="mt-4 col-md-6">
              <label for="pin_code">Pin Code<span class="text-danger">*</span></label>
              <TextInput id="pin_code" type="number" v-model="form.pin_code" placeholder="Enter Pin Code"
                class="form-control mt-2 mb-3" />
              <InputError class="mt-2" :message="form.errors.pin_code" />
            </div>
            <div class="mt-4 col-md-6">
              <input type="radio" value="remote" v-model="form.remote_work" id="remote">
              <label for="remote">Remote Work</label>
              <input type="radio" value="hybrid" id="hybrid" v-model="form.remote_work">
              <label for="hybrid">Hybrid</label>
            </div>
            <div class="mt-4 col-md-6">
              <label for="industry">Industry<span class="text-danger">*</span></label>
              <select class="form-select mb-3" aria-label="Default select example" v-model="form.industry_id">
                <option selected :value="null">Select Industry</option>
                <option v-for="(position, index) in industries" :key="index" :value="position.id">{{ position.name }}
                </option>
              </select>
              <InputError class="mt-2" :message="form.errors.industry_id" />
            </div>
            <div class="mt-4 col-md-6">
              <label for="positions">Positions<span class="text-danger">*</span></label>
              <TextInput type="number" id="positions" v-model="form.positions" placeholder="Enter Postions"
                class="form-control mt-2 mb-3" />
              <InputError class="mt-2" :message="form.errors.positions" />
            </div>
            <div class="mt-4 col-md-6">
              <label for="Segment">Segment<span class="text-danger">*</span></label>
              <TextInput type="text" id="Segment" v-model="form.segment" placeholder="Enter Segment"
                class="form-control mt-2 mb-3" />
              <InputError class="mt-2" :message="form.errors.segment" />
            </div>

            <div class="mt-4 col-md-6">
              <label for="salary_range">Minimum and Maximum Salary<span class="text-danger">*</span></label>
              <div class="row">
                <div class="col-6">
                  <TextInput type="text" id="salary_range" v-model="form.min_pay_range" placeholder="Enter Minimum Salary"
                  class="form-control mt-2 mb-3" />
                  <InputError class="mt-2" :message="form.errors.min_pay_range" />
                </div>
                <div class="col-6">
                  <TextInput type="text" id="salary_range" v-model="form.max_pay_range" placeholder="Enter Maximum Salary"
                  class="form-control mt-2 mb-3" />
                <InputError class="mt-2" :message="form.errors.max_pay_range" />
                </div>
              </div>
            </div>
            <div class="mt-4 col-md-6">
              <label for="start_Date">Start Date<span class="text-danger">*</span></label>
              <TextInput type="date" id="start_Date" v-model="form.job_start_date" placeholder="Enter Start Date"
                class="form-control mt-2 mb-3" />
              <InputError class="mt-2" :message="form.errors.job_start_date" />
            </div>
            <div class="col-12 mt-4">
                            <div class="file-inputs mt-3 relative">
                                <div class="dotted-bg">
                                  <label for="categoryThumbnail" class="block text-gray-700 text-sm font-bold mb-2">Job Thumbnail</label>
                                <img :src="image" alt=""
                                  style="height:100px;margin-top:10px;">
                                <label for="job_image"  id ="job_label"class="form-control mt-2">
                                  {{ form.job_image ? 'Change File' : 'Upload File' }}
                                </label>
                                <input type="file" id="job_image" @change="selectFile($event)"
                                  accept="image/*" class="hidden ">
                                              </div>
                            </div>
                        </div>

            <div class="mt-4 col-md-12">

              <button type="submit" class="btn btn-primary forms-btn" :disabled="form.processing"> <i class="bi bi-arrow-right"></i> Apply Now </button>
            </div>
            <div></div><br>
          </div>
        </form>
      </div>
    </div>

   
  </AuthenticatedLayout>
</template>
<style scoped>
#job_label{
  cursor: pointer;
}
</style>
