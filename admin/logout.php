<?php
// configuration file
require_once('../add/config.php');

//log user out
$user->logout();
header('Location: index.php'); 
?> 