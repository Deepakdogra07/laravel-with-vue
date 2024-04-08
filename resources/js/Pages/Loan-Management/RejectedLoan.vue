<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { reactive } from 'vue';
import {Link} from '@inertiajs/vue3';
defineProps({
    rejected_loan: {
        type: Array,
        default:[],
    }
});
const getIdColumnIndex = () => {
    return 0;
};

const idColumnIndex = getIdColumnIndex();

// const options = reactive({
//   dom: 'Bftip',
//   buttons: ['csv'],
//   select: true,
//   order: [[idColumnIndex, 'desc']],
// });



const options = reactive({
  dom: 'Bftip',
//   buttons: ['csv'],
//   select: true,
  order: [[idColumnIndex, 'desc']],
});

const formatDate = (timestamp) => {
  const date = new Date(timestamp);
  const formattedDate = date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
  return formattedDate;
};
const submit = () => {
    form.post(route('loans'));
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Rejected Loans</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;">
                    <div class="p-6 text-gray-900" style="overflow-x: auto;">
                        <DataTable class="display table table-striped" :options="options" style="border:2px black ;width:100%;">
                            <thead>
                                <tr>
                                    <th class="d-none">ID</th>
                                    <th>Applicant Name</th>
                                    <th>Loan Amount</th>
                                    <th>Installments</th>
                                    <th>Date Applied</th>
                                    <th>Date Rejected</th>
                                    <!-- <th>Agent</th> -->
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="loan in rejected_loan" :key="loan.id">
                                    <td class="d-none">{{ loan.id }}</td>
                                    <td>{{ loan.applicant_name }}</td>
                                    <td>{{ loan.loan_amount }}</td>
                                    <td>{{ loan.numberOfmonths }} Months</td>
                                    <td>{{ formatDate(loan.created_at) }}</td>
                                    <td>{{ formatDate(loan.updated_at) }}</td>
                                    <!-- <td>{{ loan.get_agent && loan.get_agent.name ? loan.get_agent.name : '' }}</td> -->
                                    <td :class="{ 'text-green-700': loan.status == 1, 'text-blue-700': loan.status == 2, 'text-red-700': loan.status == 3}">
                                        {{ loan.status == 1 ? 'Approved' : (loan.status == 2 ? 'Rejected' : (loan.status == 3 ? 'Incomplete' : (loan.status == 4 ? 'Full-Complete' : 'Inactive'))) }}
                                    </td>
                                    <td>
                                        <Link :href="route('loan.view',loan.id)">
                                        <button class="btn btn-info btn-sm mr-1">View</button>
                                        </Link>

                                        <!-- <Link :href="route('loan.delete',loan.id)">
                                        <button class="btn btn-danger btn-sm mr-1">Delete</button>
                                        </Link> -->
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

