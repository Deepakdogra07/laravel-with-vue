<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome To Unstoppable Job</title>
</head>

<body style="font-family: Helvetica, Arial, sans-serif; margin: 0px; padding: 0px; background-color: #ffffff;">
    <div role="presentation" style="width: 100%; background-color: rgb(239, 239, 239);">
        <div align="center" vertical-align: top; width: 100%;">
            <div role="presentation"
                style=" border-collapse: collapse; border: 0px; border-spacing: 0px; text-align: left;">
                    <div >
                        <div style="text-align: left;">
                            <div>
                                
                              </div>
                        </div>
                        <div class="email-section" style="background-color: #f0f0f0;">
                            <h2 style="margin: 0; text-align: center; padding: 10px 0; background-color: #09332B;"><span><img class="email-logo" src="{{ url('/images/unstoppable-bw.png') }}" alt="" style="width: 150px;"></span></h2>
                            <div class="email-content" style="color: rgb(0, 0, 0); padding: 20px;">
                                <h3 style="margin-top: 0;">Your account was created by {{ $creator }}.</h3>
                                <div class="email-detail-content">
                                    <p style="padding-bottom: 10px">You can login with the following details:</p>
                                    <p style="padding-bottom: 10px">E-mail : <strong style="font-size: 130%">{{ $email }}</strong></p>
                                    <p style="padding-bottom: 10px">User name : <strong style="font-size: 130%">{{ ucfirst($username) }}</strong></p>
                                    <p style="padding-bottom: 10px">Password : <strong style="font-size: 130%">{{ $password }}</strong></p>
                                    <p style="padding-bottom: 10px; margin: 10px 0; text-align: center;">
                                        <strong>
                                            <a class="email-btn" style="background-color: #09332B; padding: 8px 10px;  border-radius: 10px; color: #fff; text-decoration: none;" href="{{ route('login') }}">Login</a>
                                        </strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</body>

</html>