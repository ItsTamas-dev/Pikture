
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pikture</title>
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>
    <img src="img/bg.jpg" class="bg-image">
    <div class="log">
        <div class="container">
            <div class="form-container login-container">
                <form action="./php/login.php" method="POST">
                <h1>Bejelentkezés</h1>
                <div class="form-control">
                    <input type="text" name="email" id="email" placeholder="Email-cím">
                        <?php if (isset($_GET['erroremail'])) { ?>
                            <small class="email-error-2"><?php echo $_GET['erroremail']; ?></small>
                        <?php } ?>
                    <span></span>
                </div>
                <div class="form-control">
                    <input type="password" name="password" id="password" placeholder="Jelszó">
                        <?php if (isset($_GET['errorpass'])) { ?>
                            <small class="email-error-2"><?php echo $_GET['errorpass']; ?></small>
                        <?php } ?>
                    <span></span>
                </div>
                <div class="content">
                        <a href="reg.php">Regisztráció</a>
                </div>
                    <input type="submit" name="submit" value="Belépés" class="button">
                </form>
            </div>
            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-panel">
                        <h1 class="title">
                            Hello<br/>
                            Barátom!
                        </h1>
                        <p>Képgalériánkkal tárolhatot saját képeidet, illetve pályázhatsz is velük!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
include_once "php/csat.php";
?>