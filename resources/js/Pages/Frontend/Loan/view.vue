<!-- <script setup>
import { defineProps } from 'vue';
const props = defineProps(['userRecord']);
console.log(props.userRecord);
const formatDate = (timestamp) => {
  const date = new Date(timestamp);
  const formattedDate = date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
  return formattedDate;
};

</script>
<template>
   <h1>Loan Information </h1><span>Application Id : {{ props.userRecord.application_id }}</span>
<ul>
       <li v-if="props.userRecord.applicant_name"><strong>Name:</strong> {{ props.userRecord.applicant_name }}</li>
       <li v-if="props.userRecord.loan_amount"><strong>Loan Amount:</strong> {{ props.userRecord.loan_amount }}</li>
       <li v-if="props.userRecord.loan_amount"><strong>Loan Amount:</strong> {{ props.userRecord.numberOfmonths }}</li>

       <li><strong>Receive Loan Through:</strong>
        <span v-if="props.userRecord.receiveLoanThrough == 0">Via Pix</span>
         <span v-if="props.userRecord.receiveLoanThrough == 1">Via Wire Transfer</span>
       </li>


       <li v-if="props.userRecord.pixKey"><strong>Pix Key:</strong> {{ props.userRecord.pixKey }}</li>
       <li v-if="props.userRecord.pixcpf"><strong>Pix CPF:</strong> {{ props.userRecord.pixcpf }}</li>
       <li v-if="props.userRecord.phonenumber"><strong>Phone Number:</strong> {{ props.userRecord.phonenumber }}</li>
       <li v-if="props.userRecord.email"><strong>Phone Number:</strong> {{ props.userRecord.email }}</li>
       <li v-if="props.userRecord.randomkey"><strong>Random Key:</strong> {{ props.userRecord.randomkey }}</li>

       <li v-if="props.userRecord.bankcode"><strong>Bank Code:</strong> {{ props.userRecord.bankcode }}</li>
       <li v-if="props.userRecord.agencyNumber"><strong>Agency Number:</strong> {{ props.userRecord.agencyNumber }}</li>
       <li v-if="props.userRecord.currentAccountNumber"><strong>Current Account Number:</strong> {{ props.userRecord.currentAccountNumber }}</li>
       <li v-if="props.userRecord.cpf"><strong>CPF:</strong> {{ props.userRecord.cpf }}</li>



       <li><strong>Document to Upload:</strong>
        <span v-if="props.userRecord.documentOption == 'ssn'">SSN</span>
         <span v-if="props.userRecord.documentOption == 'drivingLicense'">Driving License</span>
       </li>


       <li v-if="userRecord.ssnBackPhoto"><strong>Ssn Back Photo:</strong>
        <img v-if="userRecord.ssnBackPhoto" :src="userRecord.ssnBackPhoto" alt="image not found" height="64" width="64">
      </li>

        <li><strong>Front Card Image:</strong>
          <img v-if="userRecord.frontCardImage" :src="userRecord.frontCardImage" alt="" height="64" width="64">
        </li>


        <li v-if="userRecord.dlFrontPhoto">
        <strong>Dl Front Photo:</strong>
            <img v-if="userRecord.dlFrontPhoto" :src="userRecord.dlFrontPhoto" alt="Driving License Front Photo" height="64" width="64">
        </li>

        <li v-if="userRecord.dlBackPhoto">
            <strong>Dl Back Photo:</strong>
            <img v-if="userRecord.dlBackPhoto" :src="userRecord.dlBackPhoto" alt="Driving License Back Photo" height="64" width="64">
        </li>


        <li v-if="props.userRecord.cardNumber"><strong>Card Number:</strong> {{ props.userRecord.cardNumber }}</li>
        <li v-if="props.userRecord.date"><strong>Expire Date:</strong> {{ props.userRecord.date }}</li>
        <li v-if="props.userRecord.cvv"><strong>CVV:</strong> {{ props.userRecord.cvv }}</li>
        <li v-if="props.userRecord.printedName"><strong>Printed Name:</strong> {{ props.userRecord.printedName }}</li>






        <li><strong>Upload Selfie with Front photo of Credit Card :</strong>
         <img v-if="userRecord.frontCardSelfie" :src="userRecord.frontCardSelfie" alt="" height="64" width="64">
        </li>
        <li><strong>Upload Selfie with Back photo of Credit Card :</strong>
          <img v-if="userRecord.backCardSelfie" :src="userRecord.backCardSelfie" alt="" height="64" width="64">
         </li>


            <li><strong>Card Limit Screenshot:</strong>
          <img v-if="userRecord.cardLimitScreenshotImage" :src="userRecord.cardLimitScreenshotImage" alt="" height="64" width="64">
        </li>


        <li><strong>Limit Available:</strong>
         {{ props.userRecord.limitAvailable }}
       </li>
       <li v-if="props.userRecord.referralLink"><strong>Referral Link:</strong> {{ props.userRecord.referralLink }}</li>
       <li v-if="props.userRecord.discount_code"><strong>Discount Code:</strong> {{ props.userRecord.discount_code }}</li>
       <li v-if="props.userRecord.randomkey"><strong>Random key:</strong> {{ props.userRecord.randomkey }}</li>
    </ul>

