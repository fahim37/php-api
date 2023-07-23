<?php
require '../inc/dbncon.php';


function error422($message)
{
    $data = [
        'status' => 422,
        'message' => $message
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
    exit();
}
function storeCustomer($customerInput)
{
    global $conn;

    $name = mysqli_real_escape_string($conn, $customerInput['name']);
    $email = mysqli_real_escape_string($conn, $customerInput['email']);
    $phone = mysqli_real_escape_string($conn, $customerInput['phone']);

    if (empty($name)) {
        return error422('Provide your name');
    } elseif (empty($email)) {
        return error422('Provide your email');
    } elseif (empty($phone)) {
        return error422('Provide your phone no');
    } else {
        $query = "INSERT INTO customers (name,email,phone) VALUES ('$name','$email','$phone')";
        $res = mysqli_query($conn, $query);
        if ($res) {
            $data = [
                'status' => 201,
                'message' => 'Customer created Successfully'
            ];
            header("HTTP/1.0 201 Created");
            return json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => 'Internal Server Error'
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
function getCustomer($customerParams)
{
    global $conn;

    if ($customerParams['id'] == null) {
        return error422('Enter customer id');
    }
    $customerId = mysqli_real_escape_string($conn, $customerParams['id']);
    $query = "SELECT * FROM customers WHERE id='$customerId' LIMIT 1";
    $res = mysqli_query($conn, $query);
    if ($res) {
        if (mysqli_num_rows($res) == 1) {
            $result = mysqli_fetch_assoc($res);
            $data = [
                'status' => 200,
                'message' => 'Customer fetched Successfully',
                'data' => $result
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No Customer Found'
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error'
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}

function getCustomerList()
{
    global $conn;
    $query = "SELECT * FROM customers";
    $query_run = mysqli_query($conn, $query);
    if ($query_run) {
        if (mysqli_num_rows($query_run) > 0) {
            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
            $data = [
                'status' => 200,
                'message' => 'Customer List Fetched',
                'data' => $res
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'No Customer Found'
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error'
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}
function updateCustomer($customerInput, $customerParams)
{
    global $conn;
    if (!isset($customerParams['id'])) {
        return error422('customer id not found in URL');
    } elseif ($customerParams['id'] == null) {
        return error422('Provide customer id');
    }
    $id = mysqli_real_escape_string($conn, $customerParams['id']);
    $name = mysqli_real_escape_string($conn, $customerInput['name']);
    $email = mysqli_real_escape_string($conn, $customerInput['email']);
    $phone = mysqli_real_escape_string($conn, $customerInput['phone']);

    if (empty($name)) {
        return error422('Provide your name');
    } elseif (empty($email)) {
        return error422('Provide your email');
    } elseif (empty($phone)) {
        return error422('Provide your phone no');
    } else {
        $query = "UPDATE customers SET name='$name', email='$email',phone='$phone' WHERE id='$id' LIMIT 1";
        $res = mysqli_query($conn, $query);
        if ($res) {
            $data = [
                'status' => 200,
                'message' => 'Customer updated Successfully'
            ];
            header("HTTP/1.0 200 success");
            return json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => 'Internal Server Error'
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }
    }
}
function deleteCustomer($customerParams)
{
    global $conn;
    if (!isset($customerParams['id'])) {
        return error422('customer id not found in URL');
    } elseif ($customerParams['id'] == null) {
        return error422('Provide customer id');
    } else {
        $id = mysqli_real_escape_string($conn, $customerParams['id']);

        $query = "DELETE FROM customers WHERE id='$id' LIMIT 1";
        $result = mysqli_query($conn, $query);
        var_dump($result);
        if ($result) {
            $data = [
                'status' => 200,
                'message' => 'Customer deleted Successfully'
            ];
            header("HTTP/1.0 200 ok");
            return json_encode($data);
        } else {
            $data = [
                'status' => 404,
                'message' => 'Customer not found'
            ];
            header("HTTP/1.0 404 Not found");
            return json_encode($data);
        }
    }
}
