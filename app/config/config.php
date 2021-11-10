<?php
  // DB Params
  define('DB_HOST', 'localhost');
  define('DB_USER', 'root');
  define('DB_PASS', '');
  define('DB_NAME', 'sharepost');

  // fb credentials
	define( 'FB_APP_ID', '588828775575026' );
	define( 'FB_APP_SECRET', 'fa84df8f7124bfe6aab8d17bd38bee6c' );
	define( 'FB_REDIRECT_URI', 'http://localhost/shareposts/users/login' );

  // GOOGLE credentials
  define( 'GOOGLE_CLIENT_ID', '1077172918494-3heojo31o53ha1bjd9t0ilqi1uj5uit7.apps.googleusercontent.com' );
	define( 'GOOGLE_CLIENT_SECRET', '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' );
	define( 'GOOGLE_REDIRECT_URI', 'http://localhost/shareposts/users/login' );

  // App Root
  define('APPROOT', dirname(dirname(__FILE__)));
  // URL Root
  define('URLROOT', 'http://localhost/shareposts');
  // Site Name
  define('SITENAME', 'SharePosts');
  // App Version
  define('APPVERSION', '1.0.0');