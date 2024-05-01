<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Link } from '@inertiajs/vue3';
import {reactive, ref, watch, watchPostEffect } from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';


const props = defineProps({
    errors: {
      type: Object
    }
});
// watchPostEffect(()=>{
//   console.log(props.errors)
//   if(props.errors.message){
//     toast(props.errors.message, {
//         autoClose: 3000,
//         theme: 'dark',
//       });
//   }
// })
// watch(props.errors,(old_value,new_value) => {
//   console.log(old_value,new_value)
//   if(old_value?.message != new_value?.message && (new_value?.message.length > 0)){
//     toast(new_value?.message, {
//         autoClose: 3000,
//         theme: 'dark',
//       });
    
//   }
// })

const form = reactive({
  slider_heading: '',
  slider_description: '',
  slider_image: '',

})
function submitForm() {
    const formData = new FormData();
    formData.append('slider_heading', form.slider_heading);
    formData.append('slider_description', form.slider_description);
    formData.append('slider_image', form.slider_image);
    // Post data 
    router.post('/home-page/store', formData)
  }
 

 const url = ref('');

  
  function handleFileInput(event) {
    form.slider_image = event.target.files[0];
    url.value = URL.createObjectURL(form.slider_image) ;
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
                            <label for="sliderHeading" class="block text-gray-700 text-sm font-bold mb-2">Slider Heading</label>
                            <input type="text" id="sliderHeading"placeholder="Enter Slider Heading" v-model="form.slider_heading"  class="form-control mt-2 mb-3">
                             <span v-if="props.errors.slider_heading" class="error-message">{{ props.errors.slider_heading }}</span> 
                        </div>
                        <div class="mb-4">
                            <label for="sliderDescription" class="block text-gray-700 text-sm font-bold mb-2">Slider Description (less than 100 words)</label>
                            <textarea id="sliderDescription"placeholder="Enter Slider Description" v-model="form.slider_description" class="form-control mt-2 mb-3"></textarea>
                             <span v-if="props.errors.slider_description" class="error-message">{{ props.errors.slider_description }}</span> 
                        </div>
                        <div class="mb-4">
                          <label for="sliderImage" class="block text-gray-700 text-sm font-bold mb-2">Slider Image</label>
                          <input type="file" id="sliderImage" @change="handleFileInput($event)" accept="image/*" class="form-control">
                          <img v-bind:src="url" alt="" class="mt-2">
                          <span v-if="props.errors.slider_image" class="error-message">{{ props.errors.slider_image }}</span> 
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

  img{
    width: 100px;
  }
  
</style>