<?php
session_start();
include('../connection.php');
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $grade = $data['grade'];
    $section = $data['section'];
    if (!is_numeric($grade) || !preg_match('/^[a-zA-Z0-9_]+$/', $section)) {
        echo json_encode(['error' => 'Invalid grade or section']);
        $conn->close();
        exit;
    }
    $table_name = 'G' . "$grade" . 'S' . "$section" . "_attendance";
    $conn->begin_transaction();
    try {
        $remove = $conn->prepare("DROP TABLE IF EXISTS $table_name");
        if ($remove->execute()) {
            $remove->close();
        } else {
            $remove->close();
            throw new Exception("database delete error");
        }
        $gather = $conn->prepare("SELECT user_id from stdata WHERE grade=? and section=?");
        $gather->bind_param('is', $grade, $section);
        if ($gather->execute()) {
            $gather->store_result();
            $gather->bind_result($user_id);
            if ($gather->num_rows > 0) {
                $grade_students = [];
                while ($gather->fetch()) {
                    $grade_students[] = $user_id;
                }
                $gather->close();
            }
        } else {
            $gather->close();
            throw new Exception("database load error");
        }
        $remove = $conn->prepare("DELETE from stdata Where grade= ? and section= ?");
        $remove->bind_param('is', $grade, $section);
        if ($remove->execute()) {
            $remove->close();
        } else {
            $remove->close();
            throw new Exception("database remove error");
        }
        $remove = $conn->prepare("DELETE from classes Where grade= ? and section= ?");
        $remove->bind_param('is', $grade, $section);
        if ($remove->execute()) {
            $remove->close();
        } else {
            $remove->close();
            throw new Exception("grade remove error");
        }
        $remove = $conn->prepare("DELETE FROM stdssn WHERE user_id= ?");
        foreach ($grade_students as $student) {
            $remove->bind_param('s', $student);
            if (!$remove->execute()) {
                $remove->close();
                throw new Exception("sessions remove error");
            }
        }
        $remove->close();
        $conn->commit();
        echo json_encode(['status' => 'OK', 'message' => 'Deleted Successfully']);
        exit;
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
