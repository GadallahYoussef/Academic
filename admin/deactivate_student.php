<?php
session_start();
include('../connection.php');
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $name = $data['name'];
    $grade = $data['grade'];
    $section = $data['section'];
    if (!preg_match('/^\s*$/', $name)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Input']);
        $conn->close();
        exit;
    }

    // Validate `grade` to be an integer
    if (!filter_var($grade, FILTER_VALIDATE_INT)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Input']);
        $conn->close();
        exit;
    }

    // Validate `section` to be either an integer or a single letter
    if (!preg_match('/^\d$|^[a-zA-Z]$/', $section)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Input']);
        $conn->close();
        exit;
    }
    $table_name = 'G' . "$grade" . 'S' . "$section" . "_attendance";
    $conn->begin_transaction();
    try {
        $deactivate = $conn->prepare("UPDATE stdata SET status='inactive' WHERE student_name=? and grade=? and section=?");
        $deactivate->bind_param('sis', $name, $grade, $section);
        if ($deactivate->execute()) {
            $deactivate->close();
        } else {
            $deactivate->close();
            throw new Exception("failed to update student data");
        }
        $deactivate = $conn->prepare("UPDATE $table_name SET student_status='inactive' WHERE student_name=?");
        $deactivate->bind_param('s', $name);
        if ($deactivate->execute()) {
            $deactivate->close();
            $conn->commit();
            echo json_encode(['status' => 'OK', 'message' => 'deactivated successfully']);
            exit;
        } else {
            $deactivate->close();
            throw new Exception("failed to deactivate from his section");
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
