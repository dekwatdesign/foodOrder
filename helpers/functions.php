<?php

// Database configuration function
function getDatabaseConnections(): array
{
    $default_host = $_ENV['SHOP_DB_HOST'];
    $default_user = $_ENV['SHOP_DB_USER'];
    $default_pass = $_ENV['SHOP_DB_PASS'];
    $default_db = $_ENV['SHOP_DB_NAME'];

    // Work Connection
    $default_connect = new mysqli($default_host, $default_user, $default_pass, $default_db);
    $default_connect->set_charset("utf8");
    $default_connect->connect_error ? die("Connection failed: " . $default_connect->connect_error) : null;

    return [
        'default' => $default_connect
    ];
}

function checkExistsKey($auth_method, $auth_key, $params = [])
{
    global $conn;
    $sql = "SELECT * FROM members_keys WHERE auth_method='$auth_method' AND auth_key = '{$auth_key}' ";
    $query = $conn->query($sql);

    // New Insert
    if ($query->num_rows === 0):
        $new_mb_vals = [
            'display_name_auth_method' => $auth_method,
            'display_name' => strlen($params['display_name']) > 0 ? addslashes($params['display_name']) : null,
            'avatar_auth_method' => $auth_method,
            'avatar_img' => strlen($params['avatar_img']) > 0 ? $params['avatar_img'] : null,
        ];
        $new_mb_sql = arrayToInsertSQL('members', $new_mb_vals);
        if ($conn->query($new_mb_sql) === TRUE):
            $last_id = $conn->insert_id;
            $new_key_vals = [
                'member_id' => $last_id,
                'auth_method' => $auth_method,
                'auth_key' => $auth_key,
                'key_hashed' => strlen($params['key_hashed']) > 0 ? $params['key_hashed'] : null,
            ];
            $new_key_sql = arrayToInsertSQL('members_keys', $new_key_vals);
            $conn->query($new_key_sql);
        endif;
    endif;
}

function getPublishProfile($auth_key, $auth_method = 'email')
{
    // $profile = [];
    // switch ($auth_method) {
    //     case 'line':
    //         $profile = getLineProfileWithUserID($auth_key);
    //         break;
    //     default:
    //         $profile = getDefaultProfile($auth_key);
    //         break;
    // }

    // return $profile;
    return [
        'display_name' => $_SESSION['display_name'],
        'avatar_img' => $_SESSION['avatar_img'],
    ];
}

function getDefaultProfile($auth_key)
{
    return [];
}

function getLineProfileWithUserID($user_id)
{

    return [
        'display_name' => $_SESSION['display_name'],
        'avatar_img' => $_SESSION['avatar_img'],
    ];
}

