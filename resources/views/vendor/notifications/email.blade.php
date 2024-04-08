<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<body style="font-family: Helvetica, Arial, sans-serif; margin: 0px; padding: 0px;">
    <div  style="background-color: #2CBCDD; display: flex; padding: 10px 0; justify-content: center;">
        <img src="{{config('app.url')}}images/instant-loan-logo.png" alt="" style="width: 150px; margin: 0 auto;">
    </div>
    <div style="padding: 30px 20px; background-color: #f7f7f7;">
        <p style="font-size: 16px; color: #000;">Clique no botão abaixo para verificar seu endereço de e-mail.</p>
        <div style="text-align: center; margin: 30px 0;">
            <a  href="{{ $actionUrl }}" style="text-decoration:none; padding: 11px 20px; color: #fff; background-color: #000D37; border-radius: 10px;">Verifique o endereço de e-mail</a>
        </div>
        <p style="font-size: 16px; color: #000;"> Se você não criou uma conta, nenhuma ação adicional será necessária<br>
            Atenciosamente, Dinheiro Agora!</p>
    </div>
    <div>
        <p style="font-size: 16px; color: #000;">Se estiver com problemas para clicar no botão "Verificar endereço de e-mail", copie e cole o URL abaixo em seu navegador:</p>
        <p>{{ $actionUrl }}</p>
    </div>
    <div style="background-color: blanchedalmond; padding: 10px 20px; display: flex; justify-content: center;">
        <h4>direito autoral &#169; Dinheiroagora</h4>
     </div>
</body>

</html>
