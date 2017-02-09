<?php
// start session
session_start();

require 'rbg_database.php';

if (isset($_SESSION['user_id'])){

	// id == id
	$records = $conn->prepare('SELECT memID,email,password,fname,lname,memType,Intensity FROM member WHERE memID = :memID');
	// binds session[user_id] to id from db
	$records->bindParam(':memID', $_SESSION['user_id']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);
	$user = NULL;

	if(count($results) > 0){
		$user = $results;
	}
}

$output = NULL;

if (isset($_POST['Key'])) {
	$searchQ = $_POST['Key'];
	$sql = $conn->prepare("SELECT member.fname AS  'first Name', member.lname AS  'Last Name', coach.coachID AS  'Coach',coach.specialty AS 'Specialty', member.wrkTime AS  'workout time', employee.fName AS  'Coaches First Name', employee.lName AS  'Coaches Last Name', employee.phoneNumber AS  'Coaches Phone Number', employee.email AS 'coaches email' FROM member, employee INNER JOIN coach WHERE ((member.memID = '".$_SESSION['user_id']."') AND (coach.empID = employee.empID) AND (coach.shiftTime = member.wrkTime) AND (coach.xp >= member.xp) AND (coach.specialty LIKE  '%$searchQ%')) GROUP BY member.fname LIMIT 0 , 30");
	
	if($sql->execute()){

		while ($row = $sql->fetch()) {
			$fname = $row['Coaches First Name'];
			$lname = $row['Coaches Last Name'];
			$output .= $fname.' '.$lname;
		}
		$count = $sql->rowCount();
		if ($count == 0) {
			$output = 'There was no possible coach for you. See front desk for more information.'.'<br><a href="http://localhost/RBGym/member/rbg_member_index.php"><button class="w3-btn">Go back</button><a><br>';
			die($output);
		}
		$output .= '<br><a href="http://localhost/RBGym/member/rbg_member_index.php"><button class="w3-btn">Go back</button><a><br>';
		die($output);
	}else{
		$output = 'There was no possible coach for you. See front desk for more information.'.'<br><a href="http://localhost/RBGym/member/rbg_member_index.php"><button class="w3-btn">Go back</button><a><br>';
		die($output);
	}


}

$output = NULL;

if (isset($_POST['showCoaches'])) {
			$records = $conn->prepare("SELECT fname, lname, address, email, phoneNumber, title, salary, coach.specialty FROM employee, coach WHERE employee.empID = coach.empID");
			$records->execute();
			$count = $records->rowCount();

			if ($count > 0) {
			     // output data of each row W
			     while($row = $records->fetch()) {
			            $output .= "Name: ".$row['fname']." ".$row['lname']."<br>Address: ".$row['address']."<br>Email: ".$row['email']."<br>Phone Number: ".$row['phoneNumber']."<br>Title: ".$row['title'].'<br>Specialty: '.$row['specialty']."<br>Salary: ".$row['salary']."<br>"."<br>";
			     }
			     $output .= '<a href="http://localhost/RBGym/trainer/rbg_trainer_index.php"><button class="w3-btn">Go back</button><a><br>';
			     die($output);
			} else {
				 $output .= "<br>";
			     $output .= "0 results";
			     $output .= "<br>";
		   	     $output .= "<br>";
			     die($output);

			}
}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Royal Blue Gym</title>
	<link type="text/css" rel="stylesheet" href="rbgss.css">
	<link rel="stylesheet" href="w3.css">
	<link href="https://fonts.googleapis.com/css?family=Lora|Pacifico" rel="stylesheet">

