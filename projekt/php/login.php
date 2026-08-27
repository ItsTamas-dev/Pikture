<?php
include_once "conn.php";

$email = $_POST['email'];
$password = $_POST['password'];

if(empty($email)){
    header("Location:../index.php?erroremail=Adja meg az email címet!");
}else if(empty($password)){
    header("Location:../index.php?errorpass=Adja meg a jelszót!");
}else{
    $email = str_replace(" ","",$email);
    $password = str_replace(" ","",$password);
    $mdpass = md5($password);
    $result = 0;
    $sql = "BEGIN
                :v_result := Login(:email, :pass);
            END;";

    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":v_result", $result, 1);
    oci_bind_by_name($stmt, ":email", $email);
    oci_bind_by_name($stmt, ":pass", $mdpass);
    oci_execute($stmt);

    echo $result;
    if($result== 0){
        header("Location:../index.php?erroremail=Hibás email vagy jelszó!");
    }else{
        session_start();
        $_SESSION['user'] = $result;
        header("Location: ../main.php?");
    }

    /*$s_name = oci_parse($conn, "SELECT * FROM USERS  WHERE EMAIL = '{$email}'");
    oci_execute($s_name);
    if (!$row = oci_fetch_assoc($s_name)) {
        header("Location:../index.php?erroremail=Nincs találat a megadott e-mail címre!");
    } else {
        if($row['PASSWORD'] == md5($password)){
            session_start();
            $_SESSION['user'] = $row["USERID"];
            header("Location: ../main.php?");
        }else{
            header("Location:../index.php?errorpass=Hibás jelszó!");
        }
    }*/
}

?>