// สร้าง CSRF Token
function generate_csrf_token()
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// ตรวจสอบ CSRF Token
function verify_csrf_token($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// ป้องกัน Brute Force (ล็อกบัญชีชั่วคราว)
function check_login_attempts($pdo, $ip)
{
    $stmt = $pdo->prepare("SELECT attempts, last_attempt FROM login_attempts WHERE ip = ?");
    $stmt->execute([$ip]);
    $row = $stmt->fetch();

    if ($row) {
        if ($row['attempts'] >= 5 && time() - strtotime($row['last_attempt']) < 900) {
            return false;
        }
    }
    return true;
}

// บันทึกการพยายามล็อกอิน
function record_login_attempt($pdo, $ip, $success)
{
    if ($success) {
        $stmt = $pdo->prepare("DELETE FROM login_attempts WHERE ip = ?");
        $stmt->execute([$ip]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO login_attempts (ip, attempts, last_attempt) 
            VALUES (?, 1, NOW()) ON DUPLICATE KEY UPDATE attempts = attempts + 1, last_attempt = NOW()");
        $stmt->execute([$ip]);
    }
}

function lineLoginURL()
{
    return "https://access.line.me/oauth2/v2.1/authorize?response_type=code" .
        "&client_id=" . $_ENV['LINE_CHANNEL_ID'] .
        "&redirect_uri=" . urlencode($_ENV['LINE_CALLBACK_URL']) .
        "&scope=profile%20openid%20email" .
        "&state=" . bin2hex(random_bytes(16));
}

function convertDateToWeekdayArr($date): array
{
    $weekdays = [
        [
            "name_en_full" => "Sunday",
            "name_th_short" => "อา.",
            "color_class" => "danger"
        ],
        [
            "name_en_full" => "Monday",
            "name_th_short" => "จ.",
            "color_class" => "primary"
        ],
        [
            "name_en_full" => "Tuesday",
            "name_th_short" => "อ.",
            "color_class" => "success"
        ],
        [
            "name_en_full" => "Wednesday",
            "name_th_short" => "พ.",
            "color_class" => "info"
        ],
        [
            "name_en_full" => "Thursday",
            "name_th_short" => "พฤ.",
            "color_class" => "warning"
        ],
        [
            "name_en_full" => "Friday",
            "name_th_short" => "ศ.",
            "color_class" => "secondary"
        ],
        [
            "name_en_full" => "Saturday",
            "name_th_short" => "ส.",
            "color_class" => "dark"
        ]
    ];

    $timestamp = strtotime($date);
    $englishDay = date('w', $timestamp); // คืนค่าชื่อวันเป็นภาษาอังกฤษ (Monday, Tuesday, ...)

    return $weekdays[$englishDay] ?? []; // แปลงเป็นวันภาษาไทย
}

function getClientInfo()
{
    $clientInfo = [];

    // Get client IP address
    $clientInfo['ip_address'] = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

    // Check for proxy or forwarded IP address
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $clientInfo['ip_address'] = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $clientInfo['ip_address'] = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    // Get User-Agent (browser details)
    $clientInfo['user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';

    // Get server details
    $clientInfo['server_name'] = $_SERVER['SERVER_NAME'] ?? 'UNKNOWN';
    $clientInfo['server_addr'] = $_SERVER['SERVER_ADDR'] ?? 'UNKNOWN';
    $clientInfo['request_method'] = $_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN';
    $clientInfo['request_uri'] = $_SERVER['REQUEST_URI'] ?? 'UNKNOWN';

    return $clientInfo;
}

function generateSessionKey()
{
    // สร้างคีย์แบบสุ่ม 32 ไบต์ และเข้ารหัสในรูปแบบ Base64
    $key = bin2hex(random_bytes(32));
    return $key;
}

function generateRememberKey()
{
    // สร้างคีย์แบบสุ่ม 64 ไบต์ และเข้ารหัสในรูปแบบ Base64
    $key = base64_encode(random_bytes(64));
    return $key;
}

function arrayToInsertSQL($tableName, $data)
{
    // ตรวจสอบว่าข้อมูลไม่ว่างเปล่า
    if (empty($tableName) || empty($data) || !is_array($data)) {
        throw new InvalidArgumentException("Invalid table name or data.");
    }

    // สร้างรายการคอลัมน์และค่าจาก Array
    $columns = implode(", ", array_keys($data));

    // สร้าง placeholders และตรวจสอบค่า null
    $placeholders = [];

    foreach ($data as $key => $value) {
        if ($value === null) {
            $placeholders[] = " 'NULL' ";
        } else {
            $placeholders[] = " '$value' ";
        }
    }

    // ใช้ implode เพื่อรวม placeholders
    $placeholders = implode(", ", $placeholders);

    // สร้างคำสั่ง SQL
    $sql = "INSERT INTO $tableName ($columns) VALUES ($placeholders);";

    return $sql;
}

function arrayToInsertSQLMultiRows($tableName, $data_arr)
{
    // สร้างรายการคอลัมน์และค่าจาก Array
    $columns = implode(", ", array_keys($data_arr[0]));
    // สร้าง placeholders และตรวจสอบค่า null
    $placeholders_all = [];

    foreach ($data_arr as $dkey => $value_arr) {
        $placeholders = [];
        foreach ($value_arr as $vkey => $value) {
            if ($value === null) {
                $placeholders[] = " 'NULL' ";
            } else {
                $placeholders[] = " '$value' ";
            }
        }
        $placeholders_all[] = "(" . implode(", ", $placeholders) . ")";
    }

    $values_sql = implode(", ", $placeholders_all);

    // สร้างคำสั่ง SQL
    $sql = "INSERT INTO $tableName ($columns) VALUES $values_sql;";

    return $sql;
}


function arrayToUpdateSQL($tableName, $data, $where)
{
    // ตรวจสอบข้อมูลเบื้องต้น
    if (empty($tableName) || empty($data) || !is_array($data) || empty($where)) {
        throw new InvalidArgumentException("Invalid table name, data, or where clause.");
    }

    // สร้างส่วนของคอลัมน์สำหรับการอัปเดต
    $setClause = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));

    // สร้างคำสั่ง SQL
    $sql = "UPDATE $tableName SET $setClause WHERE $where;";

    return $sql;
}

function getTimeRangeOptions($timeRange)
{
    // กำหนดอาร์เรย์ของช่วงเวลา
    $time_range_arr = [
        1 => 1 * 24 * 60 * 60,   // 1 วัน
        2 => 7 * 24 * 60 * 60,   // 1 สัปดาห์
        3 => 30 * 24 * 60 * 60,  // 1 เดือน (ประมาณ 30 วัน)
        4 => 90 * 24 * 60 * 60,  // 3 เดือน (ประมาณ 90 วัน)
        5 => 180 * 24 * 60 * 60, // 6 เดือน (ประมาณ 180 วัน)
        6 => 365 * 24 * 60 * 60  // 1 ปี (365 วัน)
    ];

    // ตรวจสอบว่า timeRange ที่ส่งมาเป็นค่าที่ถูกต้อง
    if (!array_key_exists($timeRange, $time_range_arr)) {
        throw new InvalidArgumentException("Invalid time range selected.");
    }
    $expiryTime = time() + $time_range_arr[$timeRange];

    // คำนวณเวลา expiryTime ตามช่วงเวลา
    return [
        'expire_time' => $expiryTime,
        'expire_datetime' => date("Y-m-d H:i:s", $expiryTime),
    ];
}

function setLongTermCookie($name, $value, $timeRange)
{

    $expiryTime = getTimeRangeOptions($timeRange);

    // ตั้งค่า Cookie
    setcookie($name, $value, $expiryTime['expire_time'], "/", "", true, true);

    // ส่งคืนวันที่หมดอายุในรูปแบบที่ต้องการ
    return $expiryTime['expire_datetime'];
}

function clearAllCookies()
{
    // วนลูปลบ Cookie ทั้งหมด
    foreach ($_COOKIE as $name => $value) {
        // ตั้งค่าเวลาหมดอายุของ Cookie เป็นอดีต
        setcookie($name, '', time() - 3600, '/');
        unset($_COOKIE[$name]); // ลบจากตัวแปร $_COOKIE
    }
}

function getCurrentFiscalYear()
{
    // รับค่าเดือนและปีปัจจุบัน
    $currentMonth = (int) date('m'); // เดือน (01-12)
    $currentYear = (int) date('Y');  // ปีปัจจุบัน

    // หากเดือนปัจจุบันน้อยกว่า 10 (ก่อนตุลาคม) ปีงบประมาณจะเป็นปีปัจจุบัน - 1
    if ($currentMonth > 10) {
        return $currentYear + 1;
    }

    // หากเป็นเดือนตุลาคมถึงธันวาคม ปีงบประมาณจะเป็นปีปัจจุบัน
    return (int) $currentYear;
}

function getShops()
{
    global $conn;

    $shops = [];

    $sql = "SELECT * FROM shops ORDER BY create_at DESC";
    $query = $conn->query($sql);
    while ($row = $query->fetch_assoc()) {
        $shops[] = $row;
    }

    return $shops;
}

function getShopInfo($shop_ref)
{
    global $conn;

    $shop_info = [];

    $sql = "SELECT
                sh.id,
                sh.shop_username,
                sh.shop_title,
                sh.shop_description,
                sh.shop_image_logo,
                sh.shop_image_cover,
                sb.branch_title 
            FROM
                shops AS sh
                INNER JOIN shops_branches AS sb ON sh.id = sb.shop_id 
            WHERE
                sh.id = '$shop_ref' 
                OR sh.shop_username = '$shop_ref'";
    $query = $conn->query($sql);
    if ($query->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
            $shop_info = $row;
        }
    }

    return $shop_info;
}

