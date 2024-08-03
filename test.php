<?php
session_start();
include("./connection.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $grade = $_POST['grade'];
    $section = $_POST['section'];
    $material_type = $_POST['material_type'];
    $description = $_POST['description'];
    $upload_dir = "./student/materials/$grade/";
    if (!filter_var($grade, FILTER_VALIDATE_INT)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Input']);
        $conn->close();
        exit;
    }
    if (!preg_match('/^\d$|^[a-zA-Z]$/', $section) and $section !== 'all') {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Input']);
        $conn->close();
        exit;
    }
    // Create the uploads directory if it doesn't exist
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Validate file
    $file_type = mime_content_type($_FILES["file"]["tmp_name"]);
    $allowed_types = [
        'image/jpeg',
        'image/png',
        'application/pdf',
        'audio/mp3',
        'audio/wav'
    ];

    if (in_array($file_type, $allowed_types)) {
        $file_name = basename($_FILES["file"]["name"]);
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // Save file metadata to the database
            $material = $conn->prepare("INSERT INTO materials (grade, section, type, description, url) VALUES (?, ?, ?, ?, ?)");
            $material->bind_param("issss", $grade, $section, $material_type, $description, $target_file);

            if ($material->execute()) {
                $conn->close();
                echo json_encode(['status' => 'OK', 'message' => 'added successfully']);
                exit;
            } else {
                $conn->close();
                echo json_encode(['status' => 'error', 'message' => 'database error']);
                exit;
            }
        } else {
            $conn->close();
            echo json_encode(['status' => 'error', 'message' => 'server error']);
            exit;
        }
    } else {
        $conn->close();
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type']);
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="post" enctype="multipart/form-data">
        <label for="file">Choose a file:</label>
        <input type="file" id="file" name="file" required>
        <input type="text" name="section" value="section">
        <input type="number" name="grade" value="1">
        <input type="text" name="material_type" value="type">
        <input type="text" name="description" value="description">
        <br><br>
        <button type="submit">Upload</button>
    </form>

</body>

</html>