<?php
require_once "connect.php";

$username = $password = $confirm_password;
$username_err = $password_err = $confirm_password_err;

if (isset($_POST["register"])) {
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username";
    } else {
        $sql = "SELECT id FROM login WHERE user = :username";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            $param_username = trim($_POST['username']);

            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $username_err = "Username already exist";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops ! Something went wrong";
            }
            unset($stmt);
        }
    }

    if (empty(trim($_POST['password']))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty(trim($_POST['confirm_password']))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match";
        }
    }

    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = 'INSERT INTO `login`(`user`, `password`) VALUES (:username,:password)';

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_BCRYPT);
            if ($stmt->execute()) {
                header("location: read.php");
            } else {
                echo "Something went wrong";
            }
            unset($stmt);
        }
    } else {
        echo $password_err;
        echo $username_err;
        echo $confirm_password_err;
    }
    unset($pdo);

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
<h2>REGISTER</h2>
<form action="" method="post">
<label for="username">username</label>
<input type="text" name="username">
<label for="password">password</label>
<input type="password" name="password">
<label for="confirm_password">confirm password</label>
<input type="password" name="confirm_password">
<input type="submit" name="register">
</form>
</body>
</html>
