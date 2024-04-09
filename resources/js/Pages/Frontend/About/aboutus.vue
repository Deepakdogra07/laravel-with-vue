<script setup>
import Footer from "../../Frontend/footer.vue";
import Header from "../../Frontend/header.vue";
import "../../../../css/frontend.css";
import { Head, Link, useForm } from '@inertiajs/vue3';
</script>
<template>
    <Header class="login-wrapper" />
    <Head title="About Us" />
    <div class="about-us-bg-wrapper">
        <div class="container">
            <h1 class="mb-4 text-blue text-center">About Us</h1>
            <div
                v-if="status"
                class="mb-4 text-sm font-medium text-green-600">A
                {{ status }}
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row">
            <div
                class="col-sm-12 col-md-12 col-lg-12 col-xl-12"
                style="background-color: #000D37">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-0  px-lg-0">
                        <div class="aboutus-left-image">
                            <img src="/images/instantloan-dollarBg.png" alt="">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6 mt-5 text-right">
                        <h2 style="color: white">
                            About Us
                        </h2>
                        <h3 class="text-end mb-3" style="color: #2CBCDD">
                            Somos uma plataforma online dedicada a simplificar o processo de obtenção de empréstimos através do seu cartão de crédito.
                        </h3>
                        <h6 class="text-end mt-2 text-white">
                            Nosso objetivo é proporcionar uma experiência rápida e prática para nossos clientes, eliminando a burocracia comum em transações financeiras.
                        </h6>
                        <h6 class="text-end mt-2 text-white">
                            Além disso, oferecemos uma oportunidade única aos nossos clientes através do nosso programa de afiliados. Com o programa de afiliados da Dinheiro Agora, você pode indicar amigos e familiares para utilizar nossos serviços, utilizando um código exclusivo. E o melhor: ao indicar alguém, você recebe 5% do valor do empréstimo que seu amigo realizar conosco.Explore também nossa calculadora de simulação de empréstimo, uma ferramenta visual e prática que permite que você veja instantaneamente as opções disponíveis e faça uma escolha informada.
Na Dinheiro Agora, valorizamos a transparência, a segurança e a conveniência. Estamos aqui para aiudar você a alcançar seus objetivos financeiros de forma fácil e eficiente. Junte-se a nós e descubra como podemos simplificar sua vida financeira.
                        </h6>
                    </div>
                    <div class="col-lg-3 col-md-6 px-lg-0">
                        <img class="about-banner-img" src="/images/about-group-img.png">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Next -->
    <div class="container">
        <div class="row about-us-coin">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4 mt-5">
                                <h3 style="color: #000D37;">
                                    Nossa missão como empresa
                                </h3>
                            </div>
                            <div class="col-md-4 mt-lg-5 mt-3">
                                <p>
                                    Fornecer soluções financeiras rápidas e acessíveis, com transparência e atendimento excepcional, para ajudar nossos clientes a alcançar seus objetivos financeiros.
                                </p>
                                 <Link href="/contactus" class="btn mt-3  banner-link" style="background-color: #2CBCDD;">CONTATE-NOS</Link>
                            </div>
                            <div class="col-md-4 d-flex justify-content-center mt-3">
                                <img src="/images/left-dollar.png" style="height: 170px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Next -->
    <div class="py-5"
        style="background-color: #2CBCDD">
        <div class="container">
            <div class="text-center mb-2">
                <h2 style="color: #000D37;">
                    Nossos valores
                </h2>
            </div>
        <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-3">
            <div class="card">
                <div class="card-body card-background text-white text-center">
                    <p class="card-text" >
                        Transparência: Comprometemo-nos a ser transparentes em todas as nossas operações, desde a divulgação de taxas e condições até o tratamento de informações pessoais dos clientes.
                    </p>
                </div>
            </div>
            <div class="card">
                <div class="card-body card-background text-white text-center">
                    <p class="card-text">
                        Integridade: Operamos com integridade e ética em todas as nossas interações, garantindo que nossos clientes confiem em nossos serviços e em nossa equipe.
                    </p>
                </div>
            </div>
            <div class="card">
                <div class="card-body card-background text-white text-center">
                    <p class="card-text">
                        Inovação: Buscamos constantemente maneiras inovadoras de melhorar nossos serviços e processos, mantendo-nos na vanguarda da tecnologia financeira para oferecer uma experiência excepcional aos nossos clientes.
                    </p>
                </div>
            </div>
            <div class="card">
                <div class="card-body card-background text-white text-center">
                    <p class="card-text">
                        Atendimento ao Cliente: Colocamos nossos clientes em primeiro lugar, fornecendo um atendimento ao cliente excepcional e dedicado, respondendo às suas necessidades com prontidão e eficiência.
                    </p>
                </div>
            </div>
            <div class="card">
                <div class="card-body card-background text-white text-center">
                    <p class="card-text">
                        Acessibilidade: Estamos comprometidos em tornar nossos serviços financeiros acessíveis a todos, garantindo que nossos produtos sejam fáceis de usar e compreender para uma ampla variedade de clientes.
                    </p>
                </div>
            </div>
            <div class="card">
                <div class="card-body card-background text-white text-center">
                    <p class="card-text ">
                        Responsabilidade: Assumimos a responsabilidade por nossas ações e impacto na comunidade, buscando maneiras de contribuir positivamente para o bem-estar financeiro de nossos clientes e da sociedade em geral.
                    </p>
                </div>
            </div>
        </div>
    
        <div class="text-center">
            <Link href="/contactus" class="btn btn-primary mt-3 text-white contact-us-btn" style="background-color: #000D37;">
                CONTATE-NOS
            </Link>
        </div>
       <!-- <Link >CONTATE-NOS</Link> -->
       </div>
    </div>
    <Footer />
</template>
<style scoped>
.card-background {
    background-color: #000D37;
}

.card {
    border-color: #000D37;
}
</style>
