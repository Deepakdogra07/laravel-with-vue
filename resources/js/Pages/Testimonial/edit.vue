<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const props = defineProps({
  errors: Object,
  editTestimonial: Array,
});

const form = useForm({
  name: props.editTestimonial ? props.editTestimonial.name || '' : '',
  content: props.editTestimonial ? props.editTestimonial.content || '' : '',
  image: props.editTestimonial?.image_link,
  video: props.editTestimonial?.video_link,
  description: props.editTestimonial?.description,
  status: props.editTestimonial?.status
});


const update = () => {
  form.post(route('testimonial.updated', { id: props.editTestimonial.id }),
    {
      onSuccess: () => {
        toast("Testimonial Update Successfully!", {
          autoClose: 2000,
          theme: 'dark',
        }
        );
      },
    });
};
function update_all_data(type, event) {
  if (type == 'image') {
    form.image = event.target.files[0];
  }
  if (type == 'video') {
    form.video = event.target.files[0];
  }
}
</script>
<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create News</h2>
    </template>

    <div class="flex items-center justify-center">
      <div class="w-full px-2">
        <form @submit.prevent="update" enctype="multipart/form-data">
          <div class="row">
            <div class="mt-4 col-md-6">
              <label for="name">Name<span class="text-danger">*</span></label>
              <input id="name" v-model="form.name" placeholder="Enter Name" class="form-control" autocomplete="name" />
              <div v-if="errors.name" class="text-danger">{{ errors.name }}</div>
            </div>

            <!-- <div class="mt-4 col-md-6">
                              <label for="rating">Rating<span class="text-danger">*</span></label>
                               <input id="rating" v-model="form.rating" placeholder="Enter Rating" class="block w-full mt-1" autocomplete="rating"/>
                               <div v-if="errors.rating" class="text-danger">{{ errors.rating }}</div>
                        </div> -->
            <div class="mt-4 col-md-6">
              <label for="description">Description<span class="text-danger">*</span></label>
              <textarea id="description" v-model="form.description" placeholder="Enter description"
                class="form-control"></textarea>
              <div v-if="errors.description" class="text-danger">{{ errors.description }}</div>
            </div>

            <div class="mt-4 col-md-6">
              <label for="content">Content<span class="text-danger">*</span></label>
              <textarea id="content" v-model="form.content" placeholder="Enter Content" class="form-control"></textarea>
              <div v-if="errors.content" class="text-danger">{{ errors.content }}</div>
            </div>
            <div class="mt-4 col-md-6">
              <label for="logoImage" class="block text-gray-700 text-sm font-bold mb-2">Image</label>
              <img :src="form.image" alt="" style="height:250px">
              <label for="logoImage" class="form-control mt-2 cursor-pointer">
                {{ form.image ? 'Change File' : 'Upload File' }}
              </label>
              <input type="file" id="logoImage" @change="update_all_data('image', $event)" accept="image/*"
                class="hidden">
            </div>
            <div class="mt-4 col-md-6">
              <label for="video" class="block text-gray-700 text-sm font-bold mb-2">Video</label>
              <video :src="form.video" alt="" controls></video>
              <label for="video" class="form-control mt-2 cursor-pointer">
                {{ form.video ? 'Change File' : 'Upload File' }}
              </label>
              <input type="file" id="video" @change="update_all_data('video', $event)" accept="video/*" class="hidden">
            </div>
            <div class="mt-5 col-md-6">

              <div class="configure-switch d-flex align-items-center gap-3">
                <div class="d-flex">
                  <input type="checkbox" id="status" v-model="form.status" :true-value="1" :false-value="0" name="status" />
                  <label for="status"></label>
                </div>
                <p class="mb-0 semibold">Status</p>
              </div>

              <!-- <div class="mb-4 form-check form-switch">
                <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                <input type="checkbox" id="status" v-model="form.status"  name="status"
                  class="mr-2 form-check-input">
                <label for="status" class="form-check-label text-gray-700 text-sm font-bold mb-2">Status</label>
              </div> -->
            </div>

            <div class="mt-4 col-md-12">
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
            <div></div><br>
          </div>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
<style></style>
