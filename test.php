<?php
session_start();
include('connection.php');
include('function.php');
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
$_SESSION['grade'] = 1;
$_SESSION['section'] = 'a';
$authenticated = true;
$material = $conn->prepare("SELECT id, type, description, url FROM materials WHERE (grade = ? and section = ?) or (grade = ? and section = 'all')");
$material->bind_param('isi', $_SESSION['grade'], $_SESSION['section'], $_SESSION['grade']);
if ($material->execute()) {
    $material->store_result();
    if ($material->num_rows > 0) {
        $student_material = [];
        $material->bind_result($id, $type, $description, $url);
        while ($material->fetch()) {
            $student_material[$id] = [];
            $student_material[$id]['type'] = $type;
            $student_material[$id]['caption'] = $description;
            $student_material[$id]['path'] = $url;
        }
        echo json_encode(['status' => 'OK', 'authenticated' => $authenticated, 'found' => true, 'matrials' => $student_material]);
        $material->close();
        $conn->close();
        exit;
    } else {
        echo json_encode(['status' => 'OK', 'authenticated' => $authenticated, 'found' => false]);
        $material->close();
        $conn->close();
        exit;
    }
} else {
    echo json_encode(['status' => 'error', 'authenticated' => $authenticated, 'message' => 'database error']);
    $material->close();
    $conn->close();
    exit;
}
