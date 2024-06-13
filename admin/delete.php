<?php 
require "../database.php";

$id = $_GET['pid'];

$qry = "DELETE FROM post where id=$id";
$res = $pdo->prepare($qry);
$res->execute();
header("Location:index.php");


?>