<?php
include_once './conn.php';

if (empty($_POST['picturesToDel'])){
    header("Location:../main.php");
}
//print_r($_POST['picturesToDel']);

foreach ($_POST['picturesToDel'] as $img) {
    echo "DELETE FROM PICTURES WHERE PICTUREID = {$img} <br>";
    $delimg = oci_parse($conn, "DELETE FROM PICTURES WHERE PICTUREID = {$img}");
    oci_execute($delimg);
}

header("Location:../main.php");

?>