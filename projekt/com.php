<?php
include_once "php/conn.php";
$id = $_GET["id"];
$coms = oci_parse($conn, "SELECT * FROM COMPETITION WHERE COMPETITIONID = {$id}");
oci_execute($coms);
$com = oci_fetch_assoc($coms);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Pikture</title>
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/all.css">
</head>
<body>
<div class="bg">
        <img src="img/bg.jpg" class="bg-image">
    </div>
    <?php include_once "nav.php"?>
    <div class="home_content">
        <div class="competition">
            <h1>Pályázat adatok</h1>
            <div class="top">
                <div class="data">
                    <div class="left">
                        <h2><?php echo $com['TITLE']; ?></h2><br>
                        <label>Leírás</label><br>
                        <label><?php echo $com["DESCRIPTION"]; ?></label><br><br>
                        <label>Nyeremény</label><br>
                        <label><?php echo $com["PRIZE"]; ?></label>
                    </div>
                </div>
            </div>
            <div class="bottom">
                <div class="bekuldott">
                    <h3>Beküldött képek</h3>
                    <div class="imgs">
                        <?php
                            $alltag = oci_parse($conn, "SELECT PICTURES.PICTUREPATH, PICTURES.PICTUREID FROM APPLICANTS INNER JOIN PICTURES ON PICTURES.PICTUREID = APPLICANTS.PICTUREID WHERE COMPETITIONID = {$id}");
                            oci_execute($alltag);
                            while($tags = oci_fetch_assoc($alltag)){
                                $kep = $tags["PICTUREPATH"];
                                echo '<div class="img">
                                    <a href="img.php?id='.$tags["PICTUREID"].'">
                                    <img src="'.$kep.'" alt="" srcset="">
                                    </a>
                                </div>';
                            }
                        ?>
                    </div>
                </div>
                <div class="bekuldott">
                    <form action="php/jelentkezes.php" method="POST">
                        <input type="hidden" value="<?php echo $id ?>" name="paly">
                        <input type="submit" value="Kép Beküldése">
                        <div class="imgs">
                            <?php
                                $alltag = oci_parse($conn, "SELECT * FROM PICTURES WHERE USERID = {$_SESSION["user"]}");
                                oci_execute($alltag);
                                while($tags = oci_fetch_assoc($alltag)){
                                    $kep = $tags["PICTUREPATH"];
                                    echo '<div class="img">
                                        <input type="radio" id="html" name="imgid" value="'.$tags["PICTUREID"].'">
                                        <a href="img.php?id='.$tags["PICTUREID"].'">
                                        <img src="'.$kep.'" alt="" srcset="">
                                        </a>
                                    </div>';
                                }
                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="popup-image">
        <span>&times;</span>
        <img src="img/bg.jpg" alt="" srcset="">
    </div>
    <script>
        let btn = document.querySelector("#btn");
        let sidebar = document.querySelector(".sidebar");

        btn.onclick = function(){
            sidebar.classList.toggle("active");
        }
        prof.onclick = function(){
            sidebar.classList.toggle("active");
        }
    </script>
</body>
</html>