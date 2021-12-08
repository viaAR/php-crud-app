<?php
session_start();
ob_start();

// Connect to the database
function getDbConnection(){
    // Environment Variables - Ternary format
    $dbname = isset($_ENV['DB_DBNAME']) ? $_ENV['DB_DBNAME'] : "employees";
    $host = isset($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : "database";
    $username = isset($_ENV['DB_USERNAME']) ? $_ENV['DB_USERNAME'] : "employeesApp";
    $password = isset($_ENV['DB_PASSWORD']) ? $_ENV['DB_PASSWORD'] : "student";

    try {
          $dbh = new PDO("mysql:host=$host; dbname=$dbname", $username, $password);
          $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          return $dbh;
     }

    catch (PDOException $ex) {
        echo $ex->getMessage();
        return $dbh = null;
    }
}

// Globals
$dbh = getDbConnection();
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Check if a user is already logged in
function checkIfLoggedIn()
{
    if(empty($_SESSION['LoggedInUser']))
    {
        header("location:login.php");
    }
}

// Add a new employee
if(isset($_POST['newEmployee'])){
    try {
        $sth = $dbh->prepare('INSERT INTO employees.employees (birth_date, first_name, last_name, gender, hire_date) VALUES(:bday, :fname, :lname, :gender, :hdate)');

        $sth->bindParam(':bday', $_POST['birthDate']);
        $sth->bindParam(':fname', $_POST['fName']);
        $sth->bindParam(':lname', $_POST['lName']);
        $sth->bindParam(':gender', $_POST['gender']);
        $sth->bindParam(':hdate', $_POST['hireDate']);

        $result = $sth->execute();

        if(!$result)
        {
            $_SESSION['message'] = "Your request could not be processed. Please verify you entered a correct date";
            $_SESSION['msg_type'] = "danger";
        }
        else
        {
            $_SESSION['message'] = "New record created. " . $sth->rowCount() . " record(s) affected.";
            $_SESSION['msg_type'] = "success";
        }
        header("location: index.php");
    }

    catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// Delete an existing employee
if(isset($_GET['delete'])){
    try {
        $query = 'DELETE FROM employees.employees WHERE emp_no = :emp_no';
        $sth = $dbh->prepare($query);
        $sth->bindParam(':emp_no', $_GET['delete']);

        $result = $sth->execute();

        if(!$result){
            $_SESSION['message'] = "Your request could not be processed.";
            $_SESSION['msg_type'] = "danger";
        }
        else {
            $_SESSION['message'] = "Deleted. " . $sth->rowCount() . " record(s) affected.";
            $_SESSION['msg_type'] = "success";
        }
        header("location: index.php");
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// Update an existing employee
if(isset($_POST['update'])){
    try {
        $query = "UPDATE employees.employees SET birth_date = :bday, first_name = :fname, last_name = :lname, gender = :gender, hire_date = :hdate WHERE emp_no = :emp_no";
        $sth = $dbh->prepare($query);
        $sth->bindParam(':bday', $_POST['birthDate']);
        $sth->bindParam(':fname', $_POST['fName']);
        $sth->bindParam(':lname', $_POST['lName']);
        $sth->bindParam(':gender', $_POST['gender']);
        $sth->bindParam(':hdate', $_POST['hireDate']);
        $sth->bindParam(':emp_no', $_POST['empID']);

        $result = $sth->execute();

        if(!$result)
        {
            $_SESSION['message'] = "Your update request could not be processed. Please verify the entered dates.";
            $_SESSION['msg_type'] = "danger";
        }
        else
        {
            $_SESSION['message'] = "Record updated. " . $sth->rowCount() . " record(s) affected.";
            $_SESSION['msg_type'] = "success";
        }
        header("location: index.php");
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// Check the users login credentials
if(isset($_POST['login'])){
    try {
        $query = 'SELECT * FROM employees.web_users WHERE user_name = :username';
        $sth = $dbh->prepare($query);
        $sth->bindParam(':username', $_POST['loginUser']);

        $sth->execute();

        $count = $sth->rowCount();

        // Found user
        if($count == 1){
            $data = $sth->fetchAll(PDO::FETCH_ASSOC);

            foreach($data as $row){
                $hash = $row['user_pwd'];

                if (empty($_POST['loginUser']) || $_POST['loginUser'] != password_verify($_POST['loginPwd'], $hash)) {
                    // Fail
                    $_SESSION['message'] = "Username/password invalid";
                    $_SESSION['msg_type'] = "danger";
                    header("location: login.php");
                }

                if(password_verify($_POST['loginPwd'], $hash)){
                    // Success
                    $_SESSION['LoggedInUser'] = $_POST['loginUser'];
                    header("location: index.php");
                }
            }
        }
        // No user
        if($count < 1){
            $_SESSION['message'] = "Username/password invalid";
            $_SESSION['msg_type'] = "danger";
            header("location: login.php");
        }
        ob_end_flush();
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// Create a new user
if(isset($_POST['create'])){

    try {
        // Verify no existing users with that name
        $query1 = 'SELECT * FROM employees.web_users WHERE user_name = :username';
        $sth = $dbh->prepare($query1);
        $sth->bindParam(':username', $_POST['username']);

        $result = $sth->execute();

        // Count rows returned
        $count = $sth->rowCount();

        if ($count != 0){
            $_SESSION['message'] = "Username taken. Please choose another username.";
            $_SESSION['msg_type'] = "danger";
            header("location: newUser.php");
        }

        if ($count == 0){
            $hash = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $query2 = 'INSERT INTO employees.web_users (user_name, user_pwd) VALUES (:username, :password)';

            $sth = $dbh->prepare($query2);
            $sth->bindParam(':username', $_POST['username']);
            $sth->bindParam(':password', $hash);

            $result = $sth->execute();

            if(!$result){
                $_SESSION['message'] = "Your user could not be created.";
                $_SESSION['msg_type'] = "danger";
            }

            else {
                $_SESSION['message'] = "New user created!";
                $_SESSION['msg_type'] = "success";
            }
            header("location: index.php");
        }
    }
    catch (PDOException $e) {
        echo $e->getMessage();
    }
}