<?php
session_start();
include('../connection.php');
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
session_get_cookie_params();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $classes = $conn->prepare("SELECT grade, section FROM classes");
    if ($classes->execute()) {
        $classes->store_result();
        if ($classes->num_rows > 0) {
            $classes->bind_result($grade, $section);
            $class = [];
            while ($classes->fetch()) {
                $class[] = array($grade, $section);
            }
            $classes->close();
            $conn->close();
            http_response_code(200);
            echo json_encode(['status' => 'OK', 'found' => true, 'classes' => $class]);
            exit;
        } else {
            $classes->close();
            $conn->close();
            http_response_code(200);
            echo json_encode(['status' => 'OK', 'found' => false]);
            exit;
        }
    } else {
        $classes->close();
        $conn->close();
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Server Internal Error']);
        exit;
    }
} else {
    $conn->close();
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Invalid method']);
    exit;
}
