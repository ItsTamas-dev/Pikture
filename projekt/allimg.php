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
        <div class="all_img">
            <h1>Képek</h1>
            <form action="php/keres.php" method="POST">
                <label><i class="fa fa-search"></i></label>
                <input type="text" placeholder="tag" name="tag" class="in" oninput="showText()" id="keres">
            </form>
            <div class="imgs" id="all">
                <?php
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
                ?>
            </div>
        </div>
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
        function showText() {
            var inputText = document.getElementById("keres").value;
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "php/keres.php", true);
            xhr.onload = () => {
                if (xhr.readyState === 4) { // A readyState ellenőrzése
                    if (xhr.status === 200) {
                        let data = xhr.response;
                        console.log(data);
                        document.getElementById("all").innerHTML = data;
                    }
                }
            }
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("inputText=" + inputText);
        }

    </script>
</body>
</html>