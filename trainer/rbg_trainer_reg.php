<?php
session_start();

require 'rbg_database.php';

// check if signed in
if(isset($_SESSION['user_id'])){
	header("Location: http://localhost/RBGym/trainer/rbg_trainer_index.php");
}

$message = '';

if (!empty($_POST['email']) && !empty($_POST['password'])):
	// enter the new user into database
	// run sql statement
	$sql = "INSERT INTO employee (email, password, fname, lname, address, phoneNumber, age, salary, title) VALUES (:email, :password, :fname, :lname, :address, :phoneNumber, :age, :salary, :title)";

	// prepare sql statement
	$stmt = $conn->prepare($sql);

	// bind the parameters
	$stmt->bindParam(':email', $_POST['email']);
	$stmt->bindParam(':password', $_POST['password']);
	$stmt->bindParam(':fname', $_POST['fname']);
	$stmt->bindParam(':lname', $_POST['lname']);
	$stmt->bindParam(':address', $_POST['address']);
	$stmt->bindParam(':phoneNumber', $_POST['phoneNumber']);
	$stmt->bindParam(':age', $_POST['age']);
	$stmt->bindParam(':salary', $_POST['salary']);
	$stmt->bindParam(':title', $_POST['title']);

	// test success
	if($stmt->execute()):
		$output = 'Successfully created new user'.'<br><a href="http://localhost/RBGym/trainer/rbg_trainer_index.php"><button class="w3-btn">Go back</button><a><br>';
		die($output);
	else:
		die('Sorry there must have been a issue'.'<br><a href="http://localhost/RBGym/trainer/rbg_trainer_index.php"><button class="w3-btn">Go back</button><a><br>');
	endif;

endif;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Register Below</title>
	<link rel="stylesheet" type="text/css" href="rbg_style.css">
	<link href="https://fonts.googleapis.com/css?family=Lora|Pacifico" rel="stylesheet">
</head>
<body>

<div class="header">
	<a href="http://localhost/RBGym/main_page/index.php" title="">Royal Blue Gym</a>
</div>

<?php if (!empty($message)): ?>
	<p><?= $message ?></p>
<?php endif; ?>

<h1>Become a trainer</h1>

<span>or <a href="http://localhost/RBGym/trainer/rbg_trainer_login.php">login here</a></span>

	<form action="rbg_trainer_reg.php" method="POST" accept-charset="utf-8">
	
	<input type="text" name="email" value="" placeholder="Enter your email.">

	<input type="password" name="password" value="" placeholder="and password">

	<input type="password" name="password" value="" placeholder="confirm password">

	<input type="text" name="fname" value="" placeholder="Enter your first name.">

	<input type="text" name="lname" value="" placeholder="Enter your last name.">

	<input type="text" name="address" value="" placeholder="Enter your full address.">

	<input type="number" name="phoneNumber" value="" placeholder="Enter your phone number. ">

	<input type="number" name="age" value="" placeholder="Enter your age. ">

	<input type="number" name="salary" value="" placeholder="Enter your salary. ">

	<input type="text" name="title" value="" placeholder="Enter your work title. ">

	<input type="submit">

	</form>

</body>
</html>