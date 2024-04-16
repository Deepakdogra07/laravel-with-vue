<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Link } from '@inertiajs/vue3';
import { reactive } from 'vue';
import Swal from 'sweetalert2';

const props = defineProps({
    category:{
        type : Object
    },
    errors: {
      type: Object
    }
});

const form = reactive({
    id:props.category.id,
    category_heading: props.category.category_heading,
    category_image: props.category.category_image,
})

function submitForm() {
    const formData = new FormData();
     formData.append('id', form.id);
    formData.append('category_heading', form.category_heading);
    formData.append('category_image', form.category_image);
    // Post data 
    router.post(route('edit-category.update'), formData)
  }
  function handleFileInput(event){
    form.category_image = event.target.files[0]; 
  }

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
                <h2 class="font-semibold text-xl text-black-800 leading-tight">Update Category</h2>
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
                            <input type="hidden" id="categoryId" v-model="category.id">
                            <label for="categoryHeading" class="block text-gray-700 text-sm font-bold mb-2">Category Heading</label>
                            <input type="text" id="categoryHeading" v-model="form.category_heading"  class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                             <span v-if="props.errors.category_heading" class="error-message">{{ props.errors.category_heading }}</span> 
                        </div>
                       
                        <div class="mb-4">
                            <label for="categoryImage" class="block text-gray-700 text-sm font-bold mb-2">Category Image</label>
                            <input type="file" id="categoryImage" @change="handleFileInput" accept="image/*" class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                             <span v-if="props.errors.category_image" class="error-message">{{ props.errors.category_image }}</span> 
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