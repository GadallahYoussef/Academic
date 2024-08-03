<?php
session_start();
include('connection.php');
include('function.php');
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
$authenticated = false;
$continue = check_login($conn);
if ($continue and $_SESSION['status'] === 'active') {
    $authenticated = true;
}
function is_arabic($text)
{
    return preg_match('/\p{Arabic}/u', $text);
}
if ($authenticated) {
    $current = time();
    $material = $conn->prepare()
} else {
    $conn->close();
    echo json_encode(['status' => 'error', 'authenticated' => $authenticated]);
    exit;
}
