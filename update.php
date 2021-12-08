<?php
require_once ("utils.php");
$dbh = getDbConnection();

checkIfLoggedIn();

if(isset($_GET['edit'])){
    $query = "SELECT * FROM employees.employees WHERE emp_no = :emp_no";
    $sth = $dbh->prepare($query);
    $sth->bindParam(':emp_no', $_GET['edit']);

    $sth->execute();

    $data = $sth->fetchAll(PDO::FETCH_ASSOC);
    foreach($data as $row){
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update an employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/2893d31d34.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <h1 class="py-4 bg-dark text-light rounded"></h1>

    <!--Form Requirements-->
    <form class="row g-3 needs-validation bg-light rounded" novalidate action="utils.php" method="post">
        <div class="form-group">
            <label for="validationCustom01" class="form-label">Employee ID</label>
            <input type="text" class="form-control" id="validationCustom01" value="<?php echo $row['emp_no']; ?>" readonly name="empID">
        </div>

        <div class="form-group">
            <label for="validationCustom01" class="form-label">First Name</label>
            <input type="text" class="form-control" id="validationCustom01" value="<?php echo $row['first_name'] ?>" required name="fName">
            <div class="valid-feedback">
            Looks good!
            </div>
        </div>
        <div class="form-group">
            <label for="validationCustom02" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="validationCustom02" value="<?php echo $row['last_name'] ?>" required name="lName">
            <div class="valid-feedback">
            Looks good!
            </div>
        </div>
        <div class="form-group">
            <label for="validationCustom04" class="form-label">Gender</label>
            <select class="form-select" id="validationCustom04" required name="gender">
                <option selected value="<?php echo $row['gender'] ?>"><?php echo $row['gender'] ?></option>
                <option value="M">M</option>
                <option value="F">F</option>
            </select>
        </div>
        <div class="form-group">
            <label for="validationCustomUsername" class="form-label">Birth Date</label>
            <div class="input-group has-validation">
                <input type="text" placeholder="YYYY-MM-DD" required pattern="\d{4}-\d{2}-\d{2}" class="form-control" name="birthDate" id="" autofocus autocomplete="nope" value="<?php echo $row['birth_date'] ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="validationCustom03" class="form-label">Hire Date</label>
            <input type="text" placeholder="YYYY-MM-DD" required pattern="\d{4}-\d{2}-\d{2}" class="form-control" name="hireDate" id="" autofocus autocomplete="nope" value="<?php echo $row['hire_date'] ?>">
        </div>
        <?php
            }
        ?>
        <!--Buttons-->
        <div class="d-flex">
            <div class="py-2">
                <button class="btn btn-primary" type="submit" name="update">Update</button>
                <a class="btn btn-danger" href="index.php" role="button">Cancel</a>
                <a class="btn btn-secondary my-2" href="logout.php" role="button">Logout</a>
            </div>

        </div>
    </form>

    <!--JS Form Validation-->
    <script>
        (function () {
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
<?php
    $dbh = null;
    }
?>