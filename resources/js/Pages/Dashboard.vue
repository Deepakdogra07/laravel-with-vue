<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { reactive, ref, onMounted, computed } from 'vue';
import { router } from '@inertiajs/vue3'

const getIdColumnIndex = () => {
    return 0;
};

const idColumnIndex = getIdColumnIndex();

const createOptions = () => {
    const idColumnIndex = getIdColumnIndex();
    return reactive({
        searching: false,
        paging: false,
        order: [[idColumnIndex, 'desc']],
    });
};
const options1 = createOptions();
const options2 = createOptions();
const options3 = createOptions();
const options4 = createOptions();

const props = defineProps(['authData', 'users', 'loan', 'approvedLoan', 'totalAgent','totalRejectLoanCount' ,'totalAgentCount']);
// const authuser = ref(props.authData.user_type);
// const isAdmin = authuser.value;
// console.log(props.authData.user_type);
const userCount = ref(props.users.length);
const loanCount = ref(props.loan.length);
const approvedloans = ref(props.approvedLoan.length);
const totalagents = ref(props.totalAgent.length);
// console.log(userCount,'usercount');
const formatDate = (timestamp) => {
    const date = new Date(timestamp);
    const formattedDate = date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
    return formattedDate;
};

const createDataToShow = (data) => {
    const sortedData = [...data].sort((a, b) => b.id - a.id);
    return sortedData.slice(0, 5);
};
const loanDataToShow = computed(() => createDataToShow(props.loan));
const usersDataToShow = computed(() => createDataToShow(props.users));
const approvedLoanDataToShow = computed(() => createDataToShow(props.approvedLoan));
const totalAgentDataToShow = computed(() => createDataToShow(props.totalAgent));
// const dataTableOptions = {
//         searching: false,
//         paging: false,
//     };

const viewCustomer = (id) => {
    // console.log(id);
    // const toast = useToast();
    router.get(`/customers/view-customer/${id}`);
    // router.visit(route('customers'));
};

onMounted(() => {

    const elements = document.querySelectorAll('[id^="DataTables_Table_"][id$="_info"]')
    elements.forEach(e => {
        e.style.display = 'none';
    })
});

const getStatusColor = (status) => {
    switch (status.toLowerCase()) {
        case 'pending':
            return 'text-yellow-500', 'text-bold';
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
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            Dashboard
        </template>

        <!-- <div class="p-4 bg-white rounded-lg shadow-xs"> -->
        <div class="py-4 dashboard-home">
            <div class="col-12 col-lg-12 mb-4">
                <div class="card px-2">
                    <!-- <h5 class="pb-1 mb-4"></h5> -->
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-xl-3 mb-3">
                            <Link :href="route('customers')">
                                <div class="card bg-primary text-white card-flex py-2">
                                    <div class="card-header">
                                        <h4>Total Customers</h4>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-text text-center">
                                            {{ userCount }}
                                        </h3>
                                    </div>
                                </div>
                            </Link>
                        </div>

                        <div v-if="props.authData.user_type == 1" class="col-lg-3 col-md-6 col-xl-3 mb-3">
                            <Link :href="route('agents')">
                            <div class="card bg-success text-white mb-3 card-flex py-2">
                                <div class="card-header">
                                    <h4>Total Business</h4>
                                </div>
                                <div class="card-body">
                                    <h3 class="card-text text-center">
                                        {{ totalAgentCount }}
                                    </h3>
                                </div>
                            </div>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- </div> -->
        <div class="py-4">
            <div class="max-w-7xl mx-auto px-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;">
                    <div class="p-6 text-black-900 dashboard">
                        <DataTable class="display" :options="options1" style="border:2px black ;width:100%">
                            <thead>
                                <tr>
                                    <th class="d-none">ID</th>
                                    <th>Customer Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="customer in usersDataToShow" :key="customer.id">
                                    <td class="d-none">{{ customer.id }}</td>
                                    <td>{{ customer.name }}</td>
                                    <td>{{ customer.email }}</td>
                                    <td :class="{ 'active': customer.status == 1, 'inactive': customer.status == 0 }">
                                        {{ customer.status == 1 ? 'Active' : 'Inactive' }}
                                    </td>
                                    <!-- <td v-if="customer.status == 0">Inactive</td>
                                    <td v-if="customer.status == 1">Active</td> -->
                                    <td>
                                        <button class="btn btn-info btn-sm" @click="viewCustomer(customer.id)">View</button>
                                    </td>
                                </tr>
                            </tbody>
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-4">
            <div v-if="props.authData.user_type == 1">
                <div class="max-w-7xl mx-auto px-2 py-4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;">
                        <div class="p-6 text-black-900 dashboard">
                            <DataTable class="display" :options="options4" style="border:2px black ;width:100%">
                                <thead>
                                    <tr>
                                        <th class="d-none">ID</th>
                                        <th>Business Name</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="agent in totalAgentDataToShow" :key="agent.id">
                                        <td class="d-none">{{ agent.id }}</td>
                                        <td>{{ agent.name }}</td>
                                        <td>{{ agent.email }}</td>
                                        <td :class="{ 'active': agent.status == 1, 'inactive': agent.status == 0 }">
                                            {{ agent.status == 1 ? 'Active' : 'Inactive' }}
                                        </td>
                                        <td>
                                            <Link :href="route('agents.view-agent', agent.id)">
                                            <button class="btn btn-info btn-sm mr-1">View</button>
                                            </Link>
                                        </td>
                                    </tr>
                                </tbody>
                            </DataTable>
                        </div>
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
