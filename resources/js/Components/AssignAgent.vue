<script setup>
import { defineProps, ref, onMounted } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastify';
import { Head, useForm } from '@inertiajs/vue3';

const users = ref([]);
const selectedAgent = ref(null);
const props = defineProps(['leadId', 'close']);

const emit = defineEmits(['close']);
axios.get('/assignAgent')
  .then(response => {
    // console.log(response.data);
    users.value = response.data;
  })
  .catch(error => {
    console.error('Error:', error);
  });

const form = useForm({
  agent: null,
});

const submit = () => {
  const formData = selectedAgent.value;
  const leadId = props.leadId;

  const toast = useToast();
  const url = `/assignAgentSave/${formData}/${leadId}`;

  form.post(url, {
    agent_id: formData,
    id: leadId,
  }, {
    onSuccess: (response) => {
      console.log(response);
      toast.success('Assign Agent Added Successfully');

    },
    onError: (errors) => {
      toast.error('Validation Error: Please check your inputs');
    },
  });
  close();


};
const close = () => {
  emit('close');
};
</script>

<template>
    <form @submit.prevent="submit">
        <div>
            <input type="hidden" :value="leadId" />
            <select class="form-select form-select-lg mb-3" id="agent" name="" aria-label=".form-select-lg"
                v-model="selectedAgent">
                <option :value="null" disabled>Select Agent</option>
                <option v-for="user in users" :key="user.id" :value="user.id">
                    {{ user.name }}
                </option>
            </select>
            <button class="btn btn-primary btn-lg" type="submit">Assign</button>
            <button class="btn btn-secondary btn-lg ms-2" type="button" @click="close">Close</button>
        </div>
    </form>
</template>

