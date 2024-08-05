<?php

// Staging or Test-Environment = false
// Livesystem or Production = true
define('ENV_PRODUCTION', TRUE);
define('CHATGPTKEY', 'sk-xxxxxxxxxxxxxxxxxxxxxxxxxxxxx');

// General Database
define('DB_SETTINGS',[
  'host' => 'mariadb',
  'user' => 'db_user',
  'password' => 'db_pass',
  'dbname' => 'bnn-buddy',
]);

// User Database
define('USER_DB_SETTINGS', DB_SETTINGS);

// Mail Stuff
define('MAIL_SERVER', 'xxxxxx');
define('MAIL_USERNAME', 'xxxxxx');
define('MAIL_PW', 'xxxxxx');
define('MAIL_SENDER_ADDRESS', 'xxxxxx');
define('MAIL_SENDER_NAME', 'Ai-Buddy');

// IPs that dont require Login
define('ALLOWED_IPS', [
  '192.168.0.1',
  '192.168.65.1',
]);

// Encryption Key (once defined - don't Change)
define('ENCRYPTION_KEY', 'xxxxxxxxxxxxx');
