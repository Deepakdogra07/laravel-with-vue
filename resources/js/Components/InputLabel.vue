<template>
  <label class="block text-gray-600">
    <span v-if="value">{{ value }}</span>
    <span v-else>
      <slot />
    </span>
  </label>
</template>


<script setup>
defineProps(['value']);
</script>
