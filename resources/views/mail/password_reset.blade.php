<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{$data['title']}}</title>
</head>
<body style="margin:0;font-weight:300; font-family:Arial, Helvetica, sans-serif;">
    <div style="width: 100%;margin-right: auto;margin-left: auto;">
        <div style="background: #2460b9; width: 100%; min-height: 80px; margin-bottom:10px;">
            <div style="width: 90%;margin-left: 5%; padding:4px">
                <div style="float: left;padding: 4px 10x 20px 0px">
                    <a href="{{ env('APP_URL') }}" target="_banner"><img src="{{ asset('img/logo.png') }}" style="padding:4px 8px 0px 0px" width="80"></a></a>
                </div>
                <div style="float: none;color: #fff;padding: 15px 0px 12px 0px">
                    <h5 style="padding: 0;margin: 0;font-size:90%;padding-bottom:0px;">&nbsp</h5>
                    <h4 style="padding: 0;margin: 0;font-size:110%;">Shreevahan Pvt.Ltd</h4>
                </div>
            </div>
        </div>
        <table style="padding: 15px;width: 90%; margin-left: 5%;">
        	<tr>
        		<td>
        		<table width="100%" cellpadding="5" cellspacing="0" style="border: 1px solid rgba(0,0,0,.125);border-radius: .25rem;margin-bottom:15px;">
	                <tr>
	                	<td style="padding: .75rem 1.25rem;background-color: rgba(0,0,0,.03);border-bottom: 1px solid rgba(0,0,0,.125);">
	                		<h5 style="padding: 0;margin: 0;font-weight: bold;font-size:100%;">Password Reset</h5>
	                	</td>
	                </tr>
	                <tr>
	                	<td style="padding: .75rem 1.25rem; line-height:1.75; font-size:18px;">
                            <p><b>Hello,</b><br>
                              You are receiving this email because we received a password reset request for your shreevahan account.
                            </p>
	                	</td>
                    </tr>
                    <tr>
	                	<td  style="padding:0px;text-align: center">
                      <a style="text-decoration:none; display: inline-block;font-weight: 400;color: #212529;text-align: center;vertical-align: middle;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;background-color: transparent;border: 1px solid transparent;padding: 8px .75rem .375rem .75rem;font-size: 1rem;line-height: 1.5;border-radius: .25rem;transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;; color: #fff; border-radius:0px; background-color: #007bff; border-color: #007bff;" target="_banner" href="{{url(route("index") . route('password.reset', $data['token'], false). '?email=' . urlencode($data['email']))}}">Chagne Password</a>
                      {{-- <p style="font-size:10px"><a href="{{url(config('app.url') . route('password.reset', $data['token'], false). '?email=' . urlencode($data['email']))}}" class="">{{url(config('app.url') . route('password.reset', $data['token'], false). '?email=' . urlencode($data['email']))}}</a></p> --}}
	                	</td>
                  </tr>
                  <tr>
	                	<td style="padding: .75rem 1.25rem; line-height:1.75; font-size:16px;">
                            <p>This password reset link will expire in 60 minutes.<br>
                              If you did not request a password reset, no further action is required.
                              <p style="font-size:12px;"><b><u>Note:</u></b><br>
                                1.Password Must Should be 8 character long.
                                2.Password should include Lower Case(a-z), Upper Case(A-Z), Number(0-9) and Symbol(!,@,#,$,%,^,&,*).<br>
                              </p>
	                	</td>
                    </tr>
	                <tr>
	                	<td style="padding:15px 15px 0 15px; padding-bottom:15px;">
                        <hr style="width:25%; margin:0;">
                            <img src="{{ asset('img/logo.png') }}" width="80" style="padding-left:10px; margin-top:10px;">
                            <p style="margin:0;padding:3px 0 3px 0; font-weight:bold;">Shreevahan Pvt.Ltd</p>
                            <p style="margin:0;padding:3px 0 3px 0;">Sundhara, Kathmandu Nepal</p>
                            <p style="margin:0;padding:3px 0 3px 0;">Phone: 01-34535566</p>
                            <p style="margin:0;padding:3px 0 3px 0;">Website: <a href="https://www.mofaga.gov.np" target="_banner">www.shreevahan.com.np</a></p>
                            <p style="margin:0;padding:3px 0 3px 0;">Email <a href="mailto:info@mofaga.gov.np">shreevahan@gmail.com</a></p>
	                	</td>
	                </tr>
                </table>
                <div style="text-align:center"><small style="margin-bottom:15px;">&copy; Copy right all right reserved Shreevahan Pvt.Ltd </small></div>
        		</td>
        	</tr>
        </table>
</body>
</html>