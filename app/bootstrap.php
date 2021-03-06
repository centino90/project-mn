<?php
/* =========== Load Dependencies  
  ============================== */

// composer dependencies
require_once '../vendor/autoload.php';

// Configs
require_once 'config/config.php';
require_once 'config/sensitive.php';

// Helpers
require_once 'helpers/debug.php';
require_once 'helpers/Image.php';
require_once 'helpers/Roles.php';
require_once 'helpers/SessionManager.php';
require_once 'helpers/UrlManager.php';
require_once 'helpers/string_helper.php';
require_once 'helpers/url_helper.php';
require_once 'helpers/session_helper.php';
require_once 'helpers/date_helper.php';

// APIs
require_once 'API/facebook.php';
require_once 'API/google.php';

// Autoload Core Libraries
spl_autoload_register(function ($className) {
  require_once 'libraries/' . $className . '.php';
});
