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

const props = defineProps(['authData', 'users','customers','business','jobs']);



const viewCustomer = (id) => {
    router.get(`/customers/view-customer/${id}`);
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
                                            {{ customers }}
                                        </h3>
                                    </div>
                                </div>
                            </Link>
                        </div>

                        <div v-if="props.authData.user_type == 1" class="col-lg-3 col-md-6 col-xl-3 mb-3">
                            <Link :href="route('business-listing.index')">
                            <div class="card bg-success text-white mb-3 card-flex py-2">
                                <div class="card-header">
                                    <h4>Total Business</h4>
                                </div>
                                <div class="card-body">
                                    <h3 class="card-text text-center">
                                        {{  business }}
                                    </h3>
                                </div>
                            </div>
                            </Link>
                        </div>
                        <div v-if="props.authData.user_type == 1" class="col-lg-3 col-md-6 col-xl-3 mb-3">
                            <Link :href="route('jobs.index')">
                            <div class="card bg-success text-white mb-3 card-flex py-2">
                                <div class="card-header">
                                    <h4>Total Jobs</h4>
                                </div>
                                <div class="card-body">
                                    <h3 class="card-text text-center">
                                        {{  jobs }}
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
        <!-- <div class="py-4">
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
                                     <td v-if="customer.status == 0">Inactive</td>
                                    <td v-if="customer.status == 1">Active</td> 
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
    -->

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
