<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Link } from '@inertiajs/vue3';
import { reactive, ref, watch, watchPostEffect } from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const url = ref(''),
rul1 = ref('');



const props = defineProps({
  errors: {
    type: Object
  }
});

const form = reactive({
  category_heading: '',
  category_image: '',
  category_thumb: '',
  status: ''

})
function submitForm() {
  const formData = new FormData();
  formData.append('category_heading', form.category_heading);
  formData.append('category_image', form.category_image);
  formData.append('thumbnail', form.category_thumb);
  formData.append('status', form.status);
  // Post data 
  router.post(route('category.store'), formData,{
      onSuccess: () => {
        toast("Categories Updated Successfully", {
          autoClose: 2000,
          theme: 'dark',
        }
        );
      },
    });
}

function handleFileInput(event) {
  form.category_image = event.target.files[0];
  rul1.value = URL.createObjectURL(form.category_image);
}
function handleFileInput1(event) {
  form.category_thumb = event.target.files[0];  
   url.value = URL.createObjectURL(form.category_thumb) ;
}

</script>

<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-black-800 leading-tight">Add Category </h2>
      <div class="button-container">
      </div>

    </template>
    <div class="py-12 add_category_page">
      <div class="max-w-7xl mx-auto px-2">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;">
          <div class="p-6 text-black-900">
            <div class="container">
              <form @submit.prevent="submitForm">
                <div class="mb-4">
                  <label for="categoryHeading" class="block text-gray-700 text-sm font-bold mb-2">Category
                    Heading</label>
                  <input type="text" id="categoryHeading" v-model="form.category_heading"
                    class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                  <span v-if="props.errors.category_heading" class="error-message">{{ props.errors.category_heading
                    }}</span>
                </div>
                <div class="mb-4">
                  <label for="categoryImage" class="block text-gray-700 text-sm font-bold mb-2">Category Image</label>
                  <input type="file" id="categoryImage" @change="handleFileInput" accept="image/*" class="form-control">
                  <img v-bind:src="rul1" alt="" class="mt-2">
                  <span v-if="props.errors.category_image" class="error-message">{{ props.errors.category_image
                    }}</span>
                </div>
                <div class="mb-4">
                  <label for="category_thumb" class="block text-gray-700 text-sm font-bold mb-2">Thumbnail</label>
                  <input type="file" id="category_thumb" @change="handleFileInput1" accept="image/*"
                  class="form-control">
                  <img v-bind:src="url" alt="" class="mt-2">
                  <span v-if="props.errors.thumbnail" class="error-message">{{ props.errors.thumbnail }}</span>
                </div>
                  <!-- <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status</label> -->
                  <!-- <input type="checkbox" id="status" v-model="form.status" name="status" class="mr-2 form-check-input"> -->

                  <div class="configure-switch d-flex align-items-center gap-3 mb-4">
                    <div class="d-flex">
                      <input type="checkbox" v-model="form.status" id="status" />
                      <label for="status"></label>
                    </div>
                    <p class="mb-0 semibold">Status</p>
                  </div>
                <button type="submit"
                  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
<style scoped>
.error-message {
  color: red;
}
img{
  width: 100px;
}
</style>