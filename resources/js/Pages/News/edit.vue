<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import { useToast } from 'vue-toastify';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';


const props = defineProps({
  errors: Object,
  errors: Object,
  editNews: Array,
});

const form = useForm({
  title: props.editNews ? props.editNews.title || '' : '',
  link: props.editNews ? props.editNews.link || '' : '',
  content: props.editNews ? props.editNews.content || '' : '',
  image: props.editNews ? props.editNews.image || '' : '',
});


const update = () => {
  form.post(route('news.updated', { id: props.editNews.id }),
    {
      onSuccess: () => {
        toast("News Update Successfully!", {
          autoClose: 2000,
          theme: 'dark',
        }
        );
      },
    });
};
</script>
<template>
    <AuthenticatedLayout>
          <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit News</h2>
          </template>
          <div class="flex items-center justify-center">
            <div class="w-full px-2">
                <form @submit.prevent="update" enctype="multipart/form-data">
                    <div class="row">
                        <div class="mt-4 col-md-6">
                              <label for="title">Title<span class="text-danger">*</span></label>
                               <input id="title" v-model="form.title" placeholder="Enter Title" class="form-control block w-full mt-1" autocomplete="title"/>
                                <div v-if="errors.title" class="text-danger">{{ errors.title }}</div>
                        </div>

                         <div class="mt-4 col-md-6">
                              <label for="link">Link<span class="text-danger">*</span></label>
                               <input id="link" v-model="form.link" placeholder="Enter Link" class="block w-full mt-1 form-control" autocomplete="link"/>
                               <div v-if="errors.link" class="text-danger">{{ errors.link }}</div>
                        </div>

                         <div class="mt-4 col-md-6">
                              <label for="content">Content<span class="text-danger">*</span></label>
                                 <textarea id="content" v-model="form.content" placeholder="Enter Content" class="form-control block w-full mt-1"></textarea>
                                <div v-if="errors.content" class="text-danger">{{ errors.content }}</div>
                        </div>

                         <div class="mt-4 col-6">
                              <label for="image">Image</label><br/>
                              <input type="file" @input="form.image = $event.target.files[0]" accept="image/*"/>
                             <div v-if="errors.image" class="form-control text-danger">{{ errors.image }}</div>
                        </div>

                        <div class="mt-4 col-md-6">
                               <button type="submit" class="btn btn-primary">Update</button>
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
