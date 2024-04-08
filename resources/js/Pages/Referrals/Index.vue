<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import { reactive, ref } from 'vue';
import { defineProps } from 'vue';
import { useToast } from 'vue-toastify';
// defineProps({
//     combined_users: {
//         type: Array
//     }
// });
const { auth_user, combined_users } = defineProps(['auth_user', 'combined_users']);

// console.log(auth_user.user_type);

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

const shareLink = async () => {
    const toast = useToast();
    if (auth_user && auth_user.referralcode) {
        const discount = auth_user.referralcode;
        // alert(discount);
        const linkToShare = 'https://instantloan.visionvivante.com/loan/create';
        const instructions = `
            Hi there! 👋
            Share this Referral Link with your Friends and Get Discount On your Loan:
            ${linkToShare}
            Discount Code:${discount}\n
            Instructions:\n
            1. Ask your Friends to Sign Up using the Shared Link.
            2. You will Earn Discount When Loan is Approved.\n
            Thank you for sharing!
        `;
        // alert(instructions);
        navigator.clipboard.writeText(`${instructions}`).then(() => {
            toast.success("copied to clipboard successfully!");
        });
    }
};
let calculateCommission = (user) => {

    let commission = parseFloat(user.commission);
    let amount = parseInt(user.loan_amount);
    const commission_amt = amount * commission / 100;
    return commission_amt;
};
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Affiliate List</h2>
            <!-- <div v-if="auth_user.user_type == 2">
                <i style="cursor: pointer;" class="fa fa-share" aria-hidden="true" @click="shareLink()">
                </i>
            </div> -->
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;">
                    <div class="p-2 text-gray-900">
                        <DataTable class="display" :options="options" style="border:2px black ;width:100%">
                            <thead>
                                <tr>
                                    <th class="d-none">ID</th>
                                    <th>User Name Referred</th>
                                    <th>User Name</th>

                                    <th>Affiliate Code</th>
                                    <th>Affiliate Loan Status</th>
                                    <!-- <th>Commission Amount</th> -->
                                    <th>Set% Commission</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for=" user  in  combined_users " :key="user.id">
                                    <td class="d-none">{{ user.id }}</td>
                                    <td>{{ user.name }}</td>
                                    <td>{{ user.applicant_name }}</td>
                                    <td>{{ user.referralcode }}</td>

                                    <td :class="['font-bold', getStatusColor(user.status)]">
                                        {{ user.status }}
                                    </td>

                                    <!-- <td>
                                        {{ user.status === 'Approved' ? calculateCommission(user) : 0 }}
                                    </td> -->

                                    <td>{{ user.wallet_commission }}%</td>
                                </tr>
                            </tbody>
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

