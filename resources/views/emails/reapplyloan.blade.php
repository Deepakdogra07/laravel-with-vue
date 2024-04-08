<!DOCTYPE html>
<html>

<head>
    <title>Create Loan</title>
</head>

<body style="font-family: Helvetica, Arial, sans-serif; margin: 0px; padding: 0px; background-color: #f5f5f5;">
    <h2 style="margin: 0; text-align: center; padding: 10px 0; background-color: #2CBCDD;"><span><img class="email-logo"
                src="{{config('app.url')}}images/instant-loan-logo.png" alt="" style="width: 150px;"></span>
    </h2>
    <div style="padding: 20px;">
        <h2 style="color: #050505">Querido {{ $mailData['name'] }},</h2> e o e-mail é {{ $mailData['title'] }}

        <p>Lamentamos informar que seu pedido de empréstimo recente foi rejeitado. Entendemos que esta notícia pode
            ser decepcionante e queremos expressar a nossa sincera empatia por qualquer inconveniente que esta decisão possa causar.
        </p>

        <p>Após análise cuidadosa de sua inscrição, determinamos que não poderemos prosseguir com sua solicitação.
            solicite neste momento. Embora nos esforcemos para ajudar todos os candidatos, existem certos critérios e circunstâncias
            que devemos aderir.</p>

        <p>Saiba que esta decisão não reflete o seu valor ou valor como indivíduo. Nossa decisão é baseada
            exclusivamente nas informações fornecidas e em nossas políticas de empréstimo atuais. Nós encorajamos você a explorar alternativas
            opções ou entre em contato para discutir possíveis próximas etapas.</p>

        <p>Se você tiver alguma dúvida ou preocupação em relação a esta decisão, não hesite em nos contatar. Nós somos
            aqui para ajudá-lo no que pudermos.</p>

        <p>Obrigado por nos considerar para suas necessidades financeiras. Agradecemos a oportunidade de atendê-lo e esperamos
            ajudá-lo no futuro.</p>

        <h3 style="color: #2CBCDD;">Sinceramente,</h3>
        <h3 style="color: #2CBCDD;">Empréstimo Instantâneo Teem</h3>
    </div>
    <div style="background-color: blanchedalmond; padding: 10px 20px; display: flex; justify-content: center;">
        <h4>direito autoral &#169; Dinheiroagora</h4>
     </div>
</body>

</html>