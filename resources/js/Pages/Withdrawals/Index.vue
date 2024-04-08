<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import { onMounted, reactive, ref } from 'vue';
import { defineProps } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
  withdraws: {
    type: Array
  },
});

const getIdColumnIndex = () => {
  return 0;
};

const idColumnIndex = getIdColumnIndex();

const options = reactive({
  order: [[idColumnIndex, 'desc']],
});

const receiptform = (id) => {
  console.log('Receipt form opened');
  router.get(`/withdraws/approve/receipt/${id}`);

};
const reason = (id) => {
  console.log('Reason form opened');
  router.get(`/withdraws/reject/reason/${id}`);
};

// onMounted(() => {
//   console.log(withdraws);
// });


const handleDownload = (id) => {
  axios.get(`/reject/loan/reason/${id}`, { responseType: 'blob' })
    .then((response) => {
      const blob = new Blob([response.data], { type: response.headers['content-type'] });
      const link = document.createElement('a');
      link.href = window.URL.createObjectURL(blob);
      link.download = 'loanRejected.pdf';
      link.click();
    })
    .catch((error) => {
      console.error('Error downloading file:', error);
    });
};

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">withdraw List</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shift-up" style="border: 1px solid #ddd;">
                    <div class="p-6 text-gray-900">
                        <!-- <DataTable class="display" :options="options" style="border:2px black ;width:100%">
                            <thead>
                                <tr>
                                    <th class="d-none">ID</th>
                                    <th>User Name</th>
                                    <th>Recive Amount Details</th>
                                    <th>withdraw Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="user in withdraws" :key="user.withdraw_id">

                                    <td class="d-none">{{ user.id }}</td>
                                    <td>{{ user.name }}</td>
                                    <td>
                                        <p v-if="user.cpf">CPF : {{ user.cpf }}</p>
                                        <p v-if="user.phonenumber">Mobile Number {{ user.phonenumber }}:</p>
                                        <p v-if="user.through_email">Email : {{ user.through_email }}</p>
                                        <p v-if="user.randomkey">Random Key : {{ user.randomkey }}</p>
                                        <p v-if="user.bankcode">Bank Code : {{ user.bankcode }}</p>
                                        <p v-if="user.agency_number">Agency Number : {{ user.agency_number }}</p>
                                        <p v-if="user.account_number">Account No. : {{ user.account_number }}</p>
                                        <p v-if="user.bank_cpf">CPF(NIN) : {{ user.bank_cpf }}</p>
                                    </td>
                                    <td>{{ user.withdrawAmount }}</td>


                                    <td :class="{
                            'text-orange': user.status == 0,
                            'text-success': user.status == 1,
                            'text-danger': user.status == 2}">

                                        {{ user.status == 0 ? 'Pending' :
                                        (user.status == 1 ? 'Approved' :
                                        (user.status == 2 ? 'Rejected'
                                        : 'Inactive')) }}

                                    </td>





                                    <div>
                                        <td v-if="user.receipt == null">
                                            <button class="btn btn-primary btn-sm"
                                                @click="receiptform(user.withdraw_id)">Approve</button>
                                            &nbsp;
                                            <button class="btn btn-danger btn-sm"
                                                @click="reason(user.withdraw_id)">Reject</button>
                                        </td>

                                        <td>
                                            <template v-if="user.status == 1">
                                            <a :href="'/storage/' + user.receipt"
                                                :data-lightbox="'/storage/'+user.receipt">
                                                <img :src="'/storage/' + user.receipt" alt="Approved"
                                                    style="height: 100px; width: 100px;">
                                            </a>
                                        </template>

                                        <template v-else-if="user.status == 2">
                                            <i @click="handleDownload(user.id)" class="fa fa-download text-primary"
                                                aria-hidden="true" style="font-size: 30px;"></i>
                                        </template>
                                        <template v-else>
                                            Pending
                                        </template>
                                        </td>

                                    </div>








                                </tr>





                            </tbody>
                        </DataTable> -->

<DataTable class="display" :options="options" style="border: 2px black; width: 100%">
    <thead>
        <tr>
            <th>User Name</th>
            <th>Recive Amount Details</th>
            <th>Withdraw Amount</th>
            <th>Status/Receipt</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="user in withdraws" :key="user.withdraw_id">
            <td>{{ user.name }}</td>
            <td>
                <!-- <p v-if="user.cpf">CPF : {{ user.cpf }}</p>
                <p v-if="user.phonenumber">Mobile Number {{ user.phonenumber }}</p>
                <p v-if="user.randomkey">Random Key {{ user.randomkey }}</p> -->
                                        <p v-if="user.cpf">CPF : {{ user.cpf }}</p>
                                        <p v-if="user.phonenumber">Mobile Number {{ user.phonenumber }}:</p>
                                        <p v-if="user.through_email">Email : {{ user.through_email }}</p>
                                        <p v-if="user.randomkey">Random Key : {{ user.randomkey }}</p>
                                        <p v-if="user.bankcode">Bank Code : {{ user.bankcode }}</p>
                                        <p v-if="user.agency_number">Agency Number : {{ user.agency_number }}</p>
                                        <p v-if="user.account_number">Account No. : {{ user.account_number }}</p>
                                        <p v-if="user.bank_cpf">CPF(NIN) : {{ user.bank_cpf }}</p>
                <!-- Add other details as needed -->
            </td>
            <td>{{ user.withdrawAmount }}</td>
            <td>
                <template v-if="user.receipt == null">
                    Pending
                </template>
                <template v-else-if="user.status == 1">
                    <a :href="'/storage/' + user.receipt" :data-lightbox="'/storage/' + user.receipt">
                        <img :src="'/storage/' + user.receipt" alt="Approved" style="height: 100px; width: 100px;">
                    </a>
                </template>
                <template v-else-if="user.status == 2">
                    <i @click="handleDownload(user.id)" class="fa fa-download text-primary" aria-hidden="true" style="font-size: 30px;"></i>
                </template>
            </td>
            <td>
                <template v-if="user.receipt == null">
                    <button class="btn btn-primary btn-sm mr-1" @click="receiptform(user.withdraw_id)">Approve</button>
                    <button class="btn btn-danger btn-sm mr-1" @click="reason(user.withdraw_id)">Reject</button>
                </template>
                <template v-else>
                    <span v-if="user.status == 1">Approved</span>
                    <span v-else-if="user.status == 2">Rejected</span>
                </template>
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
