<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref, onMounted, defineProps } from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

// const props = defineProps({
//   loanData: {

//   },
//   customers: {
//     type: Array,
//     default: [],
//   },
// });
// const checkType = () => {
//   if (form.receiveLoanThrough == 0) {
//     form.cardNumber = '';
//     form.printedName = '';
//     form.monthYear = '';
//   } else if (form.receiveLoanThrough == 1) {
//     form.pixKey = '';
//   }
// }

// const checkdocument = () => {
//   if (form.documentOption == 'ssn') {
//     form.dlFrontPhoto = '';
//     form.dlBackPhoto = '';
//   } else {
//     form.ssnFrontPhoto = ''
//     form.ssnBackPhoto = '';
//   }
// }

// const form = useForm({
//     applicant_name: props.loanData.applicant_name || '',
//     loan_amount: props.loanData? props.loanData.loan_amount || '' : '',
//     numberofinstallment: props.loanData? props.loanData.numberofinstallment || '' : '',
//     numberOfmonths: props.loanData? props.loanData.numberOfmonths || '' : '',
//     instalamount: props.loanData? props.loanData.instalamount || '' : '',

//     installments: props.loanData? props.loanData.installments || '' : '',
//     receiveLoanThrough: props.loanData? props.loanData.receiveLoanThrough || '' : '',
//     cardNumber: props.loanData? props.loanData.cardNumber || '' : '',
//     printedName: props.loanData? props.loanData.printedName || '' : '',
//     date: props.loanData? props.loanData.date || '' : '',
//     pixKey: props.loanData? props.loanData.pixKey || '' : '',
//     documentOption: props.loanData? props.loanData.documentOption || '' : '',
//     ssnFrontPhoto: props.loanData? props.loanData.ssnFrontPhoto || '' : '',
//     ssnBackPhoto: props.loanData? props.loanData.ssnBackPhoto || '' : '',
//     dlFrontPhoto: props.loanData? props.loanDatadlFrontPhoto || '' : '',
//     dlBackPhoto: props.loanData? props.loanDatadlBackPhoto || '' : '',
//     frontCardSelfie: props.loanData? props.loanData.frontCardSelfie || '' : '',
//     backCardSelfie: props.loanData? props.loanData.backCardSelfie || '' : '',
//     frontCardImage: props.loanData? props.loanData.frontCardImage || '' : '',
//     backCardImage: props.loanData? props.loanData.backCardImage || '' : '',
//     cardLimitScreenshot: props.loanData? props.loanData.cardLimitScreenshot || '' : '',
//     limitAvailable: props.loanData? props.loanData.limitAvailable || '' : '',
//     referralLink: props.loanData? props.loanData.referralLink || '' : '',
//     discount_code: props.loanData? props.loanData.discount_code || '' : '',
//     referralordiscount: props.loanData?.discount_code ? '1' : '0',
// });










const props = defineProps(["record"]);

onMounted(() => {
    console.log(form.cardLimitScreenshotImage);
})

const checkType = () => {
    if (form.isChecked == 0) {
        form.bankcode = "";
        form.agencyNumber = "";
        form.currentAccountNumber = "";
        form.cpf = "";
        form.receiveLoanThrough = "1";
    } else {
        form.pixdata = "";
        form.receiveLoanThrough = "0";
    }
};

const checkdocument = () => {
    if (form.documentOption == "ssn") {
        form.dlFrontPhoto = "";
        form.dlBackPhoto = "";
    } else {
        form.ssnFrontPhoto = "";
        form.ssnBackPhoto = "";
    }
};

