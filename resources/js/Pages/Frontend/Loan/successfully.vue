<script setup>

import NavLink from "@/Components/NavLink.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import axios from "axios";
import { router } from "@inertiajs/vue3";
import { useToast } from "vue-toastify";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";
import Footer from "../../Frontend/footer.vue";
import { ref, onMounted, getCurrentInstance } from 'vue';
import { useRoute } from 'vue-router';
import "../../../../css/frontend.css";

const { applicationId } = defineProps(['applicationId']);

</script>

<template>
    <Head title="Empréstimo com sucesso" />
  <div class="create-loan-sec">
    <div class="about-us-bg-wrapper">
      <div class="container">
        <div class="logo-main">
            <img src="/images/instant-loan-logo.png" alt="">
        </div>
        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
          {{ status }}
        </div>
      </div>
    </div>
  </div>

  <div class="successfull-loan">
    <div class="container">
        <div class="successful-content">
            <div class="successfull-image">
                <img src="/images/successs-image.png" alt="">
            </div>
            <h2 class="my-3">Empréstimo aplicado com sucesso</h2>
            <p>Id da aplicação: #{{ applicationId }}</p>
            <p class="text-center my-3">Parabéns! Você concluiu com sucesso a primeira etapa do processo de solicitação de empréstimo com o Dinheiro Agora. Seus dados foram recebidos com êxito e agora nosso time de analistas está trabalhando diligentemente para analisar cada informação fornecida.</p>
            <p class="text-center">
              Assim que sua solicitação for processada e aprovada, você receberá um e-mail com um link para a próxima etapa do processo. Por favor, fique atento à sua caixa de entrada e verifique seu e-mail regularmente para garantir que não perca nenhuma atualização.
            </p>
            <p class="text-center my-3">
              Agradecemos por escolher o Dinheiro Agora para suas necessidades financeiras. Estamos comprometidos em fornecer um serviço eficiente e transparente para ajudar você a alcançar seus objetivos financeiros.
            </p>
            <p class="text-center">
              Se tiver alguma dúvida ou precisar de assistência adicional, não hesite em entrar em contato com nossa equipe de atendimento ao cliente.
            </p>
            <p class="text-center my-3">
              Obrigado por confiar em nós!
            </p>
            <div class="d-flex align-items-center flex-wrap justify-center mt-5" style="gap: 10px;">
                <div>
                    <Link href="/applyloan" class="banner-link-next">APLICAR OUTRO EMPRÉSTIMO</Link>
                </div>
                <div>
                    <Link  href="/all-loans" class="banner-link-next">MEUS EMPRÉSTIMOS</Link>
                </div>
            </div>
        </div>
    </div>
  </div>
  <Footer />
</template>
<style scoped>

</style>
