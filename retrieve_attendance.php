<?php
session_start();
include('connection.php');
include('function.php');
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: http://localhost:5174");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
session_get_cookie_params();
$authenticated = false;
$continue = check_login($conn);
if ($continue and $_SESSION['status'] === 'active') {
    $authenticated = true;
}
function checkMonth($session_day)
{
    $separated_date = explode('-', $session_day);
    $month = $separated_date[1];
    $month = (int)($month);
    $current_month = (int)(date('m'));
    $year = $separated_date[0];
    $year = (int)($year);
    $current_year = (int)(date('Y'));
    return ($month == $current_month) and ($year == $current_year);
}
if ($authenticated) {
    $grade = $_SESSION['grade'];
    $section = $_SESSION['section'];
    $table_name = 'G' . "$grade" . 'S' . "$section" . "_attendance";
    $attendance = $conn->prepare("SELECT session_day, attendance FROM $table_name WHERE student_name=?");
    $attendance->bind_param('s', $_SESSION['name']);
    if ($attendance->execute()) {
        $attendance->store_result();
        if ($attendance->num_rows > 0) {
            $attendance->bind_result($session_date, $user_state);
            $student_attendance = [];
            while ($attendance->fetch()) {
                if (checkMonth($session_date)) {
                    $student_attendance[$session_date] = $user_state;
                }
            }
            echo json_encode(['status' => 'OK', 'authenticated' => $authenticated, 'found' => true, 'month' => date('F') . ', ' . date('Y'), 'attendance' => $student_attendance]);
            $attendance->close();
            $conn->close();
            exit;
        } else {
            echo json_encode(['status' => 'OK', 'authenticated' => $authenticated, 'found' => false, 'month' => date('F') . ', ' . date('Y')]);
            $attendance->close();
            $conn->close();
            exit;
        }
    } else {
        echo json_encode(['status' => 'error', 'authenticated' => $authenticated, 'message' => 'database error']);
        $attendance->close();
        $conn->close();
        exit;
    }
} else {
    $conn->close();
    echo json_encode(['status' => 'error', 'authenticated' => $authenticated]);
    exit;
}
