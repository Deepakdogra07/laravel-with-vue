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
        src="{{config('app.url')}}images/instant-loan-logo.png" alt="" style="width: 150px;"></span>
    </h2>
    <div style="padding: 20px; background-color: #f5f5f5;">
        <div style="color: rgb(0, 0, 0); text-align: left;">
            <h2>Oi ! {{ $mailData['userEmail'] }} ,
            </h2>
            <h2>Sua solicitação de valor de retirada é aceita Rs.
                {{ $mailData['amount'] }}.</h2>
            
        </div>
    </div>
    <div style="background-color: blanchedalmond; padding: 10px 20px; display: flex; justify-content: center;">
        <h4>direito autoral &#169; Dinheiroagora</h4>
     </div>
</body>

</html>
