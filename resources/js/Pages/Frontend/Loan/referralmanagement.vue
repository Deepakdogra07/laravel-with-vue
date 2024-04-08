<script setup>
import { useForm } from '@inertiajs/vue3'
import { onMounted, ref } from 'vue';
import { router } from '@inertiajs/vue3'
import { useToast } from 'vue-toastify'
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Footer from "../../Frontend/footer.vue";
import Header from "../../Frontend/header.vue";
import "../../../../css/frontend.css";
import Sidebar from "../../Frontend/Layouts/sidebar.vue";
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';
import { onBeforeMount, reactive } from 'vue';


function getStatusText(status) {
  if (status === 0) {
    return 'Pending';
  } else if (status === 1) {
    return 'Approved';
  } else if (status === 2) {
    return 'Rejected';
  } else {
    return 'Unknown Status';
  }
}


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

const formatDate = (timestamp) => {
  const date = new Date(timestamp);
  const formattedDate = date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
  return formattedDate;
};

const getIdColumnIndex = () => {
  return 0;
};

const idColumnIndex = getIdColumnIndex();

const options = reactive({
  order: [[idColumnIndex, 'desc']],
});

const props = defineProps({
  amount: Number,
  errors: Object,
  my_refferal_code: Number,
  applied_loans_count: Number,
  applied_loans_approved_count: Number,
  applied_loans_rejected_count: Number,
  withdrawl: Array,
  userDetails: Array,
  thirtyDaysOldAmounts: Number,
  NotthirtyDaysOldAmounts: Number,
})


const form = useForm({
  totalAmount: null,
  withdrawAmount: null,
  status: 'pending',
  my_refferal_code: '',
  isSubmitting: false,
  account_details: null,
  thirtyDaysOldAmounts: props.thirtyDaysOldAmounts,
  NotthirtyDaysOldAmounts: props.NotthirtyDaysOldAmounts,
});

onMounted(() => {
  form.totalAmount = props.amount,
    form.my_refferal_code = props.my_refferal_code
});

const submitting = ref(false);


const submitForm = async () => {
//   const submitting = ref(true);
submitting.value = true;
  const options = {
    onSuccess: page => {
      toast("Solicitação de retirada enviada com sucesso !", {
        autoClose: 2000,
        theme: 'dark',
      },
      submitting.value = false,
      );
      setTimeout(function () {
        window.location.reload();
      }, 2000);
    },
    onError: errors => {
        submitting.value = false;
    },
  }
  const response = form.post(`/referral/withdraw/amount`, options);
};





function copyReferralCode() {
  const referralCode = form.my_refferal_code;
  navigator.clipboard.writeText(referralCode);

  toast("Rreferral code copy Successfully!", {
    autoClose: 2000,
    theme: 'dark',
  }
  );
}

const account_details = ref();

const fetchAcountNumber = async () => {
  try {
    const response = await axios.get('/get/acount/number');
    account_details.value = response.data.account_details;
    form.account_details = response.data.account_details;
  } catch (error) {
    console.error('Error fetching data:', error);
  }
};

onMounted(() => {
  fetchAcountNumber();
});
</script>


