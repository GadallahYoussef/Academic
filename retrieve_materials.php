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
                if (is_arabic($description)) {
                    $rtl_description = "\u{202B}" . $description . "\u{202C}";
                    $student_material[$id]['caption'] = $rtl_description;
                } else {
                    $student_material[$id]['caption'] = $description;
                }
                $student_material[$id]['path'] = $url;
            }
            echo json_encode(['status' => 'OK', 'authenticated' => $authenticated, 'found' => true, 'matrials' => $student_material], JSON_UNESCAPED_UNICODE);
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
} else {
    $conn->close();
    echo json_encode(['status' => 'error', 'authenticated' => $authenticated]);
    exit;
}
