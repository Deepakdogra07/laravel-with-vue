<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { router, Link } from '@inertiajs/vue3';
import { onMounted, ref, reactive, watch } from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';


const props = defineProps({
    message: {
        type: String
    },
    link: {
        type: Object
    },
    errors: {
        type: Object
    }
});

watch(props, (newVal, oldVal) => {
    if (newVal.message != null) {
        toast(newVal.message, {
            autoClose: 3000,
            theme: 'dark',
        });
    }
});


const updatedLogo = ref('');
const updatedCertificate = ref([]);

const form = reactive({
    id: props.link.id,
    logo_image: props.link.logo_image,
    logo_description: props.link.logo_description,
    facebook_url: props.link.facebook_url,
    instagram_url: props.link.instagram_url,
    linkedin_url: props.link.linkedin_url,
    twitter_url: props.link.twitter_url,
    office_email: props.link.office_email,
    office_phone: props.link.office_phone,
    office_address: props.link.office_address,
    certificate_images: JSON.parse(props.link.certificate_images),
    certificate_images_status: false
})
function submitForm() {
    router.post(route('update-link-update'), form);
}

function update_data(type, event) {
    if (type == "logo_image") {
        form.logo_image = event.target.files[0];
        updatedLogo.value = URL.createObjectURL(event.target.files[0])
        console.log(updatedLogo.value);
    } else if (type == 'certificate_images') {
        form.certificate_images = [];
        const files = Array.from(event.target.files);
        form.certificate_images.push(...files);
        for (const file of files) {
            updatedCertificate.value.push(URL.createObjectURL(file))
        }

        form.certificate_images_status = true;
    }
}

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-black-800 leading-tight">Add Other Data Fields</h2>
            <div class="button-container">
            </div>

        </template>
        <div class=" text-black-900">
            <div class="container">
                <form @submit.prevent="submitForm">
                    <input type="hidden" v-value="form.id">
                    <div class="image_uploading">
                        <h2>Logo Section</h2>
                        <div class="mb-4">
                            <label for="logoImage" class="block text-gray-700 text-sm font-bold mb-2">Logo
                                Image</label>
                            <img :src="props.link.logo_image == form.logo_image ? form.logo_image : updatedLogo"
                                alt="" style="height:150px; height: 150px;
                                    background-color: #ccc;
                                    padding: 20px;
                                    margin-bottom: 10px;">
                            <label for="logoImage"
                                class=" file_cursor form-control mt-2 cursor-pointer">
                                {{ form.logo_image ? 'Change File' : 'Upload File' }}
                            </label>
                            <input type="file" id="logoImage" @change="update_data('logo_image', $event)"
                                accept="image/*" class="hidden">
                        </div>
                        <div class="mb-4">
                            <label for="logoDescription"
                                class="block text-gray-700 text-sm font-bold mb-2">Logo
                                Description (less than 100 words)</label>
                            <textarea id="logoDescription" v-model="form.logo_description"
                                class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full"></textarea>
                            <span v-if="props.errors.logo_description" class="error-message">{{
                                props.errors.logo_description }}</span>
                        </div>
                    </div>
                    <div class="categories_sections">
                        <h2>Links Section</h2>
                        <div class="mb-4">
                            <label for="facebook_url"
                                class="block text-gray-700 text-sm font-bold mb-2">Facebook
                                Url</label>
                            <input id="facebook_url" v-model="form.facebook_url"
                                class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                            <span v-if="props.errors.facebook_url" class="error-message">{{
                                props.errors.facebook_url }}</span>
                        </div>
                        <div class="mb-4">
                            <label for="instagram_url"
                                class="block text-gray-700 text-sm font-bold mb-2">Instagram
                                Url</label>
                            <input id="instagram_url" v-model="form.instagram_url"
                                class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                            <span v-if="props.errors.instagram_url" class="error-message">{{
                                props.errors.instagram_url }}</span>
                        </div>
                        <div class="mb-4">
                            <label for="linkedin_url"
                                class="block text-gray-700 text-sm font-bold mb-2">Linkedin
                                Url</label>
                            <input id="linkedin_url" v-model="form.linkedin_url"
                                class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                            <span v-if="props.errors.linkedin_url" class="error-message">{{
                                props.errors.linkedin_url }}</span>
                        </div>
                        <div class="mb-4">
                            <label for="twitter_url"
                                class="block text-gray-700 text-sm font-bold mb-2">Twitter
                                Url</label>
                            <input id="twitter_url" v-model="form.twitter_url"
                                class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                            <span v-if="props.errors.twitter_url" class="error-message">{{
                                props.errors.twitter_url
                            }}</span>
                        </div>
                    </div>
                    <div class="country_section">
                        <h2>Office Section</h2>
                        <div class="mb-4">
                            <label for="office_phone"
                                class="block text-gray-700 text-sm font-bold mb-2">Office
                                Mobile Number </label>
                            <input type="text" id="office_phone" v-model="form.office_phone"
                                class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                            <span v-if="props.errors.office_phone" class="error-message">{{
                                props.errors.office_phone }}</span>
                        </div>
                        <div class="mb-4">
                            <label for="office_email"
                                class="block text-gray-700 text-sm font-bold mb-2">Office
                                Email </label>
                            <input type="text" id="office_email" v-model="form.office_email"
                                class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                            <span v-if="props.errors.office_email" class="error-message">{{
                                props.errors.office_email }}</span>
                        </div>
                        <div class="mb-4">
                            <label for="office_address"
                                class="block text-gray-700 text-sm font-bold mb-2">Office
                                Address </label>
                            <input type="text" id="office_address" v-model="form.office_address"
                                class="bg-gray-200 focus:outline-none focus:bg-white border border-gray-300 rounded-lg py-2 px-4 block w-full">
                            <span v-if="props.errors.office_address" class="error-message">{{
                                props.errors.office_address }}</span>
                        </div>
                    </div>
                    <div class="video_Section">
                        <h2>Certificates Upload</h2>
                        <div class="mb-4">
                            <label for="certificate_imagez"
                                class="block text-gray-700 text-sm font-bold mb-2">Certificate
                                Images</label>
                            <div class="row">
                                <div v-for="(image, index) in form.certificate_images_status ? updatedCertificate : form.certificate_images"
                                    :key="index" class="col-md-4">
                                    <img :src="form.certificate_images_status ? image : `${image}`"
                                        alt="" style="height:150px;">
                                </div>
                            </div>
                            <label for="certificate_images"
                                class="form-control mt-2 cursor-pointer">
                                {{ form.certificate_images ? 'Change File' : 'Upload File' }}
                            </label>
                            <input type="file" id="certificate_images"
                                @change="update_data('certificate_images', $event)" accept="image/*" multiple
                                class="hidden">
                        </div>
                        <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style scoped>
.error-message {
    color: red;
}

.image_uploading,
.country_1_uploading,
.country_2_uploading,
.video_Section,
.country_section,
.categories_sections {
    margin-top: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 20px;
    box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
}

.file_cursor {
    cursor: pointer;
}
</style>