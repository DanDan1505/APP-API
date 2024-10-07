<?php
error_reporting(0);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once('conn.php');
require_once('req.php');

$request = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['REQUEST_URI'];

switch ($path) {
    case '/members':
        if ($request == 'POST') {
            $input = json_decode(file_get_contents('php://input'), true);
            $storemember = storeMember($input);
            echo $storemember;
        } elseif ($request == 'GET') {
            echo getList($con);
        } else {
            $data = [
                'status' => 405,
                'message' => $request . ' Method not allowed.',
            ];
            header('HTTP/1.0 405 Method Not Allowed');
            echo json_encode($data);
        }
        break;
    default:
        $data = [
            'status' => 404,
            'message' => 'Not Found',
        ];
        header('HTTP/1.0 404 Not Found');
        echo json_encode($data);
        break;
}
?>
