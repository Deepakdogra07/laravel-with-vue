<script setup>
import { defineProps, defineEmits, computed, onMounted, onUnmounted, ref, watch } from 'vue';
import AssignAgent from './AssignAgent.vue';
import AssignModal from './AssignedModal.vue';
import ChangeLoanStatus from './ChangeStatus.vue';
// import test2 from './test2.vue';
// import test3 from './test3.vue';
import ConfirmModal from './ConfirmModal.vue';
import ConfirmModal_2 from './ConfirmModal_2.vue';
const props = defineProps({
    imageSrc:{
        type:String,
        default:null
    },
    show: {
      type: Boolean,
      required: true
    },
    emits: ['close'],
    methods: {
        closeModal() {
        this.$emit('close');
        }
    }
});
</script>

<template>
    <div v-if="show" class="modal-overlay" @click.self="closeModal">
      <div class="modal-content">
        <span class="close" @click="closeModal">&times;</span>
        <img :src="imageSrc" class="image-full" alt="Full Image" />
      </div>
    </div>
  </template>