<template>

    <Head title="" />
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
                    <div class="d-flex justify-between align-items-center flex-wrap mt-3">
                        <h2>Retirar</h2>
                        <div class="withdraw-btn d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center gap-x-2">
                                <i class="fa-solid fa-wallet"></i>
                                <div style="line-height: 10px;">
                                    <!-- <p class="mb-0">Minha carteira</p> -->
                                    <p class="mb-0">Montante total</p>
                                    <h3>
                                        {{ new Intl.NumberFormat('pt-BR', {
                          style: 'currency', currency: 'BRL', minimumFractionDigits:
                            2
                        }).format(amount) }}
                                        <!-- {{amount}} -->
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <div class="withdraw-btn d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center gap-x-2">
                                <i class="fa-solid fa-wallet"></i>
                                <div style="line-height: 10px;">

                                    <p class="mb-0">Quantidade retirada</p>
                                    <h3>
                                        {{ new Intl.NumberFormat('pt-BR', {
                          style: 'currency', currency: 'BRL', minimumFractionDigits:
                            2
                        }).format(thirtyDaysOldAmounts) }}
                                        <!-- {{thirtyDaysOldAmounts}} -->
                                    </h3>
                                </div>
                            </div>
                        </div>


                        <div class="withdraw-btn d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center gap-x-2">
                                <i class="fa-solid fa-wallet"></i>
                                <div style="line-height: 10px;">

                                    <p class="mb-0">Valor não retirado</p>
                                    <h3>
                                       <!-- {{NotthirtyDaysOldAmounts}} -->
                                        {{ new Intl.NumberFormat('pt-BR', {
                          style: 'currency', currency: 'BRL', minimumFractionDigits:
                            2
                        }).format(NotthirtyDaysOldAmounts) }}
                                    </h3>
                                </div>
                            </div>
                        </div>



                    </div>


                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="myloan-tabel">
                                <div class="share-code-section-withdraw mb-4">
                                    <h3>Retirar montante</h3>
                                    <form class="d-flex flex-column align-items-center" @submit.prevent="submitForm">
                                        <input v-model="form.totalAmount" type="hidden" readonly>
                                        <div class="d-flex gap-2 account-amount-inputs">
                                            <div>
                                                <input class="amount-input" v-model="form.withdrawAmount" type="text"
                                                    name="withdrawAmount" placeholder="Insira o valor">
                                                <div v-if="errors.withdrawAmount" class="text-red-500 error-wrap">{{
                                                    errors.withdrawAmount }}

                                                </div>
                                                <div v-if="errors.cpf_or_phone" class="text-red-500 error-wrap">{{
                                                    errors.cpf_or_phone }}</div>

                                            </div>
                                        </div>
                                        <br />
                                        <button class="copy-code" :disabled="submitting">RETIRAR</button>
                                    </form>
                                </div>



                                <div class="row ">
                                    <div class="col-md-12">
                                        <div class="myloan-tabel myloan-tabel-new mb-3">
                                            <div class="d-flex justify-between align-items-center mt-3">
                                                <h3>Lista de retiradas</h3>
                                            </div>
                                            <DataTable style=" width: 100%; margin-top:20px;"
                                                class="display myLoans-table" :options="options">
                                                <thead>
                                                    <tr>
                                                        <th class="d-none">#</th>
                                                        <th class="d-none">ID</th>
                                                        <th>Data de inscrição</th>
                                                        <th>Quantia</th>
                                                        <th>Status</th>
                                                        <th>Resultado</th>
                                                        <th>Detalhes do valor recebido</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(withdrawl,index) in withdrawl" :key="withdrawl.id"
                                                        :options="options">
                                                        <td class="d-none">{{ index+1 }}</td>
                                                        <td class="d-none">{{ withdrawl.id }}</td>
                                                        <td class="tabel-blue-text">{{ formatDate(withdrawl.created_at)
                                                            }}</td>
                                                        <td class="tabel-blue-text">{{ withdrawl.withdrawAmount}}</td>
                                                        <td>
                                                            {{
                                                            withdrawl.status == 0 ? 'Pending' :
                                                            withdrawl.status == 1 ? 'Approved' :
                                                            withdrawl.status == 2 ? 'Rejeitado' :
                                                            withdrawl.status == 3 ? 'Rejeitado' :
                                                            withdrawl.status == 4 ? 'Completo':
                                                            withdrawl.status == 6 ? 'Transferido':
                                                            withdrawl.status == 'Pending' ? 'Pending' :
                                                            withdrawl.status == 100
                                                            }}
                                                        </td>
                                                        <td class="tabel-blue-text">
                                                            <div>
                                                                <template v-if="withdrawl.status == 1">
                                                                    <a :href="'/storage/' + withdrawl.receipt"
                                                                        :data-lightbox="'/storage/'+withdrawl.receipt">
                                                                        <img :src="'/storage/' + withdrawl.receipt"
                                                                            alt="Approved"
                                                                            style="height: 100px; width: 100px;">
                                                                    </a>
                                                                </template>
                                                                <template v-else-if="withdrawl.status == 2">
                                                                    <i @click="handleDownload(withdrawl.id)"
                                                                        class="fa fa-download text-primary"
                                                                        aria-hidden="true" style="font-size: 30px;"></i>
                                                                </template>
                                                                <template v-else>
                                                                    Pending
                                                                </template>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <p v-if="withdrawl.cpf">CPF : {{ withdrawl.cpf }}</p>
                                                            <p v-if="withdrawl.phonenumber">Número de telemóvel {{
                                                                withdrawl.phonenumber }}</p>
                                                            <p v-if="withdrawl.through_email">E-mail : {{
                                                                withdrawl.through_email }}</p>
                                                            <p v-if="withdrawl.randomkey">Chave Aleatória : {{
                                                                withdrawl.randomkey }}</p>
                                                            <p v-if="withdrawl.bankcode">Código bancário : {{
                                                                withdrawl.bankcode }}</p>
                                                            <p v-if="withdrawl.agency_number">Número da agência : {{
                                                                withdrawl.agency_number }}</p>
                                                            <p v-if="withdrawl.account_number">Número de conta : {{
                                                                withdrawl.account_number }}</p>
                                                            <p v-if="withdrawl.bank_cpf">CPF(NIN) : {{
                                                                withdrawl.bank_cpf }}</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </DataTable>
                                        </div>
                                    </div>
                                </div>

                                <div class="termconditions mt-4">
                                    <h2>Termos e Condições</h2>
                                    <p>1. O cliente terá a opção de compartilhar o link do site com seu código de
                                        indicação
                                        e se um novo
                                        lead vier da indicação então o
                                        o usuário receberá uma comissão de 5% assim que o empréstimo for aprovado e
                                        poderá solicitar o saque assim que atingir o valor definido para saque.</p>
                                    <p>2. A indicação só funcionará para quem é novo na plataforma.</p>
                                    <p>3. O usuário que aderir à plataforma através da indicação não será
                                        capaz de ver o benefício que o usuário existente tem quando é indicado e ele
                                        ficará
                                        oculto na
                                        plataforma</p>
                                </div>
                            </div>
                        </div>
                    </div>






                </div>
            </div>
        </div>
    </div>
    <Footer />
</template>

<style scoped>
table.dataTable thead td::before,
table.dataTable thead td::after {
    display: none !important;
}

.error-wrap {
    width: 180px;
    line-height: 20px;
}
</style>
