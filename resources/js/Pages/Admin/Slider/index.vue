<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Link } from '@inertiajs/vue3';
import { onMounted, reactive } from 'vue';
import Swal from 'sweetalert2';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';


const props = defineProps({
    sliders: {
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
const options = {
    searching: false,
    lengthChange: false, 
    paging: false ,
    sorting:false
};

    // Edit Slider
    const editSlider= async(id) =>{
        router.get(`/home-page/edit/${id}`);
    };
    // View Slider
    const viewSlider = async(id)=>{
        router.get(`/home-page/${id}`)
    };
    // Delete Slider
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
                    text: 'Slider Deleted Successfully',
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
                text: 'Error Deleting Slider. Please try again.',
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
                <h2 class="font-semibold text-xl text-black-800 leading-tight">Sliders</h2>
            <div class="button-container">
                <Link v-if="sliders.length<5" :href="route('home-page.create')">
                <button class="btn btn-info">Add Slider</button>
                </Link>
            </div>
            
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;">
                    <div class="p-6 text-black-900 table-responsive ">
                       <DataTable class="display" :options="options" style="border:2px black ;width:100% ;overflow:hidden">
                            <thead>
                                <tr>
                                    <th >ID</th>
                                    <th>Slider Heading</th>
                                    <th style="width:200px !important;" >Slider Description</th>
                                    <th>Slider Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(slider, index) in sliders" :key="slider.id">
                                    <td >{{ index+1 }}</td>
                                    <td>{{ slider.slider_heading }}</td>
                                    <td style="width:200px !important;">{{ slider.slider_description }}</td>
                                    <td>
                                        <img :src="getImageUrl(slider.slider_image)" alt="" srcset="" style="width:100px">
                                        </td>
                                    <td>
                                        <!-- <button class="btn btn-info btn-sm"  @click="viewSlider(slider.id)" >View</button> -->
                                        <!-- &nbsp; -->
                                        <button class="btn btn-primary btn-sm" @click="editSlider(slider.id)"
                                           ><i class="fas fa-edit" ></i>  </button>
                                        &nbsp;
                                        <button v-if="sliders.length>1" class="btn btn-danger btn-sm" @click="deleteSlider(slider.id)"
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