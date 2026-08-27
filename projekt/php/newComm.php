<?php
include_once "conn.php";
session_start();

$comm = $_POST["comm"];
$imgId = $_POST["img"];
$uId = $_SESSION["user"];

if(empty($comm)){
    echo "ures";
}else{
    $commup = oci_parse($conn, "INSERT INTO COMMENTS (PICTUREID, USERID, COMM) VALUES ({$imgId}, {$uId}, '{$comm}')");
    oci_execute($commup);
    echo "hi";
    header("Location:../img.php?id=".$imgId."");
}
?>