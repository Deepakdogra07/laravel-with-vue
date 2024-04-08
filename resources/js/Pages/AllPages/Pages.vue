<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import { reactive , ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastify';
import { router } from '@inertiajs/vue3';


defineProps({
    pages:{
        type: Array
    }
});

const getIdColumnIndex = () => {
    return 0;
};

const idColumnIndex = getIdColumnIndex();

const options = reactive({
    order: [[idColumnIndex, 'desc']],
});

const viewPage = (id) => {
    console.log(id);
    const toast = useToast();
    router.get(`/pages/view/${id}`);
    // toast.success('Page Updated Successfully');
};

const editPage = (id) => {
    console.log(id);
    const toast = useToast();
    router.get(`/pages/edit/${id}`);
};

const deletePage = (id) => {
    const toast = useToast();
    if (confirm('Are you sure you want to delete this record?')) {
        try {
            router.get(`/pages/delete/${id}`);
            router.visit(route('pages'));
            toast.success('Pages Deleted Successfully');

        } catch (error) {
            toast.error('Error Deleting Agent. Please try again.');
        }
    } else {
        return;
    }
};

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">All Pages Setting</h2>
            <div class="button-container">
                <Link :href="route('pages.add-details')">
                <button class="btn btn-success">Add Form</button>
                </Link>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;">
                    <div class="p-6 text-gray-900">
                        <DataTable class="display" :options="options" style="border:2px black ;width:100%">
                            <thead>
                                <tr>
                                    <th class="d-none">ID</th>
                                    <th>Title</th>
                                    <th>Slug</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="page in pages" :key="page.id">
                                    <td  class="d-none">{{ page.id }}</td>
                                    <td>{{ page.title }}</td>
                                    <td>{{ page.slug }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm" @click="viewPage(page.id)">View</button>
                                        &nbsp;
                                        <button class="btn btn-primary btn-sm" @click="editPage(page.id)">Edit</button>
                                        &nbsp;
                                        <button class="btn btn-danger btn-sm" @click="deletePage(page.id)">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>
        <!-- <Modal :show="assignAgent" :leadId="selectedLeadId" :modal="1" @close="closeModal" /> -->
    </AuthenticatedLayout>
    <!-- <div v-if="isVisible" class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <span class="close" @click="closeModal">&times;</span>
                <h2>{{ title }}</h2>
            </div>
            <div class="modal-body">
                <p>This is the modal content.</p>
                <button @click="closeModal">Close Modal</button>
            </div>
        </div>
    </div> -->
</template>