function getShopCategory($shop_ref)
{
    global $conn;

    $cat_info = [];

    $sql = "SELECT
                cat.id,
                cat.category_name AS `name`
            FROM
                shops AS sh
                INNER JOIN categories AS cat ON sh.id = cat.shop_id 
            WHERE
                ( sh.id = '$shop_ref' OR sh.shop_username = '$shop_ref' ) 
                AND cat.category_type = 'product' 
                AND cat.category_status = 'published' 
            ORDER BY
                cat.category_sort ASC";
    $query = $conn->query($sql);
    if ($query->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
            $cat_info[] = $row;
        }
    }

    return $cat_info;
}

function getShopProducts($shop_ref, $cat_ref)
{
    global $conn;
    $products = [];
    $sql = "SELECT
                cat.id AS cat_id,
                cat.category_name AS cat_name,
                pd.id AS prod_id,
                pd.product_title,
                pd.product_description,
                pd.product_price,
                img.file_key AS img_name,
                img.file_extension AS img_ex 
            FROM
                categories AS cat
                INNER JOIN products AS pd ON cat.id = pd.category_id
                LEFT JOIN products_images AS img ON pd.id = img.product_id 
            WHERE
                cat.shop_id = '$shop_ref' 
                AND pd.product_status = 'published' 
                AND img.file_sort = 1 ";
    $sql .= $cat_ref == 0 ? "" : " AND cat.id = '$cat_ref' ";
    $query = $conn->query($sql);
    if ($query->num_rows > 0) {
        while ($row = $query->fetch_assoc()) {
            $products[$row['cat_id']]['name'] = $row['cat_name'];
            $products[$row['cat_id']]['products'][] = $row;
        }
    }
    return $products;
}

