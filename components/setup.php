<?php

session_start();

require _WEBROOT_PATH_ . 'helpers/functions.php';
require _WEBROOT_PATH_ . 'helpers/userInfo.php';
require _WEBROOT_PATH_ . 'vendor/autoload.php';

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(_WEBROOT_PATH_);
$dotenv->load();

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
// Format Setup
$loggerDateTimeFormat = "Y-m-d H:i:s";
$loggerOutput = "[%datetime%] [%level_name%] [".UserInfo::get_ip()."] [%message%] %context% %extra%\n";
// Format Create A Formatter
$loggerFormatter = new LineFormatter($loggerOutput, $loggerDateTimeFormat);
// Create a handler
$loggerStream = new StreamHandler(_WEBROOT_PATH_.'logs/access'.date('_Y-m-d').'.log', Level::Debug);
$loggerStream->setFormatter($loggerFormatter);
// bind it to a logger object
$logger = new Logger(_LOG_NAME_);
$logger->pushHandler($loggerStream);