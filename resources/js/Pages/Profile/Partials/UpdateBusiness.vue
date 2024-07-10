<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import Footer from "../../Frontend/Footer.vue";
import { Country } from 'country-state-city';
import { ref } from 'vue';

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    business:{
        type:Object
    }
});

const user = usePage().props.auth.user;

const form = useForm({
    id:props.business.id,
    user_id: user.id,
    company_name :props.business.company_name,
    contact_number :props.business.contact_number,
    company_address :props.business.company_address,
    company_country_code :props.business.company_country_code,
    company_state :props.business.company_state,
    company_city :props.business.company_city,
    company_pin :props.business.company_pin,
    contact_department :props.business.contact_department,
    company_vat :props.business.company_vat,
});


const submit2 = () => {
    form.put(route('update.business'), {
        preserveScroll: true,
        onSuccess: () => {
            toast("Business Updated Successfully.!", {
            autoClose: 2000,
            theme: "dark",
        });
        },
    });
};
const class_ = ref('Selected_option');
const countries = Country.getAllCountries();

</script>
<template>
    <section class="profile_info">
        <header>
            <h2 class="text-lg font-medium text-gray-900">Business Information</h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's business information.
            </p>
        </header>


        <form class="mt-6 space-y-6 " @submit.prevent="submit2()">

                <div class="row justify-content-between business_profile_front_end">
                    <div class="col-lg-6 col-md-6 col-sm-12 p-0 col_width">
                        <div class="profile_input">
                        <InputLabel for="name" value="Company Name" />
                        <TextInput  type="text" class="mt-1 block w-full" placeholder="Enter company name" v-model="form.company_name"  autofocus autocomplete="name"/>
                        <InputError class="mt-2" :message="form.errors.company_name" />
                    </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 p-0 col_width">
                        <div class="profile_input">
                            <InputLabel for="name" value="Contact Person" />
                            <TextInput  type="text" class="mt-1 block w-full" placeholder="Enter contact person" v-model="form.contact_number"  autofocus autocomplete="name"/>
                            <InputError class="mt-2" :message="form.errors.contact_number" />
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 p-0 col_width" >
                        <div class="profile_input">
                            <InputLabel for="name" value="Company Address" />
                            <TextInput  type="text" class="mt-1 block w-full" placeholder="Enter company address" v-model="form.company_address"  autofocus autocomplete="name"/>
                            <InputError class="mt-2" :message="form.errors.company_address" />
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 p-0 col_width">
                        <div class="profile_input">
                            <InputLabel for="name" value="Country" />
                            <!-- <TextInput  type="text" class="mt-1 block w-full" v-model="form.company_country_code"  autofocus autocomplete="name"/> -->
                            <select class='form-control mt-1' v-model="form.company_country_code" :class="class_">
                                <option value=""> Select Country</option>
                                <option v-for="country  in countries" :value="country.isoCode">{{ country.name}}</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.company_country_code" />
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 p-0 col_width">
                        <div class="profile_input">
                            <InputLabel for="name" value="State" />
                            <TextInput  type="text" class="mt-1 block w-full" placeholder="Enter state" v-model="form.company_state"  autofocus autocomplete="name"/>
                            <InputError class="mt-2" :message="form.errors.company_state" />
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 p-0 col_width">
                        <div class="profile_input">
                            <InputLabel for="name" value="City" />
                            <TextInput  type="text" class="mt-1 block w-full" placeholder="Enter city" v-model="form.company_city"  autofocus autocomplete="name"/>
                            <InputError class="mt-2" :message="form.errors.company_city" />
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 p-0 col_width">
                        <div class="profile_input">
                            <InputLabel for="name" value="PIN" />
                            <TextInput  type="text" class="mt-1 block w-full" placeholder="Enter pin" v-model="form.company_pin"  autofocus autocomplete="name"/>
                            <InputError class="mt-2" :message="form.errors.company_pin" />
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 p-0 col_width">
                        <div class="profile_input">
                            <InputLabel for="name" value="Contact Department" />
                            <TextInput  type="text" class="mt-1 block w-full" placeholder="Enter contact department" v-model="form.contact_department"  autofocus autocomplete="name"/>
                            <InputError class="mt-2" :message="form.errors.contact_department" />
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 p-0 col_width">
                        <div class="profile_input">
                            <InputLabel for="name" value="Company VAT (If Applicable)" />
                            <TextInput  type="text" class="mt-1 block w-full" placeholder="Enter company VAT" v-model="form.company_vat" autofocus autocomplete="name"/>
                            <InputError class="mt-2" :message="form.errors.company_vat" />
                        </div>
                    </div>
                </div>
            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing" class="form-btn" >Save</PrimaryButton>
                <!-- <Link @click="submit2" class="btn btn-primary">Save  </Link> -->

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-white-600 bg-primary "></p>
                </Transition>
            </div>
        </form>
    </section>
</template>