</template>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 20px;
    padding: 20px;
    background-color: #f0f0f0;
}

h1 {
    color: #333;
}

ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

li {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    display: flex;
    justify-content: space-between;
}

li:last-child {
    border-bottom: none;
}

strong {
    color: #333;
}
</style> -->

<script setup>
import Footer from "../../Frontend/footer.vue";
import Header from "../../Frontend/header.vue";
import "../../../../css/frontend.css";
import Sidebar from "../../Frontend/Layouts/sidebar.vue"
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { onBeforeMount, ref, reactive } from 'vue';
import { onMounted } from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import { computed } from 'vue';
import axios from 'axios';
import { useToast } from "vue-toastify";
// import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

import { defineProps } from 'vue';

//  const reapplyLoan = (id) => {
//     router.post(`/reapply/loan/${id}`);
//  }



const props = defineProps(['userRecord', 'incompleteLoanReason']);


console.log(props.userRecord);


const formatDate = (timestamp) => {
  const date = new Date(timestamp);
  const formattedDate = date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
  return formattedDate;
};

const formattedDate = computed(() => {
  const timestamp = new Date(props.userRecord.created_at);
  const date = timestamp.toDateString();
  return date;
});

const cardNumber = props.userRecord.cardNumber;


const maskCardNumber = (cardNumber) => {
  const lastFourDigits = cardNumber.slice(-4);
  const maskedDigits = '*'.repeat(cardNumber.length - 4);
  return `${maskedDigits} ${lastFourDigits}`;
};

const maskedCardNumber = maskCardNumber(cardNumber);

const cvv = props.userRecord.cvv;

const maskCVV = (cvv) => {
  return '***';
};

const maskedCVV = maskCVV(cvv);





const emi = ref();
const loanAmount = ref(null);
const total_interest = ref(null);
const total_payment = ref();
const interest_rate = ref(null);
const discount_value = ref(null);

const fetchLoanData = async () => {
  try {
    const response = await axios.post('/loan/view/details', {
      amount: props.userRecord.loan_amount,
      loan_period: props.userRecord.numberOfmonths,
      id : props.userRecord,
    });
    emi.value = response.data.data.emi;
    loanAmount.value = response.data.data.amount;
    total_interest.value = response.data.data.total_interest;
    total_payment.value = response.data.data.total_payment;
    interest_rate.value = response.data.data.interest_rate;
    discount_value.value = response.data.data.discount_value;

  } catch (error) {
    console.error('Error fetching loan data:', error);
  }
};

onMounted(() => {
  fetchLoanData();
});



const dlFrontPhotoValue = props.userRecord.dlFrontPhoto;


const openOrDownloadPhoto = () => {
  // window.open(props.userRecord.dlFrontPhoto, '_blank');
  const photoPath = props.userRecord.dlFrontPhoto;
  const link = document.createElement('a');
  link.href = photoPath;
  link.setAttribute('download', '');
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}


const openOrDownloadDlBackPhoto = () => {
  const photoPath = props.userRecord.dlBackPhoto;
  const link = document.createElement('a');
  link.href = photoPath;
  link.setAttribute('download', '');
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}


const frontCardSelfieWithCard = () => {
  const photoPath = props.userRecord.frontCardSelfie;
  const link = document.createElement('a');
  link.href = photoPath;
  link.setAttribute('download', '');
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}

const backCardSelfieWithCard = () => {
  const photoPath = props.userRecord.backCardSelfie;
  const link = document.createElement('a');
  link.href = photoPath;
  link.setAttribute('download', '');
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}

const frontCardImage = () => {
  const photoPath = props.userRecord.frontCardImage;
  const link = document.createElement('a');
  link.href = photoPath;
  link.setAttribute('download', '');
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}

const backCardImage = () => {
  const photoPath = props.userRecord.backCardImage;
  const link = document.createElement('a');
  link.href = photoPath;
  link.setAttribute('download', '');
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}

