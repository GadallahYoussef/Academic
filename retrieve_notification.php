<?php
session_start();
include('connection.php');
include('function.php');
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
$authenticated = false;
$continue = check_login($conn);
if ($continue and $_SESSION['status'] === 'active') {
    $authenticated = true;
}
function is_arabic($text)
{
    return preg_match('/\p{Arabic}/u', $text);
}
if ($authenticated) {
    $current = time();
    $notify = $conn->prepare("SELECT notification, creation from notifications WHERE ((grade=? and section =?) 
    OR (grade='all' and section='all') OR (grade=? and section='all')) and (due > ?) ORDER BY creation");
    $notify->bind_param('isii', $_SESSION['grade'], $_SESSION['section'], $_SESSION['grade'], $current);
    if ($notify->execute()) {
        $notify->store_result();
        if ($notify->num_rows > 0) {
            $message = [];
            $notify->bind_result($notification, $creation_time);
            while ($notify->fetch()) {
                if (is_arabic($notification)) {
                    $rtl_notification = "\u{202B}" . $notification . "\u{202C}";
                    $message[$creation_time] = $rtl_notification;
                } else {
                    $message[$creation_time] = $notification;
                }
            }
            $notify->close();
            $conn->close();
            echo json_encode([
                'status' => 'OK', 'authenticated' => $authenticated, 'found' => true, 'notification' => $message
            ]);
            exit;
        } else {
            $notify->close();
            $conn->close();
            echo json_encode(['status' => 'OK', 'authenticated' => $authenticated, 'found' => false]);
            exit;
        }
    } else {
        $notify->close();
        $conn->close();
        echo json_encode(['status' => 'error', 'authenticated' => $authenticated, 'message' => 'database error']);
        exit;
    }
} else {
    $conn->close();
    echo json_encode(['status' => 'error', 'authenticated' => $authenticated]);
    exit;
}
