<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { onMounted, reactive, ref } from "vue";
import Swal from 'sweetalert2';


const props = defineProps({
    loanData: {
        type: Array,
        default: [],
    },
    authUser: {

    },
    user_type : String,
});
const getIdColumnIndex = () => {
    return 0;
};

const idColumnIndex = getIdColumnIndex();

const options = reactive({
    order: [[idColumnIndex, 'desc']],
});





const selectLoanId = ref();

const selectedLoanId = ref()

const assignedTo = ref(false);
const loanStatus = ref(false);
const selectedStatus = ref(false);
const assignedAgent = ref(false);


const assigned = (loanId,assignedId) => {
    selectLoanId.value = loanId;
    assignedTo.value = true;
    assignedAgent.value = assignedId;
}



const changeStatus = (loanid, initialStatus) => {
    selectLoanId.value = loanid;
    loanStatus.value = true;
    selectedStatus.value = initialStatus;

}
const closebtn = () => {
    // console.log('vue')
    assignedTo.value = false;
    loanStatus.value = false;
}

const getStatusColor = (status) => {
    //   const statusName = loanData.status;
    //   const status = status.toLowerCase();

    switch (status.toLowerCase()) {
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

const deleteLoan = async (id) => {
    const { value: confirmed } = await Swal.fire({
        title: 'Are you sure?',
        text: 'You want to Delete Loan Record?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    });

    try {
        if (confirmed) {
            // router.get(`/loan/delete/${id}`);
            await axios.delete(`/loan/delete/${id}`);
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Loan Deleted Successfully',
            });
            router.visit(route('loan.index'));
            setTimeout(() => {
          window.location.reload();
       }, 1500);

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

onMounted(()=>{
    // alert(props.authUser.user_type);
})
</script>

<template>
    <!-- <h1>{{ selectLoanId }}</h1> -->
    <Head title="Loan Management" />

    <AuthenticatedLayout>
        <template #header>
            <h2>Loan Management</h2>

            <div class="button-container" v-if="user_type == 1">
                <Link :href="route('loan.create')">
                <button class="btn btn-success">Add Loan</button>
                </Link>
            </div>
        </template>
        <!-- <div v-for="(text,index) in data" :key="index">{{ text }}</div> -->
        <div class="py-6">
            <div class="max-w-7xl mx-auto px-2">
                <div class="bg-white overflow-auto shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <DataTable :options="options" class="display" style="border:2px black ;width:100%">
                            <thead>
                                <tr>
                                    <th class="d-none">ID</th>
                                    <th>Applicant Name</th>
                                    <th>Email</th>
                                    <th>Loan Amount</th>
                                    <th>Installments</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="loan in props.loanData" :key="loan.id">
                                    <td class="d-none">{{ loan.id }}</td>
                                    <td>{{ loan.user_name }}</td>
                                    <td>{{ loan. user_email }}</td>
                                    <td>{{ loan.loan_amount }}</td>
                                    <td>{{ loan.numberOfmonths }} months</td>
                                    <td>{{ loan.date }}</td>
                                    <td :class="['font-bold', getStatusColor(loan.status)]">
                                        {{ loan.status }}
                                    </td>
                                    <!-- <td :class="{ 'text-green-700': loan.status == 1,'text-green-700': loan.status == 2, 'text-blue-700': loan.status == 3, 'text-red-700': loan.status == 4}">
                                        {{ loan.status == 1 ? 'Active' : (loan.status == 2 ? 'Approved' :(loan.status == 3 ? 'Pending' : (loan.status == 4 ? 'Rejected' : 'Inactive'))) }}

                                    </td> -->
                                    <td>
                                        <Link :href="route('loan.view', loan.id)">
                                        <button class="btn btn-info btn-sm mr-1">View</button>
                                        </Link>

                                        <Link :href="route('loan.edit', loan.id)">
                                        <button class="btn btn-primary btn-sm mr-1">Edit</button>
                                        </Link>
                                        <button v-if="props.authUser.user_type == 1" @click="assigned(loan.id,loan.assigned_to)"
                                            class="btn btn-warning btn-sm mr-1">Assign To</button>

                                        <button @click="changeStatus(loan.id,loan.statusValue)"
                                            class="btn btn-success btn-sm mr-1">Status</button>

                                        <!-- <Link :href="route('loan.delete',loan.id)"> -->
                                        <button class="btn btn-danger btn-sm mr-1"
                                            @click="deleteLoan(loan.id)">Delete</button>
                                        <!-- </Link> -->
                                    </td>
                                </tr>
                            </tbody>
                        </DataTable>

                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
     <!-- <modal :show="assignedTo" :loanId="selectedLoanId" :agentName="assignedAgent" :modal="2" @close="closebtn">

    </modal> -->

    <!-- <modal :key="1" :show="assignedTo" :customerId="selectedCustomerId" :agentName="assignedAgent" :modal="2" @close="closebtn"></modal> -->

    <!-- :loanId="selectedLoanId" -->

    <Modal :key="1" :show="assignedTo" :loanId="selectLoanId" :customerId="selectedCustomerId" :agentName="assignedAgent"  :modal="2" @close="closebtn"></Modal>



    <Modal :key="2" :loanId="selectLoanId" :show="loanStatus" :initialStatus="selectedStatus" :modal="3" @close="closebtn" :userType="props.authUser.user_type">

    </Modal>

</template>
<style scoped>
    .side-navbar{
        height: 100vh !important;
    }
</style>