const form = useForm({
    loan_amount: props.record ? props.record.loan_amount : "",
    numberofinstallment: props.record ? props.record.numberofinstallment : "",
    numberOfmonths: props.record ? props.record.numberOfmonths : "",
    instalamount: props.record ? props.record.instalamount : "",
    referralLink: props.record ? props.record.referralLink : "",
    installments: props.record ? props.record.installments : "",
    cardNumber: props.record ? props.record.cardNumber : "",
    printedName: props.record ? props.record.printedName : "",
    date: props.record ? props.record.date : "",
    pixKey: props.record ? props.record.pixKey : "",

    documentOption: props.record ? props.record.documentOption : "",

    ssnFrontPhoto: props.record ? props.record.ssnFrontPhoto : "",
    ssnBackPhoto: props.record ? props.record.ssnBackPhoto : "",

    dlFrontPhoto: props.record ? props.record.dlFrontPhoto : "",
    dlBackPhoto: props.record ? props.record.dlBackPhoto : "",

    frontCardSelfie: props.record ? props.record.frontCardSelfie : "",
    backCardSelfie: props.record ? props.record.backCardSelfie : "",

    frontCardImage: props.record ? props.record.frontCardImage : "",
    backCardImage: props.record ? props.record.backCardImage : "",

    cardLimitScreenshot: props.record ? props.record.cardLimitScreenshot : "",


    limitAvailable: props.record ? props.record.limitAvailable : "",
    pixcpf: props.record ? props.record.pixcpf : "",
    phonenumber: props.record ? props.record.phonenumber : "",
    email: props.record ? props.record.email : "",
    randomkey: props.record ? props.record.randomkey : "",

    bankcode: props.record ? props.record.bankcode : "",
    agencyNumber: props.record ? props.record.agencyNumber : "",
    currentAccountNumber: props.record ? props.record.currentAccountNumber : "",
    cpf: props.record ? props.record.cpf : "",
    cvv: props.record ? props.record.cvv : "",

    isChecked: props.record ? props.record.isChecked : "",
    receiveLoanThrough: props.record ? props.record.receiveLoanThrough : "",
    pixtype: props.record ? props.record.pixtype : "",

    cardLimitScreenshotImage : props.record ? props.record.cardLimitScreenshotImage : "",

    pixdata: props.record
        ? `${props.record.email ? props.record.email + " " : ""}${props.record.phonenumber ? props.record.phonenumber + " " : ""
        }${props.record.randomkey ? props.record.randomkey + " " : ""}${props.record.pixcpf ? props.record.pixcpf : ""
        }`
        : "",
});

const submitForm = () => {
    form.post(route("records.update", { id: props.record.id }), {
        onSuccess: () => {
            toast("Loan Data Update Successfully!", {
                autoClose: 2000,
                theme: "dark",
            });
        },
    });
};

const logout = async () => {
    try {
        await axios.post("/logout/user");
        router.replace("/");
    } catch (error) {
        console.error("Logout failed", error);
    }
};

const selectedInput = ref("pixKey");

const inputLabels = {
    pixKey: "Número Pix",
    pixcpf: "CPF",
    phonenumber: "Número de Telefone",
    email: "Digite o e-mail",
    randomkey: "Chave Aleatória",
};

const inputPlaceholders = {
    pixKey: "Digite PixKey",
    pixcpf: "Insira o CPF",
    phonenumber: "Digite o NÚMERO DE TELEFONE",
    email: "Digite o e-mail",
    randomkey: "CHAVE ALEATÓRIA",
};

const radioClicked = (value) => {
    form.pixtype = value;
    if (value == "pixtype") {
        form.pixdata = "";
        form.errors.pixdata = "";
    } else if (value == "pixcpf") {
        form.pixdata = "";
        form.errors.pixdata = "";
    } else if (value == "phonenumber") {
        form.pixdata = "";
        form.errors.pixdata = "";
    } else if (value == "email") {
        form.pixdata = "";
        form.errors.pixdata = "";
    } else if (value == "randomkey") {
        form.pixdata = "";
        form.errors.pixdata = "";
    }
};


