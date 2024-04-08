<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';

const { agent } = defineProps(['agent']);

</script>
<template>
  <AuthenticatedLayout>
    <Head title="View Agent"/>
      <div class="flex items-center justify-center p-6">
        <div class="w-full">
          <h1 class="mb-4 text-xl font-semibold text-gray-700">Agent Details:</h1>
          <div class="flex items-center mb-4">
          <div class="w-1/3">
            <label class="block text-gray-600 font-bold">Name:</label>
          </div>
          <div class="w-2/3">
            <span class="text-gray-800">{{ agent.name }}</span>
          </div>
        </div>

        <div class="flex items-center mb-4">
          <div class="w-1/3">
            <label class="block text-gray-600 font-bold">Email:</label>
          </div>
          <div class="w-2/3">
            <span class="text-gray-800">{{ agent.email }}</span>
          </div>
        </div>

        <div class="flex items-center mb-4">
          <div class="w-1/3">
            <label class="block text-gray-600 font-bold">Phone Number:</label>
          </div>
          <div class="w-2/3">
            <span class="text-gray-800">{{ agent.phone }}</span>
          </div>
        </div>

        <div class="flex items-center mb-4">
          <div class="w-1/3">
            <label class="block text-gray-600 font-bold">Address:</label>
          </div>
          <div class="w-2/3">
            <span class="text-gray-800">{{ agent.address }}</span>
          </div>
        </div>

        </div>
      </div>
  </AuthenticatedLayout>
</template>
<style scoped>
.bg-white {
  background-color: #fff;
}

.border {
  border: 1px solid #ddd;
}

.rounded-md {
  border-radius: 0.375rem;
}

.shadow-md {
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.text-gray-600 {
  color: #4a5568;
}

.font-bold {
  font-weight: 700;
}

.text-gray-800 {
  color: #2d3748;
}
</style>
