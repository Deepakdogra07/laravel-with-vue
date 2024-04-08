<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import { useToast } from 'vue-toastify';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const form = reactive({
  title: null,
  link: null,
  content: null,
  image: null,
});

defineProps({ errors: Object })

function submit() {
  router.post('/news', form, {
    onSuccess: page => {
      toast("News Added Successfully!", {
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
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create News</h2>
          </template>

          <div class="flex items-center justify-center">
            <div class="w-full px-2">
                <form @submit.prevent="submit">
                    <div class="row">
                        <div class="mt-4 col-md-6">
                              <label for="title">Title<span class="text-danger">*</span></label>
                               <input id="title" v-model="form.title" placeholder="Enter Title" class="block w-full mt-1 form-control" autocomplete="title"/>
                                <div v-if="errors.title" class="text-danger">{{ errors.title }}</div>
                        </div>

                         <div class="mt-4 col-md-6">
                              <label for="link">Link<span class="text-danger">*</span></label>
                               <input id="link" v-model="form.link" placeholder="Enter Link" class="block w-full mt-1 form-control" autocomplete="link"/>
                               <div v-if="errors.link" class="text-danger">{{ errors.link }}</div>
                        </div>

                         <div class="mt-4 col-md-6">
                              <label for="content">Content<span class="text-danger">*</span></label>
                               <!-- <input id="content" v-model="form.content" placeholder="Enter Content" class="block w-full mt-1" autocomplete="content"/> -->
                                 <textarea id="content" v-model="form.content" placeholder="Enter Content" class="block w-full mt-1 form-control"></textarea>
                                <div v-if="errors.content" class="text-danger">{{ errors.content }}</div>
                        </div>

                         <div class="mt-4 col-6">
                              <label for="image">Image<span class="text-danger">*</span></label><br/>
                              <input class="form-control" type="file" @input="form.image = $event.target.files[0]" accept="image/*"/>
                             <div v-if="errors.image" class="text-danger">{{ errors.image }}</div>
                        </div>

                        <div class="mt-4 col-md-6">
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
  .dataTable thead th, .dataTable tbody td{
    white-space: unset !important;
  }
</style>