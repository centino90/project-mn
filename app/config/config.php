<?php
  // DB Params
  define('DB_HOST', 'localhost');
  define('DB_USER', 'root');
  define('DB_PASS', '');
  define('DB_NAME', 'DuesPaymentSystem');

  // fb credentials
	define( 'FB_APP_ID', '4649891738473679' );
	define( 'FB_APP_SECRET', '3f981db9771fa424b0870a9eb4e4a4f4' );
	define( 'FB_REDIRECT_URI', 'http://localhost/DuesPaymentSystem/users/login' );

  // GOOGLE credentials
  define( 'GOOGLE_CLIENT_ID', '716149094685-4no609952083305njj3n077nbd3kf61r.apps.googleusercontent.com' );
	define( 'GOOGLE_CLIENT_SECRET', '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' );
	define( 'GOOGLE_REDIRECT_URI', 'http://localhost/DuesPaymentSystem/users/login' );

  // App Root
  define('APPROOT', dirname(dirname(__FILE__)));
  // URL Root
  define('URLROOT', 'http://localhost/DuesPaymentSystem');
  // Site Name
  define('SITENAME', 'DuesPaymentSystem');
  // App Version
  define('APPVERSION', '1.0.0');