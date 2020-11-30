<?php
require_once 'connect.php';

session_start();

if (isset($_SESSION["loggedIn"]) && $_SESSION['loggedIn']) {
    header("location: read.php");
    exit;
}
$username = $password = "";
$username_err = $password_err = "";

if (isset($_POST["login"])) {
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username";
    } else {
        $username = trim($_POST["username"]);
    }
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter password";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT * FROM login WHERE user= :username";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $param_username = trim($_POST["username"]);

            if ($stmt->execute()) {
                if ($row = $stmt->fetch()) {
                    $id = $row['id'];
                    $username = $row['username'];
                    $hashed_password = $row['password'];
                    if (password_verify($password, $hashed_password)) {
                        session_start();

                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;

                        header("location: read.php");
                    } else {
                        $password_err = "Incorrect password";
                    }
                }
            } else {
                $username_err = "Username does not exist";
            }
        } else {
            echo "Oops ! Something went wrong";
        }
        unset($stmt);
    }
    unset($pdo);
    echo $password_err;
    echo $username_err;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h2>LOGIN</h2>
<form action="" method="post">
<label for="username">username</label>
<input type="text" name="username">
<label for="password">password</label>
<input type="password" name="password">
<input type="submit" name="login">
</form>
<p>Don't have an account ?</p> <a href="register.php"> Sign up</a>
</body>
</html>
