<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Link, useForm } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';
import { toast } from 'vue3-toastify';

const props = defineProps({
  category: {
    type: Object
  },
  errors: {
    type: Object
  }
});

const form = useForm({
  id:props.category.id,
  category_heading: props.category.category_heading,
  category_image: props.category.category_image,
  thumbnail: props.category.thumbnail,
  status: props.category.status,
})
const category_image = ref(form.category_image),
thumbnail= ref(form.thumbnail);

function submitForm() {
    // Post data 
    form.post(route('category.updated',form.id),{
      onSuccess: () => {
        toast("Categories Updated Successfully", {
          autoClose: 2000,
          theme: 'dark',
        }
        );
      },
    });
  }
  
 
  function updateThumbnailName(type,event) {
       if(type == 'image'){
        form.category_image = event.target.files[0];
        var category= event.target.files[0];
        category_image.value = URL.createObjectURL(category);
      }else if(type == 'thumbnailimage'){
        form.thumbnail = event.target.files[0];
        var thumb  = event.target.files[0];
        thumbnail.value = URL.createObjectURL(thumb);
      }
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
                  <label for="categoryHeading" class="block text-gray-700 text-sm font-bold mb-2">Category
                    Heading</label>
                  <input type="text" id="categoryHeading" v-model="form.category_heading"
                    class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                  <span v-if="props.errors.category_heading" class="error-message">{{ props.errors.category_heading
                    }}</span>
                </div>

                <div class="mb-4">
                  <label for="categoryimage" class="block text-gray-700 text-sm font-bold mb-2">Category Image</label>
                  <img :src="category_image" alt="" style="height:100px">
                  <label for="category_image" class="form-control cursor-pointer mt-2">
                    {{ form.category_image ? 'Change File' : 'Upload File' }}
                  </label>
                  <input type="file" id="category_image" @change="updateThumbnailName('image', $event)" accept="image/*"
                    class="hidden">
                </div>
                <div class="mb-4">
                  <label for="categoryThumbnail" class="block text-gray-700 text-sm font-bold mb-2">Thumbnail</label>
                  <img :src="thumbnail" alt=""
                    style="height:100px;margin-top:10px;">
                  <label for="thumbnail" class="form-control mt-2">
                    {{ form.thumbnail ? 'Change File' : 'Upload File' }}
                  </label>
                  <input type="file" id="thumbnail" @change="updateThumbnailName('thumbnailimage', $event)"
                    accept="image/*" class="hidden ">
                </div>

                  <!-- <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status</label> -->

                  <div class="configure-switch d-flex align-items-center gap-3">
                    <div class="d-flex">
                      <input type="checkbox" v-model="form.status" id="flexSwitchCheckDefaultApply" :true-value="1" :false-value="0"
                    name="status"/>
                      <label for="flexSwitchCheckDefaultApply"></label>
                    </div>
                    <p class="mb-0 semibold">Status</p>
                  </div>

                  <!-- <input type="checkbox" id="status" v-model="form.status" :true-value="1" :false-value="0"
                    name="status" class="mr-2 form-check-input">
                  <label for="status" class="form-check-label text-gray-700 text-sm font-bold mb-2">Status</label> -->
                <button type="submit"
                  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">Submit</button>
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

.file_cursor {
  cursor: pointer;
}
</style>