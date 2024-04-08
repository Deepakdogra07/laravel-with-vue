<script setup>
import { ref, watch, onMounted, computed } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastify';
import NavLink from "@/Components/NavLink.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import axios from "axios";
import { toast } from "vue3-toastify";
import { nextTick } from 'vue';
import { watchEffect } from 'vue';
// import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";




// const showingNavigationDropdown = ref(false);
// const prop = defineProps({
//     customers: {
//         type: Array,
//         default: [],
//     },
// });

// const form = useForm({
//     applicant_id: '',
//     loan_amount: '',
//     numberofinstallment: '',
//     numberOfmonths: '',
//     instalamount: '',
//     installments: '',
//     receiveLoanThrough: '',
//     pixKey: '',
//     cardNumber: '',
//     printedName: '',
//     date: '',
//     documentOption: '',
//     ssnFrontPhoto: '',
//     ssnBackPhoto: '',
//     drivingLicense: '',
//     dlFrontPhoto: '',
//     dlBackPhoto: '',
//     frontCardSelfie: '',
//     backCardSelfie: '',
//     frontCardImage: '',
//     backCardImage: '',
//     cardLimitScreenshot: '',
//     limitAvailable: '',
//     declarationCheckbox: '',
//     status: '',
//     referralLink: '',
//     referralordiscount: '',
//     discount_code: '',
//     documents_id: '',
// });

// const checkType = () => {
//     if (form.receiveLoanThrough == 0) {
//         form.cardNumber = '';
//         form.printedName = '';
//         form.monthYear = '';
//     } else if (form.receiveLoanThrough == 1) {
//         form.pixKey = '';
//     }
// }

// const checkdocument = () => {
//     if (form.documentOption == 'ssn') {
//         form.dlFrontPhoto = '';
//         form.dlBackPhoto = '';
//     } else {
//         form.ssnFrontPhoto = ''
//         form.ssnBackPhoto = '';
//     }
// }

// const referralCodeChange = () => {
//     if (form.referralordiscount == 0) {
//         form.discount_code = '';
//     }
// }

// const referralDiscountChange = () => {
//     form.referralLink = '';
// }

// const submit = async () => {
//     const options = {
//         onSuccess: page => {
//             const toast = useToast();
//             toast.success("Loan Created Successfully!");
//         },
//         onError: errors => {
//             alert(errors.response.data.error);
//             const toast = useToast();
//             toast.error(errors.response.data.error);
//         },
//     }
//     const response = form.post(`/loan/store`, options);
// };







const isLoading = ref(false);

const showingNavigationDropdown = ref(false);

// const prop = defineProps({
//     customers: {
//         type: Array,
//         default: [],
//     },
// });


const maxSteps = 5;


const nextStep = async () => {
  const errors = {};

  if (
    !form.loan_amount ||
    isNaN(form.loan_amount) ||
    parseFloat(form.loan_amount) < 200 ||
    parseFloat(form.loan_amount) > 50000 ||
    /\s/.test(form.loan_amount)
  ) {
    errors.loan_amount = !form.loan_amount
      ? "Este campo é obrigatório"
      : /\s/.test(form.loan_amount)
        ? "Insira um valor numérico válido sem espaços para o valor do empréstimo"
        : "Insira um valor numérico válido entre 200,00.00 e 50.000,00 para o valor do empréstimo";
  }


  if (currentStep.value === 1 && !form.numberOfmonths) {
    errors.numberOfmonths = "Este campo é obrigatório";
  }

  if (currentStep.value === 2 && !form.receiveLoanThrough) {
    errors.receiveLoanThrough = "Este campo é obrigatório";
  }






  if (form.receiveLoanThrough == "0" && currentStep.value === 2) {


    if (form.pixtype === 'pixKey') {
      if (!form.pixdata) {
        errors.pixdata = "Este campo é obrigatório";
      } else if (/\s/.test(form.pixdata)) {
        errors.pixdata = "Chave Pix não deve conter espaços em branco";
      } else if (!/^\d+$/.test(form.pixdata)) {
        errors.pixdata = "A Chave Pix deve ser um número";
      } else if (parseInt(form.pixdata) <= 0) {
        errors.pixdata = "A Chave Pix deve ser um número maior que 0";
      }
    }




    if (form.pixtype === 'pixcpf') {
      if (!form.pixdata) {
        errors.pixdata = "Este campo é obrigatório";
        console.log('hello');
      } else if (!/^\d+$/.test(form.pixdata)) {
        errors.pixdata = "A Chave Pix CPF deve ser um número";
      } else if (!/^[a-zA-Z0-9]+$/.test(form.pixdata)) {
        errors.pixdata = "A Chave Pix CPF deve ser alfanumérica";
      } else if (/\s/.test(form.pixdata)) {
        errors.pixdata = "A Chave Pix CPF não deve conter espaços em branco";
      } else if (parseInt(form.pixdata) <= 0) {
        errors.pixdata = "A Chave Pix CPF deve ser um número positivo";
      } else if (form.pixdata.length !== 11) {
        errors.pixdata = "A Chave Pix CPF deve ter 11 dígitos";
      }
    }





    if (form.pixtype === 'phonenumber') {
      if (!form.pixdata) {
        errors.pixdata = "Este campo é obrigatório";
        console.log('hello !', errors.pixdata);
      } else if (/\s/.test(form.pixdata)) {
        errors.pixdata = "O número de telefone não deve conter espaços em branco";
      } else if (!/^\d{9}$/.test(form.pixdata)) {
        errors.pixdata = "O número de telefone deve conter nove dígitos";
      } else if (parseInt(form.pixdata) <= 0) {
        errors.pixdata = "O número de telefone deve ser maior que zero";
      }
    }








    if (form.pixtype === 'randomkey') {
      if (!form.pixdata) {
        errors.pixdata = "Este campo é obrigatório";
        console.log("Hello");
      } else if (/\s/.test(form.pixdata)) {
        errors.pixdata = "A chave aleatória não deve conter espaços em branco";
      }
    }


  }
  else {
    if (form.receiveLoanThrough === "1") {
      if (!form.bankcode || /\s/.test(form.bankcode) || form.bankcode < 0) {
        errors.bankcode = !form.bankcode
          ? "Este campo é obrigatório"

          : /\s/.test(form.bankcode)
            ? "O número da agência não deve conter espaços em branco"
            : form.bankcode < 0
              ? "O número da agência deve ser um valor positivo ou zero"
              : "";
      }



      if (!form.agencyNumber || /\s/.test(form.agencyNumber) || form.agencyNumber < 0) {
        errors.agencyNumber = !form.agencyNumber
          ? "Este campo é obrigatório"

          : /\s/.test(form.agencyNumber)
            ? "O número da agência não deve conter espaços em branco"
            : form.agencyNumber < 0
              ? "O número da agência deve ser um valor positivo ou zero"
              : "";
      }



      if (!form.currentAccountNumber || !/^\d+$/.test(form.currentAccountNumber) || /\s/.test(form.currentAccountNumber) || form.currentAccountNumber <= 0) {
        errors.currentAccountNumber = !form.currentAccountNumber
          ? "Este campo é obrigatório"
          : /\s/.test(form.currentAccountNumber)
            ? "O número da conta corrente não deve conter espaços em branco"
            : !/^\d+$/.test(form.currentAccountNumber)
              ? "O número da conta corrente deve conter apenas dígitos"
              : form.currentAccountNumber <= 0
                ? "O número da conta corrente deve ser um valor positivo diferente de zero"
                : "";
      }



      if (!form.cpf || !/^\d{11}$/.test(form.cpf)) {
        errors.cpf = !form.cpf
          ? "Este campo é obrigatório"
          : "CPF should be a positive numeric value with exactly 11 digits.";
      }
    }
  }




















  if (currentStep.value === 3 && !form.documentOption) {
    errors.documentOption = "Este campo é obrigatório";
  }


  if (currentStep.value === 3) {
    if (!form.documentOption) {
      errors.documentOption = "Este campo é obrigatório";
    } else if (form.documentOption === "ssn") {
      if (!form.ssnFrontPhoto) {
        errors.ssnFrontPhoto = "Este campo é obrigatório";
      }
      if (!form.ssnBackPhoto) {
        errors.ssnBackPhoto = "Este campo é obrigatório";
      }
    } else if (form.documentOption === "drivingLicense") {
      if (!form.dlFrontPhoto) {
        errors.dlFrontPhoto = "Este campo é obrigatório";
      }
      if (!form.dlBackPhoto) {
        errors.dlBackPhoto = "Este campo é obrigatório";

      }
    }
  }



  if (currentStep.value === 4 && !form.frontCardSelfie) {
    errors.frontCardSelfie = "Este campo é obrigatório";
  }

  if (currentStep.value === 4 && !form.backCardSelfie) {
    errors.backCardSelfie = "Este campo é obrigatório";
  }

  if (currentStep.value === 4 && !form.frontCardImage) {
    errors.frontCardImage = "Este campo é obrigatório";
  }

  if (currentStep.value === 4 && !form.backCardImage) {
    errors.backCardImage = "Este campo é obrigatório";
  }

  if (currentStep.value === 4 && !form.cardLimitScreenshot) {
    errors.cardLimitScreenshot = "Este campo é obrigatório";
  }

  if (
    currentStep.value === 4 &&
    (!form.limitAvailable ||
      isNaN(form.limitAvailable) ||
      parseFloat(form.limitAvailable) <= 0)
  ) {
    errors.limitAvailable = !form.limitAvailable
      ? "Este campo é obrigatório"
      : "Insira um valor numérico válido maior que 0 para Limite disponível";
  }


  if (Object.keys(errors).length > 0) {
    form.errors = errors;
    console.log('return', errors, form.errors)
    return;
  }



  if (Object.keys(errors).length === 0) {
    if (currentStep.value < maxSteps - 1) {
      currentStep.value++;
    }
  }
}







