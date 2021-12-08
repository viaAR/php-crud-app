<?php
require_once ("utils.php");

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create a new user account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/2893d31d34.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <h1 class="py-4 bg-dark text-light rounded"></h1>
    <?php
    if(isset($_SESSION['message'])):?>
        <div class="alert alert-<?=$_SESSION['msg_type']?>">
            <?php
            echo $_SESSION['message'];
            unset ($_SESSION['message']);
            ?>
        </div>
    <?php endif; ?>

    <!--Form Requirements-->
    <form class="row g-3 needs-validation bg-light rounded" novalidate action="utils.php" method="post">

        <div class="form-group">
            <label for="validationCustom01" class="form-label">Username</label>
            <input type="text" class="form-control" id="validationCustom01" value="" required name="username">
            <div class="valid-feedback">
                Looks good!
            </div>
        </div>

        <div class="form-group">
            <label for="validationCustom02" class="form-label">Password</label>
            <input type="password" class="form-control" id="validationCustom02" value="" required name="password" pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$">
            <div class="valid-feedback">
                Looks good!
            </div>
            <div class="invalid-feedback">
                Password must contain 8 characters, at least one letter and one number.
            </div>
        </div>

        <!--Buttons-->
        <div class="d-flex">
            <div class="py-2">
                <button class="btn btn-primary" type="submit" name="create">Create</button>
                <a class="btn btn-danger" href="login.php" role="button">Cancel</a>
            </div>

        </div>

    </form>

    <!--JS Form Validation-->
    <script>(function () {
            'use strict'
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>

</div>

<!--Bootstrap-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>