function getProductInfo($product_id)
{
    global $conn;
    $info = [];
    $sql = "SELECT
                pd.id AS pd_id,
                pd.product_title,
                pd.product_description,
                pd.product_status,
                pd.product_price,
                img.file_extension AS img_ext,
                img.file_key AS img_name
            FROM
                products AS pd
                INNER JOIN products_images AS img ON pd.id = img.product_id 
            WHERE
                pd.id = '$product_id' 
                AND img.file_sort = 1";
    $query = $conn->query($sql);
    while ($row = $query->fetch_assoc()) {
        $info = $row;
    }
    return $info;
}

function getProductOptions($product_id)
{
    global $conn;
    $options = [];
    $sql = "SELECT
                op.id AS op_id,
                op.product_id,
                op.category_id,
                op.option_title,
                op.option_description,
                op.option_price,
                op.option_img,
                op.option_qty,
                cat.id AS cat_id,
                cat.category_sort,
                cat.category_name,
                cat.category_description,
                cat.select_min,
                cat.select_max 
            FROM
                products_options AS op
                INNER JOIN categories AS cat ON op.category_id = cat.id 
            WHERE
                ( op.product_id = '$product_id' AND op.option_status = 'published' ) 
                AND ( cat.category_type = 'option' AND cat.category_status = 'published' ) 
            ORDER BY
                cat.category_sort ASC,
                op.create_at ASC";
    $query = $conn->query($sql);
    while ($row = $query->fetch_assoc()) {
        $options[$row['cat_id']]['category'] = [
            'name' => $row['category_name'],
            'description' => $row['category_description'],
            'min' => $row['select_min'],
            'max' => $row['select_max'],
        ];
        $options[$row['cat_id']]['options'][] = $row;
    }

    return $options;
}

