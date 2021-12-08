<?php
require_once ("utils.php");
$mysqli = getDbConnection();

$dbh = getDbConnection();

checkIfLoggedIn();

//$userSearch = "";
$userSearch = $_POST['query'];
$userSearch = "%" . $_POST['query'] . "%";


$query1 = 'SELECT * FROM employees.employees WHERE first_name LIKE :fname OR last_name LIKE :lname';
$sth = $dbh->prepare($query1);
$sth->bindParam(':fname', $userSearch);
$sth->bindParam(':lname', $userSearch);
$sth->execute();

$numOfPages = $sth->fetchColumn();

// Check for already specified page, default = 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$totalResultsPerPage = 25;

$query2 = 'SELECT * FROM employees.employees WHERE first_name LIKE :fname OR last_name LIKE :lname ORDER BY emp_no LIMIT :page, :totalResults';

if($sth = $dbh->prepare($query2)){
// Determine records that should be on specified page
$calc_page = ($page - 1) * $totalResultsPerPage;
$sth->bindParam(':fname', $userSearch);
$sth->bindParam(':lname', $userSearch);
$sth->bindParam(':page', $calc_page, PDO::PARAM_INT);
$sth->bindParam(':totalResults', $totalResultsPerPage, PDO::PARAM_INT);

$sth->execute();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manager Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/2893d31d34.js" crossorigin="anonymous"></script>
    <!--Pagination styles-->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<main>
    <div class="container text-center" >
        <h1 class="py-3 bg-dark text-light rounded"><i class="fas fa-users"></i> Employees</h1>
        <!--Confirmation banner-->
        <?php
        if(isset($_SESSION['message'])):?>
            <div class="alert alert-<?=$_SESSION['msg_type']?>">
                <?php
                echo $_SESSION['message'];
                unset ($_SESSION['message']);
                ?>
            </div>
        <?php endif; ?>
        <div class="d-flex">
            <div class="py-2">
                <form action="search.php" method="post">
                    <!--Searchbar-->
                    <label class="visually-hidden" for="autoSizingInputGroup">Username</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="fas fa-search"></i></div>
                        <input type="text" class="form-control" id="autoSizingInputGroup" placeholder="Name lookup" name="query">
                    </div>
                    <div class="input-group">
                        <!--Add employee button-->
                        <a class="btn btn-primary my-2" href="employee.php" role="button">New Employee</a>
                        <!--Logout Button-->
                        <a class="btn btn-secondary my-2" href="logout.php" role="button">Logout</a>
                    </div>
                </form>
            </div>
        </div>

        <!--Employee Table-->
        <div class="d-flex table-data">
            <table class="table table-striped table-dark">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>DOB</th>
                        <th>First</th>
                        <th>Last</th>
                        <th>Gender</th>
                        <th>Hire Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                <?php
                    $data = $sth->fetchAll(PDO::FETCH_ASSOC);
                    foreach($data as $row){
                ?>
                <tr>
                    <td><?php echo $row['emp_no'] ?></td>
                    <td><?php echo $row['birth_date'] ?></td>
                    <td><?php echo $row['first_name'] ?></td>
                    <td><?php echo $row['last_name'] ?></td>
                    <td><?php echo $row['gender'] ?></td>
                    <td><?php echo $row['hire_date'] ?></td>
                    <td>
                        <a class="btn btn-warning" href="update.php?edit=<?php echo $row['emp_no'] ?>">Edit</a>
                        <a class="btn btn-danger" href="utils.php?delete=<?php echo $row['emp_no'] ?>">Delete</a>
                    </td>
                </tr>
                <?php
                    }
                ?>
                </tbody>
            </table>
        </div>
        <!--Pageination-->
        <?php if(ceil($numOfPages / $totalResultsPerPage) > 0): ?>
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li class="prev"><a href="index.php?page=<?php echo $page-1 ?>">Prev</a></li>
                <?php endif; ?>

                <?php if ($page > 3): ?>
                    <li class="start"><a href="index.php?page=1">1</a></li>
                    <li class="dots">...</li>
                <?php endif; ?>

                <?php if ($page-2 > 0): ?><li class="page"><a href="index.php?page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
                <?php if ($page-1 > 0): ?><li class="page"><a href="index.php?page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

                <li class="currentpage"><a href="index.php?page=<?php echo $page ?>"><?php echo $page ?></a></li>

                <?php if ($page+1 < ceil($numOfPages / $totalResultsPerPage)+1): ?><li class="page"><a href="index.php?page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
                <?php if ($page+2 < ceil($numOfPages / $totalResultsPerPage)+1): ?><li class="page"><a href="index.php?page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

                <?php if ($page < ceil($numOfPages / $totalResultsPerPage)-2): ?>
                    <li class="dots">...</li>
                    <li class="end"><a href="index.php?page=<?php echo ceil($numOfPages / $totalResultsPerPage) ?>"><?php echo ceil($numOfPages / $totalResultsPerPage) ?></a></li>
                <?php endif; ?>

                <?php if ($page < ceil($numOfPages / $totalResultsPerPage)): ?>
                    <li class="next"><a href="index.php?page=<?php echo $page+1 ?>">Next</a></li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    </div>
</main>
    <!--Boostrap src-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>
<?php
    $dbh = null;
}
?>
