<?php
include_once "conn.php";
if (!$conn){
	$e = oci_error($conn);
	trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}else{
	echo "<script>alert('csatlakozva')</script>";
}
?>