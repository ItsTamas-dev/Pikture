<?php

$conn = oci_connect("TAMAS", "TAMAS", "localhost/XE");
if (!$conn){
	$e = oci_error($conn);
	trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

/*$stid = oci_parse($conn, 'SELECT * FROM USERS');
if(!$stid) {
	$e = oci_error($conn);
	trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$r = oci_execute($stid);
if (!$r){
	$e = oci_error($conn);
	trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

/*while ($record = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
	//echo sprintf('<p>%s: %s, job: %s</p>', $record['EMPNO'], $record['ENAME'], $record['JOB']);
	var_dump($record);
}*/

//oci_free_statement($stid);
//oci_close($conn);

?>