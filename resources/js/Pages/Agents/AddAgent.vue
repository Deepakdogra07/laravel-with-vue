<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import Toggle from '@vueform/toggle'
import { Head, useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastify';
import { router } from '@inertiajs/vue3';

const form = useForm({
    user_type: '2',
    name: '',
    email: '',
    password: '',
    isChecked: false,
    status: '',
    phone: '',
    address: '',
    password_confirmation: '',
});

const submit = () => {
    const toast = useToast();
    form.status = form.isChecked === 'on' ? '1' : '0';
    form.post(route('agents.add-agent'), {
        onSuccess: () => {
            router.visit(route('agents'));
            toast.success('Agent Added Successfully');
        },
        onError: (errors) => {
            console.log(form.errors.name);

            // toast.error('Validation Error: Please check your inputs');
        },
    });
};
</script>
<template>
    <AuthenticatedLayout>

        <Head title="Add Agent" />
        <div class="flex items-center justify-center px-2">
            <div class="w-full pages-heading">
                <h2 class="text-xl font-semibold text-gray-700">Add Agent</h2>
                <form @submit.prevent="submit">
                    <div class="row">
                        <div class="mt-4 col-md-6">
                            <InputLabel for="name" value="Name" style="display: inline-block;" /><strong class="required-asterisk">* </strong>
                            <TextInput id="name" type="text" placeholder="Enter Agent Name" class="block w-full mt-1"
                                v-model="form.name" autocomplete="name" />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div class="mt-4 col-md-6">
                            <InputLabel for="email" value="Email" style="display: inline-block;" /><strong class="required-asterisk">* </strong>
                            <TextInput id="email" type="email" placeholder="Enter Email" class="block w-full mt-1"
                                v-model="form.email" autocomplete="email" />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>

                        <div class="mt-4 col-md-6">
                            <InputLabel for="password" value="Password" style="display: inline-block;" /><strong class="required-asterisk">* </strong>
                            <TextInput id="password" type="password" placeholder="Enter Password" class="block w-full mt-1"
                                v-model="form.password" autocomplete="current-password" />
                            <InputError class="mt-2" :message="form.errors.password" />

                        </div>

                        <div class="mt-4 col-md-6">
                            <InputLabel for="password_confirmation" value="Confirm Password" style="display: inline-block;"/><strong class="required-asterisk">* </strong>
                            <TextInput id="password_confirmation" type="password" placeholder="Enter Confirm Password" class="block w-full mt-1" v-model="form.password_confirmation"  autocomplete="new-password" />
                            <InputError class="mt-2" :message="form.errors.password_confirmation" />
                        </div>

                        <div class="mt-4 col-md-6">
                            <InputLabel for="phone" value="Phone" style="display: inline-block;" /><strong class="required-asterisk">* </strong>
                            <TextInput id="phone" type="text" placeholder="Enter Phone Number" class="mt-1 block w-full" v-model="form.phone" autocomplete="phone" />
                            <InputError class="mt-2" :message="form.errors.phone" />
                        </div>

                        <!-- <div class="mt-4 col-md-6">
                            <InputLabel for="address" value="Address" style="display: inline-block;"/><strong class="required-asterisk">* </strong>
                            <TextInput id="address" type="text" placeholder="Enter Address" class="mt-1 block w-full" v-model="form.address" autocomplete="address" />
                            <InputError class="mt-2" :message="form.errors.address" />
                        </div> -->

                        <div class="mt-4 col-md-6">
                            <InputLabel id="toggle-label" value="Status" />
                            <Toggle id="status" labelledby="toggle-label" :classes="{
                                toggle: 'flex w-12 h-5 rounded-full relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
                                toggleOn: 'bg-gray-300 border-green-500 justify-start text-gray',
                                toggleOff: 'bg-gray-300 border-gray-300 justify-end text-black-700',
                                label: 'text-center w-8 border-box whitespace-nowrap select-none',
                            }" true-value="on" false-value="off" v-model="form.isChecked" />
                            <InputError class="mt-2" :message="form.errors.status" />
                        </div>
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


