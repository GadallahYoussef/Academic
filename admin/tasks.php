<?php
session_start();
include('../connection.php');
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
function sanitize_input($input)
{
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $type = $data['category'];
    $assignment = $data['task'];
    $grade = $data['grade'];
    $section = $data['section'];
    $expire = $data['days'];
    if (!is_numeric($grade)) {
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
    $type = sanitize_input($type);
    $assignment = sanitize_input($assignment);
    $conn->begin_transaction();
    try {
        $push = $conn->prepare("INSERT INTO tasks (grade, section, type, task, due) VALUES(?, ?, ?, ?, ?)");
        $push->bind_param('isssi', $grade, $section, $type, $assignment, $due);
        if ($push->execute()) {
            $push->close();
            $conn->commit();
            echo json_encode(['status' => 'OK', 'message' => 'task pushed']);
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
