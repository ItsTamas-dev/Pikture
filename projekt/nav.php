<?php
    include_once "php/conn.php";
    session_start();
    $all = oci_parse($conn, "SELECT * FROM USERS WHERE USERID = {$_SESSION['user']}");
    oci_execute($all);
    $row = oci_fetch_assoc($all);
    $randomNumber = rand(1, 100);
?>

<div class="sidebar">
        <div class="logo_content">
            <div class="logo">
                <i class="fa fa-image"></i>
                <div class="logo_name">Pikture</div>
            </div>
            <button>
                <i class="fa fa-exchange-alt" id="btn"></i>
            </button>
        </div>
        <ul class="nav_list">
            <li>
                <a href="main.php">
                    <i class="fas fa-address-book"></i>
                    <span class="links_name">Saját Képek</span>
                </a>
                <span class="tooltip">Saját</span>
            </li>
            <li>
                <a href="allimg.php?ker=nincs">
                    <i class="fas fa-image"></i>
                    <span class="links_name">Képek</span>
                </a>
                <span class="tooltip">Képek</span>
            </li>
            <li>
                <a href="comps.php">
                    <i class="fas fa-pen-square"></i>
                    <span class="links_name">Pályázatok</span>
                </a>
                <span class="tooltip">Pályázat</span>
            </li>
            <?php
                if($row["ROLE"] == "ADMIN"){
                    echo '
                    <li>
                        <a href="admin.php">
                            <i class="fas fa-user"></i>
                            <span class="links_name">Admin</span>
                        </a>
                        <span class="tooltip">Admin</span>
                    </li>';
                }
            ?>
        </ul>
        <div class="profile_content">
            <div class="profile">
                <div class="profile_details">
                <?php
                        if($randomNumber<21){
                            echo '<img src="img/profil1.png" alt="" id="prof">';
                        }elseif($randomNumber<41){
                            echo '<img src="img/profil2.png" alt="" id="prof">';
                        }elseif($randomNumber<61){
                            echo '<img src="img/profil3.png" alt="" id="prof">';
                        }elseif($randomNumber<81){
                            echo '<img src="img/profil4.png" alt="" id="prof">';
                        }elseif($randomNumber<99){
                            echo '<img src="img/profil5.png" alt="" id="prof">';
                        }elseif($randomNumber<=100){
                            echo '<img src="img/profil6.jpg" alt="" id="prof">';
                        }
                    ?>

                    <div class="name_job">
                        <div class="name">
                            <?php echo $row['USERNAME']; ?>
                        </div>
                        <div class="job">
                            <?php echo $row['ROLE']; ?>
                        </div>
                    </div>
                </div>
                <a href="php/logout.php">
                    <i class="fas fa-sign-out-alt"id="log_out"></i>
                </a>
            </div>
        </div>
    </div>