<?php
session_start();

require 'rbg_database.php';

// if session has started
if(isset($_SESSION['user_id'])){
	header("Location: http://localhost/RBGym/member/rbg_member_index.php");
}

if (!empty($_POST['email']) && !empty($_POST['password'])):

	// prepare sql statement
	$records = $conn->prepare('SELECT memID,email,password FROM member WHERE email = :email');
	// bind parameters :email = email
	$records->bindParam(':email', $_POST['email']);
	// execute sql statement
	$records->execute();

	// fetch results
	$results = $records->fetch(PDO::FETCH_ASSOC);

	// results should be more than 0 and password has to match
	// && password_verify($_POST['password'], $results['password'])
	if(count($results) > 0 && strncmp($results['password'], $_POST['password'], strlen($results['password'])) == 0){
		// creates session id
		$_SESSION['user_id'] = $results['memID'];
		// redirects user
		header("Location: http://localhost/RBGym/member/rbg_member_index.php");

	}else{
		// error message
		$output = 'Sorry those credentials do not match, please try again.'.'<br><a href="http://localhost/RBGym/member/rbg_mem_login.php"><button class="w3-btn">Go back</button><a><br>';
		die($output);

	}

endif;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Below</title>
	<link rel="stylesheet" type="text/css" href="http://localhost/RBGym/member/rbg_style.css">
	<link href="https://fonts.googleapis.com/css?family=Lora|Pacifico" rel="stylesheet">
</head>
<body>

<div class="header">
	<a href="http://localhost/RBGym/main_page/index.php" title="">Royal Blue Gym</a>
</div>

<?php if (!empty($message)): ?>
	<p><?= $message ?></p>
<?php endif; ?>

	<h1>Login</h1>
	<span>or <a href="http://localhost/RBGym/Become_a_member/rbg_reg_mem.php">become a member here</a></span>

	<form action="rbg_mem_login.php" method="POST" accept-charset="utf-8">
	
	<input type="text" name="email" value="" placeholder="Enter your email.">
	<input type="password" name="password" value="" placeholder="and password">
	<input type="submit">
	</form>

</body>
</html>