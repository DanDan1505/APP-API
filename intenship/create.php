<?php

error_reporting(0);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once('conn.php');
require_once('req.php');

$request = $_SERVER['REQUEST_METHOD'];

if ($request== 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (empty($input)){
      
        $storemember = storeMember($_POST);

   
}
else{
        $storemember = storeMember($input);

}
        echo $storemember;

}
else {
        $data = [
            'status' => 405,
            'message' => $request. 'Method not allowed.',
        ];
        header('HTTP/1.0 400 Method not Alowed');
        echo json_encode($data);
    }

?>