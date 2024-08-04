<?php
session_start();
include('connection.php');
include('function.php');
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
session_get_cookie_params();
$authenticated = false;
$continue = check_login($conn);
function is_arabic($text)
{
    return preg_match('/\p{Arabic}/u', $text);
}

if ($continue and $_SESSION['status'] === 'active') {
    $authenticated = true;
}

if ($authenticated) {
    $current = time();
    $tasks = $conn->prepare("SELECT id, type, task, creation FROM tasks WHERE ((grade = ? and section = ?) OR (grade = ? and section = 'all'))and (due > ?) ORDER BY creation DESC");
    $tasks->bind_param('isii', $_SESSION['grade'], $_SESSION['section'], $_SESSION['grade'], $current);
    if ($tasks->execute()) {
        $tasks->store_result();
        $tasks->bind_result($id, $type, $task, $creation);
        if ($tasks->num_rows > 0) {
            $student_task = [];
            while ($tasks->fetch()) {
                $student_task[$id] = [];
                if (is_arabic($type)) {
                    $rtl_type = "\u{202B}" . $type . "\u{202C}";
                    $student_task[$id]['type'] = $rtl_type;
                } else {
                    $student_task[$id]['type'] = $type;
                }
                if (is_arabic($task)) {
                    $rtl_task = "\u{202B}" . $task . "\u{202C}";
                    $student_task[$id]['task'] = $rtl_task;
                } else {
                    $student_task[$id]['task'] = $task;
                }
                $student_task[$id]['creation'] = $creation;
            }
            echo json_encode(['status' => 'OK', 'authenticated' => $authenticated, 'found' => true, 'tasks' => $student_task], JSON_UNESCAPED_UNICODE);
            $tasks->close();
            $conn->close();
            exit;
        } else {
            echo json_encode(['status' => 'OK', 'authenticated' => $authenticated, 'found' => false], JSON_UNESCAPED_UNICODE);
            $tasks->close();
            $conn->close();
            exit;
        }
    } else {
        echo json_encode(['status' => 'error', 'authenticated' => $authenticated, 'message' => 'database error']);
        $tasks->close();
        $conn->close();
        exit;
    }
} else {
    $conn->close();
    echo json_encode(['status' => 'error', 'authenticated' => $authenticated]);
    exit;
}
