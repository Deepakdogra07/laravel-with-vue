<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import { reactive } from 'vue';
import { defineProps } from 'vue';
import { useToast } from 'vue-toastify';

defineProps({
    combined_users: {
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
const getStatusColor = (status) => {
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

const shareLink = async (user) => {
    const toast = useToast();
    if (user && user.discount_code) {
        const discount = user.discount_code;
        // alert(discount);
        const linkToShare = 'https://instantloan.visionvivante.com/loan/create';
        const instructions = `
            Hi there! 👋
            Share this Affiliate Link with your Friends and Get Discount On your Loan:
            ${linkToShare}
            Discount Code: ${discount}\n
            Instructions:\n
            1. Ask your Friends to Sign Up using the Shared Link.
            2. You will Earn Discount When Loan is Approved.\n
            Thank you for sharing!
        `;
        navigator.clipboard.writeText(`${instructions}`).then(() => {
            toast.success("copied to clipboard successfully!");
        });
    }
};
let calculateDiscount = (user) => {

    let discount = parseFloat(user.discount);
    let amount = parseInt(user.loan_amount);
    const discount_amt = amount * discount / 100;
    // alert(discount_amt);
    return discount_amt;
};
</script>

<template>
    <AuthenticatedLayout>
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight"> Admin Referral List</h2>
            <i v-for="user in combined_users" :key="user.id" style="cursor: pointer;" class="fa fa-share" aria-hidden="true"
                @click="shareLink(user)"></i>
        </template> -->
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Affiliate List</h2>
            <!-- <div v-if="auth_user.user_type == 2">
                <i style="cursor: pointer;" class="fa fa-share" aria-hidden="true" @click="shareLink()">
                </i>
            </div> -->
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;">
                    <div class="p-3 text-gray-900">

                        <DataTable class="display" :options="options" style="border:2px black ;width:100%">
                            <thead>
                                <tr>
                                    <th class="d-none">ID</th>
                                    <th>User Name</th>
                                    <th>Amount</th>
                                    <th>Affiliate Loan Status</th>
                                    <!-- <th>Comission Amount</th> -->
                                    <th>Set% Discount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in combined_users" :key="user.id">
                                    <td class="d-none">{{ user.id }}</td>

                                    <td>{{ user.applicant_name }}</td>
                                    <td>{{ user.loan_amount }}</td>

                                    <td :class="['font-bold', getStatusColor(user.status)]">
                                        {{ user.status }}
                                    </td>

                                    <!-- <td v-if="user.status == 'Approved'">
                                        {{ calculateDiscount(user) }}
                                    </td> -->


                                    <!-- <td>{{ user.commission }}%</td> -->

                                    <td>{{ user.discountcodevalue }}%</td>


                                </tr>
                            </tbody>
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

