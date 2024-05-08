<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import Swal from 'sweetalert2';
import { useToast } from 'vue-toastify';

defineProps({
  testimonialRecords: Array,
})

// const testimonialDelete = (id) => {

// }

const testimonialDelete = async (id) => {
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
      router.delete(`/testimonial/${id}`);
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: 'Testimonial Deleted Successfully',
      });
        setTimeout(() => {
          window.location.reload();
       }, 1000);

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
      text: 'Error Deleting testimonial. Please try again.',
    });
  }
};

const testimonialedit = (id)=>{
    router.get(`testimonial/${id}/edit`);
}
</script>
<template>
    <AuthenticatedLayout>
          <!-- <template #header> -->
            <div class="d-flex justify-between align-items-center mb-4">
              <h2 class="font-semibold text-xl text-gray-800 leading-tight">Testimonials</h2>
              <div class="button-container">
                    <Link :href="route('testimonial.create')">
                    <button class="btn btn-success">Add Testimonials</button>
                    </Link>
                </div>
            </div>
          <!-- </template> -->
          <div class="py-12">
          <div class="max-w-7xl mx-auto px-2">
              <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;">
                  <div class="p-6 text-black-900 padding_remove bg_tablee">
                      <DataTable class="display" :options="options" style="border:2px black ;width:100%">
                          <thead>
                              <tr>
                                  <th class="d-none">ID</th>
                                  <th>Name</th>
                                  <th>Image</th>
                                  <th>Content</th>
                                  <th>Status</th>
                                  <th>Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                          <tr v-for="testimonialRecord in testimonialRecords" :key="testimonialRecord.id">
                                  <td class="d-none">{{ testimonialRecord.id }}</td>
                                  <td>{{ testimonialRecord.name }}</td>
                                  <td>
                                    <div class="image_sections_testimonial">
                                      <img :src="`${testimonialRecord.image_link}`">
                                    </div>
                                  </td>
                                  <td>{{ testimonialRecord.content }}</td>
                                  <td :style="{ color: (testimonialRecord.status == 0) ? 'red' : 'green' }" >
                                    {{ (testimonialRecord.status == 0) ?"Inactive" : "Active" }}
                                  </td>
                                  <td>
                                    <div class="d-flex gap-2">
                                      <button type="button" class="btn btn-primary" @click="testimonialedit(testimonialRecord.id)"><i class="fas fa-edit"></i></button>
                                      <button type="button" class="btn btn-danger" @click="testimonialDelete(testimonialRecord.id)"><i class="fas fa-trash"></i></button>
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
