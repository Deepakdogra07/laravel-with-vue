<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<body style="font-family: Helvetica, Arial, sans-serif; margin: 0px; padding: 0px;">
    <div  style="background-color: #09332B; display: flex; padding: 10px 0; justify-content: center;">
        <img src="{{ url('/images/unstoppable-bw.png') }}" alt="Company" style="display: block;width: 150px; margin: 0 auto;"> 
        {{-- <img src="{{config('app.url')}}images/instant-loan-logo.png" alt="" style="width: 150px; margin: 0 auto;"> --}}
    </div>
    <div style="padding: 30px 20px; background-color: #f7f7f7;">
        <p style="font-size: 16px; color: #000;">Click the button below to Reset Your Password.</p>
        <div style="text-align: center; margin: 30px 0;">
            <a  href="{{ $actionUrl }}" style="text-decoration:none; padding: 11px 20px; color: #fff; background-color: #000D37; border-radius: 10px;">Reset Password</a>
        </div>
        
    </div>
    <div>
        <p style="font-size: 16px; color: #000;">If you are having trouble clicking the "Reset Pasword" button, copy and paste the URL below into your browser:</p>
        <p>{{ $actionUrl }}</p>
    </div>
   
</body>

</html>
