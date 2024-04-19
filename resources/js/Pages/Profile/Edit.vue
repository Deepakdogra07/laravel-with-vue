<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const props = defineProps({
  mustVerifyEmail: Boolean,
  status: String,
  discountCode: String,
  auth_type: String,
});



function copyReferralCode() {
  const BASE_URL = window.location.origin;
  const discountCode = props.discountCode;
  const discountCodeLink = `${BASE_URL}?discountcode=${discountCode}`;
  navigator.clipboard.writeText(discountCodeLink);
  toast("Discount code copy successfully !", {
    autoClose: 2000,
    theme: 'dark',
  }
  );
}


// function copyReferralCode() {
//     const BASE_URL = window.location.origin;
//     const referralCode = form.my_refferal_code;
//     const referralLink = `${BASE_URL}?refralcode=${referralCode}`;
//     navigator.clipboard.writeText(referralLink);

//     toast("Cópia do código de referência com sucesso!", {
//         autoClose: 2000,
//         theme: 'dark',
//     });
// }



</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
           <div class="d-flex justify-between w-100">
            <h3>Profile</h3>

                <!-- <div v-if="auth_type == 1">
                    <button @click="copyReferralCode" class="copy-code">
                <i class="fa-solid fa-copy"></i> &nbsp;Copy discount code</button>
                </div> -->

                <!-- <div v-if="auth_type == 2">
                    <button @click="copyReferralCode" class="copy-code">
                <i class="fa-solid fa-copy"></i> &nbsp;Copy Referral code</button>
                </div> -->
           </div>
        </template>




        <div class="sm:px-6 md:px-0 lg:px-0 space-y-6">
          <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <UpdateProfileInformationForm
                :must-verify-email="mustVerifyEmail"
                :status="status"
                class="max-w-xl"
            />
          </div>

          <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <UpdatePasswordForm class="max-w-xl" />
          </div>

          <!-- <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <DeleteUserForm class="max-w-xl" />
          </div> -->
        </div>
    </AuthenticatedLayout>
</template>
