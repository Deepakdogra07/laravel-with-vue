<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastify';
import { router } from '@inertiajs/vue3';


const props = defineProps({
    comissionLoan : Array,
});

const form = useForm({
    commission: props.comissionLoan ? props.comissionLoan.commission : '',
    discount: props.comissionLoan ? props.comissionLoan.discount : '',
    interest: props.comissionLoan ? props.comissionLoan.interest : '',
});

const submit = () => {
    const toast = useToast();
    form.post(route('add-commission'), {
        onSuccess: () => {
            toast.success('Commission/Interest Added Successfully');
            setTimeout(() => {
            window.location.reload();
        }, 1000);
        },
        onError: (errors) => {
        },
    });
};
</script>
<template>
    <AuthenticatedLayout>
        <div class="flex items-center justify-center">
            <div class="w-full px-2">
                <h2 class="font-semibold text-xl text-black-800 leading-tight">Add Interest Commission</h2>
                <form @submit.prevent="submit">
                    <div class="row">
                        <div class="mt-4 col-md-6">
                            <InputLabel for="commission" value="Commission (in %)" />
                            <TextInput id="commission" placeholder="Enter Commission" class="block w-full mt-1"
                                v-model="form.commission" autocomplete="commission" />
                            <InputError class="mt-2" :message="form.errors.commission" />
                        </div>

                        <div class="mt-4 col-md-6">
                            <InputLabel for="discount" value="Discount (in %)" />
                            <TextInput id="discount" placeholder="Enter Discount" class="block w-full mt-1"
                                v-model="form.discount" autocomplete="discount" />
                            <InputError class="mt-2" :message="form.errors.discount" />
                        </div>

                        <div class="mt-4 col-md-6">
                            <InputLabel for="interest" value="Interest (in %)" />
                            <TextInput id="interest" placeholder="Enter Interest" class="block w-full mt-1"
                                v-model="form.interest" autocomplete="interest" />
                            <InputError class="mt-2" :message="form.errors.interest" />
                        </div>

                    </div>
                    <div class="mt-4">
                        <PrimaryButton class="btn-primary" @click="submit" type="submit">
                            Submit
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
