<?php

session_start();
unset($_SESSION['id_usuario']);
unset($_SESSION['id_master']);
header("location: index.php");
?>