<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import { useToast } from 'vue-toastify';
import { router } from '@inertiajs/vue3'
import { reactive,ref } from 'vue';
import modal from '@/Components/Modal.vue';

defineProps({
    customers: {
        type: Array
    },
    authUser:{

    }
});
const assignedAgent = ref(false);
const assignedTo = ref(false);
const selectedCustomerId = ref(null);
const getIdColumnIndex = () => {
    return 0;
};

const idColumnIndex = getIdColumnIndex();

const options = reactive({
    order: [[idColumnIndex, 'desc']],
});

const submit = () => {
    form.post(route('customers'));
};

const assigned = (customerId,assignedId) => {
    selectedCustomerId.value = customerId;
    assignedTo.value = true;
    assignedAgent.value = assignedId;
}

const deleteCustomer = async (id) => {
    const { value: confirmed } = await Swal.fire({
        title: 'Are you sure?',
        text: 'You want to Delete Customer Record?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    });

    try {
        if (confirmed) {
            router.get(`/customers/delete-customer/${id}`);
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Customer Deleted Successfully',
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
            text: 'Error Deleting Customer. Please try again.',
        });
    }
};
const viewCustomer = (id) => {
    const toast = useToast();
    router.get(`/customers/view-customer/${id}`);
};

const editCustomer = (id) => {
    router.get(`/customers/edit-customer/${id}`);
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-black-800 leading-tight"> Customers</h2>
            <div v-if="authUser.user_type == 1" class="button-container">
                <Link :href="route('customers.add-customer')">
                <button class="btn btn-success">Add Customer</button>
                </Link>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;">
                    <div class="p-6 text-black-900 padding_remove">
                        <DataTable class="display" :options="options" style="border:2px black ;width:100%">
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
                                <tr v-for="customer in customers" :key="customer.id">
                                    <td class="d-none">{{ customer.id }}</td>
                                    <td>{{ customer.name }}</td>
                                    <td>{{ customer.email }}</td>
                                    <td :class="{ 'active': customer.status == 1, 'inactive': customer.status == 0 }">
                                        {{ customer.status == 1 ? 'Active' : 'Inactive' }}
                                    </td>
                                    <td>
                                        <!-- <button class="btn btn-info btn-sm" @click="viewCustomer(customer.id)"><i class="fas fa-edit"></i>  </button> -->
                                        <button v-if="authUser.user_type == 1" class="btn btn-primary btn-sm"
                                            @click="editCustomer(customer.id)"><i class="fas fa-edit"></i>  </button>
                                        &nbsp;
                                        <button v-if="authUser.user_type == 1" class="btn btn-danger btn-sm"
                                            @click="deleteCustomer(customer.id)"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
    <modal :show="assignedTo" :customerId="selectedCustomerId" :agentName="assignedAgent" :modal="2" @close="closebtn"></modal>
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
