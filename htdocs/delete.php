<?php
require_once 'verification.php';
require "connect.php";
$id = $_GET['id'];
$sql = $pdo->prepare('DELETE from hiking WHERE id=?');
$sql->execute(array($id));
header("location: http://localhost:2021/read.php");
