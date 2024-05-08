<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Link } from '@inertiajs/vue3';
import { onMounted,reactive, ref } from 'vue';
import Swal from 'sweetalert2';
import { toast } from 'vue3-toastify';

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
    image_heading: props.logo.logo_heading,
    image_description: props.logo.logo_description,
    image_image: props.logo.logo_image,
    country_1_name: props.logo.country_1_name,
    country_1_image: props.logo.country_1_image,
    country_2_name: props.logo.country_2_name,
    country_2_image: props.logo.country_2_image,
    video_heading: props.logo.video_heading,
    video_subheading: props.logo.video_subheading,
    video_description: props.logo.video_description,
    video: props.logo.video_introduction,
    category_heading:props.logo.category_heading,
    category_subheading:props.logo.category_subheading,
    country_description:props.logo.country_description,
})
const country_1_image = ref(form.country_1_image),
country_2_image = ref(form.country_2_image),
logo_image = ref(form.image_image);
function submitForm() {
   
    router.post(route('edit-logo.update'), form,{
    onSuccess: () => {
        toast("Data Updated Successfully", {
          autoClose: 2000,
          theme: 'dark',
        });
      },
    });
   
  }
  function handleFileInput(event){
    form.logo_image = event.target.files[0]; 
  }

  function update_all_data(type,event) {
      if(type =="image_heading"){
        form.image_heading = event.target.value;
      }else if(type == 'image_image'){
        form.image_image = event.target.files[0];
        logo_image.value = URL.createObjectURL(form.image_image); 
      }else if(type == 'image_description'){
        form.image_description = event.target.value;
      }else if(type =="category_heading"){
        form.category_heading = event.target.value;
      }else if(type =="category_subheading"){
        form.category_subheading = event.target.value;
      }else if(type =="country_description"){
        form.country_description = event.target.value;
      }else if(type =="country_1_name"){
        form.country_1_name = event.target.value;
      }else if(type =="country_2_name"){
        form.country_2_name = event.target.value;
      }else if(type =="video_heading"){
        form.video_heading = event.target.value;
      }else if(type =="video_description"){
        form.video_description = event.target.value;
      }else if(type =="country_1_image"){
        form.country_1_image = event.target.files[0];
        country_1_image.value = URL.createObjectURL(form.country_1_image);
      }else if(type =="country_2_image"){        
        form.country_2_image = event.target.files[0];
        country_2_image.value = URL.createObjectURL(form.country_2_image);
      }else if(type =="video_subheading"){
        form.video_subheading = event.target.value;
      }else if(type =="video"){
         const file = event.target.files[0];
            const maxSize = 50 * 1024 * 1024; 
            if (file.size > maxSize) {
                alert('File size exceeds the limit (50 MB)');
                document.getElementById('video').value = '';
                return;
            }
            form.video = file;
      }
    }

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
                <h2 class="font-semibold text-xl text-black-800 leading-tight">Edit Fields</h2>
            <div class="button-container">
            </div>
            
        </template>
        <div class="py-12">
                <div class="max-w-7xl mx-auto px-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;">
                    <div class="p-6 text-black-900">
                    <div class="container">
                           <form @submit.prevent="submitForm">
                        <div class="image_uploading" >
                            <h2>Image Section</h2>
                            <div class="mb-4">
                                <label for="logoHeading" class="block text-gray-700 text-sm font-bold mb-2">Image Heading</label>
                                <input type="text" id="logoHeading" v-model="form.image_heading"  @input="update_all_data('image_heading',$event)" class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                                <span v-if="props.errors.image_heading" class="error-message">{{ props.errors.image_heading }}</span> 
                            </div>
                            <div class="mb-4">
                                <label for="logoDescription" class="block text-gray-700 text-sm font-bold mb-2">Image Description (less than 100 words)</label>
                                <textarea id="logoDescription" v-model="form.image_description" @input="update_all_data('image_description',$event)" class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full"></textarea>
                                <span v-if="props.errors.image_description" class="error-message">{{ props.errors.image_description }}</span> 
                            </div>
                            <div class="mb-4">
                                <label for="logoImage" class="block text-gray-700 text-sm font-bold mb-2">Image</label>
                                <img :src="logo_image" alt="" style="height:250px">
                                <label for="logoImage" class="form-control mt-2 cursor-pointer">
                                    {{ form.image_image ? 'Change File' : 'Upload File' }}
                                </label>
                              <input type="file" id="logoImage" @change="update_all_data('image_image',$event)" accept="image/*" class="hidden">
                            <span v-if="props.errors.image_image" class="error-message">{{ props.errors.image_image }}</span> 
                            </div>
                        </div>
                        <div class="categories_sections">
                          <h2>Category Section</h2>
                            <div class="mb-4">
                                <label for="category_heading" class="block text-gray-700 text-sm font-bold mb-2">Category Heading</label>
                                <input id="category_heading" v-model="form.category_heading" @input="update_all_data('category_heading',$event)" class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                                <span v-if="props.errors.category_heading" class="error-message">{{ props.errors.category_heading }}</span> 
                            </div>
                             <div class="mb-4">
                                <label for="category_subheading" class="block text-gray-700 text-sm font-bold mb-2">Category SubHeading </label>
                                <input id="category_subheading" v-model="form.category_subheading" @input="update_all_data('category_subheading',$event)" class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                                <span v-if="props.errors.category_subheading" class="error-message">{{ props.errors.category_subheading }}</span> 
                            </div>
                        </div>
                        <div class="country_section">
                          <h2>Country Section</h2>
                          <div class="mb-4">
                                  <label for="country_description" class="block text-gray-700 text-sm font-bold mb-2">Countries Description </label>
                                  <input type="text" id="country_description" v-model="form.country_description"  @input="update_all_data('country_description',$event)" class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                                  <span v-if="props.errors.country_description" class="error-message">{{ props.errors.country_description }}</span> 
                              </div>
                          <div class="country_1_uploading" >
                              <h2>First Country Section</h2>
                              <div class="mb-4">
                                  <label for="Country-1" class="block text-gray-700 text-sm font-bold mb-2">First Country Name </label>
                                  <input type="text" id="Country-1" v-model="form.country_1_name"  @input="update_all_data('country_1_name',$event)" class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                                  <span v-if="props.errors.country_1_name" class="error-message">{{ props.errors.country_1_name }}</span> 
                              </div>
                              <div class="mb-4">
                                    <label for="country_1_image" class="block text-gray-700 text-sm font-bold mb-2">Image</label>
                                    <img :src="country_1_image" alt="" style="height:250px">
                                    <label for="country_1_image" class="form-control mt-2 cursor-pointer">
                                        {{ form.country_1_image ? 'Change File' : 'Upload File' }}
                                    </label>
                                    <input type="file" id="country_1_image" @change="update_all_data('country_1_image',$event)" accept="image/*" class="hidden">
                                    <span v-if="props.errors.country_1_image" class="error-message">{{ props.errors.country_1_image }}</span> 
                              </div>
                          </div>
                          <div class="country_1_uploading" >
                              <h2>Second Country Section</h2>
                              <div class="mb-4">
                                  <label for="Country-2" class="block text-gray-700 text-sm font-bold mb-2">Second Country Name </label>
                                  <input type="text" id="Country-2" v-model="form.country_2_name"  @input="update_all_data('country_2_name',$event)" class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                                  <span v-if="props.errors.country_2_name" class="error-message">{{ props.errors.country_2_name }}</span> 
                              </div>
                              <div class="mb-4">
                                  <label for="country_2_image" class=" block text-gray-700 text-sm font-bold mb-2">Image</label>
                                    <img :src="country_2_image" alt="" style="height:250px">
                                    <label for="country_2_image" class="form-control mt-2 cursor-pointer">
                                        {{ form.country_2_image ? 'Change File' : 'Upload File' }}
                                    </label>
                                    <input type="file" id="country_2_image" @change="update_all_data('country_2_image',$event)" accept="image/*" class="hidden">
                                    <span v-if="props.errors.country_2_image" class="error-message">{{ props.errors.country_2_image }}</span>  
                              </div>
                          </div>
                        </div>
                        <div class="video_Section">
                            <h2>How It Works</h2>
                            <div class="mb-4">
                                <label for="video_heading" class="block text-gray-700 text-sm font-bold mb-2">Video heading </label>
                                <input type="text" id="video_heading" v-model="form.video_heading"  @input="update_all_data('video_heading',$event)" class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                                <span v-if="props.errors.video_heading" class="error-message">{{ props.errors.video_heading }}</span> 
                            </div>
                            <div class="mb-4">
                                <label for="video_subheading" class="block text-gray-700 text-sm font-bold mb-2">Video subheading </label>
                                <input type="text" id="video_subheading" v-model="form.video_subheading"  @input="update_all_data('video_subheading',$event)" class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                                <span v-if="props.errors.video_subheading" class="error-message">{{ props.errors.video_subheading }}</span> 
                            </div>
                            <div class="mb-4">
                                <label for="video_description" class="block text-gray-700 text-sm font-bold mb-2">Video description </label>
                                <input type="text" id="video_description" v-model="form.video_description"  @input="update_all_data('video_description',$event)" class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                                <span v-if="props.errors.video_description" class="error-message">{{ props.errors.video_description }}</span> 
                            </div>
                            <div class="mb-4">
                                 <label for="video" class=" block text-gray-700 text-sm font-bold mb-2">Video </label>
                                <video controls style="height: 250px;">
                                    <source :src="form.video" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                                <label for="video" class="form-control mt-2 cursor-pointer">
                                    {{ form.video ? 'Change File' : 'Upload File' }}
                                </label>
                                <input type="file" id="video" @change="update_all_data('video',$event)" accept="video/*" class="hidden">
                                <span v-if="props.errors.video" class="error-message">{{ props.errors.video }}</span>
                            </div>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                        </div>
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
.image_uploading ,.country_1_uploading,.country_2_uploading, .video_Section,.country_section,.categories_sections{
    margin-top:20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 20px;
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
  }
  
  .file_cursor{
    cursor: pointer;
  }
</style>