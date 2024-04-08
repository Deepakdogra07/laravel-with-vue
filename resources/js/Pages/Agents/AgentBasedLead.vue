<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';
import {  Link, router } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

defineProps({
    leads: {
        type: Array
    }
});

const options = {
    dom: 'Bftip',
    buttons: ['csv'],
    // select: true
};

const selectedLeadId = ref(null);
const assignAgent = ref(false);

const resign = (leadId) => {
    selectedLeadId.value = leadId;
    assignAgent.value = true;

}
const closeModal = () => {
    // console.log('vue')
    assignAgent.value = false;
    location.reload();
}

const cancelAgent = async (id) => {
    const { value: confirmed } = await Swal.fire({
        title: 'Are you sure?',
        text: 'You want to Cancel Agent from this Loan?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, Cancel it!'
    });
    try {
        if (confirmed) {
            router.get(`/cancelAgent/${id}`);
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Cancel Loan on this Agent Successfully',
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
            text: 'Error Cancel Agent on Loan. Please try again.',
        });
    }
};


const getStatusColor = (status) => {
    // console.log(status);
    switch (status) {
        case 'pending':
            return 'text-yellow-500';
        case 'approved':
            return 'text-green-500';
        case 'rejected':
            return 'text-red-500';
        case 'incomplete':
            return 'text-black-500';
        case 'fullcomplete':
            return 'text-blue-500';
        case 're-apply':
            return 'text-orange-500';
        default:
            return 'text-gray-800';
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Assigned Loans</h2>
        </template>

        <div class="py-12">
            <div class="px-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;">
                    <div class="p-4 text-gray-900">
                        <DataTable class="display" :options="options" style="border:2px black ;width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Loan Amount</th>
                                    <th>Installments</th>
                                    <th>Loan Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="lead in leads" :key="lead.id">
                                    <td>{{ lead.applicant_name }}</td>
                                    <td>{{ lead.loan_amount }}</td>
                                    <td>{{ lead.numberOfmonths }} Months</td>
                                    <td :class="['font-bold', getStatusColor(lead.status)]">
                                        <!-- {{ lead.status }} -->
                                        <p class="text-warning" v-if="lead.status == 0">Pending</p>
                                        <p class="text-success" v-if="lead.status == 1">Approved</p>
                                        <p class="text-danger" v-if="lead.status == 2">Rejected</p>
                                        <p class="text-black" v-if="lead.status == 3">Incomplete</p>
                                        <p class="text-success" v-if="lead.status == 4">FullComplete</p>
                                        <p class="text-orange" v-if="lead.status == 5">Re-Apply</p>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" @click="resign(lead.id)">Resign To
                                            Other Agent</button>

                                        <Link :href="route('loan.view', lead.id)" class="pl-2">
                                          <button class="btn btn-info btn-sm mr-1">View</button>
                                        </Link>

                                        <Link :href="route('loan.edit', lead.id)">
                                          <button class="btn btn-primary btn-sm mr-1">Edit</button>
                                        </Link>

                                        &nbsp;<button class="btn btn-danger btn-sm" @click="cancelAgent(lead.id)">Cancel
                                            Loan</button>


                                    </td>
                                </tr>
                            </tbody>
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>
        <Modal :show="assignAgent" :leadId="selectedLeadId" :modal="1" @close="closeModal" />
    </AuthenticatedLayout>
</template>

