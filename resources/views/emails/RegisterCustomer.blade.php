<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome To Dinheiro Agora</title>
</head>

<body style="font-family: Helvetica, Arial, sans-serif; margin: 0px; padding: 0px; background-color: #ffffff;">
    <div role="presentation" style="width: 100%; background-color: rgb(239, 239, 239);">
        <div align="center" vertical-align: top; width: 100%;">
            <div role="presentation"
                style=" border-collapse: collapse; border: 0px; border-spacing: 0px; text-align: left;">
                    <div >
                        <div style="text-align: left;">
                            <div>
                                <!-- <img src="" alt="Company" style="display: block; margin: 0 auto;"> -->
                            </div>
                        </div>
                        <div class="email-section" style="background-color: #f0f0f0;">
                            <h2 style="margin: 0; text-align: center; padding: 10px 0; background-color: #2CBCDD;"><span><img class="email-logo" src="{{config('app.url')}}images/instant-loan-logo.png" alt="" style="width: 150px;"></span></h2>
                            <div class="email-content" style="color: rgb(0, 0, 0); padding: 20px;">
                                <h3 style="margin-top: 0;">Sua conta foi criada por {{ $creator }}.</h3>
                                <div class="email-detail-content">
                                    <p style="padding-bottom: 10px">Você pode fazer login com os seguintes detalhes:</p>
                                    <p style="padding-bottom: 10px">E-mail : <strong style="font-size: 130%">{{ $email }}</strong></p>
                                    <p style="padding-bottom: 10px">Nome de usuário : <strong style="font-size: 130%">{{ ucfirst($username) }}</strong></p>
                                    <p style="padding-bottom: 10px">Senha : <strong style="font-size: 130%">{{ $password }}</strong></p>
                                    <p style="padding-bottom: 10px; margin: 10px 0; text-align: center;">
                                        <strong>
                                            <a class="email-btn" style="background-color: #2CBCDD; padding: 8px 10px;  border-radius: 10px; color: #fff; text-decoration: none;" href="{{ route('login') }}">Clique aqui para logar</a>
                                        </strong>
                                    </p>
                                    <h3 style="color: #2CBCDD; text-align: center;">Obrigado,<br>Dinheiro Agora Team</h3>
                                </div>
                            </div>
                            <div style="background-color: blanchedalmond; padding: 10px 20px; display: flex; justify-content: center;">
                                <h4>direito autoral &#169; Dinheiroagora</h4>
                             </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</body>

</html>