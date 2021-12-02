<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDA-DCC</title>
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
        </div>

        <div style="max-width: 600px; border-radius: 8px;margin: 0 auto;">
            <h1 style="gap: 10px;display: flex; align-items: center; justify-content: center; margin-bottom: 60px;">
                Your new password
            </h1>

            <div>
                <h2>Hello,</h2>
                <hr>
                <br>
                <center>
                    <p>Here is an uncrypted version of your new password.</p>

                    <div style="display:inline-block;margin: 20px 0; padding: 15px;border: 2px solid #D946EF ;border-radius: 5px;color:#D946EF;font-weight: bold;text-decoration:none;">
                        {{password}}
                    </div>

                    <p>You can always request a password reset as long as you have access to your email.</p>

                    <br>

                    <div>
                        Regards,
                        <b>PDA-DCC</b>
                    </div>
                </center>
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
                    © 2021 - PDA-DCC
                </p>
            </footer>
        </div>
    </div>
</body>

</html>