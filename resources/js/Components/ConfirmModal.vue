<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue';


const emit = defineEmits(['close']);

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
    <div class="new-popup ">
        <a :href="'/applyloan?loan_amount=' + loanData.amount + '&time=' + loanData.loan_period" target="_blank"
                  class="banner-link">Sim, eu tenho</a>
        <!-- <a class="pl-4 btn-grey" href="/">Não</a> -->
        <button class="btn btn-secondary btn-lg" type="button" @click="close">Não tenho</button>
    </div>
</template>
