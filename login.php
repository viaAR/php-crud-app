<?php
require_once ("utils.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee DB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/2893d31d34.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="back">
    <div class="div-center">
        <div class="login-content">
            <?php
            if(isset($_SESSION['message'])):?>
                <div class="alert alert-<?=$_SESSION['msg_type']?>">
                    <?php
                    echo $_SESSION['message'];
                    unset ($_SESSION['message']);
                    ?>
                </div>
            <?php endif; ?>
            <form action="utils.php" method="post">
                <label class="visually-hidden" for="loginUser">Username</label>
                <!--Username-->
                <div class="input-group">
                    <div class="input-group-text"><i class="fas fa-user"></i></div>
                    <input type="text" class="form-control" id="loginUser" placeholder="Username" name="loginUser">
                </div>
                <!--Password-->
                <div class="input-group py-2">
                    <div class="input-group-text"><i class="fas fa-key"></i></div>
                    <input type="password" class="form-control" id="loginPwd" placeholder="Password" name="loginPwd">
                </div>
                <div class="d-flex">
                    <div class="py-2">
                        <button type="submit" class="btn btn-primary" name="login" id="submit" value="Login">Login</button>
                        <a class="btn btn-secondary my-2" href="newUser.php" role="button">Create User</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Bootstrap-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>