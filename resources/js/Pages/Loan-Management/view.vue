<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head } from '@inertiajs/vue3';
import { defineProps, ref} from 'vue';
import FsLightbox from "fslightbox-vue/v3";

const {loanData, documents} = defineProps(['loanData','documents']);
// console.log(loanData);
const formatDate = (timestamp) => {
  const date = new Date(timestamp);
  const formattedDate = date.toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
  });
  return formattedDate;
};
/****  fsLightBox ****/
const picUrl = ref([])
const toggler = ref(0)

const openFs = (url) => {
  picUrl.value.pop();
    picUrl.value.push(url);
    toggler.value++;
}
/****  -------- ****/

const getStatusColor = () => {
  const statusName = loanData.status;
  const status = statusName.toLowerCase();
//   console.log(status);
  switch (status) {
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
    default:
      return 'text-gray-800';
  }
};
</script>
<template>
  <AuthenticatedLayout>
    <FsLightbox
              :toggler="toggler"
              :sources="picUrl"
            />
    <Head title="View Loan"/>

      <div class="flex items-center justify-center p-6 ">
        <div class="w-full">
          <h1 class="mb-4 text-xl font-semibold text-gray-700">Loan Details:</h1>
          <div class="flex items-center mb-4">
          <div class="w-1/3">
            <label class="block text-gray-600 font-bold">Applicant Name:</label>
          </div>




          <div class="w-2/3">
            <span class="text-gray-800">{{ loanData.applicant_name}}</span>
          </div>
        </div>



        <div class="flex items-center mb-4">
          <div class="w-1/3">
            <label class="block text-gray-600 font-bold">Loan Amount:</label>
          </div>
          <div class="w-2/3">
            <span class="text-gray-800">{{ loanData.loan_amount }}</span>
          </div>
        </div>



        <div class="flex items-center mb-4">
          <div class="w-1/3">
            <label class="block text-gray-600 font-bold">Number of Months:</label>
          </div>
          <div class="w-2/3">
            <span class="text-gray-800">{{ loanData.numberOfmonths }}</span>
          </div>
        </div>



        <div class="flex items-center mb-4" v-if="loanData.cal_emi >0 && loanData.cal_total_interest != null">
          <div class="w-1/3">
            <label class="block text-gray-600 font-bold">Emi:</label>
          </div>
          <div class="w-2/3">
            <span class="text-gray-800">
                {{ new Intl.NumberFormat('pt-BR', {
                          style: 'currency', currency: 'BRL', minimumFractionDigits: 2
                        }).format(loanData.cal_emi) }}

            </span>
          </div>
        </div>


        <div class="flex items-center mb-4" v-if="loanData.cal_total_interest > 0 && loanData.cal_total_interest != null">
          <div class="w-1/3">
            <label class="block text-gray-600 font-bold">Total Interest:</label>
          </div>
          <div class="w-2/3">
            <span class="text-gray-800">
                {{ new Intl.NumberFormat('pt-BR', {
                          style: 'currency', currency: 'BRL', minimumFractionDigits: 2
                        }).format(loanData.cal_total_interest) }}
            </span>
          </div>
        </div>



        <div class="flex items-center mb-4" v-if="loanData.cal_total_payment > 0 && loanData.cal_total_payment != null">
          <div class="w-1/3">
            <label class="block text-gray-600 font-bold">Total Payment:</label>
          </div>
          <div class="w-2/3">
            <span class="text-gray-800">
                {{ new Intl.NumberFormat('pt-BR', {
                          style: 'currency', currency: 'BRL', minimumFractionDigits: 2
                        }).format(loanData.cal_total_payment) }}
            </span>
          </div>
        </div>








        <div class="flex items-center mb-4">
          <div class="w-1/3">
            <label class="block text-gray-600 font-bold">Date:</label>
          </div>
          <div class="w-2/3">
            <span class="text-gray-800">{{ formatDate(loanData.created_at) }}</span>
          </div>
        </div>
        <div class="flex mb-4">
          <div class="w-1/3">
            <label class="block text-gray-600 font-bold">Card Details</label>
          </div>
          <div v-if="loanData.cardNumber" class="w-2/3">
            <span class="text-gray-800"><b>Printed Name</b> : {{loanData.printedName }}</span>
          <br />
            <span class="text-gray-800"><b>Card Number</b> : {{loanData.cardNumber }}</span>
            <br />
            <span class="text-gray-800"><b>Expiry Date</b> : {{loanData.date }}</span>
          </div>
        </div>
        <div class="flex mb-4">
          <div class="w-1/3">
            <label class="block text-gray-600 font-bold">Received Loan through:</label>
          </div>
          <div  v-if="loanData.receiveLoanThrough == 0" class="w-2/3">
            <span class="text-gray-800 font-bold"><b>Via PIX</b> :
            <br>
              <span v-if="loanData.pixcpf"><b>CPF</b> : {{ loanData.pixcpf }} <br></span>
              <span v-if="loanData.email"><b>Email</b> : {{ loanData.email }}<br></span>
              <span v-if="loanData.phonenumber"><b>Phone Number</b> : {{ loanData.phonenumber }}<br></span>
              <span v-if="loanData.randomkey"><b>Random Key</b> : {{ loanData.randomkey }} <br></span>
            </span>
          </div>
          <div  v-if="loanData.receiveLoanThrough == 1" class="w-2/3">
            <span class="text-gray-800 font-bold"><b>Via Wire Transfer</b>:
              <br>
              <span v-if="loanData.bankcode"><b>Bank Code</b> : {{ loanData.bankcode }}<br></span>
              <span v-if="loanData.agencyNumber"><b>Agency Number</b> : {{ loanData.agencyNumber }}<br></span>
              <span v-if="loanData.currentAccountNumber"><b>Current Account Number</b> : {{ loanData.currentAccountNumber }}<br></span>
              <span v-if="loanData.cpf"><b>CPF</b> : {{ loanData.cpf }}</span>
            </span>
          </div>
        </div>
        <div class="flex items-center mb-4">
          <div class="w-1/3">
            <label class="block text-gray-600 font-bold">Limit Available:</label>
          </div>
          <div class="w-2/3">
            <span class="text-gray-800">{{ loanData.limitAvailable }}</span>
          </div>
        </div>
        <div class="flex items-center mb-4">
          <div class="w-1/3">
            <label class="block text-gray-600 font-bold">affiliate Link:</label>
          </div>
          <div class="w-2/3">
            <span class="text-gray-800">{{ loanData.referralLink }}</span>
          </div>
        </div>


        <h1 class="mb-4 text-xl font-semibold text-gray-700">Documents:-</h1>



        <div v-if="loanData.ssnFrontPhoto || loanData.ssnBackPhoto" class="flex items-center mb-4">
          <div class="w-2/3">
            <label class="block text-gray-600 font-bold">RG:-</label>
          </div>
          <div class="w-2/3">
            <img v-if="loanData.ssnFrontPhoto" :src="loanData.ssnFrontPhoto" alt="" height="64" width="64" @click="openFs(loanData.ssnFrontPhoto)">

          </div>
          <div class="w-2/3">
            <img v-if="loanData.ssnBackPhoto" :src="loanData.ssnBackPhoto" alt="" height="64" width="64" @click="openFs(loanData.ssnBackPhoto)">
          </div>
        </div>
        <div v-if="loanData.dlFrontPhoto" class="flex items-center mb-4">
          <div class="w-2/3">
            <label class="block text-gray-600 font-bold">Driving licence:-</label>
          </div>
          <div class="w-2/3">
            <img v-if="loanData.dlFrontPhoto" :src="loanData.dlFrontPhoto" alt="" height="64" width="64" @click="openFs(loanData.dlFrontPhoto)">
          </div>
          <div class="w-2/3">
            <img v-if="loanData.dlBackPhoto" :src="loanData.dlBackPhoto" alt="" height="64" width="64" @click="openFs(loanData.dlBackPhoto)">
          </div>
        </div>
        <div v-if="loanData.frontCardSelfie" class="flex items-center mb-4">
          <div class="w-2/3">
            <label class="block text-gray-600 font-bold">Selfie With Credit Card:-</label>
          </div>
          <div class="w-2/3">
            <img v-if="loanData.frontCardSelfie" :src="loanData.frontCardSelfie" alt="" height="64" width="64" @click="openFs(loanData.frontCardSelfie)">
          </div>
          <div class="w-2/3">
            <img v-if="loanData.backCardSelfie" :src="loanData.backCardSelfie" alt="" height="64" width="64" @click="openFs(loanData.backCardSelfie)">
          </div>
        </div>
        <div v-if="loanData.frontCardImage" class="flex items-center mb-4">
          <div class="w-2/3">
            <label class="block text-gray-600 font-bold">Credit Card:-</label>
          </div>
          <div class="w-2/3">
            <img v-if="loanData.frontCardImage" :src="loanData.frontCardImage" alt="" height="64" width="64" @click="openFs(loanData.frontCardImage)">
          </div>
          <div class="w-2/3">
            <img v-if="loanData.backCardImage" :src="loanData.backCardImage" alt="" height="64" width="64" @click="openFs(loanData.backCardImage)">
          </div>
        </div>
        <div v-if="loanData.cardLimitScreenshot" class="flex items-center mb-4">
          <div class="w-1/3">
            <label class="block text-gray-600 font-bold">Card limit Screenshot:-</label>
          </div>
          <div class="w-2/3">
            <img v-if="loanData.cardLimitScreenshot" :src="loanData.cardLimitScreenshot" alt="" height="64" width="64" @click="openFs(loanData.cardLimitScreenshot)">
          </div>
        </div>

        <div class="flex items-center mb-4" v-if="loanData.status == 'Transferred'">
          <div class="w-1/3">
            <label class="block text-gray-600 font-bold">Amount Transfer Proof:</label>
          </div>

          <div class="w-2/3">
            <div class="w-2/3">
            <img v-if="loanData.loan_complete_proof" :src="loanData.loan_complete_proof" alt="" height="64" width="64" @click="openFs(loanData.loan_complete_proof)">
          </div>
          </div>
        </div>


        <div class="flex items-center mb-4">
          <div class="w-1/3">
            <label class="block text-gray-600 font-bold">Loan Status:</label>
          </div>
          <div class="w-2/3">
            <span :class="['font-bold', getStatusColor()]">
                {{ loanData.status }}
            </span>
          </div>
        </div>

  <!-- <div class="flex items-center mb-4">
          <div class="w-1/3">
            <label class="block text-gray-600 font-bold">Document:</label>
          </div>
          <div class="w-2/3">
            <span v-for="document in documents" :key="document" style="margin-right: 10px;">
                    <img :src="document.url" alt="Document" style="max-width: 200px; max-height: 200px;" />
                </span>
          </div>
        </div> -->

        </div>
      </div>
  </AuthenticatedLayout>
</template>
<style scoped>
.bg-white {
  background-color: #fff;
}

.border {
  border: 1px solid #ddd;
}

.rounded-md {
  border-radius: 0.375rem;
}

.shadow-md {
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.text-gray-600 {
  color: #4a5568;
}

.font-bold {
  font-weight: 700;
}

.text-gray-800 {
  color: #2d3748;
}
</style>