const prevStep = () => {
  if (currentStep.value > 0) {
    currentStep.value--;
  }
};



const form = useForm({
  loan_amount: "",
  numberofinstallment: "",
  numberOfmonths: ref(3),
  instalamount: "",
  installments: "",

  receiveLoanThrough: 0,
  cardNumber: "",
  printedName: "",
  date: "",
  documentOption: "",
  ssnFrontPhoto: "",
  ssnBackPhoto: "",
  drivingLicense: "",
  dlFrontPhoto: "",
  dlBackPhoto: "",
  frontCardSelfie: "",
  backCardSelfie: "",
  frontCardImage: "",
  backCardImage: "",
  cardLimitScreenshot: "",
  limitAvailable: "",
  declarationCheckbox: "",
  status: "",
  referralLink: "",
  documents_id: "",
  referralordiscount: "",
  discount_code: "",
  isChecked: 0,
  status: '',
  documentOption: 'drivingLicense',
  bankcode: '',
  agencyNumber: '',
  currentAccountNumber: '',
  cpf: '',
  cvv: '',
  emi: 0,
  total_interest: 0,
  total_payment: 0,
  eemail: '',
  password: '',
  pixtype: '',
  pixdata: '',
  applicant_id: '',
});


const updateValue = (value) => {
  form.loan_amount = value;
}

const checkType = () => {
  if (form.isChecked == 0) {
    form.receiveLoanThrough = '0';
    form.pixKey = '';
    form.pixcpf = '';
    form.phonenumber = '';
    form.email = '';
    form.randomkey = '';
  } else {
    form.receiveLoanThrough = '1';
    form.bankcode = '';
    form.agencyNumber = '';
    form.currentAccountNumber = '';
    form.cpf = '';
  }
};


const checkdocument = () => {
  if (form.documentOption === 'ssn') {
    form.dlFrontPhoto = '';
    form.dlBackPhoto = '';
  } else {
    form.ssnFrontPhoto = '';
    form.ssnBackPhoto = '';
  }
}



const referralCodeChange = () => {
  if (form.referralordiscount == 0) {
    form.discount_code = "";
  }
};

const referralDiscountChange = () => {
  form.referralLink = "";
};


const submit = async () => {
  isLoading.value = true;
  form.post(`/loan/store/backend/record`, {
    onSuccess: (page) => {
      toast("Loan applied successfully!", {
        autoClose: 2000,
        theme: "dark",
      });
      isLoading.value = false;
    },
    onError: errors => {
      isLoading.value = false;
    },
  });
};


const setLoanAmount = (amount) => {
  form.loan_amount = amount.toString();
}

const loanAmount = ref(null);


onMounted(async () => {
  const urlParams = new URLSearchParams(window.location.search);
  const loanAmountValue = urlParams.get('loan_amount');
  const time = urlParams.get('time');
  if (loanAmountValue) {
    form.loan_amount = loanAmountValue;
    form.numberOfmonths = time;
    getDetails();
  }
  currentStep.value = parseFloat(form.loan_amount) > 0 ? 1 : 0;
  form.documentOption = 'ssn';
});



const getDetails = () => {
  var data = {
    amount: form.loan_amount,
    loan_period: form.numberOfmonths
  }
  axios.post('/loan/details', data).then(res => {
    var data = res.data.data;
    console.log('data')
    console.log(data)
    console.log('data')
    form.loan_amount = data.amount;
    form.emi = data.emi;
    form.total_interest = data.total_interest;
    form.total_payment = data.total_payment;
  }).catch(err => {
    console.log(err)
  })
}


// watch(() => form.loan_amount, (newValue, oldValue) => {
//   if (newValue) {
//     getDetails();
//   }
// });



