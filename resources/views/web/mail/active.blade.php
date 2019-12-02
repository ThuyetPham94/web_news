<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>VAPP</title>
        <style>
        body{margin:0px; padding:0px;  font-family:tahoma;}
        </style>
    </head>
    <body>
        <table cellpadding="0" cellspacing="0"  width="620" style="margin:auto auto; background:#83539B; padding:32px 32px 48px 32px; border-radius:8px;">
            <tr cellpadding="0" cellspacing="0" >
                <td>
                    <table cellpadding="0" cellspacing="0"  style=" border-radius:8px; width:100%; font-family:Tahoma, sans-serif; padding:24px;">
                        <tr><td height="36" valign="top" style="color:rgb(240,240,240); font-size:16px;">Hi {{ $name }},</td></tr>
                        <tr>
                            <td  valign="top" style="color:rgb(240,240,240); font-size:16px; line-height:24px;">
                                Chào mừng tới Wordsgrow!<br/><br/>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" style="color:rgb(240,240,240); font-size:16px; line-height:24px;">
                                Địa chỉ email của bạn: <span> {{ $email_new }}</span><br/>
                                Click để active tài khoản <a href="http://wordsgrow.com.vn/success?email={{$email}}" style="color:green; text-decoration:none;">clicking here</a><br/><br/>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" style="color:rgb(240,240,240); font-size:15px; line-height:26px;">
                                <span style="color:rgb(240,240,240)"><b>Have a great day!</b></span><br/>
                                <b>Wordsgrow Team</b>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
