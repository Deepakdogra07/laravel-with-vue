<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import Swal from 'sweetalert2';
import { useToast } from 'vue-toastify';

defineProps({
  allNews: {
    type: Array
  }
});


const editNews = (id) => {
  router.get(`/news/${id}/edit`);
}

const deleteNews = async (id) => {
  const { value: confirmed } = await Swal.fire({
    title: 'Are you sure?',
    text: 'You want to Delete News Record?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!'
  });

  try {
    if (confirmed) {
      router.delete(`/news/${id}`);
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: 'News Deleted Successfully',
      });
      location.reload();
    } else {
      Swal.fire({
        icon: 'info',
        title: 'Canceled',
        text: 'Deletion canceled.',
      });
    }
  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Error Deleting Customer. Please try again.',
    });
  }
};
</script>
<template>
    <AuthenticatedLayout>
          <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">News</h2>

                <div class="button-container">
                     <Link :href="route('news.create')">
                     <button class="btn btn-success">Add News</button>
                     </Link>
                 </div>
          </template>


           <div class="py-12">
            <div class="max-w-7xl mx-auto px-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;">
                    <div class="p-6 text-black-900">
                        <DataTable class="display" :options="options" style="border:2px black ;width:100%">
                            <thead>
                                <tr>
                                    <th class="d-none">ID</th>
                                    <th>Title</th>
                                    <th>Link</th>
                                    <th>Content</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="news in allNews" :key="news.id">
                                   <td class="d-none">{{ news.id }}</td>
                                   <td>{{ news.title }}</td>
                                   <td>{{ news.link }}</td>
                                   <td>{{ news.content }}</td>
                                  <td>
                                      <a :href="'/storage/news/' + news.image" data-lightbox="roadtrip">
                                          <img :src="'/storage/news/' + news.image" alt="News Image" style="width: 50px; height: 50px;">
                                      </a>
                                  </td>
                                  <td>
                                    <div class="d-flex gap-2">
                                      <button type="button" class="btn btn-primary" @click="editNews(news.id)">Edit</button>
                                      <button type="button" class="btn btn-danger" @click="deleteNews(news.id)">Delete</button>
                                    </div>
                                  </td>
                                </tr>
                            </tbody>
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
<style scoped>
  .dataTable thead th, .dataTable tbody td{
    white-space: unset !important;
  }
</style>
