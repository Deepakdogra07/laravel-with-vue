<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Link } from '@inertiajs/vue3';
import { onMounted, reactive } from 'vue';
import Swal from 'sweetalert2';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const props = defineProps({
    customers: {
        type: Array
    },
});
// console.log(props.customers);
    // Edit category
    const editbusiness= async(id) =>{
        router.get(route('business-listing.edit',id));
    };
    
    // Delete category
    const deletebusiness = async (id) => {
        const { value: confirmed } = await Swal.fire({
            title: 'Are you sure?',
            text: 'You want to Delete Employer Record?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        });

        try {
            if (confirmed) {
                router.delete(route('business-listing.destroy',id));
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Employer Deleted Successfully',
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
                text: 'Error Deleting Employer. Please try again.',
            });
        }
    };
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
                <h2 class="font-semibold text-xl text-black-800 leading-tight">Categories</h2>
            <div class="button-container">
                <Link :href="route('business-listing.create')">
                <button class="btn btn-info">Add Employer</button>
                </Link>
            </div>
            
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;">
                    <div class="p-6 text-black-900">
                        <DataTable class="display"  style="border:2px black ;width:100%">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <!-- <th>test</th> -->
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                              
                                <tr v-for="(customer,index) in customers" :key="customer.id">
                                    <td >{{ index+1 }}</td>
                                    <td >
                                        <p v-html="customer.name"></p>
                                    </td>
                                    <td>{{ customer.email }}</td>
                                    <!-- <td>
                                        <img :src="getImageUrl(customer.category_image)" alt="" srcset="" style="width:100px">
                                        </td> -->
                                    <td :style="{ color: (customer.status == 0) ? 'red' : 'green' }">
                                        {{ (customer.status == 0) ?"Inactive" : "Active" }}
                                    </td>
                                    <td>
                                        &nbsp;
                                        <button class="btn btn-primary btn-sm" @click="editbusiness(customer.id)"
                                           ><i class="fas fa-edit" ></i></button>
                                        &nbsp;
                                        <button class="btn btn-danger btn-sm" @click="deletebusiness(customer.id)"
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