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
    thumbnail: props.category.thumbnail,
    status: props.category.status,
})

function submitForm() {
    // Post data 
    router.put(route('category.update',form.id), form);
  }
  
 
  function updateThumbnailName(type,event) {
      if(type =="heading"){
        form.category_heading = event.target.value;
      }else if(type == 'image'){
        form.category_image = event.target.files[0];
      }else if(type == 'thumbnailimage'){
        form.thumbnail = event.target.files[0];
      }
    }
    function updateStatus(event){
      console.log(event)
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
                            <input type="text" id="categoryHeading" v-model="form.category_heading"  @input="updateThumbnailName('heading',$event)"  class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                             <span v-if="props.errors.category_heading" class="error-message">{{ props.errors.category_heading }}</span> 
                        </div>
                       
                        <div class="mb-4">
       
                             <img :src="'/storage/categories/' + form.category_image" alt="" style="height:100px">
                              <label for="category_image" class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                                {{ form.category_image ? 'Change File' : 'Upload File' }}
                              </label>
                              <input type="file" id="category_image" @change="updateThumbnailName('image', $event)" accept="image/*" class="hidden">
                        </div>
                        <div class="mb-4">
                             <img :src="'/storage/categories/thumbnail/' + form.thumbnail" alt="" style="height:100px">
                              <label for="thumbnail" class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                                {{ form.thumbnail ? 'Change File' : 'Upload File' }}
                              </label>
                              <input type="file" id="thumbnail" @change="updateThumbnailName('thumbnailimage', $event)" accept="image/*" class="hidden">
                        </div>
                        <div class="mb-4">
                              <input type="checkbox" id="status" v-model="form.status"  :true-value="1"
                                :false-value="0" name="status" class="mr-2" >
                              <label for="status" class="text-gray-700 text-sm font-bold mb-2" >Status</label>
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