<?php
include_once "conn.php";
session_start();
$userid = filter_input(INPUT_POST, 'deluser', FILTER_SANITIZE_STRING);
echo $userid;
$del = oci_parse($conn, "DELETE FROM USERS WHERE USERID = {$userid}");
$del2 = oci_parse($conn, "DELETE FROM PICTURES WHERE USERID = {$userid}");
$del3 = oci_parse($conn, "DELETE FROM COMMENTS WHERE USERID = {$userid}");
oci_execute($del);
oci_execute($del2);
oci_execute($del3);
header("Location:../admin.php");
?>