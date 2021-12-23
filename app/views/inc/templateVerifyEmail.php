<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo SITENAME; ?></title>
</head>
<style>
    :root {
        font-family: Roboto, serif;
    }
</style>

<body style="margin:0;padding:0">
    <div>
        <div style="background-color: #F8FAFC; width:100%;text-align:center;padding: 20px 0;">
            <h2 style="color:#9CA3AF">PDA-DCC</h2>
            <img style="margin: 0 auto;" width="50px" src="{{logo_url}}" alt="">
        </div>

        <div style="max-width: 600px;padding: 0 50px; border-radius: 8px">
            <h1 style="gap: 10px;display: flex; align-items: center; justify-content: center; margin-bottom: 60px;">
                Verify your email
            </h1>

            <div>
                <p>Good day, {{email_to}}</p>
                <!-- <hr> -->
                <br>

                <p>The <b>{{transaction}}</b> you made using {{current_email}} on {{timestamp}} requires you to verify your email by clicking the link below.</p>
                <!-- <center> -->
                <br>
                <p>By clicking the link below, you will be redirected to pda-dcc.com.</p>
                <br>
                <a href="{{verify_url}}" style="display: inline-block;margin: 15px 0; padding: 15px;background-color: #D946EF;border-radius: 5px;color:#fff;font-weight: bold;text-decoration:none;">
                    Verify email address
                </a>
                <br>
                <p>If this link did not work, redo your action and resend another verification request.</p>
                <br>
                <div>
                    Regards,
                    <b>PDA-DCC</b>
                </div>
                <!-- </center> -->
            </div>

            <br>

            <footer style="margin-top: 50px;">
                <ul>
                    <center>
                        <a href="{{about_url}}">
                            About us
                        </a>
                        <a href="{{privacy_url}}" style="margin-left: 25px;">
                            Privacy policy
                        </a>
                        <a href="{{terms_url}}" style="margin-left: 25px;">
                            Terms of service
                        </a>
                    </center>
                </ul>

                <p style="text-align:center;">
                    © {{current_year}} - PDA-DCC
                </p>
            </footer>
        </div>
    </div>
</body>

</html>