<?php
// start session
session_start();

require 'rbg_database.php';

if (isset($_SESSION['user_id'])){

	// id == id
	$records = $conn->prepare('SELECT empID,email,password,fname,lname, Salary FROM employee WHERE empID = :empID');
	// binds session[user_id] to id from db
	$records->bindParam(':empID', $_SESSION['user_id']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);
	$user = NULL;

	if(count($results) > 0){
		$user = $results;
	}
}

$output = "";

if (isset($_POST['Search']) && !empty($_POST['Search'])) {
	$searchQ = $_POST['Search'];

	$sql = $conn->prepare("SELECT * FROM member WHERE lname LIKE '%$searchQ%' OR fname LIKE '%$searchQ%'") or die("ERROR");
	$sql->execute();
	$count = $sql->rowCount();

	if ($count == 0) {
		die('User not found.'.'<br><a href="http://localhost/RBGym/trainer/rbg_trainer_index.php"><button class="w3-btn">Go back</button><a><br>');
	}else{
		while ($row = $sql->fetch()) {
			$id = $row['memID'];
			$fname = $row['fname'];
			$lname = $row['lname'];
			$addr = $row['address'];
			$numbr = $row['phoneNumber'];
			$email = $row['email'];
			$output .= 'Member Info: '.'<br>'.'ID: '.$id.'<br>'.$fname.' '.$lname.'<br>'.$addr.'<br>'.$numbr.'<br>'.$email.'<br><br>';
		}
		$output .= '<br><a href="http://localhost/RBGym/trainer/rbg_trainer_index.php"><button class="w3-btn">Go back</button><a><br>';
		die($output);
	}
}

if (isset($_POST['Delete'])) {
	$searchQ = $_POST['Delete'];
	$sql = $conn->prepare("DELETE FROM member WHERE memID = '".$searchQ."'") or die("ERROR");

	if($sql->execute()){
		$output = 'Successfully deleted User'.'<br><a href="http://localhost/RBGym/trainer/rbg_trainer_index.php"><button class="w3-btn">Go back</button><a><br>';
		die($output);
	}else{
		$output = 'Error deleting User'.'<br><a href="http://localhost/RBGym/trainer/rbg_trainer_index.php"><button class="w3-btn">Go back</button><a><br>';
		die($output);
	}
}

$output = NULL;

if (isset($_POST['showCoaches'])) {
			$records = $conn->prepare("SELECT fname, lname, address, email, phoneNumber, title, salary FROM employee GROUP BY salary DESC");
			$records->execute();
			$count = $records->rowCount();

			if ($count > 0) {
			     // output data of each row W
			     while($row = $records->fetch()) {
			            $output .= "Name: ".$row['fname']." ".$row['lname']."<br>Address: ".$row['address']."<br>Email: ".$row['email']."<br>Phone Number: ".$row['phoneNumber']."<br>Title: ".$row['title']."<br>Salary: ".$row['salary']."<br>"."<br>";
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

		<div class="w3-card-8 w3-left w3-margin w3-padding-medium" style="width: 360px; height: 250px;">
			<h2 class="w3-border-bottom">Personal Info: </h2>
			<?php 
			$records = $conn->prepare("SELECT fname, lname, address, email, phoneNumber FROM employee WHERE empID = '".$_SESSION['user_id']."'");
			$records->execute();
			$count = $records->rowCount();

			if ($count > 0) {
			     // output data of each row W
			     while($row = $records->fetch()) {
			     		echo "<p class=\"w3-center w3-padding-large\"";
			            echo $row['fname']." ".$row['lname']."<br>";
			            echo $row['address']."<br>";
   						echo $row['email']."<br>";
   						echo $row['phoneNumber']."<br>";
   						echo "</p>";
			     }
			} else {
			     echo "0 results";
			}
			?>
		</div>
		<div class="w3-card-8 w3-left w3-margin w3-padding-medium">
		<ul class="w3-ul" style="width: 350px; height: 250px;"">
		<h2 class="w3-center w3-border-bottom">Membership info:</h2>
		<?php 
			$records = $conn->prepare("SELECT memType, COUNT(*) FROM member GROUP BY memType");
			$records->execute();
			$count = $records->rowCount();

			if ($count > 0) {
			     // output data of each row
				while($row = $records->fetch()) {
					echo "<li>";
					echo "Membership ".$row['memType']." has ";
					echo $row['COUNT(*)']." members<br>";
					echo "</li>";
				}
			} else {
			     echo "0 results";
			}
		?>
		</ul>
		</div>
		<div class="w3-card-8 w3-left w3-margin w3-padding-medium" style="width: 350px; height: 250px;"">
			<form action= "rbg_trainer_index.php" method="post" accept-charset="utf-8" >
			  <h2 class="w3-border-bottom">Find a Member:</h2>
			  <input type="text" name="Search" placeholder="Enter a name...">
			  <br>
			  <input class="w3-margin" type="submit" value="Submit">
			  <br>
			</form>
		</div>
		<div class="w3-card-8 w3-right w3-margin w3-padding-medium" style="position: relative; right: 15px; width: 360px; height: 275px;">
		<ul class="w3-ul" style="width: 350px; height: 250px;">
		<h2 class="w3-center w3-border-bottom">Currently Coaching:</h2>
		<?php 
			$records = $conn->prepare("SELECT member.fname AS 'First Name', member.lname AS 'Last Name', member.email, member.phoneNumber, member.address, member.age FROM member WHERE member.coachID = (SELECT DISTINCT coach.coachID FROM coach INNER JOIN employee ON coach.empID = '".$_SESSION['user_id']."' ORDER BY coach.coachID)");
			$records->execute();
			$count = $records->rowCount();

			if ($count > 0) {
			     // output data of each row
				while($row = $records->fetch()) {
					echo "<li>";
					echo $row['First Name'].' '.$row['Last Name'].'<br>';
			        echo $row['address']."<br>";
   					echo $row['email']."<br>";
   					echo $row['phoneNumber']."<br>";
					echo "</li>";
				}
			} else {
			     echo "0 results";
			}
		?>
		</ul>
		</div>
		<div class="w3-card-8 w3-right w3-margin w3-padding-medium" style="position: relative; right: 35px; width: 350px; height: 250px;">
		<h2 class="w3-border-bottom">Delete Member</h2>
			<form action="rbg_trainer_index.php" method="post" accept-charset="utf-8" >
			<input type="number" name="Delete" placeholder="Enter a ID...">
			<br>
			<input class="w3-margin" type="submit" value="Delete">
			<br>
			</form>
		</div>
		<div class="w3-card-8 w3-right w3-margin w3-padding-medium" style="position: relative; right: 35px; width: 350px; height: 250px;">
		<h2 class="w3-border-bottom">Show Coaches</h2>
		<form action="rbg_trainer_index.php" method="post" accept-charset="utf-8">
		<input type="submit" name="showCoaches" value="View">
		</form>
		</div>
	</div>
		<!--- ############ -->

	<!-- PAGE -->

	<!--- FOOTER -->
	<footer class="w3-container w3-blue w3-bottom">
		<p class="w3-center">Copyright 2016</p>
	<?php if(!empty($user)): ?>
		<a class="w3-center w3-display-topright" style="top: 14px; left: 200px; text-decoration: none;" href ="http://localhost/RBGym/Become_a_member/rbg_logout_mem.php"> - Logout</a>
	<?php endif; ?>
	</footer>
	<!--- ############ -->

<script type="text/javascript">
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";
  }
  x[slideIndex-1].style.display = "block";
}
</script>

</body>
</html>