<?php
session_start();
$_SESSION["nama"] = $_GET["txtNama"];
$_SESSION["email"] = $_GET["txtEmail"];
$_SESSION["pesan"] = $_GET["txtPesan"];
echo $_SESSION["nama"] . $_SESSION["email"] . $_SESSION["pesan"];
header("Location: post.php");
?>