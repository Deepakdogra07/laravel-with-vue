<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import { reactive, ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { useToast } from 'vue-toastify';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const form = reactive({
  name: null,
  content: null,
  image: null,
  video: null,
  description: null,
  status: null
});

defineProps({
  errors: Object,
  testimonialRecords: Array,
})

function submit() {
  router.post('/testimonial', form, {
    onSuccess: page => {
      toast("Testimonial Added Successfully!", {
        autoClose: 2000,
        theme: 'dark',
      });
    },
  });
}
function handleVideoInput(event) {
  const file = event.target.files[0];
  const maxSize = 50 * 1024 * 1024;
  if (file.size > maxSize) {
    alert('File size exceeds the limit (50 MB)');
    return;
  }
  form.video = file;
}
function Inputimage(event) {
  form.image = event.target.files[0];
}

const url = ref(''),
newVideo = ref('');


function handleFileInput1(event) {
    form.image = event.target.files[0];
    url.value = URL.createObjectURL(form.image) ;
};
function handleVideoInput2(event) {
    form.video = event.target.files[0];
    newVideo.value = URL.createObjectURL(form.video) ;
}


</script>
<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Testimonials</h2>
    </template>

    <div class="flex items-center justify-center create_testimonial_form">
      <div class="w-full px-2">
        <form @submit.prevent="submit" enctype="multipart/form-data">
          <div class="row">
            <div class="mt-4 col-md-6 input_firstt">
              <label for="name">Name<span class="text-danger">*</span></label>
              <input id="name" v-model="form.name" placeholder="Enter Name" class="block w-full mt-1 form-control"
                autocomplete="name" />
              <div v-if="errors.name" class="text-danger">{{ errors.name }}</div>
            </div>
            <div class="mt-4 col-md-6">
              <label for="description">Description<span class="text-danger">*</span></label>
              <textarea id="description" v-model="form.description" placeholder="Enter description"
                class="block w-full mt-1 form-control"></textarea>
              <div v-if="errors.description" class="text-danger">{{ errors.description }}</div>
            </div>
            <div class="mt-4 col-md-6">
              <label for="name">Image<span class="text-danger">*</span></label>
              <input @change="handleFileInput1" type="file" required accept="image/*"  placeholder="Enter Name"
                class="block w-full mt-1 form-control" autocomplete="name" />
                <img v-bind:src='url' alt="" class="mt-2">
              <div v-if="errors.image" class="text-danger">{{ errors.image }}</div>
            </div>
            <div class="mt-4 col-md-6">
              <label for="name">Video</label>
              <input type="file" accept="video/*" @change="handleVideoInput2" placeholder="Enter Name"
                class="block w-full mt-1 form-control" autocomplete="name" />
                <video :src='newVideo' class="mt-2"></video>
              <div v-if="errors.video" class="text-danger">{{ errors.video }}</div>
            </div>
            <div class="mt-4 col-md-6">
              <label for="content">Content<span class="text-danger">*</span></label>
              <textarea id="content" v-model="form.content" placeholder="Enter Content"
                class="block w-full mt-1 form-control"></textarea>
              <div v-if="errors.content" class="text-danger">{{ errors.content }}</div>
            </div>
            <br />
            <div class="mt-5 col-md-6">

              <div class="configure-switch d-flex align-items-center gap-3">
                <div class="d-flex">
                  <input type="checkbox" id="status" v-model="form.status" name="status" />
                  <label for="status"></label>
                </div>
                <p class="mb-0 semibold">Status</p>
              </div>

              <!-- <div class="mb-4 form-check form-switch">
                <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                <input type="checkbox" id="status" v-model="form.status" name="status" class="mr-2 form-check-input">
                <label for="status" class="form-check-label text-gray-700 text-sm font-bold mb-2">Status</label>
              </div> -->
            </div>

            <div class="mt-4 col-md-12">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div></div><br>
          </div>
        </form>
      </div>
    </div>

  </AuthenticatedLayout>
</template>
<style scoped>
  img{
    width: 100px;
  }
  video{
    width: 200px;
  }
</style>
