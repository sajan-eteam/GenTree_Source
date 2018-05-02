<?php
include "../backend/log.php";
$logType = 4;
$logText = 'Backend: logout avvenuto con successo';
logCreation($logType,$logText);
unset($_SESSION['admin_user_name']);
unset($_SESSION['admin_user_id']);
unset($_SESSION['user_id']);
header('Location: index.php');
?>