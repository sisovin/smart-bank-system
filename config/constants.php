<?php
require_once __DIR__ . '/env.php';
require_once __DIR__ . '/database.php';

Env::load();

define('APP_NAME', 'SmartBank');
define('APP_VERSION', '1.0.0');
define('BASE_URL', Env::get('APP_URL', 'http://localhost/smart-bank-system/public/'));

// Security
define('TOKEN_EXPIRY', (int)Env::get('TOKEN_EXPIRY', 3600)); // 1 hour
define('REFRESH_TOKEN_EXPIRY', 86400 * 7); // 7 days
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOCKOUT_TIME', 900); // 15 minutes

// Application
define('APP_ENV', Env::get('APP_ENV', 'development'));
define('APP_DEBUG', Env::get('APP_DEBUG', 'true') === 'true');

// Transaction Types
define('TRANSACTION_DEPOSIT', 'deposit');
define('TRANSACTION_WITHDRAWAL', 'withdrawal');
define('TRANSACTION_TRANSFER', 'transfer');
define('TRANSACTION_INTEREST', 'interest');
define('TRANSACTION_FEE', 'fee');

// Account Types
define('ACCOUNT_SAVINGS', 'savings');
define('ACCOUNT_CHECKING', 'checking');
define('ACCOUNT_BUSINESS', 'business');

// Roles
define('ROLE_ADMIN', 1);
define('ROLE_MANAGER', 2);
define('ROLE_TELLER', 3);
define('ROLE_ACCREDITED_INVESTOR', 4);
define('ROLE_INVESTOR', 5);
define('ROLE_CUSTOMER', 6);
?>