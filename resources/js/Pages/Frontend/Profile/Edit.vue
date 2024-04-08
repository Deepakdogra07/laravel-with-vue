<script setup>
import { reactive, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import Footer from "../../Frontend/footer.vue";
import Header from "../../Frontend/header.vue";
import "../../../../css/frontend.css";
import Sidebar from "../../Frontend/Layouts/sidebar.vue"
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { computed } from 'vue';

const props = defineProps(['userData', 'errors', 'acountDetails']);

// onMounted(()=>{
//     alert(props.userData.phone);
// })
const updateUserProfile = () => {
  form.put(route('update.user.profile', { id: props.userData.id }),
    {

      onSuccess: () => {
        form.password = '';
        form.password_confirmation = '';
        form.old_password = '';
        toast("Atualização de perfil com sucesso!", {
          autoClose: 2000,
          theme: 'dark',
        }
        );
      },

    });
};

const selectedInput = ref('pixKey');

const form = useForm({
  name: props.userData ? props.userData.name : '',
  email: props.userData ? props.userData.email : '',
  password: props.userData ? props.userData.password : '',
  address: props.userData ? props.userData.address : '',


  phone: props.userData && props.userData.phone !=null ? props.userData.phone : '',

  password_confirmation: props.userData ? props.userData.password_confirmation : '',
  old_password: '',
  account_details: props.acountDetails ? props.acountDetails.account_details : '',
  isChecked: props.userData ? props.userData.isChecked : '',


  receiveLoanThrough: props.userData ? props.userData.receiveLoanThrough : 0,



  //   pixtype: props.userData ? props.userData.pixtype : 'pixcpf',

  pixtype: props.userData && props.userData.pixtype !== null && props.userData.pixtype !== undefined && props.userData.pixtype !== '' ? props.userData.pixtype : 'pixcpf',

  pixdata: props.userData && props.userData.phonenumber ? props.userData.phonenumber :
    props.userData && props.userData.through_email ? props.userData.through_email :
      props.userData && props.userData.randomkey ? props.userData.randomkey :
        props.userData && props.userData.cpf ? props.userData.cpf :
          (props.userData ? props.userData.pixdata : ''),



  phonenumber: props.userData ? props.userData.phonenumber : '',
  pixcpf: props.userData ? props.userData.pixcpf : '',
  randomkey: props.userData ? props.userData.randomkey : '',
  bankcode: props.userData ? props.userData.bankcode : '',
  agencyNumber: props.userData ? props.userData.agency_number : '',
  currentAccountNumber: props.userData ? props.userData.account_number : '',
  cpf: props.userData ? props.userData.bank_cpf : '',
});

const inputLabels = {
  pixKey: 'Número Pix',
  pixcpf: 'CPF',
  phonenumber: 'Número de Telefone',
  eemail: 'Digite o e-mail',
  randomkey: 'Chave Aleatória'
};

const inputPlaceholders = {
  pixKey: 'Digite PixKey',
  pixcpf: 'Insira o CPF',
  phonenumber: 'Digite o NÚMERO DE TELEFONE',
  eemail: 'Digite o e-mail',
  randomkey: 'CHAVE ALEATÓRIA'
};


// const checkType = () => {
//   if (form.isChecked == 0) {
//     form.receiveLoanThrough = '0';
//     form.bankcode = '';
//     form.agencyNumber = '';
//     form.currentAccountNumber = '';
//     form.cpf = '';
//   } else {
//     form.receiveLoanThrough = '1';
//     form.pixdata = '';
//   }
// };

const checkType = () => {
  if (form.isChecked == 0) {
    form.receiveLoanThrough = '0';
    form.pixKey = '';
    form.pixcpf = '';
    form.phonenumber = '';
    form.eemail = '';
    form.randomkey = '';
  } else {
    form.receiveLoanThrough = '1';
    form.bankcode = '';
    form.agencyNumber = '';
    form.currentAccountNumber = '';
    form.cpf = '';
  }
};


onMounted(() => {
  // alert(props.userData.receiveLoanThrough);
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
  } else if (value == 'eemail') {
    form.pixdata = '';
    form.errors.pixdata = '';
  } else if (value == 'randomkey') {
    form.pixdata = '';
    form.errors.pixdata = '';
  }
}
</script>

<template>
  <!-- <h2>{{ props.acountDetails.isChecked }}</h2> -->

  <Head title="Página de perfil" />
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
          <div class="d-flex ">
            <h2>Editar Perfil</h2>
          </div>
          <div class="row mt-4">
            <div class="col-md-12">
              <div class="myloan-tabel">
                <form @submit.prevent="updateUserProfile" class="my-form">
                  <div class="row edit-profile-form">
                    <h3>Detalhes pessoais</h3>
                    <div class="col-md-8 col-12 my-3">
                      <label for="name">Nome <span class="text-red-500">*</span></label>
                      <input class="form-control" id="name" v-model="form.name" placeholder="Insira o nome" />
                      <div v-if="errors.name" class="text-red-700">{{ errors.name }}</div>
                    </div>

                    <div class="col-md-8 col-12">
                      <label for="email">E-mail <span class="text-red-500">*</span></label>
                      <input class="form-control" id="email" v-model="form.email" placeholder="Digite o e-mail" />
                      <div v-if="errors.email" class="text-red-700">{{ errors.email }}</div>
                    </div>
                    <div class="col-md-8 col-12 my-3">
                      <label for="phone">Telefone <span class="text-red-500">*</span></label>
                      <input class="form-control" id="phone" v-model="form.phone" placeholder="Digite o telefone" />
                      <div v-if="errors.phone" class="text-red-700">{{ errors.phone }}</div>
                    </div>


                    <!-- <div class="col-md-8 col-12 my-3">
                                            <label for="phone">Número de conta <span class="text-red-500">*</span></label>
                                            <input class="form-control" id="account_details" v-model="form.account_details"
                                                placeholder="Insira o número da conta" />
                                            <div v-if="errors.phone" class="text-red-700">{{ errors.account_details }}</div>
                                        </div> -->



                  </div>
                  <div class="row mt-4 edit-profile-form">
                    <h3>Alterar a senha</h3>
                    <div class="col-md-8 col-12 my-3">
                      <label for="password">Senha Antiga </label>
                      <input class="form-control" type="password" id="password" v-model="form.old_password"
                        placeholder="Digite a senha antiga" />
                      <div v-if="errors.old_password" class="text-red-700">{{ errors.old_password }}</div>
                    </div>
                    <div class="col-md-8 col-12 my-3">
                      <label for="password">Nova Senha</label>
                      <input type="password" class="form-control" id="password" v-model="form.password"
                        placeholder="Digite a senha" />
                      <div v-if="errors.password" class="text-red-700">{{ errors.password }}</div>
                    </div>
                    <div class="col-md-8 col-12">
                      <label for="password_confirmation">Confirme sua senha </label>
                      <input type="password" class="form-control" id="password_confirmation"
                        v-model="form.password_confirmation" placeholder="Digite Confirmar Senha" />
                      <div v-if="errors.password_confirmation" class="text-red-700">{{
                  errors.password_confirmation }}</div>
                    </div>
                  </div>
                  <div class="mt-4 col-md-6 custom-toggle">
                    <div class="recieve-heading mb-3">
                      <div class="recieve-heading mb-3">
                        <h3>Receber valor de retirada</h3>
                      </div>
                    </div>
                    <div class="flex items-center mb-2 custom-toggle" style="gap: 20px;">
                      <h4>Pix</h4>

                      <Toggle id="receive-loan-through-toggle" labelledby="toggle-label" :classes="{
                  toggle: 'flex w-16 h-8 rounded-full relative cursor-pointer transition items-center box-content text-xs leading-none',
                  toggleOn: 'bg-sky-400 justify-start text-white',
                  toggleOff: 'bg-sky-400 justify-end text-black-700',
                  label: 'text-center w-8 border-box whitespace-nowrap select-none',
                }" true-value=1 false-value=0 v-model="form.isChecked" @change="checkType" />
                      <h4>Transferência bancária</h4>
                    </div>
                    <InputError class="mt-2" :message="form.errors.status" />
                  </div>


                  <div v-if="form.receiveLoanThrough == '0'" class="my-4 col-md-8">
                    <div class="my-4 d-flex align-items-center flex-wrap gap-4">
                      <div class="d-flex align-items-center gap-1">
                        <input class="radio-link-btn" type="radio" id="pixcpfRadio" name="inputType" value="pixcpf"
                          v-model="form.pixtype" @click="radioClicked('pixcpf')">
                        <label for="pixcpfRadio">CPF</label>
                      </div>
                      <div class="d-flex align-items-center gap-1">
                        <input class="radio-link-btn" type="radio" id="phoneNumberRadio" name="inputType"
                          value="phonenumber" v-model="form.pixtype" @click="radioClicked('phonenumber')">
                        <label for="phoneNumberRadio">Número de Telefone</label>
                      </div>
                      <div class="d-flex align-items-center gap-1">
                        <input class="radio-link-btn" type="radio" id="emailRadio" name="inputType" value="eemail"
                          v-model="form.pixtype" @click="radioClicked('eemail')">
                        <label  for="emailRadio">Digite o e-mail</label>
                      </div>
                      <div class="d-flex align-items-center gap-1">
                        <input class="radio-link-btn" type="radio" id="randomKeyRadio" name="inputType"
                          value="randomkey" v-model="form.pixtype" @click="radioClicked('randomkey')">
                        <label  for="randomKeyRadio">Chave Aleatória</label>
                      </div>
                    </div>

                    <div class="my-4">
                      <label  :for="form.pixtype">
                        {{ inputLabels[form.pixtype] }}
                      </label>

                      <TextInput :id="form.pixtype" :placeholder="inputPlaceholders[form.pixtype]" type="text"
                        class="mt-1 block w-full" v-model="form.pixdata" :autocomplete="form.pixtype" />
                      <InputError class="mt-2" :message="form.errors.pixdata" />

                    </div>
                  </div>

                  <div v-if="form.receiveLoanThrough == '1'" class="mb-4 col-md-8">
                    <div class="my-4">
                      <label for="pixKey">
                        Código bancário
                      </label>
                      <TextInput id="bankcode" placeholder="Digite o código do banco" type="text"
                        class="mt-1 block w-full" v-model="form.bankcode" autocomplete="bankcode" />
                      <InputError class="mt-2" :message="form.errors.bankcode" />

                    </div>


                    <div>
                      <label for="pixKey">
                        Número da agência
                      </label>
                      <TextInput id="agencyNumber" placeholder="Insira o número da agência" type="text"
                        class="mt-1 block w-full" v-model="form.agencyNumber" autocomplete="agencyNumber" />
                      <InputError class="mt-2" :message="form.errors.agencyNumber" />
                    </div>


                    <div class="my-4">

                      <label for="pixKey">
                        Número da conta corrente
                      </label>
                      <TextInput placeholder="Insira o número da conta atual" id="currentAccountNumber" type="text"
                        class="mt-1 block w-full" v-model="form.currentAccountNumber" />
                      <InputError class="mt-2" :message="form.errors.currentAccountNumber" />
                    </div>



                    <div class="my-4">
                      <label for="cpf">
                        CPF (Número de Identificação Nacional) vinculado à conta
                      </label>
                      <TextInput placeholder="Insira o CPF" id="cpf" type="text" class="mt-1 block "
                        v-model="form.cpf" />
                      <InputError class="mt-2" :message="form.errors.cpf" />
                    </div>

                  </div>

                  <button class="copy-code" type="submit">SALVAR ALTERAÇÕES</button>
                  <Link class="pl-5 new-cancel-link">CANCELAR</Link>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>





  <Footer />
</template>
