<?php

// if (!isset($_SESSION['account_session_key'])) {
// 	header("Location: "._WEBROOT_PATH_."login.php");
// 	exit(0);
// }

// Connection Setup :: START
require _WEBROOT_PATH_ . 'helpers/load_env.php';
require _WEBROOT_PATH_ . 'helpers/functions.php';
$connections = getDatabaseConnections();
$connect = $connections['default'];
// Connection Setup :: END

$session_key = $_SESSION['account_session_key'];