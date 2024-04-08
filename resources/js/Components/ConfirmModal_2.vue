<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';


const emit = defineEmits(['close','nextStep']);

defineProps({
  loanData: {
    type: Object
  }
})

onMounted(async () => {
  document.addEventListener('keydown', closeOnEscape)
});


const close = () => {
   emit('close');
};

const nextStep = () => {
   emit('nextStep');
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

// onMounted(()=>{

// })

</script>
<template>
    <div class="new-popup">
         <a @click.prevent="nextStep" class="banner-link text-center" style="cursor: pointer;">
            Sim, eu tenho
         </a>
        <button class="btn btn-secondary btn-lg" type="button" @click="close">Não tenho</button>
    </div>
</template>
