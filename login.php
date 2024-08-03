<?php
session_start();
include('connection.php');
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $username = $data['username'];
    $password = $data['password'];
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid credentials']);
        exit;
    }

    $stmt = $conn->prepare('SELECT user_id, student_name, grade, section, status, password FROM stdata WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $grade, $section, $status, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password) and $status == 'active') {

            $multi_sign = $conn->prepare('SELECT session_id FROM stdssn WHERE user_id = ? AND session_id is not null');
            $multi_sign->bind_param('s', $id);
            $multi_sign->execute();
            $multi_sign->store_result();
            if ($multi_sign->num_rows == 0) {
                $_SESSION['user_id'] = $id;
                $_SESSION['name'] = $name;
                $_SESSION['grade'] = $grade;
                $_SESSION['section'] = $section;
                setcookie('PHPSESSID', session_id(), time() + 10713600, "/", "", true, true); // Secure and HttpOnly
                session_regenerate_id(true); // Regenerates the session ID and deletes the old session
                $multi_sign = $conn->prepare("UPDATE stdssn SET session_id = ? where user_id = ?");
                $session_id = session_id();
                $multi_sign->bind_param('ss', $session_id, $_SESSION['user_id']);
                $multi_sign->execute();
                echo json_encode(['status' => 'success', 'message' => 'Login successful']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Login unsuccessful']);
            }
            $multi_sign->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid credentials']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid credentials']);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
$conn->close();
