<?php
session_start();
include('../connection.php');
include('admin_connection.php');
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
session_get_cookie_params();
if ($_SERVER['REQUEST_METHOD'] == 'post') {
    $data = json_decode(file_get_contents('php://input'), true);
    $grade = $data['grade'];
    $section = $data['section'];
    if (!is_numeric($grade) || !preg_match('/^[a-zA-Z0-9_]+$/', $section)) {
        echo json_encode(['error' => 'Invalid grade or section']);
        $conn->close();
        exit;
    }
    $students = $conn->prepare("SELECT id, student_name, status FROM stdata WHERE grade=? and section=? ORDER BY id");
    $students->bind_param('is', $grade, $section);
    $students->store_result();
    if ($students->execute()) {
        $students->bind_result($id, $name, $status);
    }
}
