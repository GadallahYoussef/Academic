<?php
session_start();
include('connection.php');
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
session_get_cookie_params();
if (isset($_SESSION['user_id']) and isset($_SESSION['grade']) and isset($_SESSION['section'])) {
    $user_status = $conn->prepare("SELECT status FROM stdata WHERE user_id=?");
    $user_status->bind_param('s', $_SESSION['user_id']);
    if ($user_status->execute()) {
        $user_status->store_result();
        if ($user_status->num_rows > 0) {
            $user_status->bind_result($status);
            if ($status == 'active') {
                $user_status->close();
                $conn->close();
                echo json_encode(['status' => 'error', 'message' => 'logged in']);
                exit;
            } else {
                $user_status->close();
                $conn->close();
                echo json_encode(['status' => 'OK']);
                exit;
            }
        } else {
            $user_status->close();
            $conn->close();
            echo json_encode(['status' => 'OK', 'message' => 'NOT-AUTHENTICATED']);
            exit;
        }
    } else {
        $user_status->close();
        $conn->close();
        echo json_encode(['status' => 'OK', 'message' => 'database error']);
        exit;
    }
} else {
    $conn->close();
    echo json_encode(['status' => 'OK', 'message' => 'NOT-AUTHENTICATED']);
    exit;
}