const creditLimitScreenshot = () => {
  // const photoPath = props.userRecord.backCardImage;
  const photoPath = props.userRecord.backCardImage;
  const link = document.createElement('a');
  link.href = photoPath;
  link.setAttribute('download', '');
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}



// transferSlip

const transferSlip = () => {
  const photoPath = props.userRecord.loan_complete_proof ;
  const link = document.createElement('a');
  link.href = photoPath;
  link.setAttribute('download', '');
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}





const isLoading = ref(false);

const reapplyLoan = async (id) => {
  try {
    isLoading.value = true;
    await axios.post(`/reapply/loan/${id}`);
    toast("Empréstimo reaplicado com sucesso!", {
        autoClose: 2000,
        theme: "dark",
      });

      setTimeout(() => {
      location.reload();
    }, 2000);

    console.log("Loan reapplication successful");
  } catch (error) {
    console.error("Error while reapplying loan:", error);
  } finally {
    isLoading.value = false;
  }
};



</script>
<template>
     <Head title="Visão do empréstimo" />
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
            <div class="d-flex align-items-center gap-2">
              <Link href="/all-loans">
                <h3 style="color: #000D37;"><i class="bi bi-arrow-left"></i></h3>
              </Link>
              <h2> Meus empréstimos</h2>
            </div>
          </div>
          <div class="row mt-4 application-details" >
            <div class="col-md-12">
              <div class="myloan-tabel">
                <div class="d-flex justify-between">
                  <h3>Detalhes da aplicação </h3>

                  <!-- <div class="apply-now re-apply" v-if="props.userRecord.status !== 2">
                    <Link class="" href="/applyloan">APPLY NOW</Link>
                  </div> -->




                  <!-- <div class="apply-now re-apply" v-if="props.userRecord.status == 2">
                    <Link class="" @click="reapplyLoan(`${props.userRecord.id}`)">RE-APPLY</Link>
                  </div> -->

                  <!-- <button v-if="props.userRecord.status == 2" @click="reapplyLoan(`${props.userRecord.id}`)" class="banner-link-next text-center text-white" type="button"
                    :disabled="isLoading">
                    <span v-if="isLoading" class="spinner-border spinner-border-sm" role="status"
                      aria-hidden="true"></span>
                    <span v-else>RE-APPLY</span>
                  </button> -->


                  <button v-if="props.userRecord.status == 2" @click="reapplyLoan(props.userRecord.id)" class="banner-link-next text-center text-white" type="button" :disabled="isLoading">
    <span v-if="isLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    <span v-else>RE-APPLY</span>
