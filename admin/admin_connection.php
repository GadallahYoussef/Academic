<?php
$ndbhost = "localhost";
$ndbuser = "root";
$ndbpass = "";
$ndbname = "student_creds";

$admin_conn = mysqli_connect($ndbhost, $ndbuser, $ndbpass, $ndbname);

if (!$admin_conn) {
    die("Failed to connect: " . mysqli_connect_error());
}
