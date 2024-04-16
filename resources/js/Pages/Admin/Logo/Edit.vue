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
})

function submitForm() {
    const formData = new FormData();
     formData.append('id', form.id);
    formData.append('logo_heading', form.logo_heading);
    formData.append('logo_description', form.logo_description);
    formData.append('logo_image', form.logo_image);
    // Post data 
    router.post(route('edit-logo.update'), formData)
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