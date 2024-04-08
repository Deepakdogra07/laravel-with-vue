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
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: '2xl',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
    modal: {
        type: Number,
        default: 1,
    },
    leadId: {
        type: null,
        default: null,
    },
    loanId: {
        type: Number,
        default: null,
    },
    initialStatus: {
        type: Number,
    },
    agentName:{
        type:Number,
    },
    customerId:{
        type: Number,
    },
    loanData: {
        type: Object
    },
    loanDetails : {
        type : Array,
    },
    formPayment : {
        type : Number
  },
  userType : {
    userType : Number,
  }
});
// ADADAS
const key = ref(0);

// const emit = defineEmits(['close']);
const emit = defineEmits(['close','welcome','nextStep']);

watch(
    () => props.show,
    () => {
        if (props.show) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = null;
        }
        key.value++;
    }
);

const close = () => {
    console.log('Modal vue')
    if (props.closeable) {
        props.modal = 0;
        emit('close');
        location.reload();
    }
};

const closeOnEscape = (e) => {
    if (e.key === 'Escape' && props.show) {
        close();
    }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));

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


const welcome = () => {
    if (props.closeable) {
        emit('welcome')
    }
}

const justClose = () => {
    if (props.closeable) {
        emit('close');
    }
};
const nextStep = () => {
   emit('nextStep');
};
</script>

<template>

    <Teleport to="body">
        <Transition leave-active-class="duration-200">
            <div v-show="show" class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50" scroll-region>
                <Transition enter-active-class="ease-out duration-300" enter-from-class="opacity-0"
                    enter-to-class="opacity-100" leave-active-class="ease-in duration-200" leave-from-class="opacity-100"
                    leave-to-class="opacity-0">
                    <div v-show="show" class="fixed inset-0 transform transition-all" @click="close">
                        <div class="absolute inset-0 bg-gray-500 opacity-75" />
                    </div>
                </Transition>

                <Transition enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100" leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div v-show="show"
                        class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto popup-main"

                        :class="maxWidthClass"
 >
                        <slot v-if="show" />
                        <div v-if="modal === 1" class="flex items-center justify-center h-full">
                            <div class="bg-white rounded-lg p-12 max-w-xs">
                                <h2 class="text-2xl font-bold mb-4">Assign Agent</h2>
                                <AssignAgent :key="key" :leadId="leadId" @close="close"/>
                            </div>
                        </div>

                        <div v-if="modal === 2" class="flex items-center justify-center h-full">
                            <div class="bg-white rounded-lg p-12 max-w-xs">

                                <h2 class="text-2xl font-bold mb-4">Assign Agents</h2>
                                <AssignModal :key="key" :loanId="loanId" :customerId="customerId" :agentName="agentName" @close="close" />
                            </div>
                        </div>
                        <div v-if="modal === 3" class="flex items-center justify-center h-full">
                            <!-- <h1>{{ userType }}asdsdsd</h1> -->
                            <!-- <h1>{{ props.authUser.user_type }} SFFSDEGSWGSW</h1> -->
                            <div class="bg-white rounded-lg p-12 max-w-xs">
                                <h2 class="text-2xl font-bold mb-4">Change Status</h2>
                                <ChangeLoanStatus :key="key" :loanId="loanId" :initialStatus="initialStatus" @close="close" :userType="userType" />

                            </div>
                        </div>
                        <!-- <test2 v-if="modal == 2"/>
                        <test3 v-if="modal == 3"/> -->

                        <div v-if="modal === 4" class="flex items-center justify-center h-full">
                            <div class="bg-white rounded-lg p-12">


                                <p style="font-size: 20px;">
                                    Você tem o valor
                                     <!-- {{  loanDetails.total_payment }} -->
                                     {{ new Intl.NumberFormat('pt-BR', {
                style: 'currency', currency: 'BRL', minimumFractionDigits: 2
              }).format(Number(loanDetails.total_payment)) }}

                                     disponível no seu cartão de crédito?
                                </p>
                                <ConfirmModal  @close="welcome" :loanData="loanData" />
                            </div>
                        </div>

                        <div v-if="modal === 5" class="flex items-center justify-center h-full">
                            <div class="bg-white rounded-lg p-12 text-center">
                                <p style="font-size: 20px;">
                                Você tem o valor
                                     {{ new Intl.NumberFormat('pt-BR', {
                style: 'currency', currency: 'BRL',  minimumFractionDigits: 2
              }).format(Number(formPayment)) }}
                                 disponível no seu cartão de crédito?
                                </p>
                                <ConfirmModal_2  @close="justClose" @nextStep="nextStep" :loanData="loanData" />
                            </div>
                        </div>
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>

