<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastify';
import { router } from '@inertiajs/vue3';


const props = defineProps({ contactDetails: Array })

// const form = useForm({
//   email: props.contactDetails.email || '',
//   phone: props.contactDetails.phone_no || '',
//   address : props.contactDetails.address || '',
// });

const initialValues = {
  email: props.contactDetails && props.contactDetails.email ? props.contactDetails.email : '',
  phone: props.contactDetails && props.contactDetails.phone_no ? props.contactDetails.phone_no : null,
  address: props.contactDetails && props.contactDetails.address ? props.contactDetails.address : '',

  facebook: props.contactDetails && props.contactDetails.facebookurl ? props.contactDetails.facebookurl : '',
  instagram: props.contactDetails && props.contactDetails.instagramurl ? props.contactDetails.instagramurl : '',
  twitter: props.contactDetails && props.contactDetails.twitterurl ? props.contactDetails.twitterurl : '',
};

const form = useForm(initialValues);

const submit = () => {
  const toast = useToast();
  form.post(route('add-contact'), {
    onSuccess: () => {
      toast.success('Contact Details Updated Successfully');
    },
    onError: (errors) => {
      toast.error('Validation Error: Please check your inputs');
    },
  });
};

</script>
<template>
    <AuthenticatedLayout>
        <div class="flex items-center justify-center">
            <div class="w-full px-2">
                <h2 class="font-semibold text-xl text-black-800 leading-tight">Add Contact Details</h2>

                <form @submit.prevent="submit">
                    <div class="row">
                        <div class="mt-4 col-md-6">
                            <InputLabel class="font-bold" for="email" value="Email" />
                            <TextInput id="email" placeholder="Enter Email" class="block w-full mt-1" v-model="form.email"
                                autocomplete="email" />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="mt-4 col-md-6">
                            <InputLabel class="font-bold" for="phone" value="Phone" />
                            <TextInput id="phone" placeholder="Enter Phone" class="block w-full mt-1" v-model="form.phone"
                                autocomplete="phone" />
                            <InputError class="mt-2" :message="form.errors.phone" />
                        </div>


                        <div class="mt-4 col-md-6">
                            <InputLabel class="font-bold" for="address" value="Address" />
                            <TextInput id="address" placeholder="Enter Address" class="block w-full mt-1" v-model="form.address"
                                autocomplete="address" />
                            <InputError class="mt-2" :message="form.errors.address" />
                        </div>

                        <div class="mt-4 col-md-6">
                            <InputLabel class="font-bold" for="facebook" value="Facebook Url" />
                            <TextInput id="facebook" placeholder="Enter facebook Url" class="block w-full mt-1" v-model="form.facebook"
                                autocomplete="facebook" />
                            <InputError class="mt-2" :message="form.errors.facebook" />
                        </div>

                        <div class="mt-4 col-md-6">
                            <InputLabel class="font-bold" for="instagram" value="Instagram Url" />
                            <TextInput id="instagram" placeholder="Enter instagram Url" class="block w-full mt-1" v-model="form.instagram"
                                autocomplete="instagram" />
                            <InputError class="mt-2" :message="form.errors.instagram" />
                        </div>

                        <div class="mt-4 col-md-6">
                            <InputLabel class="font-bold" for="twitter" value="Twitter Url" />
                            <TextInput id="twitter" placeholder="Enter Twitter Url" class="block w-full mt-1" v-model="form.twitter"
                                autocomplete="Twitter" />
                            <InputError class="mt-2" :message="form.errors.twitter" />
                        </div>




                        <div class="mt-3 col-md-12">
                            <PrimaryButton @click="submit" type="submit">
                                Submit
                            </PrimaryButton>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
