<script setup>
import Footer from "../../Frontend/footer.vue";
import Header from "../../Frontend/header.vue";
import "../../../../css/frontend.css";
import Sidebar from "../../Frontend/Layouts/sidebar.vue"
import { Head, Link, useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
import { useToast } from 'vue-toastify';
import { toast } from "vue3-toastify";
import axios from 'axios';
import { ref } from 'vue';
import "vue3-toastify/dist/index.css";

import { onBeforeMount, reactive } from 'vue';

const props = defineProps({
  loanRecord: Array,
  countLoan: Object,
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


const reapply = ref('Reaplicar');

const reapplyLoan = async (id) => {
  try {
    reapply.value = 'Aguarde...';
    await axios.post(`/reapply/loan/${id}`);
    toast("Empréstimo aplicado com sucesso!", {
      autoClose: 2000,
      theme: "dark",
    });
    setTimeout(() => {
      reapply.value = 'Reaplicar';
      location.reload();
    }, 2500);
  } catch (error) {
    console.error('Error occurred while reapplying loan:', error);
  }
};


const editLoan = (id)=>{
    router.visit(`/edit/${id}`);
}

const getIdColumnIndex = () => {
  return 0;
};


const idColumnIndex = getIdColumnIndex();

const options = reactive({
  order: [[idColumnIndex, 'desc']],
});
</script>
<template>
     <Head title="Todos os empréstimos" />
     <div class="user-dashboard-header">
       <Header class="login-wrapper-dashboard" />
     </div>

    <div class="user-dashboard"> </div>
    <div class="user-dashboard-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <Sidebar />
                </div>
                <div class="col-lg-9">

                    <div class="d-flex justify-between align-items-center mt-3 flex-wrap gap-3">
                        <h2>Total de empréstimos</h2>
                        <div class="apply-now">
                            <Link class="" href="/applyloan">APLIQUE AGORA</Link>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="myloan-tabel">
                                <div class="d-flex justify-between align-items-center my-3">
                                    <h3>Total de empréstimos ({{ props.countLoan }})</h3>
                                    <div class="see-all">
                                        <!-- <Link class="" href="">See all</Link> -->
                                        <!-- <Link :href="`loan/view/page/${loan.id}`">See All</Link> -->
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <DataTable style=" width: 100%;" class="display myLoans-table" :options="options">
                                        <thead>
                                            <tr>
                                                <th class="d-none">ID</th>
                                                <th style="border: 1px solid #ddd;">#</th>
                                                <th style="border: 1px solid #ddd;">Data</th>
                                                <th style="border: 1px solid #ddd;">Quantia</th>
                                                <th style="border: 1px solid #ddd;">Parcelas</th>
                                                <th style="border: 1px solid #ddd;">Status</th>
                                                <th style="border: 1px solid #ddd;">Ações</th>
                                                <th style="border: 1px solid #ddd;">    </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(loan, index) in props.loanRecord" :key="loan.id">
                                                <td class="d-none">{{ loan.id }}</td>
                                                <td style="border: 1px solid #ddd;">{{ props.loanRecord.length - index }}</td>
                                                <td style="border: 1px solid #ddd;">{{ formatDate(loan.created_at) }}</td>
                                                <td style="border: 1px solid #ddd;">{{ loan.loan_amount }}</td>
                                                <td style="border: 1px solid #ddd;">{{ loan.numberOfmonths }} mês</td>


                                                <td style="border: 1px solid #ddd;">
                                                    <span class="pending-btn" v-if="loan.status == 0">Pendente</span>
                                                    <span class="Approved-btn" v-if="loan.status == 1">Aprovado</span>
                                                    <span class="Rejected-btn" v-if="loan.status == 2">Rejeitado</span>
                                                    <span class="Doc-Pending-btn" v-if="loan.status == 3">Documento pendente</span>
                                                    <span  class="FullComplete-btn" v-if="loan.status == 4">Completo</span>
                                                    <span class="Re-Apply-btn" v-if="loan.status == 5">Reaplicar</span>
                                                    <span class="Transfered-btn" v-if="loan.status == 6">Transferido</span>
                                                </td>


                                                <td class="tabel-blue-text" style="border: 1px solid #ddd;">
                                                    <!-- <span v-if="loan.status === 0">Pending</span>
                                                    <span v-else-if="loan.status === 1">Approved</span>
                                                    <span v-else-if="loan.status === 2">Rejected</span>
                                                    <span v-else-if="loan.status === 3">Incomplete</span>
                                                    <span v-else-if="loan.status === 4">FullComplete</span>
                                                    <span v-else-if="loan.status === 5">Re-apply</span> -->
                                                    <div>
                                                        <template v-if="loan.status === 2">
                                                            <Link href="/">
                                                            <button class="btn btn-success btn-sm"
                                                                @click.prevent="reapplyLoan(loan.id)">{{ reapply }}</button>
                                                            </Link>
                                                        </template>
                                                        <template v-else-if="loan.status === 3">
                                                            <Link href="/">
                                                            <!-- <button class="btn btn-success btn-sm"
                                                                @click.prevent="reapplyLoan(loan.id)">Edit</button> -->

                                                                 <button class="btn btn-warning btn-sm text-white"
                                                                @click.prevent="editLoan(loan.id)"><i class="bi bi-pencil-square"></i></button>
                                                            </Link>
                                                        </template>
                                                        <template v-else>
                                                            <p class="pl-3">-</p>
                                                        </template>
                                                    </div>


                                                </td>
                                                <td>
                                                    <Link class="table-right-arrow" :href="`loan/view/page/${loan.id}`"><i class="bi bi-chevron-right"></i></Link>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </DataTable>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<Footer /></template>
