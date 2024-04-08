<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,Link} from '@inertiajs/vue3';
import AssignedModal from '@/Components/AssignedModal.vue';
import { reactive } from 'vue';

defineProps({
    loans: {
        type: Array,
        default: [],
    },
});
const getIdColumnIndex = () => {
    return 0;
};

const idColumnIndex = getIdColumnIndex();

const options = reactive({
  order: [[idColumnIndex, 'desc']],
});
</script>

<template>
  <Head title="Assigned Loan"/>

  <AuthenticatedLayout>
    <template #header>
     Assigned Loan To Agents
    </template>

     <!-- <div v-for="(text,index) in data" :key="index">{{ text }}</div> -->
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <DataTable  class="display" style="border:2px black ;width:100%">
                        <thead>
                            <tr>
                                <th class="d-none">ID</th>
                                <th>Applicant Name</th>
                                <th>Loan Amount</th>
                                <th>Installments</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="loan in loans" :key="loan.id">
                                <td class="d-none">{{ loan.id }}</td>
                                <td>{{ loan.applicant_name }}</td>
                                <td>{{ loan.loan_amount }}</td>
                                <td>{{ loan.numberOfmonths }} Months</td>
                                <td :class="{ 'text-green-700': loan.status == 1, 'text-blue-700': loan.status == 2, 'text-red-700': loan.status == 3}">
                                    {{ loan.status == 1 ? 'Approved' : (loan.status == 2 ? 'Rejected' : (loan.status == 3 ? 'Incomplete' : (loan.status == 4 ? 'Full-Complete' : 'Inactive'))) }}
                                </td>
                                <td>
                                    <Link :href="route('loan.view',loan.id)">
                                    <button class="btn btn-info btn-sm mr-1">View</button>
                                    </Link>
                                    <!-- <Link :href="route('loan.edit',loan.id)">
                                    <button class="btn btn-primary btn-sm">Edit</button>
                                    </Link>
                                    <Link :href="route('loan.delete',loan.id)">
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                    </Link> -->
                                    <!-- <button class="btn btn-danger btn-sm">Change Agent</button> -->
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


