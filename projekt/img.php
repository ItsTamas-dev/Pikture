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
    <?php
        include_once './php/conn.php';
        $imgID = $_GET['id'];
        if (empty($imgID)){
            header("Location:./allimg.php");
        }
    ?>
    <div class="bg">
        <img src="img/bg.jpg" class="bg-image">
    </div>
    <?php include_once "nav.php"?>
    <?php
        $imgdata = oci_parse($conn, "SELECT * FROM PICTURES
                                        INNER JOIN USERS ON PICTURES.USERID = USERS.USERID
                                        INNER JOIN LOCATIONS ON PICTURES.LOCATION = LOCATIONS.LOCATIONID
                                        WHERE PICTURES.PICTUREID = $imgID");
        oci_execute($imgdata);
        $imgs = oci_fetch_assoc($imgdata);
    ?>
    <div class="home_content">
        <div class="imgpage">
            <h1>Kép adatok</h1>
            <div class="top">
                <div class="img">
                    <img src="<?php echo $imgs['PICTUREPATH']?>" alt="">
                </div>
                <div class="data">
                    <div class="left">
                        <?php
                        $locat = oci_parse($conn, "SELECT COUNTRY.NAME AS ORSZAG, COUNTY.NAME AS MEGYE, SETTLEMENT.NAME AS TELEP FROM COUNTRY, COUNTY, SETTLEMENT
                                                    WHERE COUNTRY.ID = {$imgs['COUNTRYID']} AND COUNTY.ID = {$imgs['COUNTYID']} AND SETTLEMENT.ID = {$imgs['SETTLEMENTID']}");
                        oci_execute($locat);
                        $loc = oci_fetch_assoc($locat);
                        ?>
                        <h2>Kép készítője: <?php echo $imgs['USERNAME'] ?></h2>
                        <label><?php echo $imgs['EMAIL'] ?></label>
                        <label>Ország: <?php echo $loc['ORSZAG'] ?></label>
                        <label>Megye: <?php echo $loc['MEGYE'] ?></label>
                        <label>Település: <?php echo $loc['TELEP'] ?></label>
                    </div>
                    <div class="right">
                        <h2>Kép értékelése</h2>
                        <form method="POST" action="php/newRat.php" class="star">
                            <input type="hidden" name="imgId" value="<?php echo $imgs['PICTUREID']?>">
                            <input type="radio" id="rad" name="MyRadio" value="1">
                            <label for="rad">1</label>
                            <input type="radio" id="rad" name="MyRadio" value="2">
                            <label for="rad">2</label>
                            <input type="radio" id="rad" name="MyRadio" value="3" checked>
                            <label for="rad">3</label>
                            <input type="radio" id="rad" name="MyRadio" value="4">
                            <label for="rad">4</label>
                            <input type="radio" id="rad" name="MyRadio" value="5">
                            <label for="rad">5</label><br>
                            <input type="submit" value="Elküld" name="Result" class="submit">
                        </form>

                    </div>
                </div>
            </div>
            <h1 class="saj">Hozzászólások</h1>
                <div class="new">
                    <h2>Új hozzászólás</h2>
                    <form action="php/newComm.php" method="POST">
                        <input type="hidden" name="img" value="<?php echo $imgs['PICTUREID']?>">
                        <textarea name="comm" id="" cols="30" rows="10" maxlength="220"></textarea>
                        <input type="submit" value="Elküld">
                    </form>
                </div>
                <div class="all">
                    <?php
                    $comms = oci_parse($conn, "SELECT * FROM COMMENTS INNER JOIN PICTURES ON PICTURES.PICTUREID = COMMENTS.PICTUREID INNER JOIN USERS ON PICTURES.USERID = USERS.USERID WHERE COMMENTS.PICTUREID = $imgID");
                    oci_execute($comms);
                    while ($comm = oci_fetch_assoc($comms)){
                        echo '
                            <div class="com">
                                <h3>'.$comm["USERNAME"].'</h3>'.
                                    $comm["COMM"]
                            .'</div>

                        ';
                    }
                    ?>
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
        document.querySelectorAll('.top .img img').forEach(image =>{
            image.onclick = () =>{
                document.querySelector('.popup-image').style.display = 'block';
                document.querySelector('.popup-image img').src = image.getAttribute('src')
            }
        });
        document.querySelector('.popup-image span').onclick = () =>{
            document.querySelector('.popup-image').style.display = 'none';
        }
    </script>
</body>
</html>