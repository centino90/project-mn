<?php
// DB Params
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'DuesPaymentSystem');

// fb credentials
define('FB_APP_ID', '597967324656000');
define('FB_APP_SECRET', '96b5f8442fa44b01bc8ee03d17da0271');
define('FB_REDIRECT_URI', 'http://localhost/DuesPaymentSystem/users/redirectPage');

// GOOGLE credentials
define('GOOGLE_CLIENT_ID', '339949192946-oeiqofcjp8j81t759usbnm5eamp20uvn.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
define('GOOGLE_REDIRECT_URI', 'http://localhost/DuesPaymentSystem/users/redirectPage');

// RECAPTCHA credentials
define('RECAPTCHA_SITEKEY', '6LcpA30dAAAAAOVfY5fIQgV5BDZsAtBnpo8lkdW1');
define('RECAPTCHA_SECRET', '6LcpA30dAAAAAGQnG5gzHeDcSiOMEfEaz8_93-a1');

// MAIL settings
define('MAIL_MAILER', 'smtp');
define('MAIL_HOST', 'smtp.mailtrap.io');
define('MAIL_PORT', '587');
define('MAIL_USERNAME', '5751f0c27c5469');
define('MAIL_PASSWORD', '9a4457a2f0275c');
define('MAIL_ENCRYPTION', null);
define('MAIL_FROM_ADDRESS', 'c2c439914d-5fcf45@inbox.mailtrap.io');
define('MAIL_FROM_NAME', 'PDA-DCC');


// App Root
define('APPROOT', dirname(dirname(__FILE__)));
// URL Root
define('URLROOT', 'http://localhost/DuesPaymentSystem');
// Site Name
define('SITENAME', 'PDA-DCC');
// App Version
define('APPVERSION', '1.0.0');
