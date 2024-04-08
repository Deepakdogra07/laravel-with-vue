<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useToast } from 'vue-toastify';
import { router, Link } from '@inertiajs/vue3';
import { reactive } from 'vue';
import Swal from 'sweetalert2';

defineProps({
    agents: {
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

const submit = () => {
    form.post(route('agents'));
};

const deleteAgent = async (id) => {
    const { value: confirmed } = await Swal.fire({
        title: 'Are you sure?',
        text: 'You want to Delete Agent Record?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    });

    try {
        if (confirmed) {
            router.delete(`/agents/delete-agent/${id}`);
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Agent Deleted Successfully',
            });
            // router.visit(route('agents'));
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
            text: 'Error Deleting Agent. Please try again.',
        });
    }
};
const viewAgent = (id) => {
    console.log(id);
    const toast = useToast();
    router.get(`/agents/view-agent/${id}`);
};

const editAgent = (id) => {
    router.get(`/agents/edit-agent/${id}`);
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
                <h2 class="font-semibold text-xl text-black-800 leading-tight">Agents</h2>
            <div class="button-container">
                <Link :href="route('agents.add-agent')">
                <button class="btn btn-success">Add Agent</button>
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
                                    <th class="d-none">ID</th>
                                    <th>Agent Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="agent in agents" :key="agent.id">
                                    <td class="d-none">{{ agent.id }}</td>
                                    <td>{{ agent.name }}</td>
                                    <td>{{ agent.email }}</td>
                                    <td :class="{ 'active': agent.status == 1, 'inactive': agent.status == 0 }">
                                        {{ agent.status == 1 ? 'Active' : 'Inactive' }}
                                    </td>
                                    <td>
                                        <button class="btn btn-info btn-sm" @click="viewAgent(agent.id)">View</button>
                                        &nbsp;
                                        <button class="btn btn-primary btn-sm" @click="editAgent(agent.id)">Edit</button>
                                        &nbsp;
                                        <button class="btn btn-danger btn-sm" @click="deleteAgent(agent.id)">Delete</button>
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
   .active{
      color: green;
      font-weight: 600;
   }
   .inactive{
      color: red;
      font-weight: 600;
   }
</style>