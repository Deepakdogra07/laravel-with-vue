<script setup>
import NavLink from "@/Components/NavLink.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import axios from "axios";
import { router } from "@inertiajs/vue3";
import { useToast } from "vue-toastify";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import Footer from "../../Frontend/footer.vue";
import { ref, onMounted, getCurrentInstance, computed, watch } from 'vue';
import { nextTick } from 'vue';
import { watchEffect } from 'vue';
import Modal from '../../../Components/Modal.vue'
import { usePage } from '@inertiajs/inertia-vue3'

const $page = usePage();
console.log($page.props.user,'auth')

const showText = ref(false);

const hideModal = () => {
    showText.value = true;
    showModal.value = !showModal.value;
}


const showModal = ref(false)

const isLoading = ref(false);

const showingNavigationDropdown = ref(false);

const maxSteps = 5;

const nextStepModel = () => {
    showModal.value = !showModal.value
    nextStep();
}

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
        errors.pixdata = "A Chave CPF deve ser um número";
      } else if (!/^[a-zA-Z0-9]+$/.test(form.pixdata)) {
        errors.pixdata = "A Chave CPF deve ser alfanumérica";
      } else if (/\s/.test(form.pixdata)) {
        errors.pixdata = "A Chave CPF não deve conter espaços em branco";
      } else if (parseInt(form.pixdata) <= 0) {
        errors.pixdata = "A Chave CPF deve ser um número positivo";
      } else if (form.pixdata.length !== 11) {
        errors.pixdata = "A Chave CPF deve ter 11 dígitos";
      }
    }





    if (form.pixtype === 'phonenumber') {
      if (!form.pixdata) {
        errors.pixdata = "Este campo é obrigatório";
        console.log('hello !', errors.pixdata);
      } else if (/\s/.test(form.pixdata)) {
        errors.pixdata = "O número de telefone não deve conter espaços em branco";
      } else if (!/^\d{11}$/.test(form.pixdata)) {
        errors.pixdata = "O número de telefone deve conter 11 dígitos";
      } else if (parseInt(form.pixdata) <= 0) {
        errors.pixdata = "O número de telefone deve ser maior que zero";
      }
    }


    // if (form.pixtype == 'email') {
    //     if (!form.pixdata) {
    //      errors.pixdata = "Este campo é obrigatório";
    //    }
    // }

    if (form.pixtype === 'email') {
      if (!form.pixdata) {
        errors.pixdata = "Este campo é obrigatório";
      } else if (!/\S+@\S+\.\S+/.test(form.pixdata)) {
        errors.pixdata = "O endereço de email é inválido";
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

const props = defineProps({ interest_rate: Number, referralCode: String, discountcodevalue: String , discountcode : String, isUserLoggedIn: Boolean })

// onMounted(()=>{
//     alert(props.discountcode);
// })

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
  referralLink: props.referralCode ? props.referralCode : '',
  documents_id: "",
  referralordiscount: "",
  discountcodevalue : props.discountcodevalue ? props.discountcodevalue : '',
  discount_code : props.discountcode ? props.discountcode : '',
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
  phone_number : '',
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
  form.post(`/loan/store/record`, {
    onSuccess: (page) => {
      toast("Empréstimo aplicado com sucesso!", {
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
  getDetails();
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

// Esko Uncomment krna pad skta hai

// watch(() => form.loan_amount, (oldValue, newValue) => {
//   if (oldValue != newValue) {
//     console.log(oldValue);
//     getDetails();
//   }
// });

const debounce = (func, delay) => {
  let timeoutId;
  return (...args) => {
    clearTimeout(timeoutId);
    timeoutId = setTimeout(() => {
      func(...args);
    }, delay);
  };
};


const debouncedSubmit = debounce(getDetails, 500);

// Esko Uncomment krna pad skta hai



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


const loader = "loader.gif";

</script>
<template>
     <Head title="Aplicar empréstimo" />
  <div class="create-loan-sec">
    <div class="about-us-bg-wrapper">
      <div class="container">
        <div class="logo-main">
          <Link href="/"><img src="images/instant-loan-logo.png" alt=""></Link>
        </div>
        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">A
          {{ status }}
        </div>
      </div>
    </div>
  </div>
  <div class="bg-dark-blue">
    <div class="container">
      <div class="create-loan-section">
        <div class="row">
          <div class="col-lg-12">
            <form @submit.prevent="submit()" class="form-section-main" enctype="multipart/form-data">
              <h3 class="main-heading-form mb-4 text-center">
                Criar novo empréstimo
              </h3>
              <div class="progress-bar-section py-4">
                <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0"
                  aria-valuemax="100">
                  <div class="progress-bar" :style="{ width: progressBarWidth }"></div>
                </div>
              </div>

              <div v-if="currentStep === 0">
                <div class="label-section mb-4 mt-2">
                  <label class="text-white mb-2" for="loan_amount">Insira o valor do empréstimo
                    <span class="text-red-500">*</span></label>
                  <div class="input-area position-relative">
                    <button @click.prevent="nextStep"><i class="fa-solid fa-arrow-right"></i></button>


                    <TextInput id="loan_amount" placeholder="Insira o valor do empréstimo" type="text"
                      class="mt-1 block w-full" v-model="form.loan_amount" @input="debouncedSubmit"
                      autocomplete="loan_amount" />
                  </div>
                  <InputError class="mt-2" :message="form.errors.loan_amount" />
                </div>

                <div class="amount-btns mt-5">
                  <div class="row">
                    <div class="col-md-3 col-6">
                      <a @click.prevent="setLoanAmount(200)" class="amout-added">
                        R$  200,00
                      </a>

                    </div>
                    <div @click.prevent="setLoanAmount(10000)" class="col-md-3 col-6">
                      <a class="amout-added">
                        R$ 10.000,00
                      </a>
                    </div>
                    <div class="col-md-3 col-6">
                      <a @click.prevent="setLoanAmount(25000)" class="amout-added">
                        R$ 25.000,00
                      </a>
                    </div>
                    <div class="col-md-3 col-6">
                      <a @click.prevent="setLoanAmount(50000)" class="amout-added">
                        R$ 50.000,00
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row emi-form" v-if="currentStep === 1">
                <div class="col-lg-5 col-12 mb-3">
                  <label class="mb-4" for="numberOfmonths">Parcelas por mês
                    <span class="text-red-500">*</span></label>
                  <select v-model="form.numberOfmonths" id="numberOfmonths" name="numberOfmonths" @change="getDetails()"
                    class="form-select mt-1 block w-full">
                    <option value="" disabled selected>
                      Selecione o número de mês
                    </option>
                    <option value="3">3 mês</option>
                    receiveLoanThrough
                    <option value="6">6 mês</option>
                    <option value="9">9 mês</option>
                    <option value="12">12 mês</option>
                  </select>
                  <InputError class="mt-2" :message="form.errors.numberOfmonths" />
                  <div class="d-flex flex-column mt-4" style="gap: 15px;">

                    <button v-if="!isUserLoggedIn" @click.prevent="nextStep" class="banner-link-next text-center">
                       PRÓXIMO
                    </button>

                    <span v-else class="banner-link cursor-pointer text-center" @click="showModal = !showModal">
                        PRÓXIMO
                    </span>

                    <button @click.prevent="prevStep" class="px-4 py-2 text-white back-btn">
                      Voltar
                    </button>
                    <p v-if="showText" style="color:red">
                        Infelizmente não temos o valor disponível no seu cartão de crédito,
                         ainda não temos linha de crédito disponível para outros formatos.
                    </p>
                  </div>
                </div>
                <div class="col-lg-1 special-gap"></div>
                <div class="col-lg-6 col-12">
                  <div class="emi-calculation">
                    <h3 class="text-center mb-2">Parcelas por mês</h3>


                    <h2 class="text-center">
                      {{ new Intl.NumberFormat('pt-BR', {
                        style: 'currency', currency: 'BRL', minimumFractionDigits: 2
                      }).format(form.emi) }}

                      <span>/Por mês</span>
                    </h2>


                    <div class="emi-record-chart row mt-3">
                      <div class="col-md-8 col-8">
                        <p>Valor</p>
                      </div>
                      <div class="col-md-4 col-4">
                        <!-- <p>${{ form.loan_amount }}</p> -->
                        <p>{{ new Intl.NumberFormat('pt-BR', {
                          style: 'currency', currency: 'BRL', minimumFractionDigits:
                            2
                        }).format(form.loan_amount) }}</p>

                      </div>
                      <div class="col-md-8 col-8">
                        <!-- <p>Interest Amount ({{ props.interest_rate ? props.interest_rate + '%' : '5%' }})</p> -->
                        <p>Juros ({{ props.interest_rate ? new Intl.NumberFormat('pt-BR', {
                          style: 'percent',
                          minimumFractionDigits: 2
                        }).format(props.interest_rate / 100) : new Intl.NumberFormat('pt-BR', {
                          style: 'percent', minimumFractionDigits: 2
                        }).format(0.05) }})</p>
                      </div>
                      <div class="col-md-4 col-4">
                        <!-- <p>${{ form.total_interest }}</p> -->
                        <p>{{ new Intl.NumberFormat('pt-BR', {
                          style: 'currency', currency: 'BRL', minimumFractionDigits:
                            2
                        }).format(form.total_interest) }}</p>

                      </div>
                      <!-- <div class="col-md-8 col-8">
                        <p>Tax</p>
                      </div>
                      <div class="col-md-4 col-4">
                        <p>
                            $1000
                        </p>
                      </div> -->
                    </div>
                    <hr class="emi-hrline">
                    <div class="total-emi row">
                      <div class="col-md-8 col-7">
                        <p>Montante total</p>
                      </div>
                      <div class="col-md-4 col-5">
                        <!-- {{ form.total_payment + 1000 }} -->
                        <h4>
                        {{ new Intl.NumberFormat('pt-BR', {
                          style: 'currency', currency: 'BRL', minimumFractionDigits: 2
                        }).format(form.total_payment) }}
                        </h4>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- <div class="emi-limit text-center text-white mt-4">
                  <p>(Você deve ter um $20k limite disponível no seu cartão)</p>
                </div> -->
              </div>



              <div v-if="currentStep === 2">
                <div class="mt-4 col-md-6 custom-toggle">
                  <div class="recieve-heading mb-3">
                    <h2 class="text-white">Receber valor do empréstimo</h2>
                  </div>
                  <div class="flex items-center mb-2" style="gap: 20px;">
                    <span class="text-white">Pix</span>

                    <Toggle id="receive-loan-through-toggle" labelledby="toggle-label" :classes="{
                      toggle: 'flex w-16 h-8 rounded-full relative cursor-pointer transition items-center box-content text-xs leading-none',
                      toggleOn: 'bg-sky-400 justify-start text-white',
                      toggleOff: 'bg-sky-400 justify-end text-black-700',
                      label: 'text-center w-8 border-box whitespace-nowrap select-none',
                    }" true-value=1 false-value=0 v-model="form.isChecked" @change="checkType" />
                    <span class="text-white">Transferência bancária</span>
                  </div>
                  <InputError class="mt-2" :message="form.errors.status" />
                </div>



                <div v-if="form.receiveLoanThrough == '0'" class="my-4">
                            <div class="my-4 d-flex align-items-center flex-wrap gap-4">
                                <div class="d-flex align-items-center gap-1">
                                    <input class="radio-link-btn" type="radio" id="pixcpfRadio" name="inputType" value="pixcpf" v-model="form.pixtype" @click="radioClicked('pixcpf')">
                                    <label class="text-white" for="pixcpfRadio">CPF</label>
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <input class="radio-link-btn" type="radio" id="phoneNumberRadio" name="inputType" value="phonenumber" v-model="form.pixtype" @click="radioClicked('phonenumber')">
                                    <label class="text-white" for="phoneNumberRadio">Número de Telefone</label>
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <input class="radio-link-btn" type="radio" id="emailRadio" name="inputType" value="email" v-model="form.pixtype" @click="radioClicked('email')">
                                    <label class="text-white" for="emailRadio">Digite o e-mail</label>
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <input class="radio-link-btn" type="radio" id="randomKeyRadio" name="inputType" value="randomkey" v-model="form.pixtype" @click="radioClicked('randomkey')">
                                    <label class="text-white" for="randomKeyRadio">Chave Aleatória</label>
                                </div>
                            </div>

                            <div class="my-4">
                            <label class="text-white" :for="form.pixtype">
                                {{ inputLabels[form.pixtype] }}
                                <span class="text-red-500">*</span>
                            </label>
                            <TextInput :id="form.pixtype" :placeholder="inputPlaceholders[form.pixtype]" type="text" class="mt-1 block w-full" v-model="form.pixdata" :autocomplete="form.pixtype" />
                            <InputError class="mt-2" :message="form.errors.pixdata" />
                            </div>
                </div>









                <div v-if="form.receiveLoanThrough == '1'" class="mb-4">
                  <div class="my-4">
                    <label class="text-white" for="pixKey">
                      Código bancário
                      <span class="text-red-500">*</span>
                    </label>
                    <TextInput id="bankcode" placeholder="Digite o código do banco" type="text" class="mt-1 block w-full"
                      v-model="form.bankcode" autocomplete="bankcode" />
                    <InputError class="mt-2" :message="form.errors.bankcode" />
                  </div>


                  <div>
                    <label class="text-white" for="pixKey">
                      Número da agência
                      <span class="text-red-500">*</span>
                    </label>
                    <TextInput id="agencyNumber" placeholder="Insira o número da agência" type="text"
                      class="mt-1 block w-full" v-model="form.agencyNumber" autocomplete="agencyNumber" />
                    <InputError class="mt-2" :message="form.errors.agencyNumber" />
                  </div>


                  <div class="my-4">

                    <label class="text-white " for="pixKey">
                      Número da conta corrente
                      <span class="text-red-500">*</span>
                    </label>
                    <TextInput placeholder="Insira o número da conta atual" id="currentAccountNumber" type="text"
                      class="mt-1 block w-full" v-model="form.currentAccountNumber" />
                    <InputError class="mt-2" :message="form.errors.currentAccountNumber" />
                  </div>



                  <div class="my-4">
                    <label class="text-white " for="cpf">
                      CPF (Número de Identificação Nacional) vinculado à conta
                      <span class="text-red-500">*</span>
                    </label>
                    <TextInput placeholder="Insira o CPF" id="cpf" type="text" class="mt-1 block w-full"
                      v-model="form.cpf" />
                    <InputError class="mt-2" :message="form.errors.cpf" />
                  </div>

                </div>

                <div class="d-flex flex-column" style="gap: 20px;">



                  <button @click.prevent="nextStep" class="banner-link-next text-center">
                    PRÓXIMO
                  </button>







                  <button @click.prevent="prevStep" class="text-white back-btn">
                    Voltar
                  </button>
                </div>
              </div>



              <div v-if="currentStep === 3">
                <h3 class="text-white">Documento para upload</h3>
                <div class="d-flex align-items-center mt-3 document-uploads" style="gap: 20px">
                  <span class="text-white">RG</span>
                  <Toggle id="documentOptionToggle" labelledby="documentOptionToggleLabel" :classes="{
                    toggle: 'flex w-16 h-8 rounded-full relative cursor-pointer transition items-center box-content text-xs leading-none',
                    toggleOn: 'bg-sky-400 justify-start text-white',
                    toggleOff: 'bg-sky-400 justify-end text-black-700',
                    label: 'text-center w-8 border-box whitespace-nowrap select-none',
                  }" true-value="drivingLicense" false-value="ssn" v-model="form.documentOption"
                    @change="checkdocument">
                  </Toggle>
                  <span class="text-white">Carteira de motorista</span>
                </div>


                <div v-if="form.documentOption === 'drivingLicense'" class="mt-4">
                  <span class="text-white">Carteira de motorista</span>
                  <div class="row">




                    <div class="col-md-6 col-12 mb-3">
                      <div class="file-inputs" :class="{ 'selected': form.dlFrontPhoto }">
                        <i class="bi bi-camera"></i>
                        <div class="dotted-bg">
                          <i class="fa-regular fa-image"></i>
                          <p class="choose-para">Escolher arquivo sss</p>
                          <p class="file-type">(Suporte de formato - JPG, PNG, PDF)</p>
                          <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                          <input class="upload" type="file" @input="selectFrontImage" accept="image/jpeg, image/jpg" />
                          <!-- <p v-if="form.dlFrontPhoto" class=" mt-2 successfull-text">Imagem enviada com sucesso</p> -->
                        </div>
                        <div v-if="form.dlFrontPhoto"  class="successfull-text">
                          <i class="fa-solid fa-circle-check"></i>
                        </div>
                      </div>
                      <InputLabel class="text-white text-center mt-2" for="dlFrontPhoto" value="Carregar foto da frente" />
                      <InputError class="mt-2 text-center" :message="form.errors.dlFrontPhoto" />
                    </div>







                    <div class="col-md-6 col-12 mb-3">
                      <div class="file-inputs" :class="{ 'selected': form.dlBackPhoto }">
                        <i class="bi bi-camera"></i>
                        <div class="dotted-bg">
                          <i class="fa-regular fa-image"></i>
                          <p class="choose-para">Escolher arquivo</p>
                          <p class="file-type">(Suporte de formato - JPG, PNG, PDF)</p>
                          <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                          <input class="upload" type="file" @input="selectBackImage" accept="image/jpeg, image/jpg" />
                        </div>
                        <div v-if="form.dlBackPhoto" class="successfull-text">
                          <i  class="fa-solid fa-circle-check"></i>
                        </div>
                        <!-- <p v-if="form.dlBackPhoto" class=" mt-2 successfull-text">Imagem enviada com sucesso</p> -->
                      </div>
                      <InputLabel class="text-white text-center mt-2" for="dlBackPhoto" value="Carregar foto de volta" />
                      <InputError class="mt-2 text-center" :message="form.errors.dlBackPhoto" />
                    </div>

                  </div>
                </div>

                <div v-if="form.documentOption === 'ssn'" class="mt-4">
                  <span class="text-white">RG</span>
                  <div class="row">

                    <!-- <div class="col-md-6 col-12">
                      <div class="file-inputs">
                        <i class="bi bi-camera"></i>
                        <div class="dotted-bg">
                          <i class="fa-regular fa-image"></i>
                          <p class="choose-para">Escolher arquivo</p>
                          <p class="file-type">(Suporte de formato - JPG, PNG, PDF)</p>
                          <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                          <input class="upload" type="file" @input="form.ssnFrontPhoto = $event.target.files[0]"
                            accept="image/jpeg, image/jpg" />
                        </div>
                      </div>
                      <InputLabel class="text-white text-center mt-2" for="ssnFrontPhoto" value="Upload Photo of Front" />
                      <InputError class="mt-2" :message="form.errors.ssnFrontPhoto" />
                    </div> -->

                    <div class="col-md-6 col-12 mb-3">
                      <div class="file-inputs" :class="{ 'selected': form.ssnFrontPhoto }">
                        <i class="bi bi-camera"></i>
                        <div class="dotted-bg">
                          <i class="fa-regular fa-image"></i>
                          <p class="choose-para">Escolher arquivo</p>
                          <p class="file-type">(Suporte de formato - JPG, PNG, PDF)</p>
                          <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                          <input class="upload" type="file" @input="selectssnFrontImage" accept="image/jpeg, image/jpg" />
                        </div>
                        <div v-if="form.ssnFrontPhoto" class="successfull-text">
                          <i  class="fa-solid fa-circle-check"></i>
                        </div>
                        <!-- <p v-if="form.ssnFrontPhoto" class=" mt-2 successfull-text">Imagem enviada com sucesso</p> -->
                      </div>
                      <InputLabel class="text-white text-center mt-2" for="ssnFrontPhoto" value="Carregar foto da frente" />
                      <InputError class="mt-2 text-center" :message="form.errors.ssnFrontPhoto" />
                    </div>


                    <!-- <div class="col-md-6 col-12">
                      <div class="file-inputs">
                        <i class="bi bi-camera"></i>
                        <div class="dotted-bg">
                          <i class="fa-regular fa-image"></i>
                          <p class="choose-para">Escolher arquivo</p>
                          <p class="file-type">(Suporte de formato - JPG, PNG, PDF)</p>
                          <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                          <input class="upload" type="file" @input="form.ssnBackPhoto = $event.target.files[0]"
                            accept="image/jpeg, image/jpg" />
                        </div>
                      </div>
                      <InputLabel class="text-white text-center mt-2" for="ssnBackPhoto" value="Upload Photo of back" />
                      <InputError class="mt-2" :message="form.errors.ssnBackPhoto" />
                    </div> -->


                    <div class="col-md-6 col-12 mb-3">
                      <div class="file-inputs" :class="{ 'selected': form.ssnBackPhoto }">
                        <i class="bi bi-camera"></i>
                        <div class="dotted-bg">
                          <i class="fa-regular fa-image"></i>
                          <p class="choose-para">Escolher arquivo</p>
                          <p class="file-type">(Suporte de formato - JPG, PNG, PDF)</p>
                          <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                          <input class="upload" type="file" @input="selectssnBackImage" accept="image/jpeg, image/jpg" />
                        </div>
                        <div v-if="form.ssnBackPhoto" class="successfull-text">
                          <i  class="fa-solid fa-circle-check"></i>
                        </div>
                        <!-- <p v-if="form.ssnBackPhoto" class=" mt-2 successfull-text"><span><i
                              class="bi bi-check-circle-fill"></i></span> Imagem enviada com sucesso</p> -->
                      </div>
                      <InputLabel class="text-white text-center mt-2" for="ssnBackPhoto" value="Carregar foto de volta" />
                      <InputError class="mt-2 text-center" :message="form.errors.ssnBackPhoto" />
                    </div>


                  </div>
                </div>

                <div class="d-flex flex-column mt-3" style="gap: 20px;">
                  <button @click.prevent="nextStep" class="banner-link-next text-center">
                    PRÓXIMO
                  </button>
                  <button @click.prevent="prevStep" class="text-white back-btn">
                    Voltar
                  </button>
                </div>
              </div>

              <!-- DONE -->





              <div v-if="currentStep === 4">
                <h3 class="text-white">Carregar detalhes do cartão de crédito</h3>
                <div class="row">
                  <div class="col-md-12">
                    <div class="my-3 ">
                      <InputLabel class="text-white d-inline" for="cardNumber" value="Número do cartão" /><span class="text-danger"> *</span>
                      <TextInput id="cardNumber" placeholder="Insira os detalhes do cartão" type="text"
                        class="mt-1 block w-full" v-model="form.cardNumber" autocomplete="cardNumber" />
                      <InputError class="mt-2" :message="form.errors.cardNumber" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="my-3">
                      <InputLabel class="text-white d-inline" for="date" value="Data de validade" placeholder="Data de validade" /><span class="text-danger"> *</span>
                      <TextInput id="date" type="month" class="mt-1 block w-full" v-model="form.date"
                        autocomplete="date" />
                      <InputError class="mt-2" :message="form.errors.date" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="my-3">
                      <InputLabel class="text-white d-inline" for="cvv" value="Cvv" /><span class="text-danger"> *</span>
                      <TextInput id="cvv" type="text" class="mt-1 block w-full" v-model="form.cvv"
                        placeholder="Digite cvv" />
                      <InputError class="mt-2" :message="form.errors.cvv" />
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="my-3">
                    <InputLabel class="text-white d-inline" for="printedName" value="Nome impresso" /> <span class="text-danger">*</span>
                    <TextInput id="printedName" placeholder="Digite o nome impresso" type="text" class="mt-1 block w-full"
                      v-model="form.printedName" autocomplete="printedName" />
                    <InputError class="mt-2" :message="form.errors.printedName" />
                  </div>
                </div>

                <hr class="my-5 card-detail-hr" />
                <h5 class="text-white">Imagens de cartão de crédito</h5>
                <div class="row my-2">


                  <!-- <div class="col-md-6 col-12">
                    <div class="file-inputs">
                        <i class="bi bi-camera"></i>
                        <div class="dotted-bg">
                          <i class="fa-regular fa-image"></i>
                          <p class="choose-para">Escolher arquivo</p>
                          <p class="file-type">(Suporte de formato - JPG, PNG, PDF)</p>
                          <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                          <input class="upload" type="file" @input="
                              form.frontCardImage = $event.target.files[0]
                              " accept="image/jpeg, image/jpg" />
                        </div>
                      </div>
                      <div class="text-center">
                        <label class="text-white mt-2" for="frontCardImage">Carregar foto frontal do cartão de crédito
                          <span class="text-red-500">*</span></label>
                      </div>
                        <InputError class="mt-2" :message="form.errors.frontCardImage" />
                  </div> -->

                  <div class="col-md-6 col-12 mb-3">
                    <div class="file-inputs" :class="{ 'selected': form.frontCardImage }">
                      <i class="bi bi-camera"></i>
                      <div class="dotted-bg">
                        <i class="fa-regular fa-image"></i>
                        <p class="choose-para">Escolher arquivo</p>
                        <p class="file-type">(Suporte de formato - JPG, PNG, PDF)</p>
                        <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                        <input class="upload" type="file" @input="selectFrontCardImage" accept="image/jpeg, image/jpg" />
                        <!-- <p v-if="form.frontCardImage" class=" mt-2 successfull-text">Imagem enviada com sucesso</p> -->
                      </div>
                      <div v-if="form.frontCardImage" class="successfull-text">
                        <i  class="fa-solid fa-circle-check"></i>
                      </div>
                    </div>
                    <div class="text-center">
                      <label class="text-white mt-2" for="frontCardImage">Carregar foto frontal do cartão de crédito<span
                          class="text-red-500">*</span></label>
                    </div>
                    <InputError class="mt-2 text-center" :message="form.errors.frontCardImage" />
                  </div>


                  <!-- <div class="col-md-6">
                    <div class="file-inputs">
                        <i class="bi bi-camera"></i>
                        <div class="dotted-bg">
                          <i class="fa-regular fa-image"></i>
                          <p class="choose-para">Escolher arquivo</p>
                          <p class="file-type">(Suporte de formato - JPG, PNG, PDF)</p>
                          <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                          <input class="upload" type="file" @input="form.backCardImage = $event.target.files[0]"
                    accept="image/jpeg, image/jpg" />
                        </div>
                      </div>
                      <div class="text-center">
                        <label class="text-white  mt-2" for="backCardImage">Carregar novamente a foto do cartão de crédito
                      <span class="text-red-500">*</span></label>
                      </div>
                  <InputError class="mt-2" :message="form.errors.backCardImage" />
                  </div> -->


                  <div class="col-md-6 col-12 mb-3">
                    <div class="file-inputs" :class="{ 'selected': form.backCardImage }">
                      <i class="bi bi-camera"></i>
                      <div class="dotted-bg">
                        <i class="fa-regular fa-image"></i>
                        <p class="choose-para">Escolher arquivo</p>
                        <p class="file-type">(Suporte de formato - JPG, PNG, PDF)</p>
                        <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                        <input class="upload" type="file" @input="selectBackCardImage" accept="image/jpeg, image/jpg" />
                        <!-- <p  class=" mt-2 successfull-text">Imagem enviada com sucesso</p> -->
                      </div>
                      <div v-if="form.backCardImage" class="successfull-text">
                        <i  class="fa-solid fa-circle-check"></i>
                      </div>
                    </div>
                    <div class="text-center">
                      <label class="text-white mt-2" for="backCardImage">Carregar novamente a foto do cartão de
                        crédito<span class="text-red-500">*</span></label>
                    </div>
                    <InputError class="mt-2 text-center" :message="form.errors.backCardImage" />
                  </div>




                  <!-- <div class="col-md-6 mt-4">
                    <div class="file-inputs">
                        <i class="bi bi-camera"></i>
                        <div class="dotted-bg">
                          <i class="fa-regular fa-image"></i>
                          <p class="choose-para">Escolher arquivo</p>
                          <p class="file-type">(Suporte de formato - JPG, PNG, PDF)</p>
                          <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                          <input class="upload" type="file" @input="form.frontCardSelfie = $event.target.files[0]"
                  accept="image/jpeg, image/jpg" />
                        </div>
                      </div>
                      <div class="text-center">
                        <label class="text-white  mt-2" for="frontCardSelfie">Carregar selfie com foto frontal do cartão de crédito
                          <span class="text-red-500">*</span></label>
                      </div>
                      <InputError class="mt-2" :message="form.errors.frontCardSelfie" accept="image/jpeg, image/jpg" />
                  </div> -->

                  <div class="col-md-6 col-12 mb-3">
                    <div class="file-inputs" :class="{ 'selected': form.frontCardSelfie }">
                      <i class="bi bi-camera"></i>
                      <div class="dotted-bg">
                        <i class="fa-regular fa-image"></i>
                        <p class="choose-para">Escolher arquivo</p>
                        <p class="file-type">(Suporte de formato - JPG, PNG, PDF)</p>
                        <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                        <input class="upload" type="file" @input="selectFrontCardSelfie" accept="image/jpeg, image/jpg" />
                        <!-- <p  class=" mt-2 successfull-text">Imagem enviada com sucesso</p> -->
                      </div>
                      <div v-if="form.frontCardSelfie" class="successfull-text">
                        <i  class="fa-solid fa-circle-check"></i>
                      </div>
                    </div>
                    <div class="text-center">
                      <label class="text-white mt-2" for="frontCardSelfie">Carregar selfie com foto frontal do cartão de
                        crédito<span class="text-red-500">*</span></label>
                    </div>
                    <InputError class="mt-2 text-center" :message="form.errors.frontCardSelfie" accept="image/jpeg, image/jpg" />
                  </div>


                  <!-- <div class="col-md-6 mt-4">
                    <div class="file-inputs">
                        <i class="bi bi-camera"></i>
                        <div class="dotted-bg">
                          <i class="fa-regular fa-image"></i>
                          <p class="choose-para">Escolher arquivo</p>
                          <p class="file-type">(Suporte de formato - JPG, PNG, PDF)</p>
                          <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                          <input class="upload" type="file" @input="form.backCardSelfie = $event.target.files[0]" accept="image/jpeg, image/jpg" />
                        </div>
                      </div>
                      <div class="text-center">
                        <label class="text-white  mt-2" for="backCardSelfie">Carregar selfie com imagem traseira do cartão de crédito
                          <span class="text-red-500">*</span></label>
                      </div>
                      <InputError class="mt-2" :message="form.errors.backCardSelfie" />
                  </div> -->

                  <div class="col-md-6 col-12 mb-3">
                    <div class="file-inputs " :class="{ 'selected': form.backCardSelfie }">
                      <i class="bi bi-camera"></i>
                      <div class="dotted-bg">
                        <i class="fa-regular fa-image"></i>
                        <p class="choose-para">Escolher arquivo</p>
                        <p class="file-type">(Suporte de formato - JPG, PNG, PDF)</p>
                        <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                        <input class="upload" type="file" @input="selectBackCardSelfie" accept="image/jpeg, image/jpg" />
                        <!-- <p v-if="form.backCardSelfie" class=" mt-2 successfull-text">Imagem enviada com sucesso</p> -->
                      </div>
                      <div v-if="form.backCardSelfie" class="successfull-text">
                        <i  class="fa-solid fa-circle-check"></i>
                      </div>
                    </div>
                    <div class="text-center">
                      <label class="text-white mt-2" for="backCardSelfie">Carregar selfie com imagem traseira do cartão de
                        crédito<span class="text-red-500">*</span></label>
                    </div>
                    <InputError class="mt-2 text-center" :message="form.errors.backCardSelfie" />
                  </div>


                </div>
                <hr class="my-5 card-detail-hr" />

                <div class="mb-4">
                  <h5 class="text-white">Captura de tela do limite de crédito</h5>
                  <div class="row mt-2">


                    <!-- <div class="col-md-6">
                      <div class="file-inputs">
                        <i class="bi bi-camera"></i>
                        <div class="dotted-bg">
                          <i class="fa-regular fa-image"></i>
                          <p class="choose-para">Escolher arquivo</p>
                          <p class="file-type">(Suporte de formato - JPG, PNG, PDF)</p>
                          <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                          <input class="upload" type="file" @input="
                    form.cardLimitScreenshot =
                    $event.target.files[0]
                    " accept="image/jpeg, image/jpg" />
                        </div>
                      </div>
                      <div class="text-center">
                        <label class="text-white mt-2" for="cardLimitScreenshot">Faça upload de uma captura de tela com o limite do cartão
                          <span class="text-red-500">*</span></label>
                          <InputError class="mt-2" :message="form.errors.cardLimitScreenshot" />
                      </div>
                    </div> -->

                    <div class="col-md-6 col-12 mb-3">
                      <div class="file-inputs" :class="{ 'selected': form.cardLimitScreenshot }">
                        <i class="bi bi-camera"></i>
                        <div class="dotted-bg">
                          <i class="fa-regular fa-image"></i>
                          <p class="choose-para">Escolher arquivo</p>
                          <p class="file-type">(Suporte de formato - JPG, PNG, PDF)</p>
                          <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                          <input class="upload" type="file" @input="selectCardLimitScreenshot"
                            accept="image/jpeg, image/jpg" />
                          <!-- <p v-if="form.cardLimitScreenshot" class=" mt-2 successfull-text">Imagem enviada com sucesso</p> -->
                        </div>
                        <div  v-if="form.cardLimitScreenshot"  class="successfull-text">
                          <i class="fa-solid fa-circle-check"></i>
                        </div>
                      </div>
                      <div class="text-center">
                        <label class="text-white mt-2" for="cardLimitScreenshot">Faça upload de uma captura de tela com o
                          limite do cartão<span class="text-red-500">*</span></label>
                        <InputError class="mt-2 text-center" :message="form.errors.cardLimitScreenshot" />
                      </div>
                    </div>

                  </div>
                  <div class="my-4">
                    <label class="text-white" for="limitAvailable">Limite disponível no cartão de crédito
                      <span class="text-red-500">*</span></label>
                    <TextInput id="limitAvailable" placeholder="Insira o limite disponível" type="number"
                      class="mt-1 block w-full" v-model="form.limitAvailable" autocomplete="limitAvailable" />
                    <InputError class="mt-2" :message="form.errors.limitAvailable" />

                    <InputError class="mt-2" :message="form.errors.referralLink" />
                    <InputError class="mt-2" :message="form.errors['discount_code']" />
                  </div>
                </div>



                <!-- Start -->


                <div v-if="isUserLoggedIn == false">
                  <div class="col-md-12">
                    <div class="my-3">
                      <InputLabel class="text-white" for="email" value="Digite o e-mail para registrar o usuário" />
                      <TextInput id="email" placeholder="Digite o e-mail" type="email" class="mt-1 block w-full"
                        v-model="form.eemail" autocomplete="eemail" />
                      <InputError class="mt-2" :message="form.errors.eemail" />
                    </div>
                  </div>


                  <div class="col-md-12">
                    <div class="my-3">
                      <InputLabel class="text-white" for="password" value="Senha" />
                      <TextInput id="password" placeholder="Digite a senha" type="password" class="mt-1 block w-full"
                        v-model="form.password" autocomplete="password" />
                      <InputError class="mt-2" :message="form.errors.password" />
                    </div>
                  </div>


                  <div class="col-md-12">
                    <div class="my-3">
                      <InputLabel class="text-white" for="phone_number" value="Número de telefone" />
                      <TextInput id="phone_number" placeholder="Digite seu número de telefone" type="text" class="mt-1 block w-full"
                        v-model="form.phone_number" autocomplete="phone_number" />
                      <InputError class="mt-2" :message="form.errors.phone_number" />
                    </div>
                  </div>
                </div>

                  <!-- <div class="col-md-12">
                    <div class="my-3">
                        <InputLabel class="text-white" for="confirm_password" value="Confirm Password" />
                        <TextInput id="confirm_password" placeholder="Confirm Password" type="password" class="mt-1 block w-full"
                                v-model="form.confirm_password" autocomplete="new-password" />
                        <InputError class="mt-2" :message="form.errors.confirm_password" />
                    </div>
                    </div> -->

                <!-- End -->

                <div class="checkbox-loan d-flex align-items-center">
                  <input type="checkbox" id="declarationCheckbox" v-model="form.declarationCheckbox" />
                  <label class="text-white px-3" for="declarationCheckbox">
                    Concordo <a target="_blank" href="term-condition">Termos de uso</a> e <a target="_blank" href="privacy-policy">Política de Privacidade.</a></label>
                  </div>
                  <input-error :message="form.errors.declarationCheckbox" />
                <div class="row mt-4" style="gap: 20px">
                  <!-- <button class="banner-link-next text-center" enctype="multipart/form-data">
                    CONFIRM
                  </button> -->







              <div>
                <button @click="submit" class="w-100 banner-link-next text-center text-white" type="button"
                  :disabled="isLoading">
                  <span v-if="isLoading" class="spinner-border spinner-border-sm" role="status"
                    aria-hidden="true"></span>
                  <span v-else>CONFIRME</span>
                </button>

                  <div class="overlay" v-if="isLoading">
                      <img class="loader-gif" :src="loader" alt="Loader">
                  </div>
             </div>

                  <button @click.prevent="prevStep" class="text-white back-btn">
                    Voltar
                  </button>
                </div>
                <br />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


  <Modal :modal='5' :show="showModal" @close="hideModal"
        @nextStep="nextStepModel" :formPayment="form.total_payment"/>


  <Footer />
</template>

<style scoped>
.selected {
    background-color: #2cbcdd;
    color: #fff;
}

.checkbox-loan input:checked {
    border: 1px solid #fff !important;
}




.overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    /* Semi-transparent black */
    z-index: 9999;
    /* Ensure it's above other content */
    display: flex;
    justify-content: center;
    align-items: center;
}

.loader-gif {
    width: 220px !important;
}


@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}

.text-dark-blue {
    color: red;  /* Dark blue color */
}
</style>
