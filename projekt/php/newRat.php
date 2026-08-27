<?php
include_once "conn.php";
session_start();

$radioVal = $_POST["MyRadio"];
$imgId = $_POST["imgId"];

echo $imgId."---".$_SESSION['user']."---".$radioVal;
$sql = "DECLARE
            v_result BOOLEAN;
        BEGIN
            v_result := NewRating(:imgId, :user, :radioVal);
            IF v_result THEN
                DBMS_OUTPUT.PUT_LINE('Az értékelés sikeresen hozzáadva!');
            ELSE
                DBMS_OUTPUT.PUT_LINE('Az értékelés frissítve!');
            END IF;
        END;";

$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ":imgId", $imgId);
oci_bind_by_name($stmt, ":user", $_SESSION['user']);
oci_bind_by_name($stmt, ":radioVal", $radioVal);

oci_execute($stmt);
header("Location:../img.php?id=".$imgId."&rat=0");
?>