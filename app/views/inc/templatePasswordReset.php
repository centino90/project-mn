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
    <div style="display: flex; flex-direction: column; align-items:center; justify-content: center">
        <div style="background-color: #F8FAFC; width:100%;text-align:center;padding: 20px 0;">
            <h2 style="color:#9CA3AF">PDA-DCC</h2>
        </div>

        <div style="max-width: 700px; border-radius: 8px;">
            <h1 style="gap: 10px;display: flex; align-items: center; justify-content: center; margin-bottom: 60px;">
                <svg style="width: 35px;height:35px;" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd" />
                </svg>
                Your new password
            </h1>

            <div>
                <h2>Hello,</h2>
                <hr>
                <div style="display: flex; justify-content:center; align-items:center; flex-direction:column">
                    <p>Here is an uncrypted version of your new password.</p>

                    <div style="margin: 20px 0; padding: 15px;border: 2px solid #D946EF ;border-radius: 5px;color:#D946EF;font-weight: bold;text-decoration:none;">
                        {{password}}
                    </div>

                    <p>You can always request a password reset as long as you have access to your email.</p>

                    <div>
                        Regards,
                        <b>PDA-DCC</b>
                    </div>
                </div>
            </div>

            <footer style="margin-top: 50px;">
                <ul style="display: flex; justify-content:center; gap:20px;">
                    <a href="{{about_url}}" class="flex gap-1 text-sm font-semibold text-secondary-500 hover:text-secondary-900">
                        About us
                    </a>
                    <a href="{{privacy_url}}" class="flex gap-1 text-sm font-semibold text-secondary-500 hover:text-secondary-900">
                        Privacy policy
                    </a>
                    <a href="{{terms_url}}" class="flex gap-1 text-sm font-semibold text-secondary-500 hover:text-secondary-900">
                        Terms of service
                    </a>
                </ul>

                <p style="text-align:center;">
                    © 2021 - PDA-DCC
                </p>
            </footer>
        </div>
    </div>
</body>

</html>