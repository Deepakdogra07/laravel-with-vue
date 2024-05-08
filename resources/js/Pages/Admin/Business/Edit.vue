<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    customer: {
        type: Array
    }
})
const form = useForm({
    id: props.customer.id,
    user_type: props.customer?.user_type,
    name: props.customer?.name,
    email: props.customer?.email,
    password: props.customer?.password,
    status: props.customer?.status,
    phone: props.customer?.phone,

});

const submit = () => {
    form.post(route('business-listing.update', form.id), {
        onSuccess: () => {
            toast("Employer Updated Successfully", {
          autoClose: 2000,
          theme: 'dark',
        });
            
        }
    });
};
</script>
<template>
    <AuthenticatedLayout>

        <Head title="Update Employer" />
        <div class="flex items-center justify-center px-2">
            <div class="w-full">
                <h1 class="text-xl font-semibold text-gray-700">Update Employer</h1>

                <form @submit.prevent="submit">
                    <div class="row">
                        <div class="mt-4 col-md-6">
                            <InputLabel for="name" value="UserName" style="display: inline-block;" /><strong
                                class="required-asterisk">*
                            </strong>
                            <TextInput id="name" type="text" placeholder="Enter Employer UserName" class="form-control"
                                v-model="form.name" autocomplete="name" />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="mt-4 col-md-6">
                            <InputLabel for="email" value="Email" style="display: inline-block;" /><strong
                                class="required-asterisk">*
                            </strong>
                            <TextInput id="email" type="email" placeholder="Enter Email" class="form-control"
                                v-model="form.email" autocomplete="email" />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>



                        <div class="mt-4 col-md-6">
                            <InputLabel for="phone" value="Phone" style="display: inline-block;" /><strong
                                class="required-asterisk">*
                            </strong>
                            <TextInput id="phone" type="text" placeholder="Enter Phone Number" class="form-control"
                                v-model="form.phone" autocomplete="phone" />
                            <InputError class="mt-2" :message="form.errors.phone" />
                        </div>
                       
                        <div class="mt-4 col-md-6">

                            <div class="configure-switch d-flex align-items-center gap-3">
                                <div class="d-flex">
                                    <input type="checkbox" id="status" v-model="form.status" true-value="1" false-value="0" name="status" />
                                    <label for="status"></label>
                                </div>
                                <p class="mb-0 semibold">Status</p>
                            </div>


                            <InputError class="mt-2" :message="form.errors.status" />
                        </div>
                    </div>
                    <div class="mt-4">
                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                            type="submit">
                            Submit
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
