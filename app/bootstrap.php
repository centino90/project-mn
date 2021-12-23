<?php
/* =========== Load Dependencies  
  ============================== */

// composer dependencies
require_once '../vendor/autoload.php';

// Configs
require_once 'config/config.php';
require_once 'config/api.php';

// Helpers
require_once 'helpers/string_helper.php';
require_once 'helpers/url_helper.php';
require_once 'helpers/session_helper.php';
require_once 'helpers/date_helper.php';

require_once 'helpers/mailer.php';

// APIs
require_once 'API/facebook.php';
require_once 'API/google.php';

// Autoload Core Libraries
spl_autoload_register(function ($className) {
  require_once 'libraries/' . $className . '.php';
});
