<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { reactive } from 'vue';
import Swal from 'sweetalert2';

defineProps({
  loanData: {
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

const deleteLoanPermanantly = async (id) => {
  const { value: confirmed } = await Swal.fire({
    title: 'Are you sure?',
    text: 'You want to Delete Loan Record permanantly?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!'
  });

  try {
    if (confirmed) {
      // router.get(`/loan/delete/${id}`);
      await axios.delete(`/loan/deleted/${id}`);
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: 'Loan Deleted Successfully',
      });
      router.visit(route('deleted.loans'));

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

const deleteLoan = async (id) => {
  const { value: confirmed } = await Swal.fire({
    title: 'Are you sure?',
    text: 'You want to Restore this Loan Record?',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, restore it!'
  });

  try {
    if (confirmed) {
      // router.get(`/loan/delete/${id}`);
      await axios.delete(`/loan/delete/${id}`);
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: 'Loan Restored Successfully',
      });
      router.visit(route('deleted.loans'));

    } else {
      Swal.fire({
        icon: 'info',
        title: 'Canceled',
        text: 'Restore loan canceled.',
      });
    }
  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Error restore loan. please try again.',
    });
  }
};

</script>

<template>
  <Head title="Loan Management"/>

  <AuthenticatedLayout>
    <template #header>
     Loan Management
    </template>
     <!-- <div v-for="(text,index) in data" :key="index">{{ text }}</div> -->
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-2">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <DataTable  class="display" :options="options" style="border:2px black ;width:100%">
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
                            <tr v-for="loan in loanData" :key="loan.id">
                                <td class="d-none">{{ loan.id }}</td>
                                <td>{{ loan.applicant_name }}</td>
                                <td>{{ loan.loan_amount }}</td>
                                <td>{{ loan.numberOfmonths }} Months</td>
                                <td :class="{ 'text-green-700': loan.status == 1, 'text-red-700': loan.status == 0 }">
                                        {{ loan.status == 1 ? 'Active' : 'Inactive' }}
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-info"  @click="deleteLoan(loan.id)">Restore</button>
                                        <button class="btn btn-primary" @click="deleteLoanPermanantly(loan.id)">Delete permanantly</button>
                                    </div>
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


