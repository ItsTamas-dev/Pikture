<?php
include_once "conn.php";
session_start();

$comp = $_POST["paly"];
$imgid = $_POST["imgid"];
$userid = $_SESSION["user"];
$alltag = oci_parse($conn, "SELECT COUNT(USERID) AS DB FROM APPLICANTS WHERE USERID = {$userid} AND PICTUREID = {$imgid} AND COMPETITIONID = {$comp}");
oci_execute($alltag);
$tags = oci_fetch_assoc($alltag);
if($tags["DB"] == 0){
    $alltag2 = oci_parse($conn, "INSERT INTO APPLICANTS(USERID,PICTUREID,COMPETITIONID) VALUES({$userid},{$imgid},{$comp})");
    oci_execute($alltag2);
}
header("Location:../com.php?id=$comp");

?>