<?php
session_start();

require 'rbg_database.php';

// check if signed in
if(isset($_SESSION['user_id'])){
	header("Location: http://localhost/RBGym/Become_a_member/rbg_index_login.php");
}

$message = '';

if (!empty($_POST['email']) && !empty($_POST['password'])):
	// enter the new user into database
	// run sql statement
	$sql = "INSERT INTO member (email, password, fname, lname, address, phoneNumber, age, memType, intensity, wrkTime, xp) VALUES (:email, :password, :fname, :lname, :address, :phoneNumber, :age, :memType, :intensity, :wrkTime, :xp)";

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
	$stmt->bindParam(':memType', $_POST['memType']);
	$stmt->bindParam(':intensity', $_POST['intensity']);
	$stmt->bindParam(':wrkTime', $_POST['wrkTime']);
	$stmt->bindParam(':xp', $_POST['xp']);

	// test success
	if($stmt->execute()):
		$output = 'Successfully created new user'.'<br><a href="http://localhost/RBGym/main_page/index.php"><button class="w3-btn">Go back</button><a><br>';
		die($output);
	else:
		die('Sorry there must have been a issue');
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

<h1>Become a member</h1>

<span>or <a href="http://localhost/RBGym/member/rbg_mem_login.php">login here</a></span>

	<form action="rbg_reg_mem.php" method="POST" accept-charset="utf-8">
	
	<input type="text" name="email" value="" placeholder="Enter your email.">

	<input type="password" name="password" value="" placeholder="and password">

	<input type="password" name="password" value="" placeholder="confirm password">

	<input type="text" name="fname" value="" placeholder="Enter your first name.">

	<input type="text" name="lname" value="" placeholder="Enter your last name.">

	<input type="text" name="address" value="" placeholder="Enter your full address.">

	<input type="number" name="phoneNumber" value="" placeholder="Enter your phone number. ">

	<input type="number" name="age" value="" placeholder="Enter your age. ">

	<input type="text" name="memType" value="" placeholder="Membership type. ">

	<input type="number" name="intensity" value="" placeholder="Intensity level. ">

	<input type="text" name="wrkTime" value="" placeholder="Enter your workout time. ">

	<input type="number" name="xp" value="" placeholder="Enter your experience level. ">

	<input type="submit">

	</form>

</body>
</html>