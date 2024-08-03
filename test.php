<?php
include('connection.php');
$uid = "asdgfsfdgdfg";
$query = "select status from stdata where user_id = '$uid' limit 1";
$result = mysqli_query($conn, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $status = mysqli_fetch_assoc($result)['status'];
    mysqli_close($conn);
    echo true;
} else {
    mysqli_close($conn);
    echo false;
}
print_r($status);
