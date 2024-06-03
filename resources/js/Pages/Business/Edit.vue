<script setup>
import Header from "../Frontend/Header.vue"
import Footer from "../Frontend/Footer.vue";
import SubHeading from '@/Pages/Frontend/SubHeading.vue'
import { Head, Link, useForm } from '@inertiajs/vue3';
import CustomPagination from '@/Components/CustomPagination.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import Checkbox from '@/Components/Checkbox.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref,onMounted } from "vue";
import { toast } from 'vue3-toastify';
import '@@/frontend.css';
import '@@/multiselect.css';
import * as countryStateCity from 'country-state-city';
import Multiselect from 'vue-multiselect';
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import '@vueup/vue-quill/dist/vue-quill.bubble.css';
import '@vuepic/vue-datepicker/dist/main.css'; 
import VueDatePicker from '@vuepic/vue-datepicker'; 

const today = new Date();
const format = (date) => {
  const day = date.getDate();
  const month = date.getMonth() + 1;
  const year = date.getFullYear();
  var month1 = (month <=9) ?`0${month}`:month;
  form.job_start_date = `${year}-${month1}-${day}`;
  return `${year}/${month1}/${day}`;
}




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
  },
  languages:{
    type:Array
  },
  currencies:{
    type:Array
  }

});


const form = useForm({
  id: props.job.id,
  job_title: props.job.job_title,
  job_image: props.job.job_image,
  job_description: props.job.job_description,
  detail: props.job.detail,
  conditions: props.job.conditions,
  requirements: props.job.requirements,
  language_id : [],
  posting_summary: props.job.posting_summary,
//   job_description: props.job.job_description,
  position_id: props.job.position_id,
  seniority_id: props.job.seniority_id,
  discipline_id: props.job.discipline_id,
  work_experience_id: props.job.work_experience_id,
  skills_id: [],
  remote_work: props.job.remote_work,
  industry_id: [],
  segment: props.job.segment,
  positions: props.job.positions,
  pin_code: props.job.pin_code,
  state: props.job.state,
  min_pay_range: props.job.min_pay_range,
  max_pay_range: props.job.max_pay_range,
  job_start_date: props.job.job_start_date,
  city: props.job.city,
  job_country: props.job.job_country,
  currency_id:props.job.currency_id,
  recommended_skills: JSON.parse(props.job.recommended_skills)
});
onMounted( () => {
    props.skills.forEach(element => {
        if(props.job.skills_id.includes(element.id)){
            form.skills_id.push(element);
        }
    });
    // form.recommended_skills = JSON.parse(props.job.recommended_skills);
    props.languages.forEach(element => {
        if(props.job.language_id.includes(element.id)){
            form.language_id.push(element);
        }
    });
    props.industries.forEach(element => {
        if(props.job.industry_id.includes(element.id)){
            form.industry_id.push(element);
        }
    });
    if(form.recommended_skills.includes('documentation')){
        active_checkbox.value.documentation = 'active-checkbox';
    }
    if(form.recommended_skills.includes('technical')){
        active_checkbox.value.technical = 'active-checkbox';
    }
    if(form.recommended_skills.includes('electrician')){
        active_checkbox.value.electrician = 'active-checkbox';
    }
    if(form.recommended_skills.includes('mechanical')){
        active_checkbox.value.mechanical = 'active-checkbox';
    }
})
const active_checkbox =ref({
        documentation:'',
        mechanical:'',
        electrician:'',
        technical:''
    });

const countries = countryStateCity.Country.getAllCountries(),
image = ref(form.job_image);
function selectFile(event){
    form.job_image = event.target.files[0]
    image.value = URL.createObjectURL(form.job_image);
}

const submit = () => {
    form.post(route('business-jobs.updates',form.id), {
      onSuccess: () => {
        toast("Job Updated Successfully!", {
          autoClose: 2000,
          theme: 'dark',
        }
        );
      },
    });
};
// function select_skill(skill){
//     let index = form.skills_id.findIndex(s => s.id === skill.id);
//     if(index !== -1){
//         form.skills_id.splice(index,1);
//     }else{
//         index = props.skills.findIndex(s => s.id === skill.id);
//         if(index >0){
//             form.skills_id.push(skill);
//         }
//     }   
// }
function checked_event(event){
    if(event.target.checked){
        form.recommended_skills.push(event.target.value);
    }else{
        form.recommended_skills.splice(event.target.value,1);
    }
}
const  select_class = ref('');
function handleChange(){
        select_class.value = 'Selected_option';
}
console.log(select_class,'selected_class')
</script>