</head>
<body id="index">

	<!--- NAV BAR -->
	
		<!-- large screen -->
		<nav>
			<ul class="w3-container w3-navbar w3-blue w3-hide-small">
				<li class="w3-navitem"><h5 style="font-family: 'Pacifico', cursive; font-size: 18px;">Royal Blue Gym</h5></li>
				<li id="NAVLIST"><a href="http://localhost/RBGym/main_page/index.php"><h5>Home</h5></a></li>				<li id="NAVLIST"><a href="http://localhost/RBGym/trainer/rbg_trainer_login.php"><h5>Trainers</h5></a></li>
				<li id="NAVLIST"><a href="http://localhost/RBGym/member/rbg_mem_login.php"><h5>Members</h5></a></li>
				<li id="NAVLIST"><a class="w3-yellow w3-text-blue w3-hover-grey" href="http://localhost/RBGym/Become_a_member/rbg_reg_mem.php"><h5>Become a Member</h5></a></li>
			</ul>
		</nav>
		<!--- ############ -->


	<!---        -->

	<!--- PAGE -->

		<!-- large screen -->
		<div id="page" class="w3-container w3-round-xlarge w3-display-middle w3-center" style="width: 1250px; top: 410px; overflow: auto;">
		<h1 class="w3-border-bottom w3-border-blue w3-blue w3-text-white w3-round-xlarge" style="font-family: 'Pacifico', cursive; padding-bottom: 15px; padding-top: 15px;">Welcome <?= $user['fname'];?> <?= $user['lname'];?></h1>
		<div class="w3-card-8 w3-left w3-margin w3-padding-medium">
			<h3 class="w3-border-bottom">Personal Info: </h3>
			<?php 
			$records = $conn->prepare("SELECT fname, lname, address, email, phoneNumber FROM member WHERE memID = '".$_SESSION['user_id']."'");
			$records->execute();
			$count = $records->rowCount();

			if ($count > 0) {
			     // output data of each row W
			     while($row = $records->fetch()) {
			            echo $row['fname']." ".$row['lname']."<br>";
			            echo $row['address']."<br>";
   						echo $row['email']."<br>";
   						echo $row['phoneNumber']."<br>";
   						echo "<br>";
			     }
			} else {
				echo "<br>";
			     echo "0 results";
			     echo "<br>";
		   	     echo "<br>";

			}
			?>
		<a style="text-decoration: none;" href="http://localhost/RBGym/member/update_mem_form.php"> <button class="w3-btn w3-blue w3-round-xlarge" style="display: block; clear: both; margin: auto;"><h6>Update Info</h6></button></a>	
		</div>
		<div class="w3-card-8 w3-left w3-margin w3-padding-medium" style="width: 350px; height: 240px;">
		<h3 class="w3-border-bottom">Intensity Level: </h3>
			<h1 class="w3-xxlarge"><?= $user['Intensity'];?></h1>
		</div>
		<div class="w3-card-8 w3-left w3-margin w3-padding-medium" style="width: 350px; height: 240px;">
		<h3 class="w3-border-bottom">Membership Type: </h3>
		<h1 class="w3-xxlarge"><?= strtoupper($user['memType']);?></h1>
		</div>
		<div class="w3-card-8 w3-left w3-margin w3-padding-medium" style="width: 350px; height: 250px;">
		<h3 class="w3-border-bottom">Recommend Coach: </h3>
			<form action="rbg_member_index.php" method="post" accept-charset="utf-8" >
			<input type="text" name="Key" placeholder="Enter a workout...">
			<br>
			<input class="w3-margin" type="submit" value="Recommend">
			<br>
			</form>
		</div>
		<div class="w3-card-8 w3-margin w3-padding-medium w3-dropdown-hover" style="width: 350px; height: 250px; position: relative; right: 25px;">
		<h3 class="w3-border-bottom">Try this machine: </h3>
		<?php 
		$sql = $conn->prepare("SELECT * FROM equipment ORDER BY rand()");
		$sql->execute();

		while ($row = $sql->fetch()) {
			$output = "<p class=\"w3-display-middle w3-large\">".'Type: '.$row['name']." <br>Brand: ".$row['brand']."<br>";
			echo $output;
			break;
		}
		?>
		</div>
		<div class="w3-card-8 w3-right w3-margin w3-padding-medium" style="position: relative; right: 55px; width: 350px; height: 250px;">
		<h2 class="w3-border-bottom">Show Coaches</h2>
		<form action="rbg_member_index.php" method="post" accept-charset="utf-8">
		<input type="submit" name="showCoaches" value="View">
		</form>
		</div>
		</div>
	<!-- PAGE -->

	<!--- FOOTER -->
	<footer class="w3-container w3-blue w3-bottom">
		<p class="w3-center">Copyright 2016</p>
	<?php if(!empty($user)): ?>
		<a class="w3-center w3-display-topright" style="top: 14px; left: 200px; text-decoration: none;" href ="http://localhost/RBGym/Become_a_member/rbg_logout_mem.php"> - Logout</a>
	<?php endif; ?>
	</footer>
	<!--- ############ -->

</body>
</html>