<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Link } from '@inertiajs/vue3';
import { onMounted, reactive } from 'vue';
import Swal from 'sweetalert2';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const props = defineProps({
    jobs: {
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

   

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
                <h2 class="font-semibold text-xl text-black-800 leading-tight">Jobs</h2>
                <div class="button-container">
                <Link :href="route('jobs.create')">
                <button class="btn btn-info">Add Job</button>
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
                                    <th >Name</th>
                                    <th>Email</th>
                                    <th>Mobile Number</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(job,index) in jobs" :key="job.id">
                                    <td >{{ index+1 }}</td>
                                    <td>
                                            {{ job?.user_name }}
                                    </td>
                                    <td> {{ job?.user_email }}</td>
                                    <td>
                                        {{ job?.user_mobile }}
                                    </td>
                                   
                                    <td>
                                        
                                        
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