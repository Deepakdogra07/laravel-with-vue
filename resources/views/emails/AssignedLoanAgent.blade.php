<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body style="font-family: Helvetica, Arial, sans-serif; margin: 0px; padding: 0px; background-color: #ffffff;">
    <h2 style="margin: 0; text-align: center; padding: 10px 0; background-color: #2CBCDD;"><span><img class="email-logo"
        src="{{config('app.url')}}images/instant-loan-logo.png" alt=""
        style="width: 150px;"></span>
    </h2>
    <div style="padding: 20px; background-color: rgb(255, 255, 255);">
        <h3> Olá ! um usuário cujo ID de e-mail é : {{ $mailData['loansuser']->email }} .O valor do empréstimo é
            {{ $mailData['loanAmount'] }} atribuído a você.
         </h3>
    </div>
   <div style="background-color: blanchedalmond; padding: 10px 20px; display: flex; justify-content: center;">
        <h4>direito autoral &#169; Dinheiroagora</h4>
    </div>
</body>
</html>