// ผ่านการเช็ค session แล้ว
function addToCart($sess_id, $shop_id, $prod_id, $opt_arr = [])
{
    global $conn;
}

function getNewBillCode($shop_id)
{
    global $conn;

    // Get the latest bill code for the shop
    $sql = "SELECT bill_code FROM bills WHERE shop_id = '$shop_id' ORDER BY create_at DESC LIMIT 1";
    $query = $conn->query($sql);
    $latest_bill_code = $query->num_rows > 0 ? $query->fetch_assoc()['bill_code'] : null;

    // Generate new bill code
    if ($latest_bill_code) {
        $number = (int) substr($latest_bill_code, -6) + 1;
        $new_bill_code = 'B' . str_pad($number, 6, '0', STR_PAD_LEFT);
    } else {
        $new_bill_code = 'B000001';
    }

    return $new_bill_code;
}

function getMemberIDWithAuthKey($auth_key)
{
    global $conn;
    $member_id = null;

    $sql = "SELECT member_id FROM members_keys WHERE auth_key = '$auth_key'";
    $query = $conn->query($sql);
    if ($query->num_rows > 0) {
        $row = $query->fetch_assoc();
        $member_id = $row['member_id'];
    }

    return $member_id;
}

function getNewID($tableName)
{
    global $conn;

    $sql = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = '$tableName'";
    $query = $conn->query($sql);
    $autoIncrement = null;

    if ($query->num_rows > 0) {
        $row = $query->fetch_assoc();
        $autoIncrement = $row['AUTO_INCREMENT'];
    }

    return $autoIncrement;
}

function getOrderIDWithBillID($billID)
{
    global $conn;
    $order_id = null;

    $sql = "SELECT id FROM orders_products WHERE bill_id = '$billID'";
    $query = $conn->query($sql);
    if ($query->num_rows > 0) {
        $row = $query->fetch_assoc();
        $order_id = $row['id'];
    }

    return $order_id;
}

function checkExistsOrderOptions($billID, $product_id, $cats_options)
{
    global $conn;
    $result = [];
    $sql = "SELECT id FROM orders_products WHERE bill_id = '$billID' AND product_id='$product_id' ";
    $query = $conn->query($sql);
    if ($query->num_rows > 0):
        while ($row = $query->fetch_assoc()):
            $order_id = $row['id'];
            $exists_arr = [];

            $opts_count_sql = "SELECT 
                                    * 
                                FROM 
                                    orders_products_options 
                                WHERE 
                                    order_id='$order_id' ";
            $opts_count_query = $conn->query($opts_count_sql);
            $opts_count = $opts_count_query->num_rows;

            foreach ($cats_options as $cate_id => $opt_arr):
                foreach ($opt_arr as $opt_k => $opt_v):
                    $option_id = $opt_v['option_id'];
                    $opts_sql = "SELECT 
                                        * 
                                    FROM 
                                        orders_products_options 
                                    WHERE 
                                        order_id='$order_id' 
                                        AND category_id='$cate_id' 
                                        AND option_id='$option_id' ";
                    $opts_query = $conn->query($opts_sql);
                    if ($opts_query->num_rows > 0):
                        $exists_arr[] = 'true';
                    else:
                        $exists_arr[] = 'false';
                    endif;
                endforeach;
            endforeach;

            if ($opts_count != count($exists_arr)) :
                $exists_arr[] = 'false';
            endif;

            if (!in_array('false', $exists_arr)):
                $result['id'][] = $order_id;
                $result['status'][] = 'true';
            else:
                $result['status'][] = 'false';
            endif;
        endwhile;
    else:
        $result['status'][] = 'false';
    endif;

    return $result;
}
