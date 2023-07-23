<?php
header('Access-Control-Allow-Orlgln:*');
header('content-Type: application/json');
header('Access-control-Allow-method: DELETE');
header('Access-control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorilzation, X-Request-With');

include('function.php');
$requestMethod = $_SERVER["REQUEST_METHOD"];

if ($requestMethod == "DELETE") {
    $deleteCustomer = deleteCustomer($_GET);
    echo $deleteCustomer;
} else {
    $data = [
        'status' => 405,
        'message' => $requestMethod . ' Method Not Allowed'
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}
