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

// const options = reactive({
//     order: [[idColumnIndex, 'desc']],
// });

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
const  options= {columnDefs: [{
            targets: 4, 
            orderable: false 
          }
        ]
      };


      
function get_date(dateString) {
    const date = new Date(dateString);
    function pad(num) {
        return num < 10 ? '0' + num : num;
    }

    const month = pad(date.getMonth() + 1);
    const day = pad(date.getDate());
    const year = date.getFullYear();
    let hours = date.getHours();
    const minutes = pad(date.getMinutes());
    const seconds = pad(date.getSeconds());
    const ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12;
    hours = pad(hours);
    const formattedDate = `${month}/${day}/${year} ${hours}:${minutes}:${seconds}${ampm}`;
    return formattedDate;
}
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
        <div class="py-12 add_customers">
            <div class="max-w-7xl mx-auto px-2 add_customers_inner">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;">
                    <div class="p-6 text-black-900 padding_remove">
                        <DataTable class="display" :options="options" style="border:2px black ;width:100%">
                            <thead>
                                <tr>
                                    <th class="d-none">ID</th>
                                    <th>Customer Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Date Registered</th>
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
                                    <td v-html="get_date(customer.created_at)"></td>

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
