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
      <h1>Admin</h1>
        <div class="admin">
          <div class="cont">
            <div class="small">
              <h3>Kategória elemei:</h3>
              <div class="cats">
                <?php
                  $alltag = oci_parse($conn, "SELECT TAGS, COUNT(PICTUREID) AS DB FROM PICTURES GRoUP BY TAGS");
                  oci_execute($alltag);
                  while($tags = oci_fetch_assoc($alltag)){
                      echo "<label>".$tags["TAGS"].": ".$tags["DB"]." db</label><br>";
                  }
                ?>
              </div>
            </div>
            <div class="small">
              <h3>Ország elemei:</h3>
              <div class="cats">
                <?php
                  $alltag = oci_parse($conn, "SELECT COUNTRY.NAME AS CNAME, COUNT(LOCATIONID) AS DB FROM LOCATIONS INNER JOIN COUNTRY ON COUNTRY.ID = LOCATIONS.COUNTRYID GROUP BY LOCATIONS.COUNTRYID, COUNTRY.NAME");
                  oci_execute($alltag);
                  while($tags = oci_fetch_assoc($alltag)){
                      echo "<label>".$tags["CNAME"].": ".$tags["DB"]." db</label><br>";
                  }
                ?>
              </div>
            </div>
            <div class="small">
              <h3>Megyék elemei:</h3>
              <div class="cats">
                <?php
                  $alltag = oci_parse($conn, "SELECT
                  LOCATIONS.COUNTYID, COUNTY.NAME AS SNAME,
                  COUNT(LOCATIONS.COUNTYID) *
                      (SELECT COUNT(PICTURES.LOCATION)
                       FROM PICTURES
                       WHERE PICTURES.LOCATION = LOCATIONS.LOCATIONID) AS DB
                  FROM
                  LOCATIONS
                  INNER JOIN COUNTY ON COUNTY.ID = LOCATIONS.COUNTYID
                  GROUP BY
                  LOCATIONS.COUNTYID,
                  LOCATIONS.LOCATIONID,
                  COUNTY.NAME
                  ORDER BY DB DESC");
                  oci_execute($alltag);
                  while($tags = oci_fetch_assoc($alltag)){
                      echo "<label>".$tags["SNAME"].": ".$tags["DB"]." db</label><br>";
                  }
                ?>
              </div>
            </div>
            <div class="small">
              <h3>Települések elemei:</h3>
              <div class="cats">
                <?php
                  $alltag = oci_parse($conn, "SELECT
                  LOCATIONS.SETTLEMENTID, SETTLEMENT.NAME AS SNAME,
                  COUNT(LOCATIONS.SETTLEMENTID) *
                      (SELECT COUNT(PICTURES.LOCATION)
                       FROM PICTURES
                       WHERE PICTURES.LOCATION = LOCATIONS.LOCATIONID) AS DB
                  FROM
                  LOCATIONS
                  INNER JOIN SETTLEMENT ON SETTLEMENT.ID = LOCATIONS.SETTLEMENTID
                  GROUP BY
                  LOCATIONS.SETTLEMENTID,
                  LOCATIONS.LOCATIONID,
                  SETTLEMENT.NAME
                  ORDER BY DB DESC");
                  oci_execute($alltag);
                  while($tags = oci_fetch_assoc($alltag)){
                      echo "<label>".$tags["SNAME"].": ".$tags["DB"]." db</label><br>";
                  }
                ?>
              </div>
            </div>
          </div>
          <div class="cont">
            <div class="small">
              <h3>Felhasználók képei:</h3>
              <div class="cats">
                <?php
                  $alltag = oci_parse($conn, "SELECT USERS.EMAIL AS UEMAIL, COUNT(PICTUREID) AS DB FROM PICTURES  INNER JOIN USERS ON USERS.USERID = PICTURES.USERID GROUP BY PICTURES.USERID, USERS.EMAIL ORDER BY DB DESC");
                  oci_execute($alltag);
                  while($tags = oci_fetch_assoc($alltag)){
                      echo "<label>".$tags["UEMAIL"].": ".$tags["DB"]." db</label><br>";
                  }
                ?>
              </div>
            </div>
            <div class="small">
              <h3>Kategória értékelések:</h3>
              <div class="cats">
                <?php
                  $alltag = oci_parse($conn, "SELECT TAGS, AVG(RATING.STAR) AS ATLAG FROM PICTURES INNER JOIN RATING ON RATING.PICTUREID = PICTURES.PICTUREID GROUP BY TAGS ORDER BY ATLAG DESC");
                  oci_execute($alltag);
                  while($tags = oci_fetch_assoc($alltag)){
                      echo "<label>".$tags["TAGS"].": ".round($tags["ATLAG"],2)." <i class='fas fa-star'></i></label><br>";
                  }
                ?>
              </div>
            </div>
            <div class="small">
              <h3>Városok legjobbja:</h3>
              <div class="cats">
                <?php
                  $alltag = oci_parse($conn, "SELECT SETTLEMENT.NAME AS SNAME, AVG(RATING.STAR) AS ATLAG, PICTURES.PICTUREID AS PID
                  FROM SETTLEMENT
                  JOIN LOCATIONS ON SETTLEMENT.ID = LOCATIONS.SETTLEMENTID
                  JOIN PICTURES ON LOCATIONS.LOCATIONID = PICTURES.LOCATION
                  JOIN RATING ON PICTURES.PICTUREID = RATING.PICTUREID
                  WHERE (SETTLEMENT.NAME, RATING.STAR) IN (
                      SELECT SETTLEMENT.NAME, MAX(RATING.STAR) AS MAX_STAR
                      FROM SETTLEMENT
                      JOIN LOCATIONS ON SETTLEMENT.ID = LOCATIONS.SETTLEMENTID
                      JOIN PICTURES ON LOCATIONS.LOCATIONID = PICTURES.LOCATION
                      JOIN RATING ON PICTURES.PICTUREID = RATING.PICTUREID
                      GROUP BY SETTLEMENT.NAME
                  )
                  GROUP BY SETTLEMENT.NAME, PICTURES.PICTUREID");
                  oci_execute($alltag);
                  while($tags = oci_fetch_assoc($alltag)){
                      echo "<label>".$tags["SNAME"].": ".round($tags["ATLAG"],2)." <i class='fas fa-star'></i>----><a href='img.php?id=".$tags["PID"]."'>ITT</a></label><br>";
                  }
                ?>
              </div>
            </div>
            <div class="small">
              <h3>Feltöltési statisztikák:</h3>
              <div class="cats">
                <?php
                  $alltag = oci_parse($conn, "SELECT * FROM UPLOAD");
                  oci_execute($alltag);
                  while($tags = oci_fetch_assoc($alltag)){
                      echo "<label>".$tags["DATUM"].": USER ".$tags["USERID"]."->".$tags["MIT"]."</label><br>";
                  }
                ?>
              </div>
            </div>
          </div>
          <div class="cont">
            <div class="big">
              <h3>Felhasználó törlése:</h3>
              <div class="cats">
                <label>Email</label><br>
                <form action="php/deluser.php" method="POST">
                <select name="deluser">
                  <?php
                    $alltag = oci_parse($conn, "SELECT * FROM USERS WHERE ROLE ='USER'");
                    oci_execute($alltag);
                    while($tags = oci_fetch_assoc($alltag)){
                      echo '<option value="'.$tags["USERID"].'">'.$tags["EMAIL"].'</option>';
                    }
                  ?>
                </select><br>
                <input type="submit" value="Töröl" class="udel">
                </form>
              </div>
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