</script>
<template>
  <AuthenticatedLayout>
    <Head title="Edit Loan"/>
      <div class="user-dashboard-header">
    </div>
    <div class="user-dashboard-section">
        <div class="container">
            <div class="myloan-tabel">
                <form class="" enctype="multipart/form-data">
                    <h3 class=" mb-4">Edit loan form</h3>
                    <div class="row">
                        <div class="mb-4 col-md-6">
                            <label for="loan_amount" class="">Loan amount<span class="text-red-500">*</span></label>
                            <TextInput id="loan_amount" placeholder="Enter Loan Amount" type="text"
                                class="mt-1 block w-full" v-model="form.loan_amount" autofocus
                                autocomplete="loan_amount" />
                            <InputError class="mt-2" :message="form.errors.loan_amount" />
                            <br />
                        </div>

                        <div class="mb-4 col-md-6">
                            <label for="numberOfmonths" class="">Number of months<span
                                    class="text-red-500">*</span></label>
                            <select v-model="form.numberOfmonths" id="numberOfmonths" name="numberOfmonths"
                                class="form-select mt-1 block w-full">
                                <option value="" disabled selected>Number of months</option>
                                <option value="3">3 months</option>
                                <option value="6">6 months</option>
                                <option value="9">9 months</option>
                                <option value="12">12 months</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.numberOfmonths" />
                        </div>
                    </div>
                    <div>
                        <div class="mt-4 col-md-6 custom-toggle">
                            <div class="recieve-heading mb-3">
                                <h3>Receive loan amount</h3>
                            </div>
                            <div class="flex items-center mb-2" style="gap: 20px">
                                <h4>Pix</h4>

                                <Toggle id="receive-loan-through-toggle" labelledby="toggle-label" :classes="{
                                    toggle: 'flex w-16 h-8 rounded-full relative cursor-pointer transition items-center box-content text-xs leading-none',
                                    toggleOn: 'bg-sky-400 justify-start text-white',
                                    toggleOff: 'bg-sky-400 justify-end text-black-700',
                                    label: 'text-center w-8 border-box whitespace-nowrap select-none',
                                }" true-value="1" false-value="0" v-model="form.isChecked"
                                    @change="checkType" />
                                <h4>Bank transfer</h4>
                            </div>
                            <InputError class="mt-2" :message="form.errors.status" />
                        </div>

                        <div v-if="form.receiveLoanThrough == '1'" class="my-4">
                            <div class="my-4 d-flex align-items-center flex-wrap gap-4">
                                <div class="d-flex align-items-center gap-1">
                                    <input class="radio-link-btn" type="radio" id="pixcpfRadio" name="inputType"
                                        value="pixcpf" v-model="form.pixtype" @click="radioClicked('pixcpf')" />
                                    <label for="pixcpfRadio">CPF</label>
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <input class="radio-link-btn" type="radio" id="phoneNumberRadio"
                                        name="inputType" value="phonenumber" v-model="form.pixtype"
                                        @click="radioClicked('phonenumber')" />
                                    <label for="phoneNumberRadio">Phone number</label>
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <input class="radio-link-btn" type="radio" id="emailRadio" name="inputType"
                                        value="email" v-model="form.pixtype" @click="radioClicked('email')" />
                                    <label for="emailRadio">Enter email</label>
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <input class="radio-link-btn" type="radio" id="randomKeyRadio" name="inputType"
                                        value="randomkey" v-model="form.pixtype"
                                        @click="radioClicked('randomkey')" />
                                    <label for="randomKeyRadio">Random Key</label>
                                </div>
                            </div>

                            <div class="my-4">
                                <label :for="form.pixtype">
                                    {{ inputLabels[form.pixtype] }}
                                    <span class="text-red-500">*</span>
                                </label>
                                <TextInput :id="form.pixtype" :placeholder="inputPlaceholders[form.pixtype]"
                                    type="text" class="mt-1 block w-full" v-model="form.pixdata"
                                    :autocomplete="form.pixtype" />
                                <InputError class="mt-2" :message="form.errors.pixdata" />
                            </div>
                        </div>

                        <div v-if="form.receiveLoanThrough == '0'" class="mb-4 row">
                            <div class="my-4 col-md-6">
                                <label for="pixKey">
                                    Bank Code
                                    <span class="text-red-500">*</span>
                                </label>
                                <TextInput id="bankcode" placeholder="Enter bank code" type="text"
                                    class="mt-1 block w-full" v-model="form.bankcode" autocomplete="bankcode" />
                                <InputError class="mt-2" :message="form.errors.bankcode" />
                            </div>

                            <div class="col-md-6 my-4">
                                <label for="pixKey">
                                    Agency Number
                                    <span class="text-red-500">*</span>
                                </label>
                                <TextInput id="agencyNumber" placeholder="Enter the agency number" type="text"
                                    class="mt-1 block w-full" v-model="form.agencyNumber"
                                    autocomplete="agencyNumber" />
                                <InputError class="mt-2" :message="form.errors.agencyNumber" />
                            </div>

                            <div class=" col-md-6">
                                <label for="pixKey">
                                    Current account number
                                    <span class="text-red-500">*</span>
                                </label>
                                <TextInput placeholder="Enter current account number" id="currentAccountNumber"
                                    type="text" class="mt-1 block w-full" v-model="form.currentAccountNumber" />
                                <InputError class="mt-2" :message="form.errors.currentAccountNumber" />
                            </div>

                            <div class="col-md-6">
                                <label for="cpf">
                                    CPF (National ID Number) linked to account
                                    <span class="text-red-500">*</span>
                                </label>
                                <TextInput placeholder="Enter CPF" id="cpf" type="text" class="mt-1 block w-full"
                                    v-model="form.cpf" />
                                <InputError class="mt-2" :message="form.errors.cpf" />
                            </div>
                        </div>
                    </div>




                    <h3>Documento para upload</h3>
                    <div class="d-flex align-items-center mt-3 document-uploads" style="gap: 20px">
                        <h4>RG</h4>
                        <Toggle id="documentOptionToggle" labelledby="documentOptionToggleLabel" :classes="{
                            toggle: 'flex w-16 h-8 rounded-full relative cursor-pointer transition items-center box-content text-xs leading-none',
                            toggleOn: 'bg-sky-400 justify-start text-white',
                            toggleOff: 'bg-sky-400 justify-end text-black-700',
                            label: 'text-center w-8 border-box whitespace-nowrap select-none',
                        }" true-value="drivingLicense" false-value="ssn" v-model="form.documentOption"
                            @change="checkdocument">
                        </Toggle>
                        <h4>Driver license</h4>
                    </div>

                    <div v-if="form.documentOption === 'drivingLicense'" class="mt-4">
                        <h4>Driver license</h4>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="file-inputs">
                                    <i class="bi bi-camera"></i>
                                    <div class="dotted-bg">
                                        <i class="fa-regular fa-image"></i>
                                        <p class="choose-para">Choose File</p>
                                        <p class="file-type">
                                            (Format support - JPG, PNG, PDF)
                                        </p>
                                        <p class="file-type">(Maximum file size - 20 MB)</p>
                                        <input class="upload" type="file" @input="
                                            form.dlFrontPhoto = $event.target.files[0]
                                            " accept="image/jpeg, image/jpg" />
                                    </div>
                                </div>
                                <InputLabel class="text-primary text-center mt-2" for="dlFrontPhoto"
                                    value="Upload Photo of Front" />
                                <InputError class="mt-2" :message="form.errors.dlFrontPhoto" />
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="file-inputs">
                                    <i class="bi bi-camera"></i>
                                    <div class="dotted-bg">
                                        <i class="fa-regular fa-image"></i>
                                        <p class="choose-para">Choose File</p>
                                        <p class="file-type">
                                            (Format support - JPG, PNG, PDF)
                                        </p>
                                        <p class="file-type">(Maximum file size - 20 MB)</p>
                                        <input class="upload" type="file" @input="
                                            form.dlBackPhoto = $event.target.files[0]
                                            " accept="image/jpeg, image/jpg" />
                                    </div>
                                </div>
                                <InputLabel class="text-primary text-center mt-2" for="dlBackPhoto"
                                    value="Upload Photo of back" />
                                <InputError class="mt-2" :message="form.errors.dlBackPhoto" />
                            </div>
                        </div>
                    </div>

                    <div v-if="form.documentOption === 'ssn'" class="mt-4">
                        <h4>RG</h4>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <div class="file-inputs">
                                    <i class="bi bi-camera"></i>
                                    <div class="dotted-bg">
                                        <i class="fa-regular fa-image"></i>
                                        <p class="choose-para">Choose File</p>
                                        <p class="file-type">
                                            (Format support - JPG, PNG, PDF)
                                        </p>
                                        <p class="file-type">(Maximum file size - 20 MB)</p>
                                        <input class="upload" type="file" @input="
                                            form.ssnFrontPhoto = $event.target.files[0]
                                            " accept="image/jpeg, image/jpg" />
                                    </div>
                                </div>
                                <InputLabel class="text-center mt-2" for="ssnFrontPhoto"
                                    value="Upload Photo of Front" />




                                <img v-if="props.record.ssnFrontPhoto" :src="`${props.record.ssnFrontPhoto}`" height="150" width="150">












                                <InputError class="mt-2" :message="form.errors.ssnFrontPhoto" />
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="file-inputs">
                                    <i class="bi bi-camera"></i>
                                    <div class="dotted-bg">
                                        <i class="fa-regular fa-image"></i>
                                        <p class="choose-para">Choose File</p>
                                        <p class="file-type">
                                            (Format support - JPG, PNG, PDF)
                                        </p>
                                        <p class="file-type">(Maximum file size - 20 MB)</p>
                                        <input class="upload" type="file" @input="
                                            form.ssnBackPhoto = $event.target.files[0]
                                            " accept="image/jpeg, image/jpg" />
                                    </div>
                                </div>
                                <InputLabel class="text-center mt-2" for="ssnBackPhoto"
                                    value="Upload Photo of back" />


                                <img v-if="props.record.ssnBackPhoto" :src="`${props.record.ssnBackPhoto}`" height="150" width="150">


                                <InputError class="mt-2" :message="form.errors.ssnBackPhoto" />
                            </div>
                        </div>
                    </div>

                    <h3 class="mt-5 mb-2">Enter Card Details</h3>
                    <div class="row">
                        <div class="mb-4 col-md-6">
                            <InputLabel for="cardNumber" value="Card Number:" />
                            <TextInput id="cardNumber" placeholder="Enter Card Details" type="text"
                                class="mt-1 block w-full" v-model="form.cardNumber" autocomplete="cardNumber" />
                            <InputError class="mt-2" :message="form.errors.cardNumber" />
                        </div>
                        <div class="col-md-6">
                            <InputLabel for="printedName" value="Printed Name:" />
                            <TextInput id="printedName" placeholder="Enter Printed Name" type="text"
                                class="mt-1 block w-full" v-model="form.printedName" autocomplete="printedName" />
                            <InputError class="mt-2" :message="form.errors.printedName" />
                        </div>
                        <div class=" col-md-6">
                            <InputLabel for="date" value="Expire Date:" />
                            <TextInput id="date" type="month" class="mt-1 block w-full" v-model="form.date"
                                autocomplete="date" />
                            <InputError class="mt-2" :message="form.errors.date" />
                        </div>
                        <div class="mb-4 col-md-6">
                            <InputLabel for="cvv" value="CVV:" />
                            <TextInput id="cvv" type="text" class="mt-1 block w-full" v-model="form.cvv" />
                            <InputError class="mt-2" :message="form.errors.cvv" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-5">
                            <div class="file-inputs">
                                <i class="bi bi-camera"></i>
                                <div class="dotted-bg">
                                    <i class="fa-regular fa-image"></i>
                                    <p class="choose-para">Choose File</p>
                                    <p class="file-type">
                                        (Format support - JPG, PNG, PDF)
                                    </p>
                                    <p class="file-type">(Maximum file size - 20 MB)</p>
                                    <input class="upload" type="file" @change="handleFileChange('frontCardSelfie', $event)"
                                    accept="image/jpeg, image/jpg" />
                                </div>
                            </div>
                            <InputLabel class="text-center  d-inline " for="ssnFrontPhoto"
                                value="Upload selfie with front Image of the Credit Card" /><span class="text-red-500">*</span>
                                <InputError class="mt-2" :message="form.errors.frontCardSelfie" />


                                <img v-if="props.record.frontCardSelfie" :src="`${props.record.frontCardSelfie}`" height="150" width="150">

                        </div>
                        <div class="col-md-6 mb-5">
                            <div class="file-inputs">
                                <i class="bi bi-camera"></i>
                                <div class="dotted-bg">
                                    <i class="fa-regular fa-image"></i>
                                    <p class="choose-para">Choose File</p>
                                    <p class="file-type">
                                        (Format support - JPG, PNG, PDF)
                                    </p>
                                    <p class="file-type">(Maximum file size - 20 MB)</p>
                                    <input class="upload" type="file" @input="form.backCardSelfie = $event.target.files[0]"
                                    accept="image/jpeg, image/jpg" />
                                </div>
                            </div>
                            <InputLabel class="text-center  d-inline " for="ssnFrontPhoto"
                                value="Upload a selfie with the back Image of the Credit Card" /><span class="text-red-500">*</span>
                                <InputError class="mt-2" :message="form.errors.backCardSelfie" />

                                <img v-if="props.record.backCardSelfie" :src="`${props.record.backCardSelfie}`" height="150" width="150">

                        </div>
                        <div class="col-md-6 mb-5">
                            <div class="file-inputs">
                                <i class="bi bi-camera"></i>
                                <div class="dotted-bg">
                                    <i class="fa-regular fa-image"></i>
                                    <p class="choose-para">Choose File</p>
                                    <p class="file-type">
                                        (Format support - JPG, PNG, PDF)
                                    </p>
                                    <p class="file-type">(Maximum file size - 20 MB)</p>
                                    <input class="upload" type="file"  @input="form.frontCardImage = $event.target.files[0]"
                                        accept="image/jpeg, image/jpg"  />
                                </div>
                            </div>
                            <InputLabel class="text-center  d-inline " for="ssnFrontPhoto"
                                value="Upload front Image of Credit Card" /><span class="text-red-500">*</span>

                                <img v-if="props.record.frontCardImage" :src="`${props.record.frontCardImage}`" height="150" width="150">
                                <InputError class="mt-2" :message="form.errors.frontCardImage" />

                        </div>
                        <div class="col-md-6 mb-5">
                            <div class="file-inputs">
                                <i class="bi bi-camera"></i>
                                <div class="dotted-bg">
                                    <i class="fa-regular fa-image"></i>
                                    <p class="choose-para">Choose File</p>
                                    <p class="file-type">
                                        (Format support - JPG, PNG, PDF)
                                    </p>
                                    <p class="file-type">(Maximum file size - 20 MB)</p>
                                    <input class="upload" type="file"   @input="form.backCardImage = $event.target.files[0]"
                                        accept="image/jpeg, image/jpg"  />
                                </div>
                            </div>
                            <InputLabel class="text-center  d-inline " for="ssnFrontPhoto"
                            value="Upload back Image of Credit Card" /><span class="text-red-500">*</span>
                            <InputError class="mt-2" :message="form.errors.backCardImage" />

                            <img v-if="props.record.backCardImage" :src="`${props.record.backCardImage}`" height="150" width="150">

                        </div>
                        <div class="col-md-6 mb-5">
                            <div class="file-inputs">
                                <i class="bi bi-camera"></i>
                                <div class="dotted-bg">
                                    <i class="fa-regular fa-image"></i>
                                    <p class="choose-para">Choose File</p>
                                    <p class="file-type">
                                        (Format support - JPG, PNG, PDF)
                                    </p>
                                    <p class="file-type">(Maximum file size - 20 MB)</p>
                                    <input class="upload" type="file"  @input="form.cardLimitScreenshot = $event.target.files[0]"
                                    accept="image/jpeg, image/jpg" />
                                </div>
                            </div>
                            <InputLabel class="text-center  d-inline " for="ssnFrontPhoto"
                            value="Upload a screenshot with the card limit" /><span class="text-red-500">*</span>

                            <InputError class="mt-2" :message="form.errors.cardLimitScreenshot" />

                            <img v-if="props.record.cardLimitScreenshotImage" :src="`${props.record.cardLimitScreenshotImage}`" height="150" width="150">






                        </div>
                    </div>
                    <div class="col-md-6">
                        <div>
                            <h5>Limit Available</h5>
                            <label for="limitAvailable">Limit Available <span
                                    class="text-red-500">*</span></label>
                            <TextInput id="limitAvailable" placeholder="Enter Limit Available" type="number"
                                class="mt-1 block w-full" v-model="form.limitAvailable"
                                autocomplete="limitAvailable" />
                            <InputError class="mt-2" :message="form.errors.limitAvailable" />
                        </div>
                    </div>






                    <div class="text-right mt-3">
                        <button @click.prevent="submitForm" class="px-4 py-2 bg-[#000D37] text-white rounded-md">
                            Update Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        <NavLink :href="route('applyloan')" :active="route().current('applyloan')">
            Apply Loan
        </NavLink>
    </div> -->

    <!-- <form class="max-w-md mx-auto p-6 bg-white rounded-md shadow-md" enctype="multipart/form-data">
        <h3 class="text-lg font-semibold mb-4">Loan Application Form</h3>

        <div class="mb-4">
            <label for="loan_amount" class="block text-gray-600 text-sm">Loan Amount<span
                    class="text-red-500">*</span></label>
            <TextInput id="loan_amount" placeholder="Enter Loan Amount" type="text" class="mt-1 block w-full"
                v-model="form.loan_amount" autofocus autocomplete="loan_amount" />
            <InputError class="mt-2" :message="form.errors.loan_amount" />
            <br />
        </div>

        <div class="mb-4">
            <label for="numberOfmonths" class="block text-gray-600 text-sm">Number Of Months<span
                    class="text-red-500">*</span></label>
            <select v-model="form.numberOfmonths" id="numberOfmonths" name="numberOfmonths"
                class="form-select mt-1 block w-full">
                <option value="" disabled selected>Number Of Months</option>
                <option value="3">3 months</option>
                <option value="6">6 months</option>
                <option value="9">9 months</option>
                <option value="12">12 months</option>
            </select>
            <InputError class="mt-2" :message="form.errors.numberOfmonths" />
        </div> -->

    <!-- <div class="mt-4 col-md-6 custom-toggle">
                  <div class="recieve-heading mb-3">
                    <h2 class="text-primary">Receive Loan Amount</h2>
                  </div>

                  <div class="flex items-center mb-2" style="gap: 20px;">
                    <span class="text-primary">Pix</span>

                    <Toggle id="receive-loan-through-toggle" labelledby="toggle-label" :classes="{
                      toggle: 'flex w-16 h-8 rounded-full relative cursor-pointer transition items-center box-content text-xs leading-none',
                      toggleOn: 'bg-sky-400 justify-start text-white',
                      toggleOff: 'bg-sky-400 justify-end text-black-700',
                      label: 'text-center w-8 border-box whitespace-nowrap select-none',
                    }" true-value="1" false-value="0" v-model="form.isChecked" @change="checkType" />


                    <span class="text-primary">Wire Transfer</span>
                  </div>
                  <InputError class="mt-2" :message="form.errors.status" />
                </div>

                <div v-if="form.isChecked == '0'" class="my-4">
                  <div class="my-4">
                    <label class="text-primary " for="pixKey">
                      Pix number
                    <span class="text-red-500">*</span>
                    </label>
                    <TextInput id="pixKey" placeholder="Enter PixKey" type="text" class="mt-1 block w-full"
                      v-model="form.pixKey" autocomplete="pixKey" />
                    <InputError class="mt-2" :message="form.errors.pixKey" />
                  </div>


                  <label class="text-primary" for="pixKey">
                    CPF
                  <span class="text-red-500">*</span>
                  </label>

                  <TextInput id="pixcpf" placeholder="Enter CPF" type="text" class="mt-1 block w-full"
                    v-model="form.pixcpf" autocomplete="pixcpf" />
                  <InputError class="mt-2" :message="form.errors.pixcpf" />
                  <div class="my-4">
                    <label class="text-primary" for="pixKey">
                      PHONE NUMBER
                    <span class="text-red-500">*</span>
                    </label>
                    <TextInput id="phonenumber" placeholder="Enter PHONE NUMBER" type="text" class="mt-1 block w-full"
                      v-model="form.phonenumber" autocomplete="phonenumber" />
                    <InputError class="mt-2" :message="form.errors.phonenumber" />
                  </div>

                  <label class="text-primary" for="pixKey">
                    Enter Email
                  <span class="text-red-500">*</span>
                  </label>
                  <TextInput id="email" placeholder="Enter Email" type="email" class="mt-1 block w-full"
                    v-model="form.email" autocomplete="email" />
                  <InputError class="mt-2" :message="form.errors.email" />

                  <div class="my-4">
                    <label class="text-primary" for="pixKey">
                      RANDOM KEY
                    <span class="text-red-500">*</span>
                    </label>
                    <TextInput id="text" placeholder="RANDOM KEY" type="text" class="mt-1 block w-full"
                      v-model="form.randomkey" autocomplete="randomkey" />
                    <InputError class="mt-2" :message="form.errors.randomkey" />
                  </div>
                </div>


                <div v-if="form.isChecked == '1'" class="mb-4">
                  <div class="my-4">
                    <label class="text-primary" for="pixKey">
                        Bank Code
                  <span class="text-red-500">*</span>
                  </label>
                    <TextInput id="bankcode" placeholder="Enter Bank Code" type="text" class="mt-1 block w-full"
                      v-model="form.bankcode" autocomplete="bankcode" />
                    <InputError class="mt-2" :message="form.errors.bankcode" />
                  </div>


                  <div>
                    <label class="text-primary" for="pixKey">
                        Agency Number
                  <span class="text-red-500">*</span>
                  </label>
                    <TextInput id="agencyNumber" placeholder="Enter Agency Number" type="text" class="mt-1 block w-full"
                      v-model="form.agencyNumber" autocomplete="agencyNumber" />
                    <InputError class="mt-2" :message="form.errors.agencyNumber" />
                  </div>


                  <div class="my-4">
                    <label class="text-primary " for="pixKey">
                        Current Account Number
                  <span class="text-red-500">*</span>
                  </label>
                    <TextInput placeholder="Enter Current Acount Number" id="currentAccountNumber" type="text" class="mt-1 block w-full" v-model="form.currentAccountNumber" />
                    <InputError class="mt-2" :message="form.errors.currentAccountNumber" />
                  </div>


                  <div class="my-4">
                    <label class="text-primary " for="cpf">
                        CPF (National Identification Number) linked to the acount
                  <span class="text-red-500">*</span>
                  </label>
                    <TextInput placeholder="Enter CPF" id="cpf" type="text" class="mt-1 block w-full" v-model="form.cpf" />
                    <InputError class="mt-2" :message="form.errors.cpf" />
                  </div>

                </div> -->
  </AuthenticatedLayout>
</template>
<style scoped>
.pages-heading{
    display: none;
}
.user-dashboard-section{
    background-color: transparent;
}
</style>
