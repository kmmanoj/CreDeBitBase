<?php
	session_start();
	$server="localhost";
	$user="root";
	$passwd="";
	$db="CreDeBitBase";
	$conn=new mysqli($server,$user,$passwd,$db);
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<link rel="icon" href="res/images/icon.png"/>
		<title>Error : CreDeBitBase</title>
		<link rel="stylesheet" href="res/css/style.css"/>
	</head>
	<body>
		<script src="res/js/behave.js"></script>
		<!-- Navigation bar -->
		<div class="header">
			<h1 id="brand"><a class="default" href="index.html">CreDeBitBase</a></h1>
			<div class="popup" id="back" onmouseover="popUp('backtext')" onmouseout="popUp('backtext')">
				<a href="home.php"><img id="backimg" class="navimg credentialimg" src="res/images/back.png"/></a>
				<span id="backtext" class="text">Back</span>
			</div>
		</div>
		<div class="content">
	<?php	
		// if connection error, then end the page with an error 
		if($conn->connect_error){
			die("<h1>Something Went Wrong</h1>");
		}	
		if(isset($_POST['addbutton'])){
			$add="INSERT INTO ".$_SESSION['username']." VALUES(\"".$_POST['client']."\",";
			if($_POST['type']=='Expense'){
				$add=$add."-";
			}
			$add=$add.$_POST['amount'].",\"".$_POST['date']."\",\"".$_POST['category']."\");";
			$conn->query($add);
			header("Location: home.php");
		}
		else if(isset($_POST['delbutton'])){
			$transaction=$_POST['transaction'];
			$words=explode(" ",$transaction);
			$q="DELETE FROM ".$_SESSION['username']." WHERE client=\"".$words[2]."\" AND amount=";
			if($words[0]=='Expense'){
				$q=$q."-";
			}
			$q=$q.$words[5]." AND trn_date=\"".$words[7]."\" AND category=\"".$words[9]."\";";
			$conn->query($q);
			header("Location: home.php");
		}
	?>
	</body>
</html>