<?php
include_once "conn.php";

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$repassword = $_POST['repassword'];
if (empty($name)){
    header("Location:../reg.php?errorname=Adjon meg egy nevet");
}else if(empty($email)){
    header("Location:../reg.php?erroremail=Adjon meg egy email címet");
}else if(empty($password)){
    header("Location:../reg.php?errorpass=Adjon meg egy jelszót");
}else if(empty($repassword)){
    header("Location:../reg.php?errorrepass=Adja meg újra a jelszót");
}else if($password === $repassword){
    $s_name = oci_parse($conn, "SELECT * FROM USERS  WHERE EMAIL = '{$email}'");
    oci_execute($s_name);
    if (!$row = oci_fetch_assoc($s_name)) {
        if($password === $repassword){
            $md = md5($password);
            $up = oci_parse($conn, "INSERT INTO USERS (USERNAME, PASSWORD, EMAIL, ROLE) VALUES ('{$name}', '{$md}', '{$email}', 'USER')");
            oci_execute($up);
            header("Location:../index.php?erroremail=Sikeres regisztráció, jelentkezz be!");
        }else{
            header("Location:../reg.php?errorrepass=A két jelszó nem egyezik!");
        }
    }else{
        header("Location:../reg.php?erroremail=Ez az email már létetik!");
    }
}else{
    header("Location:../reg.php?errorrepass=A két jelszó nem egyezik!");
}



?>