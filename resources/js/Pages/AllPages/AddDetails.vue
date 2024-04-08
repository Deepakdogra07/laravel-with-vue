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


const form = useForm({
   title: '',
    slug: '',
    content: '',
});
const content = ref('');

onMounted(() => {
    const $summernote = $('#summernote');
    $summernote.summernote();
    $summernote.on('summernote.change', () => {
        content.value = $summernote.summernote('code');
    });
});
onMounted(() => {
    $('#summernote').summernote();
});
const submit = () => {
    form.content = content.value;
    // console.log(form);
const toast = useToast();
    form.post(route('pages.details-save'),{
        onSuccess: () => {
            router.visit(route('pages'));
            toast.success('Form Details Added Successfully');
        },
        onError: (errors) => {
            console.log(form.errors.name);
            toast.error('Validation Error: Please check your inputs');
        },
    });
};
</script>
<template>
    <AuthenticatedLayout>

        <div class="flex items-center justify-center h-screen">
            <div class="w-full">
                <h2 class="font-semibold text-xl text-black-800 leading-tight">Add Page Details</h2>

                <form @submit.prevent="submit">
                    <div class="mt-4">
                        <InputLabel for="title" value="Title" />
                        <TextInput id="title" type="text" placeholder="Enter Title" class="block w-full mt-1"
                        v-model="form.title" autocomplete="title" />
                        <InputError class="mt-2" :message="form.errors.title" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="slug" value="Slug" />
                        <TextInput id="slug" type="text" placeholder="Enter Slug" class="block w-full mt-1"
                        v-model="form.slug"  autocomplete="slug" />
                        <InputError class="mt-2" :message="form.errors.slug" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="content" value="Content" />
                        <div id="summernote"></div>
                        <InputError class="mt-2" :message="form.errors.content" />

                        <!-- <TextInput id="content" type="text" placeholder="Enter Content" class="block w-full mt-1"
                        v-model="form.content"  autocomplete="content" /> -->
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


