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
    }
});
console.log(props.jobs,'1234567890-');
onMounted(() => {
    console.log(props.msg, 'props.msg');
    if (props.msg != null) {
        toast(props.msg, {
            autoClose: 3000,
            theme: 'dark',
        });
    }

})
const deletejob = async (id) => {
    const { value: confirmed } = await Swal.fire({
        title: 'Are you sure?',
        text: 'You want to Delete Job Record?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    });

    try {
        if (confirmed) {
            router.delete(route('jobs.destroy', id));
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Job Deleted Successfully',
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
            text: 'Error Deleting Job. Please try again.',
        });
    }
};


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
                                    <th>ID</th>
                                    <th>Job Title</th>
                                    <th>Positions</th>
                                    <th>Industry</th>
                                    <th>Created By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(job, index) in jobs" :key="job.id">
                                    <td>{{ index + 1 }}</td>
                                    <td>
                                        {{ job?.job_title }}
                                    </td>
                                    <td> {{ job?.position?.name }}</td>
                                    <td>
                                        {{ job?.industry?.name }}
                                    </td>
                                    <td>
                                        {{ job?.createdby?.name }}
                                    </td>
                                    <td>
                                        <Link :href="route('jobs.show', job.id)" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                        </Link>
                                        &nbsp;
                                        <Link :href="route('jobs.edit', job.id)" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                        </Link>
                                        &nbsp;
                                        <button class="btn btn-danger btn-sm" @click="deletejob(job.id)"><i
                                                class="fas fa-trash"></i></button>
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

<style scoped></style>