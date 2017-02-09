<?php
// start session
session_start();

require 'rbg_database.php';

if (isset($_SESSION['user_id'])){

	// id == id
	$records = $conn->prepare('SELECT memID,email,password FROM member WHERE memID = :memID');
	// binds session[user_id] to id from db
	$records->bindParam(':memID', $_SESSION['user_id']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);
	$user = NULL;

	if(count($results) > 0){
		$user = $results;
	}
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Royal Blue Gym</title>
	<link rel="stylesheet" type="text/css" href="rbg_style.css">
	<link href="https://fonts.googleapis.com/css?family=Lora|Pacifico" rel="stylesheet">
</head>
<body>

<div class="header">
	<a href="http://localhost/RBGym/main_page/index.php" title="">Royal Blue Gym</a>
</div>
<?php if(!empty($user)): ?>

	<br/>Welcome <?= $user['email']; ?>
	<br/><br/>You are successfully logged in!
	<br/><br/>
	<a href ="rbg_logout_mem.php">Logout?</a>
<?php else: ?>
<h1>Please Login or Register</h1>
<a href="rbg_login.php">Login</a> or
<a href="http://localhost/RBGym/Become_a_member/rbg_reg_mem.php">Register</a>
<?php endif; ?>

</body>
</html>