<template>

    <Head title="Job Application Form" />
    <Header class="login-wrapper" />
    <SubHeading :job_id="form.id" />
    <div class="login-bg-wrapper create_space create_code">
        <div class="about-us-bg-wrapper">
            <div class="container">
                <form @submit.prevent="submit" enctype="multipart/form-data">
                    <div class="row add-job-form-section job_posting_page">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="mt-4 ">
                                <span class="label text-label">Job Title <span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <TextInput id="job_title" type="text" v-model="form.job_title"
                                        placeholder="Enter job title" class="form-control mt-2" />
                                </div>
                                <InputError class="mt-2" :message="form.errors.job_title" />

                            </div>
                            <div class="mt-4">
                                <span class="label text-label">Position type<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <select class="form-select   mt-2 Selected_option " aria-label="Default select example"
                                        v-model="form.position_id">
                                        <option selected :value="null">Select Type</option>
                                        <option v-for="(position, index) in positions" :key="index"
                                            :value="position.id">{{ position.name }}
                                        </option>
                                    </select>
                                </div>
                                <InputError class="mt-2" :message="form.errors.position_id" />
                            </div>
                            <div class="mt-4">
                                <label for="Seniority">Seniority<span class="text-danger"> *</span></label>
                                <div class="eye-icon-div">
                                    <select class="form-select  mt-2 Selected_option "  aria-label="Default select example"
                                        v-model="form.seniority_id" >
                                        <option selected :value="null">Select Seniority</option>
                                        <option v-for="(position, index) in seniorities" :key="index"
                                            :value="position.id">{{
                                                position.name }}</option>
                                    </select>
                                </div>
                                <InputError class="mt-2" :message="form.errors.seniority_id" />
                            </div>
                            <div class="mt-4">
                                <label for="discipline">Discipline<span class="text-danger"> *</span></label>
                                <div class="eye-icon-div">
                                    <select class="form-select  mt-2  Selected_option" aria-label="Default select example"
                                        v-model="form.discipline_id">
                                        <option selected :value="null">Select Type</option>
                                        <option v-for="(position, index) in disciplines" :key="index"
                                            :value="position.id">{{ position.name }}
                                        </option>
                                    </select>
                                </div>
                                <InputError class="mt-2" :message="form.errors.discipline_id" />
                            </div>
                            <div class="mt-4 arrow_label">
                                <span class="label text-label">Overall Work Experience<span
                                        class="text-danger"> *</span></span>
                                <div class="eye-icon-div skills_input">
                                    <select class="form-select   mt-2 Selected_option"  aria-label="Default select example"
                                        v-model="form.work_experience_id">
                                        <option selected :value="null">Select Type</option>
                                        <option v-for="(position, index) in work_experience" :key="index"
                                            :value="position.id">{{
                                                position.experience }}</option>
                                    </select>
                                </div>
                                <InputError class="mt-2" :message="form.errors.work_experience_id" />
                            </div>
                            <div class="mt-4">
                                <span class="label text-label">Skills<span style="color:red"> *</span></span>
                                <div class="eye-icon-div skills_input">
                                    <multiselect v-model="form.skills_id" :options="props.skills" :multiple="true"
                                        :close-on-select="false" :clear-on-select="false" :preserve-search="true"
                                        placeholder="Select Skills" label="name" track-by="name">
                                    </multiselect>
                                    <InputError class="mt-2" :message="form.errors.skills_id" />
                                </div>
                                <div class="mt-4">
                                            <label class="label text-label recommended_text">Recommended Skills</label>
                                            <ul class="job_recommenrded_skills pl-0">
                                                <div class="recommended_checkbox" :class = "active_checkbox.documentation">
                                                    <!--  -->
                                                    <TextInput type="checkbox" @click="checked_event($event)"
                                                        :checked="form.recommended_skills.includes('documentation')"
                                                        
                                                        class="recommended_checkbox" value="documentation"
                                                        id="documents-1" />
                                                    <label class="label_checkbox" for="documents-1">
                                                        Documentation</label>
                                                </div>
                                                <div class="recommended_checkbox" :class = "active_checkbox.mechanical">
                                                    <TextInput type="checkbox" @click="checked_event($event)"
                                                        :checked="form.recommended_skills.includes('mechanical')"
                                                        class="recommended_checkbox" value="mechanical"

                                                        id="documents-2" />
                                                    <label class="label_checkbox" for="documents-2"> Mechanical </label>
                                                </div>
                                                <div class="recommended_checkbox" :class = "active_checkbox.technical" >
                                                    <TextInput type="checkbox" @click="checked_event($event)"
                                                        :checked="form.recommended_skills.includes('technical')"
                                                        class="recommended_checkbox" value="technical"
                                                        id="documents-3" />
                                                    <label class="label_checkbox" for="documents-3"> Technical</label>
                                                </div>
                                                <div class="recommended_checkbox" :class = "active_checkbox.electrician">
                                                    <TextInput type="checkbox" @click="checked_event($event)"
                                                        :checked="form.recommended_skills.includes('electrician')"
                                                        class="recommended_checkbox" value="electrician"
                                                        id="documents-4" />
                                                    <label class="label_checkbox" for="documents-4"> Electrician
                                                    </label>
                                                </div>
                                                <!--  <li v-for="(skill,key )  in skills.slice(4)" :key="key" > -->
                                                <!-- <span  @click="select_skill(skill)">{{ skill.name }}</span>  -->
                                                <!-- </li> -->
                                            </ul>
                                        </div>
                                <InputError class="mt-2" :message="form.errors.recommended_skills" />
                               
                            </div> 
                            <div class="mt-4 arrow_label">
                                <span class="label text-label">Languages<span style="color:red"> *</span></span>
                                <div class="eye-icon-div language_input mt-2">
                                    <multiselect v-model="form.language_id" :options="props.languages" :multiple="true"
                                        :close-on-select="false" :clear-on-select="false" :preserve-search="true"
                                        placeholder="Select Languages" label="name" track-by="name">
                                    </multiselect>
                                </div>
                                <InputError class="mt-2" :message="form.errors.language_id" />
                            </div>
                            <div class="mt-4">
                                <span class="label text-label">City<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <TextInput id="city" type="text" v-model="form.city" placeholder="Enter City"
                                        class="form-control mt-2  " />
                                </div>
                                <InputError class="mt-2" :message="form.errors.city" />
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                            <div class="mt-4">
                                <span class="label text-label">Zip Code</span>
                                <div class="eye-icon-div">
                                    <TextInput id="pin_code" type="text" v-model="form.pin_code"
                                        placeholder="Enter Zip Code" class="form-control mt-2  " />
                                    <InputError class="mt-2" :message="form.errors.pin_code" />
                                </div>
                            </div>
                            <div class="mt-4 Remote Work_label">
                                <label class="flex items-center">
                                    <!-- <Checkbox class="remember-me-check" name="remember" /> -->
                                    <span class="label text-label">Remote Work</span>
                                </label>
                                <div class="d-flex align-items-center mt-3 gap-4 remote_work">
                                    <div class="d-flex align-items-center">
                                        <input type="radio" class="radio-new-btn" name="remote_work"
                                            v-model="form.remote_work" value="remote_work">
                                        <label class="pl-2" for="">Remote Work</label>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <input type="radio" class="radio-new-btn" name="remote_work"
                                            v-model="form.remote_work" value="hybrid">
                                        <label class="pl-2" for="">Hybrid</label>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <input type="radio" class="radio-new-btn" name="remote_work"
                                            v-model="form.remote_work" value="onsite">
                                        <label class="pl-2" for="">On-Site</label>
                                    </div>
                                </div>
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                            <div class="mt-4 industry_label">
                                <span class="label text-label">Industry<span style="color:red"> *</span></span>
                                <div class="eye-icon-div mt-2">
                                    <!-- <select class="form-select  " aria-label="Default select example"
                                        v-model="form.industry_id">
                                        <option selected :value="null">Select Industry</option>
                                        <option v-for="(position, index) in industries" :key="index"
                                            :value="position.id">{{ position.name }}
                                        </option>
                                    </select> -->
                                    <multiselect v-model="form.industry_id" :options="props.industries" :multiple="true"
                                        :close-on-select="false" :clear-on-select="false" :preserve-search="true"
                                        placeholder="Select Industries" label="name" track-by="name">
                                    </multiselect>
                                </div>
                                <InputError class="mt-2" :message="form.errors.industry_id" />
                            </div>



                        </div>








                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="mt-4 minium_salary">
                                <span class="label text-label">Segment <span style="color:red"> *</span></span>
                                <TextInput type="text" id="Segment" v-model="form.segment" placeholder="Enter Segment"
                                    class="form-control mt-2  " />
                                <InputError class="mt-2" :message="form.errors.segment" />
                            </div>
                            <div class="mt-4">
                                <span class="label text-label">Position<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <TextInput type="text" id="positions" v-model="form.positions"
                                        placeholder="Enter Position" class="form-control mt-2  " />
                                    <InputError class="mt-2" :message="form.errors.positions" />
                                </div>
                            </div>
                            <div class="mt-4">
                                <span class="label text-label">Currency</span>
                                <div class="eye-icon-div">
                                    <select class="form-select  mt-2" :class="[select_class, { 'Selected_option': form.currency_id }]" aria-label="Default select example" @change="handleChange()"
                                        v-model="form.currency_id" >
                                        <option selected :value="null">Select Currency</option>
                                        <option v-for="(position, index) in currencies" :key="index"
                                            :value="position.id"> {{ position.country }} ({{
                                                position.symbol }})</option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.currency_id" />
                                </div>
                            </div>
                            <div class="mt-4 minimum_input">
                                <!-- <input type="checkbox"> -->
                                <span class="label text-label">Minimum and Maximum Salary<span style="color:red">
                                        *</span></span>
                                <div class="row">
                                    <div class="col-md-6 eye-icon-div ">
                                        <TextInput type="text" id="salary_range" v-model="form.min_pay_range"
                                            placeholder="Enter Minimum Salary" class="form-control mt-2  " />
                                        <InputError class="mt-2" :message="form.errors.min_pay_range" />
                                    </div>
                                    <div class="col-md-6 eye-icon-div ">
                                        <TextInput type="text" id="salary_range" v-model="form.max_pay_range"
                                            placeholder="Enter Maximum Salary" class="form-control mt-2  " />
                                        <InputError class="mt-2" :message="form.errors.max_pay_range" />
                                    </div>

                                </div>
                            </div>
                            <div class="mt-4">
                                <span class="label text-label">Start Date<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <!-- <TextInput type="date" id="start_Date" v-model="form.job_start_date"
                                        placeholder="Enter Start Date" class="form-control mt-2  " /> -->
                                        <VueDatePicker v-model="form.job_start_date" placeholder="Select Start Date" class="form-control mt-2  " :format="format" :min-date="today" :max-date="futureTwoWeeks" />
                                </div>
                                <InputError class="mt-2" :message="form.errors.job_start_date" />
                            </div>
                            <div class="mt-4   ">
                                <span class="label text-label">Job Posting Summary<span style="color:red">
                                        *</span></span>
                                <div class="eye-icon-div">
                                    <textarea id="job_summary" rows="5" type="text" v-model="form.posting_summary"
                                        placeholder="Enter job posting summary" class="form-control mt-2" />
                                </div>
                                <InputError class="mt-2" :message="form.errors.posting_summary" />
                            </div>
                            <div class="mt-4 spacing_btm new-job-description">
                                <label for="job_description">Details of the Job <span class="text-danger">*</span></label>
                                <div class="eye-icon-div mt-2 textarea_font">
                                    <QuillEditor contentType="html" toolbar="essential"
                                        v-model:content="form.job_description" placeholder="Enter Details of the Job" />
                                </div>
                                <InputError class="mt-2" :message="form.errors.job_description" />
                            </div>
                            <div class="mt-4   ">
                                <span class="label text-label">Conditions<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <textarea id="conditions" rows="5" type="text" v-model="form.conditions"
                                        placeholder="Enter Conditions" class="form-control mt-2" />
                                </div>
                                <InputError class="mt-2" :message="form.errors.conditions" />
                            </div>
                            <div class="mt-4   ">
                                <span class="label text-label">Requirements<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <textarea id="requirements" rows="5" type="text" v-model="form.requirements"
                                        placeholder="Enter Requirements" class="form-control mt-2" />
                                </div>
                                <InputError class="mt-2" :message="form.errors.requirements" />
                            </div>
                        </div>









                <!------end------>

                        <div class="col-md-6 d-none">
                            
                            <!-- <div class="col-md-6"> -->
                            
                            
                            <div class="mt-4">
                                <span class="label text-label">City<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <TextInput id="city" type="text" v-model="form.city" placeholder="Enter City"
                                        class="form-control mt-2  " />
                                </div>
                                <InputError class="mt-2" :message="form.errors.city" />
                                <!-- <InputError class="mt-2" :message="form.errors.password" /> -->
                            </div>
                            <div class="mt-4">
                                <span class="label text-label">Zip Code</span>
                                <div class="eye-icon-div">
                                    <TextInput id="pin_code" type="text" v-model="form.pin_code"
                                        placeholder="Enter Zip Code" class="form-control mt-2  " />
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
                            
                            
                            <!-- </div> -->
                        </div>
                        <div class="col-md-6 d-none">
                            
                            <!-- <div class="mt-4   ">
                                <span class="label text-label">Details of the Job<span style="color:red">
                                        *</span></span>
                                <div class="eye-icon-div">
                                    <textarea id="details" rows="5" type="text" v-model="form.detail"
                                        placeholder="Enter Details of the Job" class="form-control mt-2" />
                                </div>
                                <InputError class="mt-2" :message="form.errors.detail" />
                            </div> -->
                            
                            
                        </div>

                        <div class="col-md-6 country_input ">
                            <div class="mt-4">
                                <span class="label text-label">Country<span style="color:red"> *</span></span>
                                <div class="eye-icon-div">
                                    <select class="form-select  mt-2 Selected_option" aria-label="Default select example"
                                        v-model="form.job_country" >
                                        <option selected :value="null">Select Country</option>
                                        <option v-for="country in countries" :key="country.id" :value="country.name">{{
                                            country.name }}</option>
                                    </select>
                                </div>
                                <InputError class="mt-2" :message="form.errors.job_country" />
                            </div>
                        </div>

                        <div class="col-12 mt-4 file_upload">
                            <div class="file-inputs mt-3 relative">
                                <div class="dotted-bg">
                                    <img :src="image" alt="" srcset="">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"
                                        fill="none">
                                        <path
                                            d="M54.0774 47.7783L54.0771 47.7778L43.0478 32.5166C43.047 32.5155 43.0463 32.5145 43.0455 32.5134C41.5448 30.4238 38.4396 30.4235 36.9386 32.5128C36.9377 32.5141 36.9368 32.5153 36.9359 32.5166L25.9066 47.7778L25.9062 47.7783C24.1017 50.2769 25.8784 53.7609 28.9661 53.7609H32.6383V67.1046H15.4721C8.09988 66.6655 2 59.6549 2 51.908C2 46.6514 4.84793 42.0611 9.08693 39.5752L10.5322 38.7276L9.951 37.1562C9.59374 36.1903 9.40499 35.1506 9.40499 34.0412C9.40499 29.0159 13.4626 24.9583 18.4879 24.9583C19.5794 24.9583 20.6192 25.1465 21.5866 25.5043L23.3067 26.1405L24.0892 24.4818C27.3185 17.6362 34.28 12.8951 42.3688 12.8945C52.8366 12.9101 61.4659 20.9279 62.4473 31.143L62.5934 32.664L64.0993 32.9228C71.9373 34.2702 78 41.5883 78 49.9301C78 58.8106 71.0858 66.4598 62.4369 67.1046H47.3453V53.7609H51.0176C54.0719 53.7609 55.8919 50.2907 54.0774 47.7783Z"
                                            stroke="#01796F" stroke-width="4" />
                                    </svg>
                                    <h2 class="choose-para">Upload a thumbnail of the job</h2>
                                    <p class="file-type">Max size 20MB</p>
                                    <input class="upload" type="file" id="banner" @change="selectFile($event)" accept="image/*" />
                                </div>
                            </div>
                            <InputError class="mt-2" :message="form.errors.job_image"/>
                        </div>
                        <div class="col-12 ">
                            <div class="flex items-center justify-center mt-4 login-btn-main">

                                <PrimaryButton type="submit" class="forms-btn" :disabled="form.processing">
                                    Update Job <span> <i class="bi bi-arrow-right"></i></span>
                                </PrimaryButton>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <Footer />
</template>
