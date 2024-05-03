<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body style="font-family: Helvetica, Arial, sans-serif; margin: 0px; padding: 0px; background-color: #ffffff;">
    <h2 style="margin: 0; text-align: center; padding: 10px 0; background-color: #09332B;"><span><img class="email-logo"
                src="{{config('app.url')}}images/instant-loan-logo.png" alt="" style="width: 150px;"></span>
    </h2>
    <div style="padding: 20px;">
        <h2 style="color: #053249;">Contact us Information</h2>
        <p><strong>Name:</strong> {{ $mailData['name'] }}</p>
        <p><strong>E-mail:</strong> {{ $mailData['email'] }}</p>
        <p><strong>Mobile Number:</strong> {{ $mailData['phone'] }}</p>
        <p><strong>Message:</strong> {{ $mailData['message'] }}</p>

        <!-- Your custom message -->
        <h3 style="color: #09332B;">Thank you for contacting us. We will surely email/phone you immediately.</h3>
    </div>
    <div style="background-color: blanchedalmond; padding: 10px 20px; display: flex; justify-content: center;">
     </div>
</body>

</html>