<?php

define('_WEBROOT_PATH_', '../');
define('_LOG_NAME_', 'action');
require _WEBROOT_PATH_ . 'components/setup.php';
$conn = getDatabaseConnections()['default'];

$bill_check_sql = "SELECT id FROM bills WHERE bill_status = 'open' ORDER BY id DESC LIMIT 1";
$bill_result = $conn->query($bill_check_sql);

if ($bill_result->num_rows > 0) {
    $bill_row = $bill_result->fetch_assoc();
    $bill_id = $bill_row['id'];
} else {
    $bill_vals = [
        'shop_id' => $_POST['shop_id'],
        'bill_code' => getNewBillCode($_POST['shop_id']),
        'bill_status' => 'open',
        // 'bill_price' => '',
        'member_id' => getMemberIDWithAuthKey($_SESSION['auth_key']),
        // 'members_contact_id' => '',
        // 'payment_method_id' => '',
        // 'discount_code' => '',
        // 'price_order' => '',
        // 'price_shipping' => '',
        // 'price_discount' => '',
        // 'price_vat' => '',
        // 'price_final' => '',
    ];
    $insert_bill_sql = arrayToInsertSQL('bills', $bill_vals);
    if ($conn->query($insert_bill_sql) === TRUE) {
        $bill_id = $conn->insert_id;
    } else {
        die("Error: " . $conn->error);
    }
}

$order_vals = [
    'bill_id' => $bill_id,
    'product_id' => $_POST['product_id'],
    'product_qty' => 1,
];

$ins_options_sqls = [];
$order_cats_options = [];
foreach ($_POST['options'] as $cate_id => $values):
    $val_arr = [];
    foreach ($values as $value) {
        $val_arr[] = [
            'order_id' => getNewID('orders_products'),
            'category_id' => $cate_id,
            'option_id' => $value,
            'option_qty' => 1,
        ];
    }
    $order_cats_options[$cate_id] = $val_arr;
    $ins_options_sqls[] = arrayToInsertSQLMultiRows('orders_products_options', $val_arr);
endforeach;
$exists_order = checkExistsOrderOptions($bill_id, $_POST['product_id'], $order_cats_options);
if (in_array('true', $exists_order['status'])) {
    foreach ($exists_order['id'] as $orderID):
        $sql_update = "UPDATE orders_products SET product_qty = product_qty + 1 WHERE id = '$orderID'";
        $conn->query($sql_update);
    endforeach;
} else {
    $order_sql = arrayToInsertSQL('orders_products', $order_vals);
    if ($conn->query($order_sql) === TRUE):
        foreach ($ins_options_sqls as $sql) {
            $conn->query($sql);
        }
    endif;
}