const progressBarWidth = computed(() => {
  switch (currentStep.value) {
    case 0:
      return '0%';
    case 1:
      return '20%';
    case 2:
      return '40%';
    case 3:
      return '60%';
    case 4:
      return '80%';
    default:
      return '';
  }
});


const currentStep = ref(0);


const props = defineProps({
  interest_rate: Number,
  customers: Number,
});


const handleNumberOfMonthsChange = () => {
  const updatedNumberOfMonths = form.numberOfmonths;
};

const selectFrontImage = (event) => {
  form.dlFrontPhoto = event.target.files[0]
}

const selectBackImage = (event) => {
  form.dlBackPhoto = event.target.files[0]
}

const selectssnFrontImage = (event) => {
  form.ssnFrontPhoto = event.target.files[0]
}

const selectssnBackImage = (event) => {
  form.ssnBackPhoto = event.target.files[0]
}


const selectFrontCardImage = (event) => {
  form.frontCardImage = event.target.files[0]
}

const selectBackCardImage = (event) => {
  form.backCardImage = event.target.files[0]
}


const selectFrontCardSelfie = (event) => {
  form.frontCardSelfie = event.target.files[0]
}

const selectBackCardSelfie = (event) => {
  form.backCardSelfie = event.target.files[0]
}

const selectCardLimitScreenshot = (event) => {
  form.cardLimitScreenshot = event.target.files[0]
}


const selectedInput = ref('pixKey');

const inputLabels = {
  pixKey: 'Número Pix',
  pixcpf: 'CPF',
  phonenumber: 'Número de Telefone',
  email: 'Digite o e-mail',
  randomkey: 'Chave Aleatória'
};

const inputPlaceholders = {
  pixKey: 'Digite PixKey',
  pixcpf: 'Insira o CPF',
  phonenumber: 'Digite o NÚMERO DE TELEFONE',
  email: 'Digite o e-mail',
  randomkey: 'CHAVE ALEATÓRIA'
};

onMounted(() => {
  form.pixtype = 'pixcpf';
});

const radioClicked = (value) => {
  form.pixtype = value;
  if (value == 'pixtype') {
    form.pixdata = '';
    form.errors.pixdata = '';
  } else if (value == 'pixcpf') {
    form.pixdata = '';
    form.errors.pixdata = '';
  } else if (value == 'phonenumber') {
    form.pixdata = '';
    form.errors.pixdata = '';
  } else if (value == 'email') {
    form.pixdata = '';
    form.errors.pixdata = '';
  } else if (value == 'randomkey') {
    form.pixdata = '';
    form.errors.pixdata = '';
  }
}
</script>

