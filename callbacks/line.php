<?php

define('_WEBROOT_PATH_', '../');
define('_LOG_NAME_', 'action');
require _WEBROOT_PATH_.'/components/setup.php';
$conn = getDatabaseConnections()['default'];

if (!isset($_GET['code'])) {
    die('Authorization code not found');
}

$code = $_GET['code'];

// ขอ Access Token
$data = [
    'grant_type'    => 'authorization_code',
    'code'          => $code,
    'redirect_uri'  => $_ENV['LINE_CALLBACK_URL'],
    'client_id'     => $_ENV['LINE_CHANNEL_ID'],
    'client_secret' => $_ENV['LINE_CHANNEL_SECRET'],
];

$options = [
    'http' => [
        'header'  => "Content-Type: application/x-www-form-urlencoded",
        'method'  => 'POST',
        'content' => http_build_query($data)
    ]
];

$response = file_get_contents("https://api.line.me/oauth2/v2.1/token", false, stream_context_create($options));
$token_data = json_decode($response, true);

if (!isset($token_data['access_token'])) {
    die('Failed to get access token');
}

// ดึงข้อมูลโปรไฟล์
$options = [
    'http' => [
        'header'  => "Authorization: Bearer " . $token_data['access_token'],
        'method'  => 'GET'
    ]
];

$response = file_get_contents("https://api.line.me/v2/profile", false, stream_context_create($options));
$user_data = json_decode($response, true);
error_log(json_encode($user_data, JSON_PRETTY_PRINT));
if (!isset($user_data['userId'])) {
    die('Failed to get user profile');
}

$_SESSION['auth_method'] = 'line';
$_SESSION['auth_key'] = $user_data['userId'];
$_SESSION['display_name'] = $user_data['displayName'];
$_SESSION['avatar_img'] = $user_data['pictureUrl'];

checkExistsKey('line', $user_data['userId'], [
    'display_name' => $user_data['displayName'],
    'avatar_img' => $user_data['pictureUrl'],
]);

header("Location: ../");
exit;
?>
