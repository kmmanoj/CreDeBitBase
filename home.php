<?php
	session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<link rel="icon" href="res/images/icon.png"/>
		<title>Home : CreDeBitBase</title>
		<link rel="stylesheet" href="res/css/style.css"/>
	</head>
	<body>
		<script src="res/js/behave.js"></script>
		<!-- Alert message -->
		<?php
			$server="localhost";
			$user="root";
			$passwd="";
			$db="CreDeBitBase";
			$conn=new mysqli($server,$user,$passwd,$db);
			// if connection error, then end the page with an error 
			if($conn->connect_error){
				die("
					<center>
					<div style='position:absolute;left:30%;width:40%'>
						<img src='res/images/error.png'/>
						<h1 style='background:rgb(120,180,180);color:rgb(41,68,77);border-radius:10px;'>
						SERVER ERROR!!!
						</h1>
					</div>
					</center>
				");
			}

			echo "
				<center>
				<div id='regsuccess' style='position:absolute;left:43%;width:14%'>
				<img id='alertimg' style='width:30px;' src='res/images/done.png'/>
				<p style='background:rgb(120,180,180);color:rgb(41,68,77);border-radius:10px;'>";

			// if page redirected from register page
			if(isset($_POST['registerbutton'])){
				// check for duplicate
				$checkduplicate="SELECT * FROM TableIndex WHERE username=\"".$_POST['username']."\";";
				$output=$conn->query($checkduplicate);
				$duplicate=false;
				if($output->num_rows>0 && $row=$output->fetch_assoc()){
					// display content to allow user to go back and register with a different username 
					echo "
						<script>
							document.getElementById('alertimg').src='res/images/error.png';
						</script>
					";
					echo "<strong>Sorry! Username unavailable, try another</strong>";
					$duplicate=true;
				}
				// if not duplicate insert into the database
				if(!$duplicate){
					// insert the record into the database
					$insertrec="INSERT INTO TableIndex VALUES(\"".$_POST['name']."\",\"".$_POST['username']."\",\"".$_POST['password']."\");";
					$conn->query($insertrec);
					$createtable="CREATE TABLE ".$_POST['username']."(client VARCHAR(50), amount INTEGER, trn_date DATE, category varchar(50));";
					$conn->query($createtable);
					echo "REGISTERED SUCCESSFULLY!!!";
				}
			}

			// if page redirected from login page
			else if(isset($_POST['loginbutton'])){
				$checkexistance="SELECT * FROM TableIndex WHERE username=\"".$_POST['username']."\" AND password=\"".$_POST['password']."\";";
				$run=$conn->query($checkexistance);
				if($run->num_rows>0 && $row=$run->fetch_assoc()){
					echo "LOGGED IN SUCCESSFULLY!!!";
				}
				else{
					die("
						<script>
							document.getElementById('alertimg').src='res/images/error.png';
						</script>
						<strong>Sorry! Username or Password is incorrect</strong>
						</p>
						</div>
						</center>

						<div class='header'>
							<h1 id='brand'><a class='default' href='index.html'>CreDeBitBase</a></h1>
							<div class='popup' id='back' onmouseover='popUp(\"backtext\")' onmouseout='popUp(\"backtext\")'>
								<a href='login.html'><img id='backimg' class='navimg credentialimg' src='res/images/back.png'/></a>
								<span id='backtext' class='text'>Back</span>
							</div>
						</div>
					");
				}

			}
			// end the page with an alert that fades away later 
			echo "
				</p>
				</div>
				</center>
				<script>
					window.setTimeout(function(){
						document.getElementById('regsuccess').innerHTML='';
					},5000);
				</script>
			";

			// if duplicate then, display different headers navigation
			if($duplicate){
				die("
					<div class='header'>
						<h1 id='brand'><a class='default' href='index.html'>CreDeBitBase</a></h1>
						<div class='popup' id='back' onmouseover='popUp(\"backtext\")' onmouseout='popUp(\"backtext\")'>
							<a href='register.html'><img id='backimg' class='navimg credentialimg' src='res/images/back.png'/></a>
							<span id='backtext' class='text'>Back</span>
						</div>
					</div>
				");
			}
		?>

		</div>
		<!-- Navigation bar -->
		<div class="header">
			<h1 id="brand"><a class="default" href="index.html">CreDeBitBase</a></h1>
			<div class="popup" id="logout" onmouseover="popUp('logouttext')" onmouseout="popUp('logouttext')">
				<a href="loggedout.php"><img id="logoutimg" class="credentialimg" src="res/images/logout.png"/></a>
				<span id="logouttext" class="text">Logout</span>
			</div>
			<div style="padding:10px;display:inline;float:right;color: rgb(99,194,243)">
				<p><b>Hi, <?php 
				$getname="SELECT * FROM TableIndex WHERE username=\"".$_POST['username']."\" AND password=\"".$_POST['password']."\";";
				$run=$conn->query($getname);
				if($run->num_rows>0 && $record=$run->fetch_assoc()){
					echo $record['name'];
					$_SESSION['name']=$record['name'];
					$_SESSION['username']=$_POST['username'];
					$_SESSION['password']=$_POST['password'];
				}
				else{
					echo $_SESSION['name'];	
				}
				?>!</b></p>
			</div>
		<div class="content">
			<div class="popup contentElement" id="add" onmouseover="popUp('addtext')" onmouseout="popUp('addtext')">
				<a href="action.php?action=add"><img id="addimg" class="actionimg" src="res/images/addtransaction.png"/></a>
				<span id="addtext" class="text">Add</span>
			</div>
			<div class="popup contentElement" id="del" onmouseover="popUp('deltext')" onmouseout="popUp('deltext')">
				<a href="action.php?action=delete"><img id="delimg" class="actionimg" src="res/images/deletetransaction.png"/></a>
				<span id="deltext" class="text">Delete</span>
			</div>
			<div class="popup contentElement" id="view" onmouseover="popUp('viewtext')" onmouseout="popUp('viewtext')">
				<a href="action.php?action=view"><img id="viewimg" class="actionimg" src="res/images/viewtransaction.png"/></a>
				<span id="viewtext" class="text">View</span>
			</div>
			<div class="popup contentElement" id="info" onmouseover="popUp('sumtext')" onmouseout="popUp('sumtext')">
				<a href="action.php?action=info"><img id="sumimg" class="actionimg" src="res/images/infotransaction.png"/></a>
				<span id="sumtext" class="text">Summary</span>
			</div>
		</div>
	</body>
</html>
