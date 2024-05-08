<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
// import { defineProps , ref} from 'vue';
import { router } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';

const { customer, errors } = defineProps(['customer', 'errors']);

const form = useForm({
  name: customer.name,
  email: customer.email,
  status: customer.status,
  phone: customer.phone,
  address: customer.address,

});
// console.log(form);
const submit = () => {  
  const formData = {
    name: form.name || '',
    email: form.email || '',
    phone: form.phone || '',
    address: form.address || '',
    status: form.status,
  };
  router.put(`/customers/update-customer/${customer.id}`, formData, {
    onSuccess: () => {
        toast("Customer Updated Successfully!", {
          autoClose: 2000,
          theme: 'dark',
        }
        );
     
    },
    // onError: (errors) => {
    //     toast.error('Validation Error: Please check your inputs');
    // },
  });
}
</script>
<template>
  <AuthenticatedLayout>

    <Head title="Edit Customer" />
    <div class="flex items-center justify-center p-6 ">
      <div class="w-full">
        <h1 class="mb-4 text-xl font-semibold text-black-700">Edit Customer</h1>

        <form class="row" @submit.prevent="submit">
          <div class="mt-4 col-md-6">
            <InputLabel for="name" value="Name" style="display: inline-block;" /><strong class="required-asterisk">*
            </strong>
            <TextInput id="name" type="text" placeholder="Enter Name" class="form-control" :value="form.name"
              v-model="form.name" autocomplete="name" />
            <InputError class="mt-2" :message="errors.name" />
          </div>

          <div class="mt-4 col-md-6">
            <InputLabel for="email" value="Email" style="display: inline-block;" /><strong class="required-asterisk">*
            </strong>
            <TextInput id="email" type="email" placeholder="Enter Email" class="form-control" :value="form.email"
              v-model="form.email" autocomplete="email" readonly />
            <InputError class="mt-2" :message="errors.email" />
          </div>

          <div class="mt-4 col-md-6">
            <InputLabel for="phone" value="Phone" style="display: inline-block;" /><strong class="required-asterisk">*
            </strong>
            <TextInput id="phone" type="text" placeholder="Enter Phone Number" class="form-control" v-model="form.phone"
              autocomplete="phone" />
            <InputError class="mt-2" :message="errors.phone" />
          </div>

          <!-- <div class="mt-4 col-md-6">
                <InputLabel for="address" value="Address" style="display: inline-block;"/><strong class="required-asterisk">* </strong>
                <TextInput id="address" type="text" placeholder="Enter Address" class="form-control" v-model="form.address" autocomplete="address" />
                <InputError class="mt-2" :message="errors.address" />
            </div> -->

          <div class="mt-4 col-md-6">

            <div class="configure-switch d-flex align-items-center gap-3">
              <div class="d-flex">
                <input type="checkbox" id="status" true-value="1" false-value="0" v-model="form.status" name="status" />
                <label for="status"></label>
              </div>
              <p class="mb-0 semibold">Status</p>
            </div>

            <!-- <InputLabel id="toggle-label" value="Status" />
            <Toggle id="status" labelledby="toggle-label" :classes="{
              toggle: 'flex w-12 h-5 rounded-full relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
              toggleOn: 'bg-gray-300 border-green-500 justify-start text-gray',
              toggleOff: 'bg-gray-300 border-gray-300 justify-end text-black-700',
              label: 'text-center w-8 border-box whitespace-nowrap select-none',
            }" true-value="1" false-value="0" v-model="form.status" /> -->
            <InputError class="mt-2" :message="errors.status" />
          </div>

          <div class="mt-4">
            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" type="submit">
              Submit
            </PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
