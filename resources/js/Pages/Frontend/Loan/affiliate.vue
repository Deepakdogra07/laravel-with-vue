<!-- <script setup>
import "../../../../css/frontend.css";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { onBeforeMount, ref, reactive } from 'vue';


const props = defineProps({
  users: Array,
});


const loanUsers = ref('');
const pending = ref('');
const approved = ref('');
const rejected = ref('');

let selectedUser = null;

onBeforeMount(async () => {
  console.log('onBeforeMount')
  try {
    await fetchData();
  } catch (error) {
    console.error('Error during component mount:', error);
  }
  console.log('onBeforeMount2')

});


const showTable = ref(0);
const fetchData = async () => {
  if (selectedUser == null) {
    const apiUrl = `loan/value/${selectedUser}`;
    try {
      const response = await axios.get(apiUrl);
      if (response.data.status) {
        console.log(loanUsers)
        loanUsers.value = response.data.data;
        pending.value = response.data.pending;
        approved.value = response.data.approved;
        rejected.value = response.data.rejected;
      }
      showTable.value++;
      console.log('fetched');
    } catch (error) {
      console.error('Error fetching user data:', error);
    }
  }
};

const getIdColumnIndex = () => {
  return 0;
};

const idColumnIndex = getIdColumnIndex();

const options = reactive({
  order: [[idColumnIndex, 'desc']],
});



</script>
<template>
    <Head title="Affiliate" />
      <div class="flex items-center">
    <h2 class="mr-4 text-lg font-semibold">Status Counts:</h2>
    <div class="flex space-x-4">
        <span class="text-orange-500 dark:text-orange-400">Pending: {{ pending }}</span>
        <span class="text-green-500 dark:text-green-400">Approved: {{ approved }}</span>
        <span class="text-red-500 dark:text-red-400">Rejected: {{ rejected }}</span>
    </div>
</div>
        <div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <DataTable :options="options" :key="showTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                             <th scope="col" class="px-6 py-3 d-none">
                                Id
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Address
                            </th>

                            <th scope="col" class="px-6 py-3">
                                Phone
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="loan in loanUsers" :key="loan.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                           <td  class="d-none">{{ loan.id }}</td>
                            <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ loan.user.name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ loan.user.email }}
                            </td>
                            <td class="px-6 py-4">
                                {{ loan.user.address }}
                            </td>

                            <td class="px-6 py-4">
                                {{ loan.user.phone }}
                            </td>

                            <td class="px-6 py-4">
                                {{ loan.user.gender }}
                            </td>

                            <td class="px-6 py-4">
                                <button v-if="loan.user.status == 0" class="status-button pending">Pending</button>
                                <button v-else-if="loan.user.status == 1" class="status-button approved">Approved</button>
                                <button v-else-if="loan.user.status == 2" class="status-button rejected">Rejected</button>
                                <button v-else class="status-button unknown">Unknown Status</button>
                            </td>
                        </tr>
                    </tbody>
                </DataTable>

            </div>
        </div>
        <br />
</template>


<style>
label {
    font-size: 1.2rem;
    margin-bottom: 0.5rem;
    display: block;
}

