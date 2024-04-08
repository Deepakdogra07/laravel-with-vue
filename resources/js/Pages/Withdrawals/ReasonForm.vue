<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Toggle from '@vueform/toggle'
import { Head, useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastify';
import { Inertia } from '@inertiajs/inertia';

const id = defineProps(['id']);

const form = useForm({
    withdrawId: id,
    receipt: '',
});
const handleFileChange = (event) => {
    form.receipt = event.target.files[0];
};
const submit = () => {
    const toast = useToast();
    form.post(route('reason.add',{ id: form.withdrawId }), {
        onSuccess: () => {
            Inertia.visit('/withdraws');
            toast.success('Reason Uploaded Successfully');
        },
        onError: (errors) => {
            toast.error('Validation Error: Please check your inputs');
        },
    });
};
</script>
<template>
    <AuthenticatedLayout>

        <Head title="Rejection Reason" />
        <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
            <div class="w-full">
                <h1 class="mb-4 text-xl font-semibold text-gray-700">Rejection Reason</h1>

                <form @submit.prevent="submit" enctype="multipart/form-data">
                    <input type="hidden" v-model="form.withdrawId" />

                    <div class="mt-4">
                        <InputLabel for="receipt" value="Upload Reason" />
                        <TextInput id="receipt" type="text" placeholder="Enter Reject Reason" class="block w-full mt-1"
                        @change="handleFileChange"  v-model="form.receipt" autocomplete="receipt" accept="image/*"  />
                        <InputError class="mt-2" :message="form.errors.receipt" />
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