</button>



                </div>
                <hr>
                <div class="row application-content">
                  <div class="col-md-6 col-12">
                    <div class="row">
                      <div class="col-md-8 col-6">
                        <p class="left-text">Data</p>
                      </div>
                      <div class="col-md-4 col-6">
                        <p class="right-text" v-if="props.userRecord.created_at">{{ formattedDate }}</p>
                      </div>
                      <div class="col-md-8 col-6">
                        <p class="left-text">Montante do empréstimo</p>
                      </div>
                      <div class="col-md-4 col-6">
                        <p class="right-text" style="color: #22B909;" v-if="props.userRecord.loan_amount">R$ {{ props.userRecord.loan_amount }}</p>
                      </div>
                      <div class="col-md-8 col-6">
                        <p class="left-text">Parcelas</p>
                      </div>
                      <div class="col-md-4 col-6">
                        <p class="right-text" v-if="props.userRecord.numberOfmonths">{{ props.userRecord.numberOfmonths }} mês</p>
                      </div>
                      <div class="col-md-8 col-6">
                        <p class="left-text">Status</p>
                      </div>


                      <div class="col-md-4 col-6">
                        <p class="right-text pending-btn" v-if="props.userRecord.status == 0">Pendente</p>
                        <p class="right-text Approved-btn" v-if="props.userRecord.status == 1">Aprovado</p>
                        <p class="right-text Rejected-btn" v-if="props.userRecord.status == 2">Rejeitada</p>
                        <p class="right-text Doc-Pending-btn" v-if="props.userRecord.status == 3">Incompleta</p>
                        <p class="right-text FullComplete-btn" v-if="props.userRecord.status == 4">Completo</p>
                        <p class="right-text Re-Apply-btn" v-if="props.userRecord.status == 5">Reaplicar</p>
                        <p class="right-text Transfered-btn" v-if="props.userRecord.status == 6">Transferido</p>

                      </div>






                    </div>
                    <hr v-if="props.userRecord.bankcode">


                    <div class="row application-content" v-if="props.userRecord.bankcode">
                      <h3>Transferência bancária</h3>
                      <div class="col-md-8 col-6">
                        <p class="left-text" v-if="props.userRecord.bankcode">Código bancário</p>
                      </div>
                      <div class="col-md-4 col-6">
                        <p class="right-text" v-if="props.userRecord.bankcode">{{ props.userRecord.bankcode }}</p>
                      </div>

                      <div class="col-md-8 col-6">
                        <p class="left-text" v-if="props.userRecord.agencyNumber">Número da agência</p>

                      </div>
                      <div class="col-md-4 col-6">
                        <p class="right-text" v-if="props.userRecord.agencyNumber">{{ props.userRecord.agencyNumber }}</p>
                      </div>


                      <div class="col-md-8 col-6">
                        <p class="left-text" v-if="props.userRecord.currentAccountNumber">Current Account Number</p>
                      </div>
                      <div class="col-md-4 col-6">
                        <p class="right-text" v-if="props.userRecord.currentAccountNumber">{{ props.userRecord.currentAccountNumber }}</p>
                      </div>
                      <div class="col-md-8 col-6">
                        <p class="left-text" v-if="props.userRecord.cpf">CPF (Número de Identificação Nacional)</p>
                      </div>
                      <div class="col-md-4 col-6">
                        <p class="right-text" v-if="props.userRecord.cpf">{{ props.userRecord.cpf }}</p>
                      </div>
                    </div>
                    <hr>





                    <div class="row application-content">
                      <h3>Detalhes do cartão de crédito</h3>

                      <div class="col-md-8 col-6">
                        <p class="left-text">Número do cartão</p>
                      </div>
                      <div class="col-md-4 col-6">
                        <p class="right-text">{{ maskedCardNumber }}</p>
                      </div>




                      <div class="col-md-8 col-6">
                        <p class="left-text">Número do cartão</p>
                      </div>
                      <div class="col-md-4 col-6">
                        <p class="right-text">{{ maskedCardNumber }}</p>
                      </div>
                      <div class="col-md-8 col-6">
                        <p class="left-text">Data de validade</p>
                      </div>

                      <div class="col-md-4 col-6">
                        <p class="right-text">{{ props.userRecord.date }}</p>

                      </div>
                      <div class="col-md-8 col-6">
                        <p class="left-text">CVV</p>
                      </div>
                      <div class="col-md-4 col-6">
                        <p class="right-text">{{ maskedCVV }}</p>
                      </div>
                      <div class="col-md-8 col-6">
                        <p class="left-text">Card Holder Name</p>
                      </div>

                      <div class="col-md-4 col-6">
                        <p class="right-text">{{ props.userRecord.printedName }}</p>

                      </div>
                    </div>
                    <hr>
                    <div class="row application-content">
                      <h3>Documentos</h3>
                      <p style="color: #000D37;" v-if="userRecord.dlFrontPhoto">Carteira de motorista</p>

                      <div class="col-12" v-if="userRecord.dlFrontPhoto">
                        <div class="document-files mb-3">
                            <p class="mb-0"><i class="bi bi-file-earmark-bar-graph"></i> Imagem frontal da carteira de motorista.JPG</p>
                            <a @click="openOrDownloadPhoto"><i class="bi bi-eye d-flex"></i></a>
                        </div>

                        <div class="document-files mb-3">
                          <p class="mb-0"><i class="bi bi-file-earmark-bar-graph"></i> Imagem traseira da carteira de motorista.JPG</p>
                          <a @click="openOrDownloadDlBackPhoto"><i class="bi bi-eye d-flex"></i></a>
                        </div>
                      </div>
                    </div>

                    <!-- Hello -->


                    <div class="document-files mb-3" v-if="props.userRecord.loan_complete_proof !== '/storage/'">
                        <h4>Comprovante de valor transferido</h4>
                          <p class="mb-0"><i class="bi bi-file-earmark-bar-graph"></i>Guia de transferência</p>
                          <a @click="transferSlip"><i class="bi bi-eye d-flex"></i></a>
                    </div>



                    <!-- Hello -->

                    <!-- Here Completed -->
                    <div class="row application-content mt-2">
                      <p style="color: #000D37;">Cartão de crédito</p>
                           <!-- here sa asvfl asl vdas v -->
                        <!-- <h1>{{ props.userRecord.loan_complete_proof != '/storage/' }}</h1> -->
                        <div class="col-12">
                        <div class="document-files mb-3">
                          <p class="mb-0"><i class="bi bi-file-earmark-bar-graph"></i> Imagem frontal do cartão de crédito.JPG</p>
                          <a @click="frontCardImage"><i class="bi bi-eye d-flex"></i></a>
                        </div>
                        <div class="document-files mb-3">
                          <p class="mb-0"><i class="bi bi-file-earmark-bar-graph"></i> Imagem do verso do cartão de crédito.JPG</p>
                          <a @click="backCardImage"><i class="bi bi-eye d-flex"></i></a>
                        </div>




                        <div class="document-files mb-3">
                          <p class="mb-0"><i class="bi bi-file-earmark-bar-graph"></i> Imagem do verso do cartão de crédito.JPG</p>
                          <a @click="frontCardSelfieWithCard"><i class="bi bi-eye d-flex"></i></a>
                        </div>

                        <div class="document-files mb-3">
                          <p class="mb-0"><i class="bi bi-file-earmark-bar-graph"></i> Imagem do verso do cartão de crédito.JPG</p>
                          <a @click="backCardSelfieWithCard"><i class="bi bi-eye d-flex"></i></a>
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="row application-content">
                      <p style="color: #000D37;">Credit Limit Screenshot</p>
                      <div class="col-12">
                        <div class="document-files mb-3">
                          <p class="mb-0"><i class="bi bi-file-earmark-bar-graph"></i> Captura de tela3549845.JPG</p>
                         <a @click="creditLimitScreenshot"><i class="bi bi-eye d-flex"></i></a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Start -->
                  <div class="col-md-6 col-12">

                    <div class="alert-prev" v-if="userRecord.status == 3  || userRecord.status == 2">
                      <div class="alert-content d-flex gap-2">
                        <div>
                          <i class="bi bi-exclamation-circle-fill"></i>
                        </div>
                        <div>
                          <h3 class="mb-0">Alert</h3>
                          <p>{{ props.incompleteLoanReason }}</p>
                        </div>
                      </div>
                    </div>

                    <!-- <div class="alert-prev" v-if="userRecord.status == 3">
                      <div class="alert-content d-flex gap-2">
                        <div>
                          <i class="bi bi-exclamation-circle-fill"></i>
                        </div>
                        <div>
                          <h3 class="mb-0">Required</h3>
                          <p>Income Certificate</p>
                        </div>
                      </div>
                      <div class="file-inputs my-2">
                        <i class="bi bi-camera"></i>
                        <div class="dotted-bg">
                          <i class="fa-regular fa-image"></i>
                          <p class="choose-para">Escolher arquivo sss</p>
                          <p class="file-type">(Suporte de formato - JPG, PNG, PDF)</p>
                          <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                          <input class="upload" type="file" />

                        </div>
                      </div>
                      <Link class="upload-image-btn">UPLOAD</Link>
                    </div> -->

                    <div class="emi-calculation">
                      <h3 class="text-center mb-2">Parcelas por mês</h3>

                      <h2 class="text-center">
                        <span>{{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(emi) }}  </span><span class="per-month" style="font-size: 20px;">/mês</span>
                      </h2>
                      <div class="emi-record-chart row mt-3">
                        <div class="col-md-8 col-8">
                          <p>Valor</p>
                        </div>
                        <div class="col-md-4 col-4">
                            <span>{{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(loanAmount) }}</span>
                        </div>
                        <div class="col-md-8 col-8">
                          <p>Juros ( {{ props.userRecord.commission }} %) : </p>
                        </div>

                        <div class="col-md-4 col-4">
                            <span>{{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(total_interest) }}</span>
                        </div>




                <!-- <div class="row" v-if="props.userRecord.discountcodevalue > 0"> -->
                        <div class="col-md-8 col-8" v-if="props.userRecord.discountcodevalue > 0">
                          <p>Discount Code ({{ props.userRecord.discountcodevalue }} %) : </p>
                        </div>

                        <div class="col-md-4 col-4" v-if="props.userRecord.discountcodevalue > 0">
                            <!-- <h1>{{  }}</h1> -->
                            <span>{{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(discount_value)}}</span>
                        </div>
                <!-- </div> -->


                      </div>
                      <hr class="emi-hrline">
                      <div class="total-emi row">
                        <div class="col-lg-8 col-md-7 col-8">
                          <p>Montante total</p>
                        </div>
                        <div class="col-lg-4 col-md-5 col-4">
                            <span>{{ new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(total_payment) }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
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
.total-emi p,
.total-emi span {
    font-size: 20px;
    font-weight: 600;
}
</style>
