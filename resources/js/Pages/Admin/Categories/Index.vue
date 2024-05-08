<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Link } from '@inertiajs/vue3';
import { onMounted, reactive } from 'vue';
import Swal from 'sweetalert2';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const props = defineProps({
    categories: {
        type: Array
    },
});

    // Edit category
    const editcategory= async(id) =>{
        router.get(route('category.edit',id));
    };
    
    // Delete category
    const deletecategory = async (id) => {
        const { value: confirmed } = await Swal.fire({
            title: 'Are you sure?',
            text: 'You want to Delete Category Record?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        });

        try {
            if (confirmed) {
                router.delete(route('category.destroy',id));
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Category Deleted Successfully',
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
                text: 'Error Deleting Category. Please try again.',
            });
        }
    };
function getImageUrl(imageName) {
      return `${imageName}`;
    }
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
                <h2 class="font-semibold text-xl text-black-800 leading-tight">Categories</h2>
            <div class="button-container">
                <Link :href="route('category.create')">
                <button class="btn btn-info">Add Category</button>
                </Link>
            </div>
            
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-2 category_tables">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;">
                    <div class="p-6 text-black-900 padding_remove">
                        <DataTable class="display"  style="border:2px black ;width:100%">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Thumbnail</th>
                                    <th>Category Heading</th>
                                    <th>Category Image</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(category,index) in categories" :key="category.id">
                                    <td >{{ index+1 }}</td>
                                    <td >
                                         <img :src="(category.thumbnail)" alt="" srcset="" style="width:100px">
                                    </td>
                                    <td>{{ category.category_heading }}</td>
                                    <td>
                                        <img :src="getImageUrl(category.category_image)" alt="" srcset="" style="width:100px">
                                        </td>
                                    <td :style="{ color: (category.status == 0) ? 'red' : 'green' }">
                                        {{ (category.status == 0) ?"Inactive" : "Active" }}
                                    </td>
                                    <td>
                                        &nbsp;
                                        <button class="btn btn-primary btn-sm" @click="editcategory(category.id)"
                                           ><i class="fas fa-edit" ></i></button>
                                        &nbsp;
                                        <button v-if="categories.length>1" class="btn btn-danger btn-sm" @click="deletecategory(category.id)"
                                            ><i class="fas fa-trash" ></i></button>
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