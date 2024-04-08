<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastify';
import { router } from '@inertiajs/vue3';


const summernoteRef = ref(null);

onMounted(() => {
    const $summernote = $(summernoteRef.value);
    $summernote.summernote();
    $summernote.on('summernote.change', () => {
        form.content = $summernote.summernote('code');
    });
    $summernote.summernote('code', form.content);
});

const { page, errors } = defineProps(['page', 'errors']);

const form = useForm({
    title: page.title,
    slug: page.slug,
    content: page.content,
});

const submit = () => {
    const toast = useToast();
    const formData = {
        title: form.title || '',
        slug: form.slug || '',
        content: form.content || '',
    };
    router.put(`/pages/update/${page.id}`, formData, {
        onSuccess: () => {
            router.visit(route('pages'))
            toast.success('Pages Updated Successfully');
        },
        onError: (errors) => {
            toast.error('Validation Error: Please check your inputs');
        },
    });
};
</script>
<template>
    <AuthenticatedLayout>

        <div class="flex items-center justify-center h-screen">
            <div class="w-full">
                <h2 class="font-semibold text-xl text-black-800 leading-tight">Edit Page Details</h2>

                <form @submit.prevent="submit">
                    <div class="mt-4">
                        <InputLabel for="title" value="Title" />
                        <TextInput id="title" type="text" placeholder="Enter Title" class="block w-full mt-1"
                            :value="form.title" v-model="form.title" autocomplete="title" />
                        <InputError class="mt-2" :message="errors.title" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="slug" value="Slug" />
                        <TextInput id="slug" type="text" placeholder="Enter Slug" class="block w-full mt-1"
                            :value="form.slug" v-model="form.slug" autocomplete="slug" />
                        <InputError class="mt-2" :message="errors.slug" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="content" value="Content" />
                        <div id="summernote" ref="summernoteRef"></div>
                        <InputError class="mt-2" :message="errors.content" />

                    </div>

                    <div class="mt-4">
                        <PrimaryButton @click="submit" type="submit">
                            Submit
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


