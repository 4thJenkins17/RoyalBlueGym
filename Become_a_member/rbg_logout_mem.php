<?php 

// start all sessions
session_start();

// unset all current sessions
session_unset();

// destroy all sessions
session_destroy();

// redirect to homepage
header("Location: http://localhost/RBGym/main_page/index.php");

?>