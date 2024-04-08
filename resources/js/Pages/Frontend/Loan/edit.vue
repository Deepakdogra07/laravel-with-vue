<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import NavLink from "@/Components/NavLink.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import { ref, onMounted, defineProps } from "vue";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import Footer from "../../Frontend/footer.vue";
import Header from "../../Frontend/header.vue";
import "../../../../css/frontend.css";
import Sidebar from "../../Frontend/Layouts/sidebar.vue"

const currentStep = ref(0);
const maxSteps = 7;

const nextStep = async () => {
    const errors = {};
    if (
        !form.loan_amount ||
        isNaN(form.loan_amount) ||
        parseFloat(form.loan_amount) <= 0 ||
        /\s/.test(form.loan_amount)
    ) {
        errors.loan_amount = !form.loan_amount
            ? "This field is required"
            : /\s/.test(form.loan_amount)
                ? "Please enter a valid numeric value without spaces for the loan amount"
                : "Please enter a valid numeric value greater than 0 for the loan amount";
    }

    if (currentStep.value === 1 && !form.numberOfmonths) {
        errors.numberOfmonths = "This field is required";
    }

    if (currentStep.value === 2 && !form.receiveLoanThrough) {
        errors.receiveLoanThrough = "This field is required";
    }

    if (currentStep.value === 2) {
        if (
            form.receiveLoanThrough == "1" &&
            (!form.pixKey || /\s/.test(form.pixKey))
        ) {
            if (!form.pixKey) {
                errors.pixKey = "Pix Key is required";
            } else if (/\s/.test(form.pixKey)) {
                errors.pixKey = "Pix Key should not contain blank spaces";
            } else {
                errors.pixKey = "";
            }

            if (!form.pixcpf || /\s/.test(form.pixcpf) || form.pixcpf < 0) {
                errors.pixcpf = !form.pixcpf
                    ? "Pix CPF is required"
                    : form.pixcpf < 0
                        ? "Pix CPF should not be negative"
                        : "Pix CPF should not contain blank spaces";
            }

            if (
                !form.phonenumber ||
                /\s/.test(form.phonenumber) ||
                form.phonenumber < 0 ||
                !/^\d{9}$/.test(form.phonenumber)
            ) {
                errors.phonenumber = !form.phonenumber
                    ? "Phone Number is required"
                    : form.phonenumber < 0
                        ? "Phone Number should not be negative"
                        : /\s/.test(form.phonenumber)
                            ? "Phone Number should not contain blank spaces"
                            : "Phone Number should have exactly nine numeric digits";
            }

            if (
                !form.email ||
                /\s/.test(form.email) ||
                !/^\S+@\S+\.\S+$/.test(form.email)
            ) {
                errors.email = !form.email
                    ? "Email is required"
                    : /\s/.test(form.email)
                        ? "Email should not contain blank spaces"
                        : "Enter a valid email address";
            }

            if (
                !form.randomkey ||
                /\s/.test(form.randomkey) ||
                !/^[A-Za-z]+$/.test(form.randomkey)
            ) {
                errors.randomkey = !form.randomkey
                    ? "Random Key is required"
                    : /\s/.test(form.randomkey)
                        ? "Random Key should not contain blank spaces"
                        : "Random Key should only contain alphabetic characters";
            }
        } else {
            if (form.receiveLoanThrough == "0") {
                if (
                    !form.bankcode ||
                    /\s/.test(form.bankcode) ||
                    form.bankcode < 0
                ) {
                    errors.bankcode = !form.bankcode
                        ? "Agency Number is required"
                        : /\s/.test(form.bankcode)
                            ? "Agency Number should not contain blank spaces"
                            : form.bankcode < 0
                                ? "Agency Number should be a positive or zero value"
                                : "";
                }

                if (
                    !form.agencyNumber ||
                    /\s/.test(form.agencyNumber) ||
                    form.agencyNumber < 0
                ) {
                    errors.agencyNumber = !form.agencyNumber
                        ? "Agency Number is required"
                        : /\s/.test(form.agencyNumber)
                            ? "Agency Number should not contain blank spaces"
                            : form.agencyNumber < 0
                                ? "Agency Number should be a positive or zero value"
                                : "";
                }

                if (
                    !form.currentAccountNumber ||
                    !/^\d+$/.test(form.currentAccountNumber) ||
                    /\s/.test(form.currentAccountNumber) ||
                    form.currentAccountNumber <= 0
                ) {
                    errors.currentAccountNumber = !form.currentAccountNumber
                        ? "Current Account Number is required"
                        : /\s/.test(form.currentAccountNumber)
                            ? "Current Account Number should not contain blank spaces"
                            : form.currentAccountNumber <= 0
                                ? "Current Account Number should be a positive non-zero value"
                                : "";
                }

                if (!form.cpf || !/^\d{11}$/.test(form.cpf)) {
                    errors.cpf = !form.cpf
                        ? "CPF Number is required"
                        : "CPF should be a positive numeric value with exactly 11 digits.";
                }
            }
        }
    }

    if (Object.keys(errors).length > 0) {
        form.errors = errors;
        return;
    }

    if (currentStep.value < maxSteps - 1) {
        currentStep.value++;
    }
};