select {
    width: 100%;
    padding: 0.5rem;
    margin-bottom: 1rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.status-button {
    border: none;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
}

.pending {
    background-color: orange;
    color: white;
}

.approved {
    background-color: green;
    color: white;
}

.rejected {
    background-color: red;
    color: white;
}

.unknown {
    background-color: gray;
    color: white;
}
</style>
 -->



<script setup>
import Footer from "../../Frontend/footer.vue";
import Header from "../../Frontend/header.vue";
import "../../../../css/frontend.css";
import Sidebar from "../../Frontend/Layouts/sidebar.vue"
import { Head, Link, useForm } from '@inertiajs/vue3';
import axios from 'axios';
import { onBeforeMount, ref, reactive } from 'vue';
import { onMounted } from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';


const props = defineProps({
  users: Array,
  amount: Number,
  errors: Object,
  my_refferal_code: Number,
  applied_loans_count: Number,
  applied_loans_approved_count: Number,
  applied_loans_rejected_count: Number,
  totalCom: Number,
  auth_user: Number,
});

const loanUsers = ref('');


onBeforeMount(async () => {
  console.log('onBeforeMount')
  try {
    await fetchData();
  } catch (error) {
    console.error('Error during component mount:', error);
  }
  console.log('onBeforeMount2')
});


let selectedUser = null;
const showTable = ref(0);

const userStatus = ref(0);


const fetchData = async () => {
  if (selectedUser == null) {
    const apiUrl = `/loan/value/${selectedUser}`;
    try {
      const response = await axios.get(apiUrl);
      if (response.data.status) {
        console.log(loanUsers)
        loanUsers.value = response.data.data;
        userStatus.value = response.data.data[0].user.status;
      }
      showTable.value++;
      console.log('fetched');
    } catch (error) {
      console.error('Error fetching user data:', error);
    }
  }
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


// function copyReferralCode() {
//     const BASE_URL = window.location.origin;
//     const referralCode = form.my_refferal_code;
//     navigator.clipboard.writeText(referralCode);

//     toast("Cópia do código de referência com sucesso!", {
//         autoClose: 2000,
//         theme: 'dark',
//     }
//     );
// }

const copyLink = ref('');

onMounted(() => {
  const BASE_URL = window.location.origin;
  const referralCode = props.my_refferal_code;
  const referralLink = `${BASE_URL}?refralcode=${referralCode}`;
  copyLink.value = referralLink;
//   alert(copyLink.value);
});

const whatsappLink = `whatsapp://send?text=${copyLink}`;

// Compute whatsappLink based on copyLink value
// const whatsappLink = `whatsapp://send?text=${copyLink}`;

function copyReferralCode() {
  const BASE_URL = window.location.origin;
  const referralCode = form.my_refferal_code;
  const referralLink = `${BASE_URL}?refralcode=${referralCode}`;
  navigator.clipboard.writeText(referralLink);



  toast("Cópia do código de afiliada com sucesso!", {
    autoClose: 2000,
    theme: 'dark',
  });
}

const form = useForm({
  totalAmount: null,
  withdrawAmount: null,
  status: 'pending',
  my_refferal_code: '',
  isSubmitting: false,
  account_details: null,
});

onMounted(() => {
  form.totalAmount = props.amount,
    form.my_refferal_code = props.my_refferal_code
});

const shareViaEmail = () => {
  var userEmail = props.users[0].email;
  var mailtoLink = 'mailto:?to=' + encodeURIComponent(userEmail);
  window.open(mailtoLink, '_blank');
}

</script>
<template>
    <!-- <h1>adnkabd</h1>
    <h1>{{ loanUsers[0].status }}</h1> -->
    <Head title="Painel" />
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
                        <h2>Minhas recomendações</h2>
                        <div class="withdraw-btn d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center gap-x-2">
                                <i class="fa-solid fa-wallet"></i>
                                <div style="line-height: 10px;">
                                    <p class="mb-0">Minha carteira</p>
                                    <h3>
                                        {{ new Intl.NumberFormat('pt-BR', {
                          style: 'currency', currency: 'BRL', minimumFractionDigits:
                            2
                        }).format(amount) }}

                                    </h3>
                                </div>
                            </div>
                            <div class="withdraw-link">
                                <Link class="" href="/referral/management">RETIRAR</Link>
                            </div>


                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="myloan-tabel">
                                <div class="share-code-section">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h3>Compartilhe seu código e <br>
                                                Ganhe {{ props.totalCom }} % de comissão</h3>
                                            <p>Ganhe descontos e recompensas compartilhando <br> seu código de Afiliados
                                                pessoal com outras pessoas:</p>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- <p>Código de Referencia</p> -->
                                            <!-- <h3 class="mb-2">{{ props.my_refferal_code }}</h3> -->
                                            <h3>Compartilhe este link para receber a comissão</h3>
                                            <div class="d-flex align-items-center flex-wrap gap-2">



                                                <button @click="copyReferralCode" class="copy-code">
                                                    <i class="fa-solid fa-copy"></i> &nbsp;Copiar código de
                                                    afiliados</button>





       <!-- <a class="copy-code share-link" :href="copyLink" data-action="share/whatsapp/share">
         <i class="fa-solid fa-share-nodes"></i>
       </a> -->



       <a class="copy-code share-link" :href="`whatsapp://send?text=${copyLink}`" data-action="share/whatsapp/share"> <i class="fa-solid fa-share-nodes"></i>
    </a>





                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-4">
                                    <div class="col-md-4 cards-spaces">
                                        <div class="share-code-section-image d-flex flex-column align-items-center">
                                            <img class="mb-3" src="/images/referral-1.png" alt="">
                                            <h4>Compartilhar código de afiliados <br>
                                                com amigo </h4>
                                        </div>
                                    </div>
                                    <div class="col-md-4 cards-spaces">
                                        <div class="share-code-section-image d-flex flex-column align-items-center">
                                            <img class="mb-3" src="/images/refferal-2.png" alt="">
                                            <h4>Aplicar código em novo empréstimo</h4>
                                            <p>(somente para novo cliente)</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 cards-spaces">
                                        <div class="share-code-section-image d-flex flex-column align-items-center">
                                            <img class="mb-3" src="/images/refferal-3.png" alt="">
                                            <h4>Ganhe {{ props.totalCom }} % de comissão</h4>
                                            <p>
                                                (após aprovação do empréstimo)</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-md-12">
                                        <div class="myloan-tabel myloan-tabel-new mb-3">
                                            <div class="d-flex justify-between align-items-center mt-3">
                                                <h3>Lista de Afiliados</h3>
                                            </div>

                                            <DataTable :options="options" :key="showTable"
                                                class="display myLoans-table dataTable no-footer">
                                                <thead>
                                                    <tr>
                                                        <th>S.N.</th>
                                                        <th class=" d-none">
                                                            Eu ia
                                                        </th>


                                                        <th>Amount</th>
                                                        <th>
                                                            Data de inscrição
                                                        </th>

                                                        <th>
                                                            Nome
                                                        </th>




                                                        <th>
                                                            Status
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(loan, index) in loanUsers" :key="loan.id"
                                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                        <td class="d-none tabel-blue-text">{{ loan.id }}</td>

                                                        <td scope="row" class="px-6 py-4 tabel-blue-text">
                                                            {{ index + 1 }}
                                                        </td>
                                                        <td scope="row"
                                                            class="px-6 py-4 tabel-blue-text">
                                                            {{ loan.loan_amount }}
                                                        </td>

                                                        <td class="px-6 py-4 tabel-blue-text">
                                                            {{ formatDate(loan.user.created_at) }}
                                                        </td>


                                                        <td scope="row"
                                                            class="px-6 py-4 tabel-blue-text">
                                                            {{ loan.user.name }}
                                                        </td>


                                                        <td class="px-6 py-4 tabel-blue-text">
                                                            <button v-if="loanUsers[index].status == 0"
                                                                class="status-button pending pending-btn">Open</button>
                                                            <button v-else-if="loanUsers[index].status == 1"
                                                                class="status-button approved Approved-btn">Close</button>
                                                            <button v-else-if="loanUsers[index].status == 2"
                                                                class="status-button rejected Rejected-btn">Close</button>
                                                            <button v-else-if="loanUsers[index].status == 3" class="status-button unknown Doc-Pending-btn">Close</button>
                                                            <button v-else-if="loanUsers[index].status == 4" class="status-button unknown Doc-Pending-btn">Close</button>
                                                            <button v-else-if="loanUsers[index].status == 5" class="status-button unknown Doc-Pending-btn">Close</button>
                                                            <button v-else-if="loanUsers[index].status == 6" class="status-button unknown Doc-Pending-btn">Close</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </DataTable>

                                        </div>
                                    </div>
                                </div>

                                <div class="termconditions mt-4">
                                    <h2>Termos e Condições</h2>
                                    <p>1. O cliente terá a opção de compartilhar o link do site com seu código de indicação
                                        e se um novo lead vier da indicação então o
                                        o usuário receberá uma comissão de 5% assim que o empréstimo for aprovado e
                                        poderá solicitar o saque assim que atingir o valor definido para saque.</p>
                                    <p>2. A indicação só funcionará para quem é novo na plataforma.</p>
                                    <p>3. O usuário que aderir à plataforma através da indicação não será
                                        capaz de ver o benefício que o usuário existente tem quando é indicado e ele ficará
                                        oculto na plataforma</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<Footer /></template>