<template>
  <AuthenticatedLayout>

    <Head title="Add Loan" />
    <!-- <div class="d-flex align-items-center justify-content-center px-2">
            <div class="w-100">
                <h1 class="mb-4 h4 font-weight-bold text-dark">Add Loan</h1>
                <form @submit.prevent="submit" enctype="multipart/form-data">
                    <h3 class="text-lg font-semibold mb-4">Loan Application Form</h3>
                    <div class="row">
                        <div class="mb-4 col-md-6">
                            <label for="applicant_id">Applicant Name<span class="text-red-500">*</span></label>
                            <select v-model="form.applicant_id" id="applicant_id" name="applicant_id"
                                class="form-select mt-1 block w-full">
                                <option :value="null" disabled>Select Name</option>
                                <option v-for="customer in prop.customers" :key="customer.id" :value="customer.id">
                                    {{ customer.name }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.applicant_id" />
                        </div>
                        <div class="mb-4 col-md-6">
                            <label for="loan_amount">Enter Loan Amount <span class="text-red-500">*</span></label>
                            <TextInput id="loan_amount" type="text" class="mt-1 block w-full" v-model="form.loan_amount"
                                autofocus min="1" autocomplete="loan_amount" />
                            <InputError class="mt-2" :message="form.errors.loan_amount" />
                        </div>



                        <div class="mb-4 col-md-6">
                            <label for="numberOfmonths">Number Of Months <span class="text-red-500">*</span></label>
                            <select v-model="form.numberOfmonths" id="numberOfmonths" name="numberOfmonths"
                                class="form-select mt-1 block w-full">
                                <option value="3">3 months</option>receiveLoanThrough
                                <option value="6">6 months</option>
                                <option value="9">9 months</option>
                                <option value="12">12 months</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.numberOfmonths" />
                        </div>
                    </div>

                    <h3 class="text-lg font-semibold mb-3 mt-2">Receive Loan Through</h3>
                    <div class="row">
                        <div class="mb-4 col-md-6">
                            <label for="receive-loan-through">Received Loan through <span class="text-red-500">*</span></label>
                            <select v-model="form.receiveLoanThrough" class="form-select mt-1 block w-full"
                                @change="checkType()">
                                <option value="0">Via Pix</option>
                                <option value="1">Via Wire Transfer</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.receiveLoanThrough" />
                        </div>
                    </div>
                    <div class="row">
                        <div v-if="form.receiveLoanThrough === '0'" class="mb-4 col-md-6">
                            <h3 class="text-lg font-semibold mb-4">Pix Key</h3>
                            <InputLabel for="pixKey" value="Pix Key:" />
                            <TextInput id="pixKey" type="text" class="mt-1 block w-full" v-model="form.pixKey"
                                autocomplete="pixKey" />
                            <InputError class="mt-2" :message="form.errors.pixKey" />
                        </div>
                    </div>

                        <div v-if="form.receiveLoanThrough === '1'" class="mb-4">
                            <h3 class="text-lg font-semibold mb-4">Enter Card Details</h3>
                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <InputLabel for="cardNumber" value="Card Number:" />
                                    <TextInput id="cardNumber" type="text" class="mt-1 block w-full" v-model="form.cardNumber"
                                        autocomplete="cardNumber" />
                                    <InputError class="mt-2" :message="form.errors.cardNumber" />
                                </div>
                                <div class="col-md-6">
                                    <InputLabel for="printedName" value="Printed Name:" />
                                    <TextInput id="printedName" type="text" class="mt-1 block w-full" v-model="form.printedName"
                                        autocomplete="printedName" />
                                    <InputError class="mt-2" :message="form.errors.printedName" />
                                </div>
                                <div class="col-md-6">
                                    <InputLabel for="date" value="Month / Year:" />
                                    <TextInput id="date" type="date" class="mt-1 block w-full" v-model="form.date"
                                        autocomplete="date" />
                                    <InputError class="mt-2" :message="form.errors.date" />
                                </div>
                            </div>
                        </div>

                    <h3 class="text-lg font-semibold mb-4">Document to Upload</h3>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="documentOption">Option to Select <span class="text-red-500">*</span></label>
                            <select v-model="form.documentOption" id="documentOption" @change="checkdocument()"
                                name="documentOption" class="form-select mt-1 block w-full">
                                <option value="ssn">SSN (Social Security Number)</option>
                                <option value="drivingLicense">Driving Licence</option>
                            </select>
                        </div>
                    </div>
                    <InputError class="mt-2" :message="form.errors.documentOption" />
                    <div v-if="form.documentOption === 'ssn'" class="mt-4 row">
                        <div class="col-md-6">
                            <InputLabel for="ssnFrontPhoto" value="Ssn Front Photo" />
                            <input type="file" @input="form.ssnFrontPhoto = $event.target.files[0]" />
                        </div>
                        <div class="col-md-6">
                            <InputLabel for="ssnBackPhoto" value="Ssn Back Photo" />
                            <input type="file" @input="form.ssnBackPhoto = $event.target.files[0]" />
                        </div>
                    </div>

                    <div v-if="form.documentOption === 'drivingLicense'" class="mt-4 row">
                        <div class="col-md-6">
                            <InputLabel for="dlFrontPhoto" value="Driving License Front Photo" />
                            <input type="file" @input="form.dlFrontPhoto = $event.target.files[0]" />
                            <InputError class="mt-2" :message="form.errors.dlFrontPhoto" />
                        </div>
                        <div class="col-md-6">
                            <InputLabel for="dlBackPhoto" value="Driving License Back Photo" />
                            <input type="file" @input="form.dlBackPhoto = $event.target.files[0]" />
                            <InputError class="mt-2" :message="form.errors.dlBackPhoto" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h3 class="text-lg font-semibold mb-4">Upload a selfie with the front Image of the Credit Card</h3>
                            <div class="mb-4">
                                <input type="file" @input="form.frontCardSelfie = $event.target.files[0]" />
                                <InputError class="mt-2" :message="form.errors.frontCardSelfie" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3 class="text-lg font-semibold mb-4">Upload a selfie with the back Image of the Credit Card</h3>
                            <div class="mb-4">
                                <input type="file" @input="form.backCardSelfie = $event.target.files[0]" />
                                <InputError class="mt-2" :message="form.errors.backCardSelfie" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3 class="text-lg font-semibold mb-4">Upload front Image of Credit Card</h3>
                            <div class="mb-4">

                                <input type="file" @input="form.frontCardImage = $event.target.files[0]" />
                                <InputError class="mt-2" :message="form.errors.frontCardImage" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3 class="text-lg font-semibold mb-4">Upload back Image of Credit Card</h3>
                            <div class="mb-4">

                                <input type="file" @input="form.backCardImage = $event.target.files[0]" />
                                <InputError class="mt-2" :message="form.errors.backCardImage" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>Upload a screenshot with the card limit</h5>

                            <input type="file" @input="form.cardLimitScreenshot = $event.target.files[0]" />
                            <InputError class="mt-2" :message="form.errors.cardLimitScreenshot" />
                        </div>
                        <div class="col-md-6">
                            <label for="limitAvailable">Limit Available <span class="text-red-500">*</span></label>
                            <TextInput id="limitAvailable" type="number" class="mt-1 block w-full" v-model="form.limitAvailable"
                                autocomplete="limitAvailable" />
                            <InputError class="mt-2" :message="form.errors.limitAvailable" />
                        </div>
                    </div>


                    <div class="mb-4">
                        <label for="receive-loan-through">Please Choose One</label>
                        <div>
                            <input type="radio" id="pixRadio" v-model="form.referralordiscount" value="0"
                                @change="referralCodeChange">
                            <label for="pixRadio">Referral Code</label>
                            &nbsp;
                            <input type="radio" id="wireTransferRadio" v-model="form.referralordiscount" value="1"
                                @change="referralDiscountChange">
                            <label for="wireTransferRadio">Discount Code</label>
                        </div>
                    </div>
                    <div v-if="form.referralordiscount === '0'" class="mb-4">
                        <InputLabel for="referralLink" value="Referral Link" />
                        <TextInput id="referralLink" placeholder="Enter Referral Link" type="text" class="mt-1 block w-full"
                            v-model="form.referralLink" autocomplete="referralLink" />
                        <InputError class="mt-2" :message="form.errors.referralLink" />
                        <br />
                    </div>
                    <div v-if="form.referralordiscount === '1'" class="mb-4">
                        <InputLabel for="discount_code" value="Discount Code" />
                        <TextInput id="discount_code" placeholder="Enter Discount Code" type="text"
                            class="mt-1 block w-full" v-model="form.discount_code" autocomplete="discount_code" />
                        <InputError class="mt-2" :message="form.errors.discount_code" />
                        <br />
                    </div>

                    <div class="mb-4">
                        <input type="checkbox" id="declarationCheckbox" v-model="form.declarationCheckbox" />
                        <label for="declarationCheckbox">I declare that the information submitted is accurate</label>
                        <input-error :message="form.errors.declarationCheckbox" />
                    </div>
                    <div class="text-right">
                        <button class="px-4 py-2 bg-blue-500   rounded-md"
                            enctype="multipart/form-data">Submit</button>
                    </div>
                    <br />
                </form>
        </div>
        </div> -->

        <div class="create-loan-section">
          <div class="row">
            <div class="col-lg-12">
              <form>
                <h3 class="main-heading-form mb-4 text-center" style="color: #000D37;">
                    Create new loan
                </h3>

                <div class="row">
                    <div class="col-md-6">
                        <div class="label-section mb-4 mt-2">
                            <label class=" mb-1" for="loan_amount">Applicant Name
                            <span class="text-red-500">*</span></label>
                                <select v-model="form.applicant_id" id="applicant_id" name="applicant_id"
                                    class="form-select mt-1 block w-full" placeholder="Select Name">
                                    <option :value="null" disabled>Select Name</option>
                                    <option v-for="customer in customers" :key="customer.id" :value="customer.id">
                                        {{ customer.name }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.applicant_id" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="label-section mb-4 mt-2">
                          <label class=" mb-1" for="loan_amount">Enter the loan amount
                            <span class="text-red-500">*</span></label>
                          <div class="input-area position-relative">

                            <TextInput id="loan_amount" placeholder="Enter the loan amount" type="text"
                              class="mt-1 block w-full" v-model="form.loan_amount" autofocus autocomplete="loan_amount" style="padding: 6px;" />
                          </div>
                          <InputError class="mt-2" :message="form.errors.loan_amount" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="label-section mb-4 mt-2">
                            <label class=" mb-1" for="loan_amount">EMI
                            <span class="text-red-500">*</span></label>
                            <select v-model="form.numberOfmonths" id="numberOfmonths" name="numberOfmonths" @change="getDetails()"
                                class="form-select mt-1 block w-full">
                                <option value="" disabled selected>
                                    Select the number of months
                                </option>
                                <option value="3">3 Months</option>
                                <!-- receiveLoanThrough -->
                                <option value="6">6 Months</option>
                                <option value="9">9 Months</option>
                                <option value="12">12 Months</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.numberOfmonths" />
                        </div>
                    </div>
                </div>











                <div class="mt-4 col-md-6 custom-toggle">
                  <div class="recieve-heading mb-3">
                    <h2 class=" ">Receive loan amount</h2>
                  </div>
                  <div class="flex items-center mb-2" style="gap: 20px;">
                    <span class=" ">Pix</span>

                    <Toggle id="receive-loan-through-toggle" labelledby="toggle-label" :classes="{
                      toggle: 'flex w-16 h-8 rounded-full relative cursor-pointer transition items-center box-content text-xs leading-none',
                      toggleOn: 'bg-sky-400 justify-start  ',
                      toggleOff: 'bg-sky-400 justify-end text-black-700',
                      label: 'text-center w-8 border-box whitespace-nowrap select-none',
                    }" true-value=1 false-value=0 v-model="form.isChecked" @change="checkType" />
                    <span class=" ">Bank transfer</span>
                  </div>
                  <InputError class="mt-2" :message="form.errors.status" />
                </div>



                <div v-if="form.receiveLoanThrough == '0'" class="my-4">
                  <div class="my-4 d-flex align-items-center flex-wrap gap-4">
                    <div class="d-flex align-items-center gap-1">
                      <input class="radio-link-btn" type="radio" id="pixcpfRadio" name="inputType" value="pixcpf"
                        v-model="form.pixtype" @click="radioClicked('pixcpf')">
                      <label class=" " for="pixcpfRadio">CPF</label>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                      <input class="radio-link-btn" type="radio" id="phoneNumberRadio" name="inputType"
                        value="phonenumber" v-model="form.pixtype" @click="radioClicked('phonenumber')">
                      <label class=" " for="phoneNumberRadio">Phone number</label>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                      <input class="radio-link-btn" type="radio" id="emailRadio" name="inputType" value="email"
                        v-model="form.pixtype" @click="radioClicked('email')">
                      <label class=" " for="emailRadio">Enter email</label>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                      <input class="radio-link-btn" type="radio" id="randomKeyRadio" name="inputType" value="randomkey"
                        v-model="form.pixtype" @click="radioClicked('randomkey')">
                      <label class=" " for="randomKeyRadio">Random Key</label>
                    </div>
                  </div>

                  <div class="my-4">
                    <label class=" " :for="form.pixtype">
                      {{ inputLabels[form.pixtype] }}
                      <span class="text-red-500">*</span>
                    </label>
                    <TextInput :id="form.pixtype" :placeholder="inputPlaceholders[form.pixtype]" type="text"
                      class="mt-1 block w-full" v-model="form.pixdata" :autocomplete="form.pixtype" />
                    <InputError class="mt-2" :message="form.errors.pixdata" />
                  </div>
                </div>




                <div v-if="form.receiveLoanThrough == '1'" class="mb-4 row">
                  <div class="my-2 col-md-6">
                    <label class=" " for="pixKey">
                        Bank code
                      <span class="text-red-500">*</span>
                    </label>
                    <TextInput id="bankcode" placeholder="Enter bank code" type="text" class="mt-1 block w-full"
                      v-model="form.bankcode" autocomplete="bankcode" />
                    <InputError class="mt-2" :message="form.errors.bankcode" />
                  </div>


                  <div class="my-2 col-md-6">
                    <label class=" " for="pixKey">
                        Agency Number
                      <span class="text-red-500">*</span>
                    </label>
                    <TextInput id="agencyNumber" placeholder="Enter the agency number" type="text"
                      class="mt-1 block w-full" v-model="form.agencyNumber" autocomplete="agencyNumber" />
                    <InputError class="mt-2" :message="form.errors.agencyNumber" />
                  </div>


                  <div class="my-2 col-md-6">

                    <label class="  " for="pixKey">
                        Current account number
                      <span class="text-red-500">*</span>
                    </label>
                    <TextInput placeholder="Enter current account number" id="currentAccountNumber" type="text"
                      class="mt-1 block w-full" v-model="form.currentAccountNumber" />
                    <InputError class="mt-2" :message="form.errors.currentAccountNumber" />
                  </div>



                  <div class="my-2 col-md-6">
                    <label class="  " for="cpf">
                      CPF (National ID Number) linked to account
                      <span class="text-red-500">*</span>
                    </label>
                    <TextInput placeholder="Insira o CPF" id="cpf" type="text" class="mt-1 block w-full"
                      v-model="form.cpf" />
                    <InputError class="mt-2" :message="form.errors.cpf" />
                  </div>

                </div>











                <div>
                  <h3 class=" ">Document to upload</h3>

                  <div class="d-flex align-items-center mt-3 document-uploads" style="gap: 20px">
                    <span class=" ">RG</span>
                    <Toggle id="documentOptionToggle" labelledby="documentOptionToggleLabel" :classes="{
                      toggle: 'flex w-16 h-8 rounded-full relative cursor-pointer transition items-center box-content text-xs leading-none',
                      toggleOn: 'bg-sky-400 justify-start  ',
                      toggleOff: 'bg-sky-400 justify-end text-black-700',
                      label: 'text-center w-8 border-box whitespace-nowrap select-none',
                    }" true-value="drivingLicense" false-value="ssn" v-model="form.documentOption"
                      @change="checkdocument">
                    </Toggle>
                    <span class=" ">Driver's license</span>
                  </div>


                  <div v-if="form.documentOption === 'drivingLicense'" class="mt-4">
                    <span class=" ">Driver's license</span>
                    <div class="row">

                      <div class="col-md-6 col-12 mb-3">
                        <div class="file-inputs" :class="{ 'selected': form.dlFrontPhoto }">
                          <i class="bi bi-camera"></i>
                          <div class="dotted-bg">
                            <i class="fa-regular fa-image"></i>
                            <p class="choose-para">Choose sss file</p>
                            <p class="file-type">(Format support - JPG, PNG, PDF)</p>
                            <p class="file-type">(Maximum file size - 20 MB)</p>
                            <input class="upload" type="file" @input="selectFrontImage" accept="image/jpeg, image/jpg" />
                            <!-- <p v-if="form.dlFrontPhoto" class=" mt-2 successfull-text">Image sent successfully</p> -->
                          </div>
                          <div v-if="form.dlFrontPhoto" class="successfull-text">
                            <i class="fa-solid fa-circle-check"></i>
                          </div>
                        </div>
                        <InputLabel class="  text-center mt-2" for="dlFrontPhoto"
                          value="Upload front photo" />
                        <InputError class="mt-2 text-center" :message="form.errors.dlFrontPhoto" />
                      </div>


                      <div class="col-md-6 col-12 mb-3">
                        <div class="file-inputs" :class="{ 'selected': form.dlBackPhoto }">
                          <i class="bi bi-camera"></i>
                          <div class="dotted-bg">
                            <i class="fa-regular fa-image"></i>
                            <p class="choose-para">Choose File</p>
                            <p class="file-type">(SFormat support - JPG, PNG, PDF)</p>
                            <p class="file-type">(Maximum file size - 20 MB)</p>
                            <input class="upload" type="file" @input="selectBackImage" accept="image/jpeg, image/jpg" />
                          </div>
                          <div v-if="form.dlBackPhoto" class="successfull-text">
                            <i class="fa-solid fa-circle-check"></i>
                          </div>
                          <!-- <p v-if="form.dlBackPhoto" class=" mt-2 successfull-text">Image sent successfully</p> -->
                        </div>
                        <InputLabel class="  text-center mt-2" for="dlBackPhoto"
                          value="Upload photo back" />
                        <InputError class="mt-2 text-center" :message="form.errors.dlBackPhoto" />
                      </div>
                    </div>
                  </div>

                  <div v-if="form.documentOption === 'ssn'" class="mt-4">
                    <span class=" ">RG</span>
                    <div class="row">

                      <!-- <div class="col-md-6 col-12">
                      <div class="file-inputs">
                        <i class="bi bi-camera"></i>
                        <div class="dotted-bg">
                          <i class="fa-regular fa-image"></i>
                          <p class="choose-para">Choose File</p>
                          <p class="file-type">(Format support - JPG, PNG, PDF)</p>
                          <p class="file-type">(Maximum file size - 20 MB)</p>
                          <input class="upload" type="file" @input="form.ssnFrontPhoto = $event.target.files[0]"
                            accept="image/jpeg, image/jpg" />
                        </div>
                      </div>
                      <InputLabel class="  text-center mt-2" for="ssnFrontPhoto" value="Upload Photo of Front" />
                      <InputError class="mt-2" :message="form.errors.ssnFrontPhoto" />
                    </div> -->

                      <div class="col-md-6 col-12 mb-3">
                        <div class="file-inputs" :class="{ 'selected': form.ssnFrontPhoto }">
                          <i class="bi bi-camera"></i>
                          <div class="dotted-bg">
                            <i class="fa-regular fa-image"></i>
                            <p class="choose-para">Choose File</p>
                            <p class="file-type">(Format support - JPG, PNG, PDF)</p>
                            <p class="file-type">(Maximum file size - 20 MB)</p>
                            <input class="upload" type="file" @input="selectssnFrontImage"
                              accept="image/jpeg, image/jpg" />
                          </div>
                          <div v-if="form.ssnFrontPhoto" class="successfull-text">
                            <i class="fa-solid fa-circle-check"></i>
                          </div>
                          <!-- <p v-if="form.ssnFrontPhoto" class=" mt-2 successfull-text">Image sent successfully</p> -->
                        </div>
                        <InputLabel class="  text-center mt-2" for="ssnFrontPhoto"
                          value="Upload front photo" />
                        <InputError class="mt-2 text-center" :message="form.errors.ssnFrontPhoto" />
                      </div>


                      <!-- <div class="col-md-6 col-12">
                      <div class="file-inputs">
                        <i class="bi bi-camera"></i>
                        <div class="dotted-bg">
                          <i class="fa-regular fa-image"></i>
                          <p class="choose-para">Choose File</p>
                          <p class="file-type">(Format support - JPG, PNG, PDF)</p>
                          <p class="file-type">(Maximum file size - 20 MB)</p>
                          <input class="upload" type="file" @input="form.ssnBackPhoto = $event.target.files[0]"
                            accept="image/jpeg, image/jpg" />
                        </div>
                      </div>
                      <InputLabel class="  text-center mt-2" for="ssnBackPhoto" value="Upload Photo of back" />
                      <InputError class="mt-2" :message="form.errors.ssnBackPhoto" />
                    </div> -->


                      <div class="col-md-6 col-12 mb-3">
                        <div class="file-inputs" :class="{ 'selected': form.ssnBackPhoto }">
                          <i class="bi bi-camera"></i>
                          <div class="dotted-bg">
                            <i class="fa-regular fa-image"></i>
                            <p class="choose-para">Choose File</p>
                            <p class="file-type">(Format support - JPG, PNG, PDF)</p>
                            <p class="file-type">(Maximum file size - 20 MB)</p>
                            <input class="upload" type="file" @input="selectssnBackImage"
                              accept="image/jpeg, image/jpg" />
                          </div>
                          <div v-if="form.ssnBackPhoto" class="successfull-text">
                            <i class="fa-solid fa-circle-check"></i>
                          </div>
                          <!-- <p v-if="form.ssnBackPhoto" class=" mt-2 successfull-text"><span><i
                              class="bi bi-check-circle-fill"></i></span> Imagem enviada com sucesso</p> -->
                        </div>
                        <InputLabel class="  text-center mt-2" for="ssnBackPhoto"
                          value="Upload photo back" />
                        <InputError class="mt-2 text-center" :message="form.errors.ssnBackPhoto" />
                      </div>


                    </div>
                  </div>




                </div>

                <!-- DONE -->






                <h3 class=" ">Upload credit card details</h3>
                <div class="row">
                  <div class="col-md-6">
                    <div class="my-3 ">
                      <InputLabel class="d-inline input-label-new" for="cardNumber" value="Card number" /><span
                        class="text-danger"> *</span>
                      <TextInput id="cardNumber" placeholder="Enter card details" type="text"
                        class="mt-1 block w-full" v-model="form.cardNumber" autocomplete="cardNumber" />
                      <InputError class="mt-2" :message="form.errors.cardNumber" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="my-3">
                      <InputLabel class="input-label-new d-inline" for="date" value="Expiration date"
                        placeholder="Expiration date" /><span class="text-danger"> *</span>
                      <TextInput id="date" type="month" class="mt-1 block w-full" v-model="form.date"
                        autocomplete="date" />
                      <InputError class="mt-2" :message="form.errors.date" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="my-3">
                      <InputLabel class="input-label-new  d-inline" for="cvv" value="Cvv" /><span class="text-danger"> *</span>
                      <TextInput id="cvv" type="text" class="mt-1 block w-full" v-model="form.cvv"
                        placeholder="Type cvv" />
                      <InputError class="mt-2" :message="form.errors.cvv" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="my-3">
                      <InputLabel class="input-label-new  d-inline" for="printedName" value="Printed name" /> <span
                        class="text-danger">*</span>
                      <TextInput id="printedName" placeholder="Enter the printed name" type="text" class="mt-1 block w-full"
                        v-model="form.printedName" autocomplete="printedName" />
                      <InputError class="mt-2" :message="form.errors.printedName" />
                    </div>
                  </div>
                </div>

                <hr class="my-5 card-detail-hr" />
                <h5 class=" ">Credit card images</h5>
                <div class="row my-2">


                  <!-- <div class="col-md-6 col-12">
                    <div class="file-inputs">
                        <i class="bi bi-camera"></i>
                        <div class="dotted-bg">
                          <i class="fa-regular fa-image"></i>
                          <p class="choose-para">Choose File</p>
                          <p class="file-type">(Format support - JPG, PNG, PDF)</p>
                          <p class="file-type">(Maximum file size - 20 MB)</p>
                          <input class="upload" type="file" @input="
                              form.frontCardImage = $event.target.files[0]
                              " accept="image/jpeg, image/jpg" />
                        </div>
                      </div>
                      <div class="text-center">
                        <label class="  mt-2" for="frontCardImage">Upload front photo of credit card
                          <span class="text-red-500">*</span></label>
                      </div>
                        <InputError class="mt-2" :message="form.errors.frontCardImage" />
                  </div> -->

                  <div class="col-md-6 col-12 mb-3">
                    <div class="file-inputs" :class="{ 'selected': form.frontCardImage }">
                      <i class="bi bi-camera"></i>
                      <div class="dotted-bg">
                        <i class="fa-regular fa-image"></i>
                        <p class="choose-para">Choose File</p>
                        <p class="file-type">(Format support- JPG, PNG, PDF)</p>
                        <p class="file-type">(Maximum file size - 20 MB)</p>
                        <input class="upload" type="file" @input="selectFrontCardImage" accept="image/jpeg, image/jpg" />
                        <!-- <p v-if="form.frontCardImage" class=" mt-2 successfull-text">Image sent successfully</p> -->
                      </div>
                      <div v-if="form.frontCardImage" class="successfull-text">
                        <i class="fa-solid fa-circle-check"></i>
                      </div>
                    </div>
                    <div class="text-center">
                      <label class="  mt-2" for="frontCardImage">Upload front photo of credit card<span
                          class="text-red-500">*</span></label>
                    </div>
                    <InputError class="mt-2 text-center" :message="form.errors.frontCardImage" />
                  </div>


                  <!-- <div class="col-md-6">
                    <div class="file-inputs">
                        <i class="bi bi-camera"></i>
                        <div class="dotted-bg">
                          <i class="fa-regular fa-image"></i>
                          <p class="choose-para">Choose File</p>
                          <p class="file-type">(Format support - JPG, PNG, PDF)</p>
                          <p class="file-type">(Maximum file size - 20 MB)</p>
                          <input class="upload" type="file" @input="form.backCardImage = $event.target.files[0]"
                    accept="image/jpeg, image/jpg" />
                        </div>
                      </div>
                      <div class="text-center">
                        <label class="   mt-2" for="backCardImage">Re-upload credit card photo
                      <span class="text-red-500">*</span></label>
                      </div>
                  <InputError class="mt-2" :message="form.errors.backCardImage" />
                  </div> -->


                  <div class="col-md-6 col-12 mb-3">
                    <div class="file-inputs" :class="{ 'selected': form.backCardImage }">
                      <i class="bi bi-camera"></i>
                      <div class="dotted-bg">
                        <i class="fa-regular fa-image"></i>
                        <p class="choose-para">Choose File</p>
                        <p class="file-type">(Format support - JPG, PNG, PDF)</p>
                        <p class="file-type">(Maximum file size - 20 MB)</p>
                        <input class="upload" type="file" @input="selectBackCardImage" accept="image/jpeg, image/jpg" />
                        <!-- <p  class=" mt-2 successfull-text">Image sent successfully</p> -->
                      </div>
                      <div v-if="form.backCardImage" class="successfull-text">
                        <i class="fa-solid fa-circle-check"></i>
                      </div>
                    </div>
                    <div class="text-center">
                      <label class="  mt-2" for="backCardImage">Upload the back photo of card
                        credit<span class="text-red-500">*</span></label>
                    </div>
                    <InputError class="mt-2 text-center" :message="form.errors.backCardImage" />
                  </div>
                  <!-- <div class="col-md-6 mt-4">
                    <div class="file-inputs">
                        <i class="bi bi-camera"></i>
                        <div class="dotted-bg">
                          <i class="fa-regular fa-image"></i>
                          <p class="choose-para">Choose File</p>
                          <p class="file-type">(Suporte de formato - JPG, PNG, PDF)</p>
                          <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                          <input class="upload" type="file" @input="form.frontCardSelfie = $event.target.files[0]"
                  accept="image/jpeg, image/jpg" />
                        </div>
                      </div>
                      <div class="text-center">
                        <label class="   mt-2" for="frontCardSelfie">Upload selfie with credit card front photo
                          <span class="text-red-500">*</span></label>
                      </div>
                      <InputError class="mt-2" :message="form.errors.frontCardSelfie" accept="image/jpeg, image/jpg" />
                  </div> -->

                  <div class="col-md-6 col-12 mb-3">
                    <div class="file-inputs" :class="{ 'selected': form.frontCardSelfie }">
                      <i class="bi bi-camera"></i>
                      <div class="dotted-bg">
                        <i class="fa-regular fa-image"></i>
                        <p class="choose-para">Choose File</p>
                        <p class="file-type">(Format support- JPG, PNG, PDF)</p>
                        <p class="file-type">(Maximum file size - 20 MB)</p>
                        <input class="upload" type="file" @input="selectFrontCardSelfie" accept="image/jpeg, image/jpg" />
                        <!-- <p  class=" mt-2 successfull-text">Image sent successfully</p> -->
                      </div>
                      <div v-if="form.frontCardSelfie" class="successfull-text">
                        <i class="fa-solid fa-circle-check"></i>
                      </div>
                    </div>
                    <div class="text-center">
                      <label class="  mt-2" for="frontCardSelfie">
