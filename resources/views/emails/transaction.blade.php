<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Applied Successfully</title>
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
                                <h3 style="margin-top: 0;">Hey User, Your job is applied successfully.</h3>
                                <div class="email-detail-content">
                                    <p style="padding-bottom: 10px">Here's, your job application and status:</p>
                                    <p style="padding-bottom: 10px">E-mail : <strong style="font-size: 100%">{{ $email }}</strong></p>
                                    <p style="padding-bottom: 10px">User name : <strong style="font-size: 100%">{{ ($username) }}</strong></p>
                                    <p style="padding-bottom: 10px">Job Title : <strong style="font-size: 100%">{{ $job_title }}</strong></p>
                                    <p style="padding-bottom: 10px">Job Status : <strong style="font-size: 100%">
                                        @if ($job_status == 0)
                                            <span style="color: green;"><b>Active</b></span>
                                        @elseif ($job_status == 1)
                                        <span style="color: green;"><b>Awaiting Review</b></span>
                                        @elseif ($job_status == 2)
                                        <span style="color: green;"><b>Reviewed</b></span>
                                        @elseif ($job_status == 3)
                                        <span style="color: green;"><b>Contacted</b></span>
                                        @elseif ($job_status == 4)
                                        <span style="color: green;"><b>Hired</b></span>
                                        @elseif ($job_status == 5)
                                        <span style="color: red;"><b>Rejected</b></span>
                                        @else
                                        <span style="color: red;"><b>No Data Found</b></span>
                                        @endif    
                                    
                                    </strong></p>
                                    <p style="padding-bottom: 10px">Transaction Status : <strong style="font-size: 100%">{{ $transaction_status }}</strong></p>
                                    <h3 style="margin-top: 0;">You can view your job status . Here's the login link:</h3>
                                    <p style="padding-bottom: 10px; margin: 10px 0; text-align: center;">

                                        <strong>
                                            <a class="email-btn" style="text-decoration:none; padding: 12px 15px; color: #fff; background-color: #01796f; border-radius: 8px; font-size: 17px;" href="{{ route('login') }}">Login</a>
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