<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome To Instant Loan</title>
</head>

<body style="font-family: Helvetica, Arial, sans-serif; margin: 0px; padding: 0px; background-color: #ffffff;">
    <h2 style="margin: 0; text-align: center; padding: 10px 0; background-color: #09332B;"><span><img class="email-logo"
        src="{{config('app.url')}}images/instant-loan-logo.png" alt="" style="width: 150px;"></span>
    </h2>
    <div style="padding: 20px; background-color: rgb(255, 255, 255);">
        <div style="color: rgb(0, 0, 0); text-align: left;">
          <h2 style="margin: 1rem 0">Sua conta foi criada por {{ $creator }}</h2>
          <p style="padding-bottom: 16px">Você pode fazer login com os seguintes detalhes:</p>
          <p style="padding-bottom: 16px">E-mail : <strong style="font-size: 130%">{{ $email }}</strong></p>
          <p style="padding-bottom: 16px">Nome de usuário : <strong style="font-size: 130%">{{ ucfirst($username) }}</strong></p>
          <p style="padding-bottom: 16px">Senha : <strong style="font-size: 130%">{{ $password }}</strong></p>
          {{-- <p style="padding-bottom: 16px"><strong style="font-size: 130%"><a  style="background-color: #2CBCDD; padding: 8px 10px;  border-radius: 10px; color: #fff; text-decoration: none;" href="{{ route('login') }}">Click here to Login</a></strong></p> --}}
          <h3 style="color: #09332B;">Obrigado,<br>Equipe de empréstimo instantâneo</h3>
        </div>
      </div>
      <div style="background-color: blanchedalmond; padding: 10px 20px; display: flex; justify-content: center;">
        {{-- <h4>direito autoral &#169; Dinheiroagora</h4> --}}
     </div>
</body>

</html>
