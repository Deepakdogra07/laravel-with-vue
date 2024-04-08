<script setup>
import { computed, onMounted, onUnmounted, watch, ref } from 'vue';
import axios from 'axios';
import { useForm } from '@inertiajs/vue3';
import { useToast } from 'vue-toastify';

const users = ref([]);
const selectedAgent = ref(null);

const props = defineProps(['customerId','close','agentName','customerId','loanId']);

const form = useForm({
  agent: null,
  loanId: props.loanId,
});


axios.get('/assignAgent')
  .then(response => {
    users.value = response.data;
  })
  .catch(error => {
    console.error('Error:', error);
  });

const emit = defineEmits(['close']);


onMounted(()=>{
    console.log(props.loanId);
})

// const submitForm = () => {
//   console.log(props.customerId);
//   const formData = selectedAgent.value;
//   const customerId = props.customerId;
//   console.log(formData,'formdata......');
//   const toast = useToast();
//   const url = `/storeAssignAgent/${formData}/${customerId}`;

//   form.post(url, {
//     agent_id: formData,
//     id: customerId,
//   }, {
//     onSuccess: (response) => {
//       toast.success('Agent Added Successfully');
//     },
//     onError: (errors) => {
//       toast.error('Validation Error: Please check your input');
//     },
//   });
//   close();
// };

const submitForm = async () => {
    // alert(loanId);
    const customerId = props.customerId;
    const toast = useToast();
    const url = `/storeAssignAgent/${customerId}`;
    form.post(url, {
        onStart: () => {
            form.pending = true;
        },
        onSuccess: (response) => {
            toast.success('Agent assigned Successfully');
            setTimeout(() => {
             window.location.reload();
       }, 1500);
        },
        onError: (errors) => {
            toast.error('Validation Error: Some error occured');
        },
        onFinish: () => {
            form.pending = false;
        },
    });
};

watch(
  () => props.show,
  () => {
    if (props.show) {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = null;
    }
  }
);

const close = () => {
    console.log('Asssigned Modal vue')
    emit('close');
};

const closeOnEscape = (e) => {
  if (e.key === 'Escape' && props.show) {
    close();
  }
};

onMounted(async () => {
    // console.log('herereeeee')
    document.addEventListener('keydown', closeOnEscape)
    form.agent = props.agentName;
});

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

        <input type="hidden" v-model="form.loanId">

        <select class="form-select form-select-lg mb-3" id="agent" name="" aria-label=".form-select-lg" v-model="form.agent">
            <option :value="null" disabled>Select Agents</option>
            <option v-for="user in users" :key="user.id" :value="user.id">
            {{ user.name }}
        </option>
        </select>

        <button class="btn btn-primary btn-lg" type="submit" >Submit</button>
        <button class="btn btn-secondary btn-lg ms-2" type="button" @click="close">Close</button>
    </form>
</template>
