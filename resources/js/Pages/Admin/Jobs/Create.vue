<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import '@/../../resources/css/frontend.css';
import '@/../../resources/css/multiselect.css';
import * as countryStateCity from 'country-state-city';
import Multiselect from 'vue-multiselect';
import { ref } from 'vue';
import Checkbox from '@/Components/Checkbox.vue';
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import '@vueup/vue-quill/dist/vue-quill.bubble.css';

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

});
const countries = countryStateCity.Country.getAllCountries(),
image = ref('');


const form = useForm({
  job_image:null,
  job_title: null,
  job_description: null,
  position_id: null,
  seniority_id: null,
  discipline_id: null,
  work_experience_id: null,
  skills_id: null,
  remote_work: false,
  industry_id: null,
  segment: null,
  positions: null,
  pin_code: null,
  job_country: null,
  city: null,
  min_pay_range: null,
  max_pay_range: null,
  job_start_date: null,
});

function selectFile(event){
    form.job_image = event.target.files[0]
    image.value = URL.createObjectURL(form.job_image);
    console.log(image)
}


const submit = () => {
    form.post(route('jobs.store'),
    {
      onSuccess: () => {
        toast("Job Created Successfully!", {
          autoClose: 2000,
          theme: 'dark',
        }
        );
      },
    });
};
</script>
<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Job</h2>
    </template>

    <div class="flex items-center justify-center">
      <div class="login-bg-wrapper">
        <div class="about-us-bg-wrapper">
            <div class="container">
                <form @submit.prevent="submit" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Job Title<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                     <TextInput id="job_title" type="text" v-model="form.job_title" placeholder="Enter job title"
                                        class="form-control mt-2" />
                                </div>
                                    <InputError class="mt-2" :message="form.errors.job_title" />
                               
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <label for="job_description">Job Description<span class="text-danger">*</span></label>
                                <div class="eye-icon-div">
                                    <QuillEditor contentType="html" toolbar="essential" v-model:content="form.job_description" placeholder="Enter Job Description"/>
                                </div>
                                    <InputError class="mt-2" :message="form.errors.job_description" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Position type<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <select class="form-select mb-3 " aria-label="Default select example" v-model="form.position_id">
                                        <option selected :value="null">Select Type</option>
                                        <option v-for="(position, index) in positions" :key="index" :value="position.id">{{ position.name }}
                                        </option>
                                    </select>
                                </div>
                                <InputError class="mt-2" :message="form.errors.position_id" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <label for="Seniority">Seniority<span class="text-danger">*</span></label>
                                <div class="eye-icon-div">
                                    <select class="form-select mb-3 " aria-label="Default select example" v-model="form.seniority_id">
                                        <option selected :value="null">Select Seniority</option>
                                        <option v-for="(position, index) in work_experience" :key="index" :value="position.id">{{
                                        position.experience }}</option>
                                    </select>
                                </div>
                                <InputError class="mt-2" :message="form.errors.seniority_id" />
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mt-4">
                                <label for="discipline">Discipline<span class="text-danger">*</span></label>
                                <div class="eye-icon-div">
                                    <select class="form-select mb-3 " aria-label="Default select example" v-model="form.discipline_id">
                                        <option selected :value="null">Select Type</option>
                                        <option v-for="(position, index) in disciplines" :key="index" :value="position.id">{{ position.name }}
                                        </option>
                                    </select>
                                </div>
                                <InputError class="mt-2" :message="form.errors.discipline_id" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <label class="flex items-center">
                                    <Checkbox class="remember-me-check" name="remember" />
                                    <span class="label text-label pl-2">Remote Work</span>
                                </label>
                                <div class="d-flex align-items-center mt-3 gap-4">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" class="radio-new-btn" name="remote_work">
                                        <label class="pl-2" for="">Remote Work</label>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <input type="radio" class="radio-new-btn" name="remote_work">
                                        <label class="pl-2" for="">Hybrid</label>
                                    </div>
                                </div>
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Overall Work Experience<span class="text-danger">*</span></span>
                                <div class="eye-icon-div">
                                    <select class="form-select mb-3 " aria-label="Default select example" v-model="form.work_experience_id">
                                        <option selected :value="null">Select Type</option>
                                        <option v-for="(position, index) in work_experience" :key="index" :value="position.id">{{
                                        position.experience }}</option>
                                    </select>
                                </div>
                                <InputError class="mt-2" :message="form.errors.work_experience_id" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Skills<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                        <multiselect v-model="form.skills_id" :options="props.skills" :multiple="true" :close-on-select="false" :clear-on-select="false"
                                        :preserve-search="true" placeholder="Select Skills" label="name" track-by="name">
                                    </multiselect>
                                </div>
                                <InputError class="mt-2" :message="form.errors.skills_id" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Country<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <select class="form-select mb-3"  aria-label="Default select example" v-model="form.job_country">
                                        <option selected :value="null">Select Country</option>
                                        <option v-for="country in countries" :key="country.id" :value="country.name">{{ country.name }}</option>
                                    </select>
                                </div>
                                <InputError class="mt-2" :message="form.errors.job_country" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">City<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <TextInput id="city" type="text" v-model="form.city" placeholder="Enter City"
                                     class="form-control mt-2 mb-3"/>
                                    </div>
                                    <InputError class="mt-2" :message="form.errors.city" />
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Pin Code</span>
                                <div class="eye-icon-div">
                                    <TextInput id="pin_code" type="number" v-model="form.pin_code" placeholder="Enter Pin Code"
                                    class="form-control mt-2 mb-3" />
                                    <InputError class="mt-2" :message="form.errors.pin_code" />
                                </div>
                                <!-- <div class="mt-4">
                                    <span class="label text-label">Recommend Skills</span>
                                    <div class="d-flex align-items-center gap-2 mt-2 flex-wrap">
                                        <div class="pre-skill-selected">
                                            <p class="mb-0">Dokumentation</p>
                                        </div>
                                        <div class="pre-skill-selected">
                                            <p class="mb-0">Mechanical</p>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Industry<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <select class="form-select mb-3" aria-label="Default select example" v-model="form.industry_id">
                                        <option selected :value="null">Select Industry</option>
                                        <option v-for="(position, index) in industries" :key="index" :value="position.id">{{ position.name }}
                                        </option>
                                    </select>
                                </div>
                                <InputError class="mt-2" :message="form.errors.industry_id" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Positions</span>
                                <div class="eye-icon-div">
                                    <TextInput type="number" id="positions" v-model="form.positions" placeholder="Enter Postions"
                                        class="form-control mt-2 mb-3" />
                                    <InputError class="mt-2" :message="form.errors.positions" />
                                </div>
                            </div>
                            <div class="mt-4">
                                <span class="label text-label">Segment</span>
                                <TextInput type="text" id="Segment" v-model="form.segment" placeholder="Enter Segment"
                                    class="form-control mt-2 mb-3" />
                                <InputError class="mt-2" :message="form.errors.segment" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-4">
                                <span class="label text-label">Minimum and Maximum Salary<span style="color:red">
                                        *</span></span>
                                <div class="row">
                                    <div class="col-md-6 eye-icon-div">
                                        <TextInput type="text" id="salary_range" v-model="form.min_pay_range" placeholder="Enter Minimum Salary"
                                            class="form-control mt-2 mb-3" />
                                        <InputError class="mt-2" :message="form.errors.min_pay_range" />
                                    </div>
                                    <div class="col-md-6 eye-icon-div">
                                        <TextInput type="text" id="salary_range" v-model="form.max_pay_range" placeholder="Enter Maximum Salary"
                                            class="form-control mt-2 mb-3" />
                                        <InputError class="mt-2" :message="form.errors.max_pay_range" />
                                    </div>

                                </div>
                            </div>
                            <div class="mt-4">
                                <span class="label text-label">Start Date<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <TextInput type="date" id="start_Date" v-model="form.job_start_date" placeholder="Enter Start Date"
                                        class="form-control mt-2 mb-3" />
                                </div>
                                <InputError class="mt-2" :message="form.errors.job_start_date" />
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <div class="file-inputs mt-3 relative">
                                <div class="dotted-bg">
                                <img :src="image " alt="" srcset="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"
                                        fill="none">
                                        <path
                                            d="M54.0774 47.7783L54.0771 47.7778L43.0478 32.5166C43.047 32.5155 43.0463 32.5145 43.0455 32.5134C41.5448 30.4238 38.4396 30.4235 36.9386 32.5128C36.9377 32.5141 36.9368 32.5153 36.9359 32.5166L25.9066 47.7778L25.9062 47.7783C24.1017 50.2769 25.8784 53.7609 28.9661 53.7609H32.6383V67.1046H15.4721C8.09988 66.6655 2 59.6549 2 51.908C2 46.6514 4.84793 42.0611 9.08693 39.5752L10.5322 38.7276L9.951 37.1562C9.59374 36.1903 9.40499 35.1506 9.40499 34.0412C9.40499 29.0159 13.4626 24.9583 18.4879 24.9583C19.5794 24.9583 20.6192 25.1465 21.5866 25.5043L23.3067 26.1405L24.0892 24.4818C27.3185 17.6362 34.28 12.8951 42.3688 12.8945C52.8366 12.9101 61.4659 20.9279 62.4473 31.143L62.5934 32.664L64.0993 32.9228C71.9373 34.2702 78 41.5883 78 49.9301C78 58.8106 71.0858 66.4598 62.4369 67.1046H47.3453V53.7609H51.0176C54.0719 53.7609 55.8919 50.2907 54.0774 47.7783Z"
                                            stroke="#01796F" stroke-width="4" />
                                    </svg>
                                    <h2 class="choose-para">Upload a thumbnail of the job</h2>
                                    <p class="file-type">Max size 20MB</p>
                                    <input class="upload" type="file" id="banner"
                                        @change="selectFile($event)" />
                                    </div>
                                </div>
                        </div>
                        <div class="col-12 ">
                            <div class="flex items-center justify-center mt-4 login-btn-main">
                                
                                <PrimaryButton type="submit" class="forms-btn" :disabled="form.processing">
                                    Apply Now <span> <i class="bi bi-arrow-right"></i></span>
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

   
  </AuthenticatedLayout>
</template>
