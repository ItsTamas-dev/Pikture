<?php
include_once "conn.php";
session_start();

$cim = $_POST["cim"];
$leir = $_POST["leir"];
$nyer = $_POST["nyer"];
$alltag = oci_parse($conn, "INSERT INTO COMPETITION(TITLE,DESCRIPTION,PRIZE) VALUES('{$cim}','{$leir}',{$nyer})");
oci_execute($alltag);
header("Location:../comps.php?errorpass='Sikeres pályázat'");
echo $cim."---".$leir."---".$nyer;
?>