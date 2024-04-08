<!DOCTYPE html>
<html>

<head>
    <title>Create Loan</title>
</head>

<body style="font-family: Helvetica, Arial, sans-serif; margin: 0px; padding: 0px; background-color: #ffffff;">
    <h2 style="margin: 0; text-align: center; padding: 10px 0; background-color: #2CBCDD;"><span><img class="email-logo"
                src="{{config('app.url')}}images/instant-loan-logo.png" alt="" style="width: 150px;"></span>
    </h2>
    <div style="padding: 20px;">
        <h2>{{ $mailData['title'] }}</h2>
        <h2>{{ $mailData['body'] }}</h2>

        <!-- Your custom message -->
        <h4 style="color: #2CBCDD;">Obrigado</h4>
    </div>
    <div style="background-color: blanchedalmond; padding: 10px 20px; display: flex; justify-content: center;">
        <h4>direito autoral &#169; Dinheiroagora</h4>
     </div>
</body>

</html>