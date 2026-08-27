<?php
include_once "conn.php";
session_start();


/*$ker = $_POST['tag'];
if(empty($ker) || $ker === ""){
    header("Location:../allimg.php?ker=nincs");
}else{
    header("Location:../allimg.php?ker=".$ker."");
}*/
$be =strtolower($_POST['inputText']);
if(empty($be)){
    $allimg = oci_parse($conn, "SELECT * FROM PICTURES");
    oci_execute($allimg);
    while($imgs = oci_fetch_assoc($allimg)){
        $kep = $imgs["PICTUREPATH"];
        $id = $imgs["PICTUREID"];
        $atlag = 0;
        $all = oci_parse($conn, "SELECT SUM(STAR) AS OSSZ, COUNT(STAR) AS DB FROM RATING WHERE PICTUREID = {$id}");
        oci_execute($all);
        $stars = oci_fetch_assoc($all);
        if($stars['DB'] == 0){
            $atlag= 0;
        }else{
            $atlag= $stars['OSSZ'] / $stars['DB'];
        }
        echo '<div class="img">
            <label class="pont">'.$atlag.'</label>
                <a href="img.php?id='.$id.'"><img src="'.$kep.'" alt="" srcset=""></a>
        </div>';
    }
}else{
    $allimg = oci_parse($conn, "SELECT * FROM PICTURES
                                    JOIN LOCATIONS ON PICTURES.LOCATION = LOCATIONS.LOCATIONID
                                    JOIN COUNTRY ON LOCATIONS.COUNTRYID = COUNTRY.ID
                                    JOIN COUNTY ON LOCATIONS.COUNTYID = COUNTY.ID
                                    JOIN SETTLEMENT ON LOCATIONS.SETTLEMENTID = SETTLEMENT.ID
                                    WHERE PICTURES.TAGS LIKE '%{$be}%'
                                    OR COUNTRY.NAME LIKE '%{$be}%'
                                    OR COUNTY.NAME LIKE '%{$be}%'
                                    OR SETTLEMENT.NAME LIKE '%{$be}%'");
    oci_execute($allimg);
        while($imgs = oci_fetch_assoc($allimg)){
        $kep = $imgs["PICTUREPATH"];
        $id = $imgs["PICTUREID"];
        $atlag = 0;
        $all = oci_parse($conn, "SELECT SUM(STAR) AS OSSZ, COUNT(STAR) AS DB FROM RATING WHERE PICTUREID = {$id}");
        oci_execute($all);
        $stars = oci_fetch_assoc($all);
        if($stars['DB'] == 0){
            $atlag= 0;
        }else{
            $atlag= round($stars['OSSZ'] / $stars['DB']);
        }
        echo '<div class="img">
            <label class="pont">'.$atlag.'</label>
                <a href="img.php?id='.$id.'"><img src="'.$kep.'" alt="" srcset=""></a>
            </div>';
    }
}

?>