<?php
session_start();
include('../connection.php');
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
function sanitize_input($input)
{
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $message = $data['message'];
    $grade = $data['grade'];
    $section = $data['section'];
    $expire = $data['days'];
    if (!is_numeric($grade) and $grade !== "all") {
        $conn->close();
        echo json_encode(['status' => 'error', 'message' => 'Invalid Input']);
        exit;
    }
    if (!preg_match('/^\d$|^[a-zA-Z]$/', $section) and $section !== 'all') {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Input']);
        $conn->close();
        exit;
    }
    if (!is_numeric($expire)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Input']);
        $conn->close();
        exit;
    }
    $due = time() + ($expire * 24 * 60 * 60);
    $message = sanitize_input($message);
    $conn->begin_transaction();
    try {
        $push = $conn->prepare("INSERT INTO notifications (notification, grade, section, due) VALUES (?, ?, ?, ?)");
        $push->bind_param('ssss', $message, $grade, $section, $due);
        if ($push->execute()) {
            $push->close();
            $conn->commit();
            echo json_encode(['status' => 'OK', 'message' => 'notification pushed']);
            exit;
        } else {
            $push->close();
            throw new Exception("database error");
        }
    } catch (Exception $e) {
        $conn->rollback();
        $conn->close();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        exit;
    }
} else {
    $conn->close();
    echo json_encode(['status' => 'error', 'message' => 'Invalid Request']);
    exit;
}
