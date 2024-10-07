<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once('conn.php');
require_once('req.php');

$request = $_SERVER['REQUEST_METHOD'];

if ($request == 'GET') {
    $list = getList($con);
    echo json_encode($list); 
} else {
    $data = [
        'status' => 405,
        'message' => 'Invalid request method. Only GET requests are allowed.',
    ];
    header('HTTP/1.0 405 Method Not Allowed');
    echo json_encode($data);
}
?>