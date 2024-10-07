<?php
require_once('conn.php');
global $con;

function error422($message){
    $data = [
        'status' => 422,
        'message' => $message,
    ];
    header('HTTP/1.0 422 Unprocessable Entity');
    echo json_encode($data);
    exit();
}

function storeMember($meminput){
    global $con;
    
    $first = $meminput['first_name'];
    $last = $meminput['last_name'];
    $email = $meminput['email']; 

    if(empty(trim($first))){
        return error422('Enter your firstname');
    }
    elseif(empty(trim($last))){
        return error422('Enter your lastname');
    }
    elseif(empty(trim($email))){
        return error422('Enter your email');
    } 
    else{
        $query = "INSERT INTO members(first_name, last_name, email) VALUES ('$first', '$last', '$email')";
        $result = mysqli_query($con, $query);

        if($result){
            $data = [
                'status' => 201,
                'message' => 'Member Created Successfully'
            ];
            header('HTTP/1.0 201 Created');
            return json_encode($data);
        }
        else{
            $data = [
                'status' => 500,
                'message' => 'Internal server error'
            ];
            header('HTTP/1.0 500 Internal Server Error');
            return json_encode($data);
        }
    }
}

function getList($con) {
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'id';
    $order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

    $query = "SELECT * FROM members ORDER BY $sort $order LIMIT $limit OFFSET $offset";
    $run = mysqli_query($con, $query);

    if ($run) {
        if (mysqli_num_rows($run) > 0) {
            $response = mysqli_fetch_all($run, MYSQLI_ASSOC);
            $data = [
                'status' => 200,
                'message' => 'Members found successfully',
                'data' => $response
            ];
            header('HTTP/1.0 200 OK');
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No members found'
            ];
            header('HTTP/1.0 404 Not Found');
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal server error'
        ];
        header('HTTP/1.0 500 Internal Server Error');
        return json_encode($data);
    }
}
?>
