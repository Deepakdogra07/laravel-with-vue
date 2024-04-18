<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Link } from '@inertiajs/vue3';
import { onMounted, reactive } from 'vue';
import Swal from 'sweetalert2';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const props = defineProps({
    links: {
        type: Array
    },
    msg:{
        type:String
    }
});
onMounted( ()=>{
    console.log(props.msg,'props.msg');
    if(props.msg != null){
        toast(props.msg, {
        autoClose: 3000,
        theme: 'dark',
      });
    }

})

//     // Edit logo
    const editlogo= async(id) =>{
        router.get(route('update-links.edit',id));
    };
   
    // Delete logo
    const deletelogo = async (id) => {
        const { value: confirmed } = await Swal.fire({
            title: 'Are you sure?',
            text: 'You want to Delete Logo Record?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        });

        try {
            if (confirmed) {
                router.get(route('update-links.destroy',id));
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Logo Deleted Successfully',
                });
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
                text: 'Error Deleting Logo. Please try again.',
            });
        }
    };
function getImageUrl(imageName) {
      return `/storage/logos/${imageName}`;
    }
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
                <h2 class="font-semibold text-xl text-black-800 leading-tight">Edit Logo and Links</h2>
            <div class="button-container">

                <Link v-if="links.length==0" :href="route('update-links.create')">
                <button class="btn btn-info">Add Logo and Link Data</button>
                </Link>
            </div>
            
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;">
                    <div class="p-6 text-black-900">
                        <table class="display" :options="options" style="border:2px black ;width:100%">
                            <thead>
                                <tr>
                                    <th >ID</th>
                                    <th>Link Heading</th>
                                    <th>logo Description</th>
                                    <th>Logo Image</th>
                                    <!-- <th>Actions</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(link,index) in links" :key="link.id">
                                    <td >{{ index+1 }}</td>
                                    <td>{{ 1 }}</td>
                                    <td>{{ link.logo_description }}</td>
                                    <td>
                                        <img :src="getImageUrl(link.logo_image)" alt="" srcset="" style="width:100px">
                                        </td>
                                    <td>
                                        &nbsp;
                                        <button class="btn btn-primary btn-sm" @click="editlogo(link.id)"
                                           ><i class="fas fa-edit" ></i></button>
                                        &nbsp;
                                        <button class="btn btn-danger btn-sm" @click="deletelogo(link.id)"
                                            ><i class="fas fa-trash" ></i></button>
                                   </td> 
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
  
</style>