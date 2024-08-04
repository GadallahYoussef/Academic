<?php
include('connection.php');
function check_login($conn)
{
    if (isset($_SESSION['user_id']) and isset($_SESSION['grade']) and isset($_SESSION['section'])) {
        $uid = $_SESSION['user_id'];
        $query = "select status from stdata where user_id = '$uid' limit 1";

        $result = mysqli_query($conn, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $status = mysqli_fetch_assoc($result);
            $_SESSION['status'] = $status['status'];

            return true;
        } else {

            return false;
        }
    } else {

        return false;
    }
}

function random_num($length)
{

    $text = "";
    if ($length < 5) {
        $length = 5;
    }

    $len = rand(4, $length);

    for ($i = 0; $i < $len; $i++) {
        $text .= rand(0, 9);
    }

    return $text;
}

function extractSheetId($url)
{
    // Regular expression to match Google Sheets URL and extract sheet ID
    $pattern = '/\/spreadsheets\/d\/([a-zA-Z0-9-_]+)/';

    // Match the pattern in the URL
    if (preg_match($pattern, $url, $matches)) {
        // Extract the sheet ID from the matched URL
        return $matches[1];
    } else {
        // Return null if no match found
        return null;
    }
}
