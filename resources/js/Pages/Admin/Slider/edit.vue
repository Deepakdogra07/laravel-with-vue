<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Link } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';
import Swal from 'sweetalert2';

const props = defineProps({
    slider: {
        type: Object
    },
    errors: {
      type: Object
    }
});


const form = reactive({
  id: props.slider.id,
  sliderHeading: props.slider.slider_heading,
  sliderDescription: props.slider.slider_description,
  sliderImage: props.slider.slider_image,

})
const slider_ = ref(props.slider.slider_image);
function submitForm() {
   
    const formData = new FormData();
    formData.append('id', form.id);
    formData.append('sliderHeading', form.sliderHeading);
    formData.append('sliderDescription', form.sliderDescription);
    formData.append('sliderImage', form.sliderImage);
    // Post
    router.post(route('home-page.update'), formData,{
      onSuccess: () => {
        toast("Slider Updated Successfully", {
          autoClose: 2000,
          theme: 'dark',
        }
        );
      },
    });
  }

    
    function updateSliderName(type,event) {
      if(type=="name"){
        form.sliderName = event.target.value;
      }else if(type=="description"){
        form.sliderDescription = event.target.value;
      }else if(type =="heading"){
        form.sliderHeading = event.target.value;
      }else if(type == 'image'){
        form.sliderImage = event.target.files[0];
        slider_.value = URL.createObjectURL(form.sliderImage);

      }

    }

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
                <h2 class="font-semibold text-xl text-black-800 leading-tight">Update Slider</h2>
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
                            <input type="hidden" id="sliderId" v-model="slider.id">
                            <label for="sliderHeading" class="block text-gray-700 text-sm font-bold mb-2">Slider Heading</label>
                            <input type="text" id="sliderHeading" v-model="slider.slider_heading" @input="updateSliderName('heading',$event)"  class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                            <span v-if="!form.sliderHeading" class="error-message">Slider Heading is required</span>
                        </div>
                        <div class="mb-4">
                            <label for="sliderDescription" class="block text-gray-700 text-sm font-bold mb-2">Slider Description (less than 100 words)</label>
                            <textarea id="sliderDescription" v-model="slider.slider_description" @input="updateSliderName('description',$event)" class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full"></textarea>
                            <span v-if="!form.sliderDescription" class="error-message">Slider Description is required</span>
                        </div>
                        <div class="mb-4">
                            <label for="sliderImage" class="block text-gray-700 text-sm font-bold mb-2">Slider Image</label>
                            <img :src="slider_" alt="" style="height:250px">
                              <label for="sliderImage" class="form-control mt-2 cursor-pointer">
                                {{ slider.slider_image ? 'Change File' : 'Upload File' }}
                              </label>
                              <input type="file" id="sliderImage" @change="updateSliderName('image', $event)" accept="image/*" class="form-control !hidden mt-2">
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
  .file_cursor{
    cursor: pointer;
  }
  
</style>