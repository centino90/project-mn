<?php
/* SITE configs */
define('APPROOT', dirname(dirname(__FILE__)));
define('DOCROOT', dirname(dirname(__FILE__), 2));
define('URLROOT', 'http://localhost/DuesPaymentSystem');
define('SITENAME', 'PDA-DCC');
define('APPVERSION', '1.0.0');

/* FB graph configs */
define('FB_GRAPH_VERSION', 'v6.0'); // facebook graph version
define('FB_GRAPH_DOMAIN', 'https://graph.facebook.com/'); // base domain for api
define('FB_APP_STATE', 'eciphp'); // verify state

/* Session configs */
define('SESSION_EXPIRATION', 60 * 10); // 10minutes by default
define('SESSION_LOGIN_TIMESTAMP', 'login_timestamp');
define('SESSION_USER', 'user');
define('SESSION_EMAIL_VERIFIED', 'email_verified');
define('SESSION_PASS_REGISTERED', 'password_registered');
define('SESSION_COMPLETE_INFO', 'complete_info');
define('SESSION_CURRENT_REGS_STEP', 'current_registration_step');

/* User Statuses */
define('USER_STATUSES', array(
    'complete_payment',
    'incomplete_payment',
    'dormant',
    'recovered'
));

/* User Roles */
define('USER_ROLES', array(
    'superadmin',
    'admin',
    'member'
));
