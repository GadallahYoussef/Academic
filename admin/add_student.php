<?php
session_start();
include('../connection.php');
include('admin_connection.php');
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
function closeConnections($conn, $admin_conn)
{
    $conn->close();
    $admin_conn->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $name = $data['name'];
    $grade = $data['grade'];
    $section = $data['section'];
    if (!preg_match('/^\s*$/', $name)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Input']);
        closeConnections($conn, $admin_conn);
        exit;
    }

    // Validate `grade` to be an integer
    if (!filter_var($grade, FILTER_VALIDATE_INT)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Input']);
        closeConnections($conn, $admin_conn);
        exit;
    }

    // Validate `section` to be either an integer or a single letter
    if (!preg_match('/^\d$|^[a-zA-Z]$/', $section)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Input']);
        closeConnections($conn, $admin_conn);
        exit;
    }
    $conn->begin_transaction();
    $admin_conn->begin_transaction();

    try {
        $verify = $conn->prepare("SELECT id from classes WHERE grade=? and section=? LIMIT 1");
        $verify->bind_param('is', $grade, $section);
        $verify->execute();
        $verify->store_result();
        if ($verify->num_rows > 0) {
            $verify->close();
            $verify = $conn->prepare("SELECT id from stdata where student_name=? and grade=? and section=? LIMIT 1");
            $verify->bind_param('sis', $name, $grade, $section);
            $verify->execute();
            $verify->store_result();
            if ($verify->num_rows > 0) {
                $verify->close();
                throw new Exception("student name already exists");
            } else {
                $verify->close();
                $separated_name = explode(' ', $name);
                $first_name = $separated_name[0];
                // $second_name = $separated_name[1];
                $student_id = uniqid('student' . "$grade" . "$section" . "_", true);
                $generate = $conn->prepare("SELECT id from stdata ORDER BY id DESC LIMIT 1");
                $generate->execute();
                $generate->store_result();
                if ($generate->num_rows == 0) {
                    $generate->close();
                    $student_username = "$first_name" . "_404";
                } else {
                    $generate->bind_result($latest);
                    $generate->fetch();
                    $generate->close();
                    $suffix = 404 + (int)($latest);
                    $student_username = "$first_name" . "_" . $suffix;
                }
                $pass = time() % 1000000;
                $student_password = $first_name . "@" . $pass;
                $student_credentials = $admin_conn->prepare("INSERT INTO students (student_name, grade, section, username, password)
            VALUES (?, ?, ?, ?, ?)");
                $student_credentials->bind_param('sisss', $name, $grade, $section, $student_username, $student_password);
                if ($student_credentials->execute()) {
                    $student_credentials->close();
                    $hashed_password = password_hash($student_password, PASSWORD_BCRYPT);
                    $student_status = 'active';
                    $student_marks = 0;
                    $store = $conn->prepare("INSERT INTO stdata (user_id, student_name, username, password, grade, section, status, marks)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $store->bind_param('ssssissi', $student_id, $name, $student_username, $hashed_password, $grade, $section, $student_status, $student_marks);
                    if ($store->execute()) {
                        $store->close();
                        $add_to_session = $conn->prepare("INSERT INTO stdssn (user_id) VALUES (?)");
                        $add_to_session->bind_param('s', $student_id);
                        if ($add_to_session->execute()) {
                            $add_to_session->close();
                        } else {
                            $add_to_session->close();
                            throw new Exception('sessions database error');
                        }
                    } else {
                        $store->close();
                        throw new Exception('student database error');
                    }
                } else {
                    $student_credentials->close();
                    throw new Exception('credentials database error');
                }
            }
        } else {
            $verify->close();
            throw new Exception('Invalid Input');
        }
    } catch (Exception $e) {
        $conn->rollback();
        $admin_conn->rollback();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        closeConnections($conn, $admin_conn);
        exit;
    }
} else {
    closeConnections($conn, $admin_conn);
    echo json_encode(['status' => 'error', 'message' => 'Invalid Request']);
    exit;
}
