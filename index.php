<?php
session_start();
include('connection.php');
include('function.php');
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
session_get_cookie_params();
$authenticated = false;
$continue = check_login($conn);
if ($continue) {
    if ($_SESSION['status'] === 'active') {
        $authenticated = true;
    }
}
if ($authenticated) {
    $schedule = $conn->prepare("SELECT day, start, end from schedule WHERE grade = ? and section = ? ORDER BY id");
    $schedule->bind_param('is', $_SESSION['grade'], $_SESSION['section']);
    $schedule->execute();
    $schedule->store_result();
    if ($schedule->num_rows > 0) {
        $schedule_day = [];
        $schedule->bind_result($day, $start, $end);
        while ($schedule->fetch()) {
            $schedule_day[] = array($day, $start, $end);
        }
        echo json_encode([
            'status' => 'OK', 'authenticated' => $authenticated, 'student_name' => $_SESSION['name'], 'student_grade' => $_SESSION['grade'], 'schedule' => $schedule_day
        ]);
        exit;
    } else {
        echo json_encode(['status' => 'error', 'authenticated' => $authenticated]);
        exit;
    }
    $schedule->close();
} else {
    echo json_encode(['status' => 'error', 'authenticated' => $authenticated]);
    $conn->close();
    exit;
}
