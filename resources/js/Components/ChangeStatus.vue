<script setup>
import { computed, onMounted, onUnmounted, watch, ref } from 'vue';
import axios from 'axios';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastify';

const users = ref([]);
const selectedStatus = ref(null);
const props = defineProps(['loanId', 'close', 'initialStatus','userType']);
const form = useForm({
    status: null,
    incompleteReason : null,
    loanTransferProof : null,
});

const emit = defineEmits(['close']);

const getStatusOptions = async () => {
    try {
        const response = await axios.get('/status-options');
        users.value = response.data;
    } catch (error) {
        console.error('Error fetching status options:', error);
    }
};

onMounted(async () => {
    document.addEventListener('keydown', closeOnEscape)
    await getStatusOptions();
    form.status = props.initialStatus;
});

const submitForm = async () => {
    const loanId = props.loanId;
    const toast = useToast();
    const url = `/changeLoanStatus/${loanId}`;
    form.post(url, {
        onStart: () => {
            form.pending = true;
        },
        onSuccess: (response) => {
            toast.success('Status changed Successfully');
        },
        onError: (errors) => {
            toast.error('Validation Error: Please check your input');
        },
        onFinish: () => {
            form.pending = false;
        },
    });
};

const close = () => {
    emit('close');
};

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
    document.body.style.overflow = null;
});

const maxWidthClass = computed(() => {
    return {
        sm: 'sm:max-w-sm',
        md: 'sm:max-w-md',
        lg: 'sm:max-w-lg',
        xl: 'sm:max-w-xl',
        '2xl': 'sm:max-w-2xl',
    }[props.maxWidth];
});
</script>

<template>
    <form @submit.prevent="submitForm">
        <div v-if="form.pending" class="loading-overlay">
            <i class="fas fa-spinner fa-spin"></i>
        </div>
        <select class="form-select form-select-lg mb-3" id="status" name="" aria-label=".form-select-lg"
            v-model="form.status">
            <option :value="null" disabled>Select Status</option>
            <option v-for="option in users" :key="option.value" :value="option.value" :disabled="(userType == 2 && option.value == 6)">
                {{ option.name }}
            </option>

            <!-- <option v-for="option in users" :key="option.value" :value="option.value" v-show="userType === '1' && option.value === 'Transferred'">
                 {{ option.name }}
             </option> -->



        </select>


        <p v-if="form.status == 3 || form.status == 2">
            <input type="text" v-model="form.incompleteReason" placeholder="Enter Reason"/>
        </p>

        <p v-if="form.status == 6">
            <input class="form-control" type="file" @input="form.loanTransferProof = $event.target.files[0]" />
        </p>

        <button class="btn btn-primary btn-lg" type="submit">Submit</button>
        <button class="btn btn-secondary btn-lg ms-2" type="button" @click="close">Close</button>
    </form>
</template>