Upload selfie with front photo from card
                        credit<span class="text-red-500">*</span></label>
                    </div>
                    <InputError class="mt-2 text-center" :message="form.errors.frontCardSelfie"
                      accept="image/jpeg, image/jpg" />
                  </div>


                  <!-- <div class="col-md-6 mt-4">
                    <div class="file-inputs">
                        <i class="bi bi-camera"></i>
                        <div class="dotted-bg">
                          <i class="fa-regular fa-image"></i>
                          <p class="choose-para">Choose File</p>
                          <p class="file-type">(Format support - JPG, PNG, PDF)</p>
                          <p class="file-type">(Maximum file size - 20 MB)</p>
                          <input class="upload" type="file" @input="form.backCardSelfie = $event.target.files[0]" accept="image/jpeg, image/jpg" />
                        </div>
                      </div>
                      <div class="text-center">
                        <label class="   mt-2" for="backCardSelfie">Upload selfie with credit card back image
                          <span class="text-red-500">*</span></label>
                      </div>
                      <InputError class="mt-2" :message="form.errors.backCardSelfie" />
                  </div> -->

                  <div class="col-md-6 col-12 mb-3">
                    <div class="file-inputs " :class="{ 'selected': form.backCardSelfie }">
                      <i class="bi bi-camera"></i>
                      <div class="dotted-bg">
                        <i class="fa-regular fa-image"></i>
                        <p class="choose-para">Choose File</p>
                        <p class="file-type">(Format support- JPG, PNG, PDF)</p>
                        <p class="file-type">(Maximum file size - 20 MB)</p>
                        <input class="upload" type="file" @input="selectBackCardSelfie" accept="image/jpeg, image/jpg" />
                        <!-- <p v-if="form.backCardSelfie" class=" mt-2 successfull-text">Image sent successfully</p> -->
                      </div>
                      <div v-if="form.backCardSelfie" class="successfull-text">
                        <i class="fa-solid fa-circle-check"></i>
                      </div>
                    </div>
                    <div class="text-center">
                      <label class="  mt-2" for="backCardSelfie">Upload selfie with card back image
                        credit<span class="text-red-500">*</span></label>
                    </div>
                    <InputError class="mt-2 text-center" :message="form.errors.backCardSelfie" />
                  </div>


                </div>
                <hr class="my-5 card-detail-hr" />

                <div class="mb-4">
                  <h5 class=" ">Credit limit screenshot</h5>
                  <div class="row mt-2">


                    <!-- <div class="col-md-6">
                      <div class="file-inputs">
                        <i class="bi bi-camera"></i>
                        <div class="dotted-bg">
                          <i class="fa-regular fa-image"></i>
                          <p class="choose-para">Choose File</p>
                          <p class="file-type">(Format support - JPG, PNG, PDF)</p>
                          <p class="file-type">(Maximum file size - 20 MB)</p>
                          <input class="upload" type="file" @input="
                    form.cardLimitScreenshot =
                    $event.target.files[0]
                    " accept="image/jpeg, image/jpg" />
                        </div>
                      </div>
                      <div class="text-center">
                        <label class="  mt-2" for="cardLimitScreenshot">Upload a screenshot of your card limit
                          <span class="text-red-500">*</span></label>
                          <InputError class="mt-2" :message="form.errors.cardLimitScreenshot" />
                      </div>
                    </div> -->

                    <div class="col-md-6 col-12 mb-3">
                      <div class="file-inputs" :class="{ 'selected': form.cardLimitScreenshot }">
                        <i class="bi bi-camera"></i>
                        <div class="dotted-bg">
                          <i class="fa-regular fa-image"></i>
                          <p class="choose-para">Choose File</p>
                          <p class="file-type">(Format support - JPG, PNG, PDF)</p>
                          <p class="file-type">(Maximum file size- 20 MB)</p>
                          <input class="upload" type="file" @input="selectCardLimitScreenshot"
                            accept="image/jpeg, image/jpg" />
                          <!-- <p v-if="form.cardLimitScreenshot" class=" mt-2 successfull-text">Image sent successfully</p> -->
                        </div>
                        <div v-if="form.cardLimitScreenshot" class="successfull-text">
                          <i class="fa-solid fa-circle-check"></i>
                        </div>
                      </div>
                      <div class="text-center">
                        <label class="  mt-2" for="cardLimitScreenshot">Upload a screenshot with the
                          card limit<span class="text-red-500">*</span></label>
                        <InputError class="mt-2 text-center" :message="form.errors.cardLimitScreenshot" />
                      </div>
                    </div>

                  </div>
                  <div class="my-4">
                    <label class=" " for="limitAvailable">Limit available on credit card
                      <span class="text-red-500">*</span></label>
                    <TextInput id="limitAvailable" placeholder="Enter the available limit" type="number"
                      class="mt-1 block w-full" v-model="form.limitAvailable" autocomplete="limitAvailable" />
                    <InputError class="mt-2" :message="form.errors.limitAvailable" />
                  </div>
                </div>




                <!-- Start -->
                <div v-if="!$page.props.auth.user">
                  <div class="col-md-12">
                    <div class="my-3">
                      <InputLabel class=" " for="email" value="Enter email to register user" />
                      <TextInput id="email" placeholder="Enter email" type="email" class="mt-1 block w-full"
                        v-model="form.eemail" autocomplete="eemail" />
                      <InputError class="mt-2" :message="form.errors.eemail" />
                    </div>
                  </div>


                  <div class="col-md-12">
                    <div class="my-3">
                      <InputLabel class=" " for="password" value="Password" />
                      <TextInput id="password" placeholder="Type the password" type="password" class="mt-1 block w-full"
                        v-model="form.password" autocomplete="password" />
                      <InputError class="mt-2" :message="form.errors.password" />
                    </div>
                  </div>

                  <!-- <div class="col-md-12">
                    <div class="my-3">
                        <InputLabel class=" " for="confirm_password" value="Confirm Password" />
                        <TextInput id="confirm_password" placeholder="Confirm Password" type="password" class="mt-1 block w-full"
                                v-model="form.confirm_password" autocomplete="new-password" />
                        <InputError class="mt-2" :message="form.errors.confirm_password" />
                    </div>
                    </div> -->
                </div>
                <!-- End -->

                <div class="checkbox-loan d-flex align-items-center">
                  <input type="checkbox" id="declarationCheckbox" v-model="form.declarationCheckbox" />
                  <label class="  px-3" for="declarationCheckbox">
                    Concordo <a target="_blank" href="/term-condition">Termos de uso</a> e <a target="_blank"
                      href="/privacy-policy">Política de Privacidade.</a></label>
                </div>
                <input-error :message="form.errors.declarationCheckbox" />
                <div class="row mt-4" style="gap: 20px">
                  <!-- <button class="banner-link-next text-center" enctype="multipart/form-data">
                    CONFIRM
                  </button> -->
                  <button @click="submit" class="banner-link-next text-center  " type="button"
                    :disabled="isLoading">
                    <span v-if="isLoading" class="spinner-border spinner-border-sm" role="status"
                      aria-hidden="true"></span>
                    <span v-else>CONFIRME</span>
                  </button>

                  <button @click.prevent="prevStep" class="back-btn">
                  Voltar
                </button>
              </div>
              <br />

            </form>
          </div>
        </div>
        </div>
</AuthenticatedLayout>

</template>

<style scoped>
.banner-link-next {
    border: 1px solid #2cbcdd;
}

.banner-link-next:hover {
    border: 1px solid #2cbcdd;
    color: #2cbcdd !important;
}

.checkbox-loan label a {
    color: #000D37;
}

.input-label-new {
    color: #000D37 !important;
}

.back-btn {
    width: fit-content;
}

.selected {
    background-color: #2cbcdd;
    color: #fff;
}
</style>

