<script setup>
import Footer from "../../Frontend/footer.vue";
import Header from "../../Frontend/header.vue";
import "../../../../css/frontend.css";
import {Head,  Link } from '@inertiajs/vue3';
</script>
<template>
    <Header class="login-wrapper" />
    <Head title="FAQ's" />

    <div class="about-us-bg-wrapper">
        <div class="container">
            <h1 class="mb-4 text-blue text-center">FAQs</h1>
            <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
                {{ status }}
            </div>
        </div>
    </div>

    <div class="accordion-bg py-5">
        <div class="container">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="row gap-faq">
                    <div class="col-md-6">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button
                                    class="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne"
                                    aria-expanded="false"
                                    aria-controls="flush-collapseOne"
                                >
                                Como funciona o processo de obtenção de empréstimo pelo cartão de crédito na Dinheiro Agora?
                                </button>
                            </h2>
                            <div
                                id="flush-collapseOne"
                                class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne"
                                data-bs-parent="#accordionFlushExample"
                            >
                                <div class="accordion-body">
                                    Na Dinheiro Agora, o processo de obtenção de empréstimo é simples. Basta acessar nosso site, preencher o formulário de solicitação e seguir as instruções para fornecer as informações necessárias. Após a análise e aprovação do seu pedido, o valor do empréstimo será depositado diretamente em sua conta bancária ou disponibilizado em seu cartão de crédito, dependendo da opção escolhida.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwo">
                                <button
                                    class="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseTwo"
                                    aria-expanded="false"
                                    aria-controls="flush-collapseTwo"
                                >
                                Quais são os requisitos para solicitar um empréstimo pelo cartão de crédito na Dinheiro Agora?
                                </button>
                            </h2>
                            <div
                                id="flush-collapseTwo"
                                class="accordion-collapse collapse"
                                aria-labelledby="flush-headingTwo"
                                data-bs-parent="#accordionFlushExample"
                            >
                                <div class="accordion-body">
                                    Para solicitar um empréstimo conosco, você precisa atender a alguns requisitos básicos, incluindo ser maior de 18 anos, possuir um cartão de crédito válido com limite disponível e apresentar comprovante de renda. Além disso, também pode ser necessário fornecer informações adicionais, conforme solicitado durante o processo de solicitação.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row gap-faq mt-4">
                    <div class="col-md-6">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button
                                    class="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseThree"
                                    aria-expanded="false"
                                    aria-controls="flush-collapseOne"
                                >
                                Como funciona o programa de afiliados da Dinheiro Agora?
                                </button>
                            </h2>
                            <div
                                id="flush-collapseThree"
                                class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne"
                                data-bs-parent="#accordionFlushExample"
                            >
                                <div class="accordion-body">
                                    Nosso programa de afiliados permite que nossos clientes indiquem amigos e familiares para utilizar nossos serviços. Ao fazer uma indicação bem-sucedida, você receberá um código exclusivo que seu amigo deverá inserir durante o processo de solicitação. Após a aprovação e realização do empréstimo pelo seu amigo, você receberá 5% do valor do empréstimo como recompensa.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingTwo">
                                <button
                                    class="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseFour"
                                    aria-expanded="false"
                                    aria-controls="flush-collapseTwo"
                                >
                                É seguro solicitar um empréstimo pelo cartão de crédito na Dinheiro Agora?
                                </button>
                            </h2>
                            <div
                                id="flush-collapseFour"
                                class="accordion-collapse collapse"
                                aria-labelledby="flush-headingTwo"
                                data-bs-parent="#accordionFlushExample"
                            >
                                <div class="accordion-body">
                                    Sim, a segurança dos nossos clientes é uma prioridade para nós. Utilizamos tecnologia de criptografia avançada para proteger todas as informações fornecidas durante o processo de solicitação.
Além disso, garantimos a confidencialidade e o tratamento seguro de todos os dados pessoais de acordo com as regulamentações de privacidade aplicáveis.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="loot-section">
    <div class="container">
      <div class="row justify-center">
        <div class="col-lg-9 col-md-12">
          <div class="row">
            <div class="col-md-6">
              <div class="image-for-mobile">
                <img class="d-lg-none d-md-none d-sm-block" src="/images/dollar-group.png" alt="dinheiro-agora">
              </div>
              <div class="loot-left-heading position-relative">
                <img src="/images/left-dollar.png" alt="dinheiro-agora">
                <h2 class="text-right"> <span class="d-block">PRONTO</span><span class="d-block">para receber </span>um
                  PIX?</h2>
              </div>
            </div>
            <div class="col-md-6">
              <div class="right-section-loot position-relative">
                <img src="/images/right-dollar.png" alt="dinheiro-agora">
                <p class="text-left">Com o Dinheiro Agora seu PIX está a um passo de distância! É rápido e fácil e o
                  melhor sem burocracia.</p>
                <div class="col-md-8 process-detail-sec mt-2">
                  <!-- <a type="button" class="banner-link">SIMULE AGORA</a> -->
                  <Link class="banner-link" href="/#loan-calaaaa">SIMULE AGORA</Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    <Footer />
</template>
<style scoped></style>
