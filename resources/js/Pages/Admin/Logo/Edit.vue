<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Link } from '@inertiajs/vue3';
import { reactive } from 'vue';
import Swal from 'sweetalert2';

console.log(route('edit-logo.store'),'12121212121');
const props = defineProps({
    logo:{
        type : Object
    },
    errors: {
      type: Object
    }
});

const form = reactive({
    id:props.logo.id,
    logo_heading: props.logo.logo_heading,
    logo_description: props.logo.logo_description,
    logo_image: props.logo.logo_image,
    country_1_name: props.logo.country_1_name,
    country_1_image: props.logo.country_1_image,
    country_2_name: props.logo.country_2_name,
    country_2_image: props.logo.country_2_image,
    video_heading: props.logo.video_heading,
    video_subheading: props.logo.video_subheading,
    video_description: props.logo.video_description,
    video: props.logo.video_introduction,
})

function submitForm() {
   
    router.post(route('edit-logo.update'), form)
  }
  function handleFileInput(event){
    form.logo_image = event.target.files[0]; 
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
                            <input type="hidden" id="logoId" v-model="logo.id">
                            <label for="logoHeading" class="block text-gray-700 text-sm font-bold mb-2">Logo Heading</label>
                            <input type="text" id="logoHeading" v-model="form.logo_heading"  class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                             <span v-if="props.errors.logo_heading" class="error-message">{{ props.errors.logo_heading }}</span> 
                        </div>
                        <div class="mb-4">
                            <label for="logoDescription" class="block text-gray-700 text-sm font-bold mb-2">Logo Description (less than 100 words)</label>
                            <textarea id="logoDescription" v-model="form.logo_description" class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full"></textarea>
                             <span v-if="props.errors.logo_description" class="error-message">{{ props.errors.logo_description }}</span> 
                        </div>
                        <div class="mb-4">
                            <label for="logoImage" class="block text-gray-700 text-sm font-bold mb-2">Logo Image</label>
                            <input type="file" id="logoImage" @change="handleFileInput" accept="image/*" class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                             <span v-if="props.errors.logo_image" class="error-message">{{ props.errors.logo_image }}</span> 
                        </div>
                        <div class="mb-4">
                            <label for="Country-1" class="block text-gray-700 text-sm font-bold mb-2">First Country Name </label>
                            <input type="text" id="Country-1" v-model="form.country_1_name"  class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                             <span v-if="props.errors.country_1_name" class="error-message">{{ props.errors.country_1_name }}</span> 
                        </div>
                         <div class="mb-4">
                            <label for="country_1_image" class="block text-gray-700 text-sm font-bold mb-2">First Country Image</label>
                            <input type="file" id="country_1_image" @change="handleFileInput1" accept="image/*" class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                             <span v-if="props.errors.country_1_image" class="error-message">{{ props.errors.country_1_image }}</span> 
                        </div>
                        <div class="mb-4">
                            <label for="Country-2" class="block text-gray-700 text-sm font-bold mb-2">Second Country Name </label>
                            <input type="text" id="Country-2" v-model="form.country_2_name"  class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                             <span v-if="props.errors.country_2_name" class="error-message">{{ props.errors.country_2_name }}</span> 
                        </div>
                         <div class="mb-4">
                            <label for="country_2_image" class="block text-gray-700 text-sm font-bold mb-2">Second Country Image</label>
                            <input type="file" id="country_2_image" @change="handleFileInput2" accept="image/*" class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                             <span v-if="props.errors.country_2_image" class="error-message">{{ props.errors.country_2_image }}</span> 
                        </div>
                        <div class="mb-4">
                            <label for="video_heading" class="block text-gray-700 text-sm font-bold mb-2">Video heading </label>
                            <input type="text" id="video_heading" v-model="form.video_heading"  class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                             <span v-if="props.errors.video_heading" class="error-message">{{ props.errors.video_heading }}</span> 
                        </div>
                        <div class="mb-4">
                            <label for="video_subheading" class="block text-gray-700 text-sm font-bold mb-2">Video subheading </label>
                            <input type="text" id="video_subheading" v-model="form.video_subheading"  class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                             <span v-if="props.errors.video_subheading" class="error-message">{{ props.errors.video_subheading }}</span> 
                        </div>
                        <div class="mb-4">
                            <label for="video_description" class="block text-gray-700 text-sm font-bold mb-2">Video description </label>
                            <input type="text" id="video_description" v-model="form.video_description"  class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                             <span v-if="props.errors.video_description" class="error-message">{{ props.errors.video_description }}</span> 
                        </div>
                        <div class="mb-4">
                          <label for="video" class="block text-gray-700 text-sm font-bold mb-2">Video</label>
                          <input type="file" id="video" @change="handleVideoInput" accept="video/*" class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                          <span v-if="props.errors.video" class="error-message">{{ props.errors.video }}</span>
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