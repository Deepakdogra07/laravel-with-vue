<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Link } from '@inertiajs/vue3';
import { onMounted, reactive } from 'vue';
import Swal from 'sweetalert2';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const props = defineProps({
    data: {
        type: Array
    },
    msg:{
        type:String
    }
});


    // Delete enquiry
    const viewenquiry = async (id) => {
        router.get(route('contactus.view',id));
    };

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
                <h2 class="font-semibold text-xl text-black-800 leading-tight">View Enquiries</h2>
                
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;">
                    <div class="p-6 text-black-900">
                        <DataTable class="display" :options="options" style="border:2px black ;width:100%">
                            <thead>
                                <tr>
                                    <th >ID</th>
                                    <th >Name</th>
                                    <th>Email</th>
                                    <th>Mobile Number</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(enquiry,index) in data" :key="enquiry.id">
                                    <td >{{ index+1 }}</td>
                                    <td>
                                            {{ enquiry?.user_name }}
                                    </td>
                                    <td> {{ enquiry?.user_email }}</td>
                                    <td>
                                        {{ enquiry?.user_mobile }}
                                    </td>
                                   
                                    <td>
                                        
                                        &nbsp;
                                        <button class="btn btn-info btn-sm" @click="viewenquiry(enquiry.id)"
                                            ><i class="fas fa-eye" ></i></button>
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