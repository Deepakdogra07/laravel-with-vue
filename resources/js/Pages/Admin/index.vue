<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Link } from '@inertiajs/vue3';
import { reactive } from 'vue';
import Swal from 'sweetalert2';

defineProps({
    sliders: {
        type: Array
    }
});
const editSlider= async(id) =>{
    router.get(`/home-page/edit/${id}`);
};
const deleteSlider = async (id) => {
    const { value: confirmed } = await Swal.fire({
        title: 'Are you sure?',
        text: 'You want to Delete Customer Record?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    });

    try {
        if (confirmed) {
            router.get(`/home-page/delete/${id}`);
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Customer Deleted Successfully',
            });
            // location.reload();
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
function getImageUrl(imageName) {
      return `/storage/slider/${imageName}`;
    }
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
                <h2 class="font-semibold text-xl text-black-800 leading-tight">Edit Home Page</h2>
            <div class="button-container">
                <Link :href="route('home-page.create')">
                <button class="btn btn-info">Add Slider</button>
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
                                    <th >ID</th>
                                    <th>Slider Name</th>
                                    <th>Slider Heading</th>
                                    <th>Slider Description</th>
                                    <th>Slider Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="slider in sliders" :key="slider.id">
                                    <td >{{ slider.id }}</td>
                                    <td>{{ slider.slider_name }}</td>
                                    <td>{{ slider.slider_heading }}</td>
                                    <td>{{ slider.slider_description }}</td>
                                    <td>
                                        <img :src="getImageUrl(slider.slider_image)" alt="" srcset="" style="width:100px">
                                        </td>
                                    <td>
                                        <button class="btn btn-info btn-sm" >View</button>
                                        &nbsp;
                                        <button class="btn btn-primary btn-sm" @click="editSlider(slider.id)"
                                           ><i class="bi bi-pencil-square" ></i>  Edit</button>
                                        &nbsp;
                                        <button class="btn btn-danger btn-sm" @click="deleteSlider(slider.id)"
                                            >Delete</button>
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
  
</style>