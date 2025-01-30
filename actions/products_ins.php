<?php
session_start();
define('_WEBROOT_PATH_', '../');
define('_LOG_NAME_', 'action');
require './components/setup.php';
$conn = getDatabaseConnections()['default'];

