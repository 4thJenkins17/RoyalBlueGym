<?php
// start session
session_start();

require 'rbg_database.php';

if (isset($_SESSION['user_id'])){

	// id == id
	$records = $conn->prepare('SELECT memID,email FROM member UNION SELECT empID, email FROM employee');
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
		<h1 class="w3-border-bottom w3-border-blue w3-blue w3-text-white w3-round-xlarge" style="font-family: 'Pacifico', cursive; padding-bottom: 10px;">Welcome to Royal Blue Gym</h1>
		<p id="summary" class="w3-left w3-large" style="right: -125px; top: -50px;"><span class="w3-text-blue">Royal Blue Gym</span> has been around since August 2016. We are a small group of dedicated trainers looking to improve the lives of the community. We offer daily group sessions and personal training sessions. 
		<ul class="w3-left w3-large" style="clear: left; position: relative; top: -150px; right: -125px;  width: 425px; list-style: none;">
			<li>R.I.P.P.E.D</li>
			<li>Tai Chi</li>
			<li>Hip-Hop Workout</li>
			<li>Zumba</li>
			<li>Pilates</li>
			<li>Group Cycling</li>
			<li>Yoga</li>
			<li>Crossfit training</li>
			<li>And more...</li>
		</ul></p>
		<p id="summary" class="w3-center w3-left w3-large" style="clear: left; overflow: auto; position: relative; top: -250px; right: -125px;">The key to success is building a routine. Here at Royal Blue Gym we are dedicated to providing excellect service to bring you back. We also offer performance training for professional atheletes. We've been training the best of the best. Do you want to train like royalty? Do you even lift bro? <!-- <button class="w3-blue w3-border-blue w3-btn w3-round-xlarge w3-center" style="position:relative; top: 10px;">Become a Member</button> --> </p>
		<img id="image" src="http://www.scottdalesupplyonline.com/wp-content/uploads/2016/08/stock-gym-2.jpg" class=" w3-image w3-border w3-right w3-round-xlarge" style="width: 600px; height: 650px; position: relative; top: -575px;">

		<div class="w3-blue w3-left w3-round-xlarge" style="width: 100%; height: 50px; position: relative; top: -550px;"></div>

		<div class="w3-content w3-display-container w3-right w3-border" style="position: relative; top: -525px; right: 170px;">
		  <img id="slideImg" class="mySlides" src="http://www.fitnessbin.com/wp-content/uploads/2015/11/Weight-training.jpg">
		  <img id="slideImg" class="mySlides" src="http://www.bodybuilding.com/fun/images/2010/6-weight-training-mistakes-newbie-should-avoid_b.jpg">

		  <a class="w3-btn-floating w3-display-left" onclick="plusDivs(-1)">&#10094;</a>
		  <a class="w3-btn-floating w3-display-right" onclick="plusDivs(1)">&#10095;</a>
		  <div class="w3-display-topleft w3-container w3-padding-8 w3-black" style="width: 250px;">
    		Royal Blue Gym in action.
  		  </div>
		</div>

		<div class="w3-blue w3-left w3-round-xlarge" style="width: 100%; height: 50px; position: relative; top: -500px;"></div>



<!-- 		<div class="w3-blue w3-left w3-round-xlarge" style="width: 100%; height: 50px; position: relative; top: -500px;"></div> -->

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