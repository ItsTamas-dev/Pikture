<?php
include_once "conn.php";
session_start();
if(isset($_FILES['image'])){
    $orszag = strtolower($_POST["orszag"]);
    $megye = strtolower($_POST["megye"]);
    $telepules = strtolower($_POST["telepules"]);
    $tags = strtolower($_POST["tags"]);

    $img_name = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $img_explode = explode('.', $img_name);
    $img_ext = end($img_explode);
    $extensions = ['jpg', 'jpeg', 'png'];
    echo $img_name;
    if(in_array($img_ext, $extensions) === true){
        $time = time();
        $img_name_fol = $time.$img_name;
        if(move_uploaded_file($tmp_name, "../img/".$img_name_fol)){
          $url = "img/" .$img_name_fol ."";
          $be = $_SESSION["user"];

          $result = 0;
          $sql = "BEGIN
                    :v_result := newPic(:c_name, :co_name, :s_name);
                  END;";

          $stmt = oci_parse($conn, $sql);
          oci_bind_by_name($stmt, ":v_result", $result, 1, SQLT_INT);
          oci_bind_by_name($stmt, ":c_name", $orszag);
          oci_bind_by_name($stmt, ":co_name", $megye);
          oci_bind_by_name($stmt, ":s_name", $telepules);

          oci_execute($stmt);
          echo $orszag;
          echo $megye;
          echo $telepules;

          echo $result;

          $up = oci_parse($conn, "INSERT INTO PICTURES (USERID, TAGS, PICTUREPATH, LOCATION) VALUES ({$be}, '{$tags}', '{$url}', {$result})");
          oci_execute($up);

          echo "siker";
            header("Location:../main.php?errorup=Sikeres feltöltés!");
        }else{
          echo "hiba feltoltes";
          exit();
        }
      }else{
        //header("Location: profil.php?errorimg=Nem megfelelő formátum (jpeg, jpg, png)!!");
        echo "hiba ffajl";
        exit();
      }
  }else{
    echo "nincs kép";
    exit();
  }

?>