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
        </div>

        <div style="max-width: 700px; border-radius: 8px;">
            <h1 style="gap: 10px;display: flex; align-items: center; justify-content: center; margin-bottom: 60px;">
                <svg style="width: 35px;height:35px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M2.94 6.412A2 2 0 002 8.108V16a2 2 0 002 2h12a2 2 0 002-2V8.108a2 2 0 00-.94-1.696l-6-3.75a2 2 0 00-2.12 0l-6 3.75zm2.615 2.423a1 1 0 10-1.11 1.664l5 3.333a1 1 0 001.11 0l5-3.333a1 1 0 00-1.11-1.664L10 11.798 5.555 8.835z" clip-rule="evenodd" />
                </svg>
                Verify your email
            </h1>

            <div>
                <h2>Hello,</h2>
                <hr>
                <br>
                <center>
                    <div style="display: flex; justify-content:center; align-items:center; flex-direction:column">
                        <p>Please click the button below to verify your email address.</p>

                        <br>
                        
                        <a href="{{verify_url}}" style="margin: 20px 0; padding: 15px;background-color: #D946EF;border-radius: 5px;color:#fff;font-weight: bold;text-decoration:none;">
                            Verify email address
                        </a>

                        <br>

                        <p>If this link did not work, redo your action and resend another verification request.</p>

                        <br>

                        <div>
                            Regards,
                            <b>PDA-DCC</b>
                        </div>
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