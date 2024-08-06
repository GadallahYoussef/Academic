<?php
session_start();
include('connection.php');
include('connection.php');
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
$logout = $conn->prepare("UPDATE stdssn SET session_id=? WHERE user_id=?");
$update = NULL;
$logout->bind_param('ss', $update, $_SESSION['user_id']);
if ($logout->execute()) {
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
    $logout->close();
    $conn->close();
    echo json_encode(['status' => 'OK', 'message' => 'logged out']);
    exit;
} else {
    $logout->close();
    $conn->close();
    echo json_encode(['status' => 'error', 'message' => 'Unexpected error']);
    exit;
}
