<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Applied Successfully</title>
</head>

<body style="font-family: Helvetica, Arial, sans-serif; margin: 0px; padding: 0px; background-color: #ffffff;">
        <table role="presentation"  class="applied_mail" style="margin:0 auto: border-collapse: collapse; width:100%; border:0;"  cellpadding="0" cellspacing="0" width="100%">
                    <thead>
                        <th>
                            <div class="" style="background-color:#01796f; padding:25px 20px;">
                                <img class="email-logo" src="{{ url('https://unstoppable.dev.visionvivante.com/images/web-logo.png') }}" alt="" style="width: 200px;">
                            </div>
                        </th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="email-section" style="background-color:#fbfbfb;">
                                    <div class="email-content" style="color: rgb(0, 0, 0); padding: 30px 10px;">
                                            <table style="max-width:600px;margin:0 auto;width:100%;">
                                                <tr>
                                                    <td>
                                                        <div class="email-detail-content" style=" background-color:#fff; border:1px solid #dfdfdf; padding:20px;">
                                                            <h2 style="margin-top: 0; text-align:center; color:#000;">Hey User, Your job is applied successfully.</h2>
                                                            <hr style="border:1px solid #dfdfdf;">
                                                            <p style="padding-bottom: 0px; padding-top:10px; color:#000;">Here's, your job application and status:</p>
                                                            <p style="padding:0px; margin:10px 0px; text-decoration:none; color:#fff;"><b style="color:#000; font-weight:700;">E-mail :</b> <span style="font-size: 100%; color:#000;">{{ $email }}</span></p>
                                                            <p style="padding:0px; margin:10px 0px;"><b style="color:#000; font-weight:700;">User name : </b><span style="font-size: 100%">{{ ($username) }}</span></p>
                                                            <p style="padding:0px; margin:10px 0px;"><b style="color:#000; font-weight:700;">Job Title : </b><span style="font-size: 100%">{{ $job_title }}</span></p>
                                                            <p style="padding:0px; margin:10px 0px;"><b style="color:#000; font-weight:700;">Job Status : </b><span style="font-size: 100%">
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
                                                            </span></p>
                                                            <p style="padding:0px; margin:10px 0px 30px 0px;"><b style="color:#000; font-weight:700;">Transaction Status : </b><span style="font-size: 100%">{{ $transaction_status }}</span></p>
                                                            <hr style="border:1px solid #dfdfdf;">
                                                            <!-- <h3 style="margin-top: 0; text-align:center; margin:20px 0px; color:#000;">You can view your job status . Here's the login link:</h3> -->
                                                            <p style="padding-bottom: 10px; margin: 30px 0px 10px 0px; text-align: center;">
                                                            <strong>
                                                            <a class="email-btn" style="text-decoration:none; padding: 15px 47px; color: #fff; background-color: #01796f; border-radius: 8px; font-size: 17px;" href="{{ route('login') }}">Login</a>
                                                            </strong>
                                                            </p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
        </table>
</body>

</html>