const prevStep = () => {
    if (currentStep.value > 0) {
        currentStep.value--;
    }
};

const props = defineProps(["record"]);

onMounted(() => {
    console.log(props.record);
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

<template #header>
    <Head title="Editar empréstimos" />
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
                    <div class="myloan-tabel">
                        <form class="" enctype="multipart/form-data">
                            <h3 class=" mb-4">Editar formulário de empréstimo</h3>
                            <div class="mb-4">
                                <label for="loan_amount" class="">Montante do empréstimo<span class="text-red-500">*</span></label>
                                <TextInput id="loan_amount" placeholder="Enter Loan Amount" type="text"
                                    class="mt-1 block w-full" v-model="form.loan_amount" autofocus
                                    autocomplete="loan_amount" />
                                <InputError class="mt-2" :message="form.errors.loan_amount" />
                                <br />
                            </div>

                            <div class="mb-4">
                                <label for="numberOfmonths" class="">Número de mês<span
                                        class="text-red-500">*</span></label>
                                <select v-model="form.numberOfmonths" id="numberOfmonths" name="numberOfmonths"
                                    class="form-select mt-1 block w-full">
                                    <option value="" disabled selected>Número de mês</option>
                                    <option value="3">3 mês</option>
                                    <option value="6">6 mês</option>
                                    <option value="9">9 mês</option>
                                    <option value="12">12 mês</option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.numberOfmonths" />
                            </div>
                            <div>
                                <div class="mt-4 col-md-6 custom-toggle">
                                    <div class="recieve-heading mb-3">
                                        <h3>Receber valor do empréstimo</h3>
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
                                        <h4>Transferência bancária</h4>
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
                                            <label for="phoneNumberRadio">Número de Telefone</label>
                                        </div>
                                        <div class="d-flex align-items-center gap-1">
                                            <input class="radio-link-btn" type="radio" id="emailRadio" name="inputType"
                                                value="email" v-model="form.pixtype" @click="radioClicked('email')" />
                                            <label for="emailRadio">Digite o e-mail</label>
                                        </div>
                                        <div class="d-flex align-items-center gap-1">
                                            <input class="radio-link-btn" type="radio" id="randomKeyRadio" name="inputType"
                                                value="randomkey" v-model="form.pixtype"
                                                @click="radioClicked('randomkey')" />
                                            <label for="randomKeyRadio">Chave Aleatória</label>
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

                                <div v-if="form.receiveLoanThrough == '0'" class="mb-4">
                                    <div class="my-4">
                                        <label for="pixKey">
                                            Código bancário
                                            <span class="text-red-500">*</span>
                                        </label>
                                        <TextInput id="bankcode" placeholder="Digite o código do banco" type="text"
                                            class="mt-1 block w-full" v-model="form.bankcode" autocomplete="bankcode" />
                                        <InputError class="mt-2" :message="form.errors.bankcode" />
                                    </div>

                                    <div>
                                        <label class="text-primary" for="pixKey">
                                            Número da agência
                                            <span class="text-red-500">*</span>
                                        </label>
                                        <TextInput id="agencyNumber" placeholder="Insira o número da agência" type="text"
                                            class="mt-1 block w-full" v-model="form.agencyNumber"
                                            autocomplete="agencyNumber" />
                                        <InputError class="mt-2" :message="form.errors.agencyNumber" />
                                    </div>

                                    <div class="my-4">
                                        <label class="text-primary" for="pixKey">
                                            Número da conta corrente
                                            <span class="text-red-500">*</span>
                                        </label>
                                        <TextInput placeholder="Insira o número da conta atual" id="currentAccountNumber"
                                            type="text" class="mt-1 block w-full" v-model="form.currentAccountNumber" />
                                        <InputError class="mt-2" :message="form.errors.currentAccountNumber" />
                                    </div>

                                    <div class="my-4">
                                        <label class="text-primary" for="cpf">
                                            CPF (Número de Identificação Nacional) vinculado à conta
                                            <span class="text-red-500">*</span>
                                        </label>
                                        <TextInput placeholder="Insira o CPF" id="cpf" type="text" class="mt-1 block w-full"
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
                                <h4>Carteira de motorista</h4>
                            </div>

                            <div v-if="form.documentOption === 'drivingLicense'" class="mt-4">
                                <h4>Carteira de motorista</h4>
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="file-inputs">
                                            <i class="bi bi-camera"></i>
                                            <div class="dotted-bg">
                                                <i class="fa-regular fa-image"></i>
                                                <p class="choose-para">Escolher arquivo</p>
                                                <p class="file-type">
                                                    (Suporte de formato - JPG, PNG, PDF)
                                                </p>
                                                <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                                                <input class="upload" type="file" @input="
                                                    form.dlFrontPhoto = $event.target.files[0]
                                                    " accept="image/jpeg, image/jpg" />
                                            </div>
                                        </div>
                                        <InputLabel class="text-primary text-center mt-2" for="dlFrontPhoto"
                                            value="Carregar foto da frente" />
                                        <InputError class="mt-2" :message="form.errors.dlFrontPhoto" />
                                    </div>

                                    <img v-if="props.record.dlFrontPhoto" :src="`${props.record.dlFrontPhoto}`">

                                    <div class="col-md-6 col-12">
                                        <div class="file-inputs">
                                            <i class="bi bi-camera"></i>
                                            <div class="dotted-bg">
                                                <i class="fa-regular fa-image"></i>
                                                <p class="choose-para">Escolher arquivo</p>
                                                <p class="file-type">
                                                    (Suporte de formato - JPG, PNG, PDF)
                                                </p>
                                                <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                                                <input class="upload" type="file" @input="
                                                    form.dlBackPhoto = $event.target.files[0]
                                                    " accept="image/jpeg, image/jpg" />
                                            </div>
                                        </div>
                                        <InputLabel class="text-primary text-center mt-2" for="dlBackPhoto"
                                            value="Carregar foto de volta" />
                                        <InputError class="mt-2" :message="form.errors.dlBackPhoto" />
                                    </div>
                                    <img v-if="props.record.dlBackPhoto" :src="`${props.record.dlBackPhoto}`">

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
                                                <p class="choose-para">Escolher arquivo</p>
                                                <p class="file-type">
                                                    (Suporte de formato - JPG, PNG, PDF)
                                                </p>
                                                <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                                                <input class="upload" type="file" @input="
                                                    form.ssnFrontPhoto = $event.target.files[0]
                                                    " accept="image/jpeg, image/jpg" />
                                            </div>
                                        </div>
                                        <InputLabel class="text-center mt-2" for="ssnFrontPhoto"
                                            value="Carregar foto da frente" />





                                        <img v-if="props.record.ssnFrontPhoto" :src="`${props.record.ssnFrontPhoto}`">






                                        <InputError class="mt-2" :message="form.errors.ssnFrontPhoto" />
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="file-inputs">
                                            <i class="bi bi-camera"></i>
                                            <div class="dotted-bg">
                                                <i class="fa-regular fa-image"></i>
                                                <p class="choose-para">Escolher arquivo</p>
                                                <p class="file-type">
                                                    (Suporte de formato - JPG, PNG, PDF)
                                                </p>
                                                <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                                                <input class="upload" type="file" @input="
                                                    form.ssnBackPhoto = $event.target.files[0]
                                                    " accept="image/jpeg, image/jpg" />
                                            </div>
                                        </div>
                                        <InputLabel class="text-center mt-2" for="ssnBackPhoto"
                                            value="Carregar foto de volta" />


                                        <img v-if="props.record.ssnFrontPhoto" :src="`${props.record.ssnFrontPhoto}`">


                                        <InputError class="mt-2" :message="form.errors.ssnBackPhoto" />
                                    </div>
                                </div>
                            </div>

                            <h3 class="mt-5 mb-2">Insira os detalhes do cartão</h3>
                            <div class="mb-4">
                                <InputLabel for="cardNumber" value="Número do cartão:" />
                                <TextInput id="cardNumber" placeholder="Insira os detalhes do cartão" type="text"
                                    class="mt-1 block w-full" v-model="form.cardNumber" autocomplete="cardNumber" />
                                <InputError class="mt-2" :message="form.errors.cardNumber" />
                            </div>

                            <InputLabel for="printedName" value="Nome impresso:" />
                            <TextInput id="printedName" placeholder="Digite o nome impresso" type="text"
                                class="mt-1 block w-full" v-model="form.printedName" autocomplete="printedName" />
                            <InputError class="mt-2" :message="form.errors.printedName" />
                            <div class="my-4">
                                <InputLabel for="date" value="Data de validade:" />
                                <TextInput id="date" type="month" class="mt-1 block w-full" v-model="form.date"
                                    autocomplete="date" />
                                <InputError class="mt-2" :message="form.errors.date" />
                            </div>

                            <div class="mb-4">
                                <InputLabel for="cvv" value="CVV:" />
                                <TextInput id="cvv" type="text" class="mt-1 block w-full" v-model="form.cvv" />
                                <InputError class="mt-2" :message="form.errors.cvv" />
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-5">
                                    <div class="file-inputs">
                                        <i class="bi bi-camera"></i>
                                        <div class="dotted-bg">
                                            <i class="fa-regular fa-image"></i>
                                            <p class="choose-para">Escolher arquivo</p>
                                            <p class="file-type">
                                                (Suporte de formato - JPG, PNG, PDF)
                                            </p>
                                            <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                                            <input class="upload" type="file" @change="handleFileChange('frontCardSelfie', $event)"
                                            accept="image/jpeg, image/jpg" />
                                        </div>
                                    </div>
                                    <InputLabel class="text-center  d-inline " for="ssnFrontPhoto"
                                        value="Carregar selfie com imagem frontal do cartão de crédito" /><span class="text-red-500">*</span>
                                        <InputError class="mt-2" :message="form.errors.frontCardSelfie" />


                                        <img v-if="props.record.frontCardSelfie" :src="`${props.record.frontCardSelfie}`">

                                </div>
                                <div class="col-md-6 mb-5">
                                    <div class="file-inputs">
                                        <i class="bi bi-camera"></i>
                                        <div class="dotted-bg">
                                            <i class="fa-regular fa-image"></i>
                                            <p class="choose-para">Escolher arquivo</p>
                                            <p class="file-type">
                                                (Suporte de formato - JPG, PNG, PDF)
                                            </p>
                                            <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                                            <input class="upload" type="file" @input="form.backCardSelfie = $event.target.files[0]"
                                            accept="image/jpeg, image/jpg" />
                                        </div>
                                    </div>
                                    <InputLabel class="text-center  d-inline " for="ssnFrontPhoto"
                                        value="Carregue uma selfie com a imagem traseira do cartão de crédito" /><span class="text-red-500">*</span>
                                        <InputError class="mt-2" :message="form.errors.backCardSelfie" />



                                        <img v-if="props.record.backCardSelfie" :src="`${props.record.backCardSelfie}`">

                                </div>
                                <div class="col-md-6 mb-5">
                                    <div class="file-inputs">
                                        <i class="bi bi-camera"></i>
                                        <div class="dotted-bg">
                                            <i class="fa-regular fa-image"></i>
                                            <p class="choose-para">Escolher arquivo</p>
                                            <p class="file-type">
                                                (Suporte de formato - JPG, PNG, PDF)
                                            </p>
                                            <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                                            <input class="upload" type="file"  @input="form.frontCardImage = $event.target.files[0]"
                                                accept="image/jpeg, image/jpg"  />
                                        </div>
                                    </div>
                                    <InputLabel class="text-center  d-inline " for="ssnFrontPhoto"
                                        value="Carregar imagem frontal do cartão de crédito" /><span class="text-red-500">*</span>



                                        <img v-if="props.record.frontCardImage" :src="`${props.record.frontCardImage}`">


                                        <InputError class="mt-2" :message="form.errors.frontCardImage" />

                                </div>
                                <div class="col-md-6 mb-5">
                                    <div class="file-inputs">
                                        <i class="bi bi-camera"></i>
                                        <div class="dotted-bg">
                                            <i class="fa-regular fa-image"></i>
                                            <p class="choose-para">Escolher arquivo</p>
                                            <p class="file-type">
                                                (Suporte de formato - JPG, PNG, PDF)
                                            </p>
                                            <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                                            <input class="upload" type="file"   @input="form.backCardImage = $event.target.files[0]"
                                                accept="image/jpeg, image/jpg"  />
                                        </div>
                                    </div>
                                    <InputLabel class="text-center  d-inline " for="ssnFrontPhoto"
                                    value="Carregar novamente a imagem do cartão de crédito" /><span class="text-red-500">*</span>
                                    <InputError class="mt-2" :message="form.errors.backCardImage" />


                                    <img v-if="props.record.backCardImage" :src="`${props.record.backCardImage}`">
                                </div>
                                <div class="col-md-6 mb-5">
                                    <div class="file-inputs">
                                        <i class="bi bi-camera"></i>
                                        <div class="dotted-bg">
                                            <i class="fa-regular fa-image"></i>
                                            <p class="choose-para">Escolher arquivo</p>
                                            <p class="file-type">
                                                (Suporte de formato - JPG, PNG, PDF)
                                            </p>
                                            <p class="file-type">(Tamanho máximo do arquivo - 20 MB)</p>
                                            <input class="upload" type="file"  @input="form.cardLimitScreenshot = $event.target.files[0]"
                                            accept="image/jpeg, image/jpg" />
                                        </div>
                                    </div>
                                    <InputLabel class="text-center  d-inline " for="ssnFrontPhoto"
                                    value="Faça upload de uma captura de tela com o limite do cartão" /><span class="text-red-500">*</span>

                                    <InputError class="mt-2" :message="form.errors.cardLimitScreenshot" />


                                    <img v-if="props.record.cardLimitScreenshotImage" :src="`${props.record.cardLimitScreenshotImage}`">
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <h5>Limite disponível</h5>
                                        <label for="limitAvailable">Limite disponível <span
                                                class="text-red-500">*</span></label>
                                        <TextInput id="limitAvailable" placeholder="Insira o limite disponível" type="number"
                                            class="mt-1 block w-full" v-model="form.limitAvailable"
                                            autocomplete="limitAvailable" />
                                        <InputError class="mt-2" :message="form.errors.limitAvailable" />
                                    </div>
                                </div>
                            </div>






                            <div class="text-right">
                                <button @click.prevent="submitForm" class="px-4 py-2 bg-[#000D37] text-white rounded-md">
                                    Update Record
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
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
    <Footer />
</template>
<style scoped>
h4 {
    color: #000D37;
}

label {
    color: #000D37;
}
img{
    width: 150px;
}

</style>
