<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=, initial-scale=1.0" />
  <title>Pikture</title>
  <link rel="stylesheet" href="fontawesome/css/all.css" />
  <link rel="stylesheet" href="css/nav.css" />
  <link rel="stylesheet" href="css/all.css" />
</head>

<body>
<div class="bg">
        <img src="img/bg.jpg" class="bg-image">
    </div>
<?php include_once "nav.php";
?>
  <div class="home_content">
    <div class="user">
      <h1>Pályázatok</h1>
        <div class="comp">
          <div class="cont">
            <div class="newcom">
              <h2>Új pályázat írása</h2>
              <form action="php/newcom.php" method="POST">
                <label>Pályázat címe:</label><br>
                <input type="text" name="cim" required><br>
                <label>Pályázat leírása:</label><br>
                <textarea name="leir" id="" cols="48" rows="5" maxlength="220" required></textarea><br>
                <label>Nyeremény:</label><br>
                <input type="number" name="nyer" id="" required><br><br>
                <input type="submit" value="Felad">
                <?php if (isset($_GET['errorpass'])) { ?>
                            <br><small class="error"><?php echo $_GET['errorpass']; ?></small>
                        <?php } ?>
              </form>
            </div>
          </div>
          <div class="cont">
            <div class="coms">
            <h2>Pályázatok</h2>
              <?php
                $alltag = oci_parse($conn, "SELECT * FROM COMPETITION");
                oci_execute($alltag);
                while($tags = oci_fetch_assoc($alltag)){
                  echo '<div class="com">
                          <h3>'.$tags["TITLE"].'</h3>
                          '.$tags["DESCRIPTION"].'<br>
                          Nyeremény: '.$tags["PRIZE"].' Ft<a href="com.php?id='.$tags["COMPETITIONID"].'">Tovább</a>
                        </div>';
                }
              ?>
            </div>
          </div>
        </div>
    </div>
  </div>
</body>
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
</html>
<!--
Felhasználók kezelése
Legtöbb képpel rendelkező felhasználók-----------done
A kategóriák legjobb képei------------done
Városok „arcai” a feltöltött képek alapján------done
Feltöltési statisztikák -----done
Fotópályázatok kiírása, szavazás, nyertes kihirdetése,
                -->