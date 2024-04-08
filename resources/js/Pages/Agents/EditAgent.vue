<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { useToast } from 'vue-toastify';

const { agent, errors } = defineProps(['agent', 'errors']);
const form = useForm({
    user_type: '2',
    name: agent.name,
    email: agent.email,
    password: agent.password,
    status: agent.status,
    phone: agent.phone,
    address: agent.address,
});

const submit = () => {
    const toast = useToast();
    const formData = {
        name: form.name || '',
        email: form.email || '',
        password: form.password || '',
        phone: form.phone || '',
        address: form.address || '',
        status: form.status,
    };

    router.put(`/agents/update-agent/${agent.id}`, formData, {
        onSuccess: () => {
            router.visit(route('agents'))
            toast.success('Agent Updated Successfully');
        },
        onError: (errors) => {
            // console.log('Validation Error:', errors);
            toast.error('Validation Error: Please check your inputs');
        },
    });
};

</script>
<template>
    <AuthenticatedLayout>

        <Head title="Edit Agent" />
        <div class="flex items-center justify-center p-6 ">
            <div class="w-full">
                <h1 class="mb-4 text-xl font-semibold text-black-700">Edit Agent</h1>

                <form class="row" @submit.prevent="submit">
                    <div class="mt-4 col-md-6">
                        <InputLabel for="name" value="Name" style="display: inline-block;" /><strong class="required-asterisk">* </strong>
                        <TextInput id="name" type="text" placeholder="Enter Name" class="fomr-control" :value="form.name" v-model="form.name" autocomplete="name" />
                        <InputError class="mt-2" :message="errors.name" />
                    </div>

                    <div class="mt-4 col-md-6">
                        <InputLabel for="email" value="Email" style="display: inline-block;" /><strong class="required-asterisk">* </strong>
                        <TextInput id="email" type="email" placeholder="Enter Email" class="fomr-control" :value="form.email" v-model="form.email" autocomplete="email" />
                        <InputError class="mt-2" :message="errors.email" />
                    </div>

                    <div class="mt-4 col-md-6">
                        <InputLabel for="phone" value="Phone" style="display: inline-block;" /><strong class="required-asterisk">* </strong>
                        <TextInput id="phone" type="text" placeholder="Enter Phone Number" class="fomr-control" v-model="form.phone" autocomplete="phone" />
                        <InputError class="mt-2" :message="errors.phone" />
                    </div>

                    <!-- <div class="mt-4 col-md-6">
                        <InputLabel for="address" value="Address" style="display: inline-block;"/><strong class="required-asterisk">* </strong>
                        <TextInput id="address" type="text" placeholder="Enter Address" class="fomr-control" v-model="form.address" autocomplete="address" />
                        <InputError class="mt-2" :message="errors.address" />
                    </div> -->

                    <div class="mt-4 col-md-6">
                        <InputLabel id="toggle-label" value="Status" />
                        <Toggle id="status" labelledby="toggle-label" :classes="{
                            toggle: 'flex w-12 h-5 rounded-full relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
                            toggleOn: 'bg-gray-300 border-green-500 justify-start text-gray',
                            toggleOff: 'bg-gray-300 border-gray-300 justify-end text-black-700',
                            label: 'text-center w-8 border-box whitespace-nowrap select-none',
                        }" true-value="1" false-value="0" v-model="form.status" />
                        <InputError class="mt-2" :message="form.errors.status" />
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

