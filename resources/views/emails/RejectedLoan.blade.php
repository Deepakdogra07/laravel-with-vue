<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="font-family: Helvetica, Arial, sans-serif; margin: 0px; padding: 0px; background-color: #ffffff;">
    <h2 style="margin: 0; text-align: center; padding: 10px 0; background-color: #2CBCDD;"><span><img class="email-logo"
        src="{{config('app.url')}}images/instant-loan-logo.png" alt="" style="width: 150px;"></span>
</h2>
    <div style="padding: 20px; background-color: rgb(255, 255, 255);">
        <div style="color: rgb(0, 0, 0); text-align: left;">
            <h2>Olá <strong style="font-size: 130%">{{
                    ucfirst($username) }}</strong></h2>
            <br>
            <h4 style="color: #d90000;"> Nos desculpe.
                <br>
                Seu empréstimo foi rejeitado.
                <h3>
                    <!--by the {{ $creator }} <p style="padding-bottom: 16px">Email : <strong style="font-size: 130%">{{ $email }}</strong></p>
<p style="padding-bottom: 16px">Username : <strong style="font-size: 130%">{{ $username }}</strong></p> -->
                    <p style="color: #2CBCDD;">Obrigado,<br>Dinheiroagora Equipe</p>
        </div>
    </div>
    <div style="background-color: blanchedalmond; padding: 10px 20px; display: flex; justify-content: center;">
        <h4>direito autoral &#169; Dinheiroagora</h4>
     </div>
</body>

</html>