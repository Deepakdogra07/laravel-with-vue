<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Link } from '@inertiajs/vue3';
import { reactive } from 'vue';
import Swal from 'sweetalert2';
import axios from 'axios';


const props = defineProps({
    errors: {
      type: Object
    }
});
const form = reactive({
  sliderName: null,
  sliderHeading: null,
  sliderDescription: null,
  sliderImage: null,

})
function submitForm() {
  const isValidForm = validateForm();
  if(!isValidForm){
        return ;
    }
    const formData = new FormData();
    formData.append('sliderName', form.sliderName);
    formData.append('sliderHeading', form.sliderHeading);
    formData.append('sliderDescription', form.sliderDescription);
    formData.append('sliderImage', form.sliderImage);
    // Post
    router.post('/home-page/store', formData)
  }
  function handleFileInput(event){
    form.sliderImage = event.target.files[0]; 
    }
    function validateForm() {
      let isValid = true;

      if (!form.sliderName ||!form.sliderHeading || !form.sliderDescription || !form.sliderImage ) {
        isValid = false;
      }
      return isValid;
    }

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
                <h2 class="font-semibold text-xl text-black-800 leading-tight">Add Slider</h2>
            <div class="button-container">
            </div>
            
        </template>
        <div class="py-12">
                <div class="max-w-7xl mx-auto px-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;">
                    <div class="p-6 text-black-900">
                    <div class="container">
                        <form @submit.prevent="submitForm">
                        <div class="mb-4">
                            <label for="sliderName" class="block text-gray-700 text-sm font-bold mb-2">Slider Name</label>
                            <input type="text" id="sliderName" v-model="form.sliderName" class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                             <span v-if="!form.sliderName" class="error-message">Slider Name is required</span> 
                        </div>
                        <div class="mb-4">
                            <label for="sliderHeading" class="block text-gray-700 text-sm font-bold mb-2">Slider Heading</label>
                            <input type="text" id="sliderHeading" v-model="form.sliderHeading"  class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                             <span v-if="!form.sliderHeading" class="error-message">Slider Heading is required</span> 
                        </div>
                        <div class="mb-4">
                            <label for="sliderDescription" class="block text-gray-700 text-sm font-bold mb-2">Slider Description (less than 100 words)</label>
                            <textarea id="sliderDescription" v-model="form.sliderDescription" class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full"></textarea>
                             <span v-if="!form.sliderDescription" class="error-message">Slider Description is required</span> 
                        </div>
                        <div class="mb-4">
                            <label for="sliderImage" class="block text-gray-700 text-sm font-bold mb-2">Slider Image</label>
                            <input type="file" id="sliderImage" @change="handleFileInput" accept="image/*" class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                             <span v-if="!form.sliderImage" class="error-message">Slider Image is required</span> 
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                        </form>
                    </div>
                    </div>
                </div>
                </div>
            </div>
    </AuthenticatedLayout>
</template>
<style scoped>
  .error-message{
    color:red;
  }
  
</style>