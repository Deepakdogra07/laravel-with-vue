<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import { useToast } from 'vue-toastify';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const form = reactive({
  name: null,
  rating: null,
  content: null,
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

</script>
<template>
    <AuthenticatedLayout>
          <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Testimonials</h2>
          </template>

          <div class="flex items-center justify-center">
            <div class="w-full px-2">
                <form @submit.prevent="submit">
                    <div class="row">
                        <div class="mt-4 col-md-6">
                              <label for="name">Name<span class="text-danger">*</span></label>
                              <input id="name" v-model="form.name" placeholder="Enter Name" class="block w-full mt-1 form-control" autocomplete="name"/>
                              <div v-if="errors.name" class="text-danger">{{ errors.name }}</div>
                        </div>

                          <!-- <div class="mt-4 col-md-6">
                              <label for="rating">Rating<span class="text-danger">*</span></label>
                               <input type="number" min="1" max="5" id="content" v-model="form.rating" placeholder="Enter Rating" class="block w-full mt-1 form-control" autocomplete="rating"/>
                               <div v-if="errors.rating" class="text-danger">{{ errors.rating }}</div>
                        </div> -->

                         <div class="mt-4 col-md-6">
                              <label for="content">Content<span class="text-danger">*</span></label>
                                 <textarea id="content" v-model="form.content" placeholder="Enter Content" class="block w-full mt-1 form-control"></textarea>
                                <div v-if="errors.content" class="text-danger">{{ errors.content }}</div>
                        </div>
                        <br/>

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
<style>

</style>
