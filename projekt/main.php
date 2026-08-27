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
        <div class="user">
            <h1>Saját adatok</h1>
            <div class="top">
                <div class="img">
                    <?php
                        if($randomNumber<21){
                            echo '<img src="img/profil1.png" alt="">';
                        }elseif($randomNumber<41){
                            echo '<img src="img/profil2.png" alt="">';
                        }elseif($randomNumber<61){
                            echo '<img src="img/profil3.png" alt="">';
                        }elseif($randomNumber<81){
                            echo '<img src="img/profil4.png" alt="">';
                        }elseif($randomNumber<99){
                            echo '<img src="img/profil5.png" alt="">';
                        }elseif($randomNumber<=100){
                            echo '<img src="img/profil6.jpg" alt="">';
                        }
                    ?>
                </div>
                <div class="data">
                    <div class="left">
                        <h2><?php echo $row['USERNAME']; ?></h2>
                        <label><?php echo $row['EMAIL']; ?></label>
                        <label>Átlag értékelés:
                            <?php
                                $all = oci_parse($conn, "SELECT SUM(STAR) AS OSSZ, COUNT(STAR) AS DB FROM RATING WHERE USERID = {$_SESSION['user']}");
                                oci_execute($all);
                                $stars = oci_fetch_assoc($all);
                                if($stars['DB'] == 0){
                                    echo 0;
                                }else{
                                    echo round($stars['OSSZ'] / $stars['DB'],2);
                                }
                            ?>
                        </label>
                    </div>
                    <div class="right">
                        <h2>Új kép feltöltése</h2>
                        <form action="php/imgup.php" method="POST" enctype="multipart/form-data">
                            <input type="file" name="image" class="file"><br>
                            <input type="text" name="orszag" placeholder="orszag" required>
                            <input type="text" name="megye" placeholder="megye" required>
                            <input type="text" name="telepules" placeholder="telepules" required>
                            <input type="text" name="tags" placeholder="tags" required>
                            <input type="submit" class="sub">
                            <?php if (isset($_GET['errorup'])) { ?>
                                <small class="email-error-2"><?php echo $_GET['errorup']; ?></small>
                            <?php } ?>
                          </form>
                    </div>
                </div>
            </div>
            <form action="./php/imgdown.php" method="post">
                <h1 class="saj">Saját feltöltések</h1>
                <div class="tor">
                    <input type="submit" value="TÖRÖL">
                </div>
                <div class="imgs">
                    <?php
                        $allimg = oci_parse($conn, "SELECT * FROM PICTURES WHERE USERID = {$_SESSION['user']}");
                        oci_execute($allimg);
                        while($imgs = oci_fetch_assoc($allimg)){
                            $kep = $imgs["PICTUREPATH"];
                            echo '<div class="img">
                                    <label class="container">
                                        <input type="checkbox" name="picturesToDel[]" value="'.$imgs['PICTUREID'].'">
                                        <span class="checkmark"></span>
                                    </label>
                                    <img src="'.$kep.'" alt="" srcset="">
                                </div>';
                        }
                    ?>
                </div>
            </form>
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
        document.querySelectorAll('.imgs .img img').forEach(image =>{
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