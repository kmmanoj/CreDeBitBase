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
		<title>Action : CreDeBitBase</title>
		<link rel="stylesheet" href="res/css/style.css"/>
		<link rel="stylesheet" href="res/css/dynamism.css"/>
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
		<div class="content" id="action-container">
			<?php 
				if($_GET['action']=='add'){
					echo "
						<h2>Add Transaction</h2><hr/>
						<form method='POST' action='result.php'>
							<center>
							<script>
								document.getElementById('action-container').style.borderColor='rgb(10,200,25)';
							</script>
							<table>
								<tr>
									<td><label>Type</label></td>
									<td>:</td>
									<td>
										<select name='type' id='typeinput'> 
											<option>Income</option>
											<option>Expense</option>
										</select>
									</td>
									<td></td><td></td><td></td>
								</tr>
								<tr>
									<td><label>Client</label></td>
									<td>:</td>
									<td><input type='text' name='client' id='clientinput' min=1 /></td>
									<td colspan='2'>
										<img id='client-alert-image' class='alert-image' src='' alt=''/>
										<p id='client-alert-message' class='alert-message'> Enter the name of the other dealer</p>
									</td>
									<td></td><td></td>
								</tr>
								<tr>
									<td><label>Amount</label></td>
									<td>:</td>
									<td><input type='number' name='amount' id='amountinput' required/></td>
									<td></td><td></td><td></td>
								</tr>
								</tr>
								<tr>
									<td><label>Category</label></td>
									<td>:</td>
									<td>
										<select name='category' id='categoryinput'>
											<option>Others</option>
											<option>Entertainment</option>
											<option>Food</option>
											<option>Travel</option>
										</select>
									</td>
									<td></td><td></td><td></td>
								</tr>
								<tr>
									<td><label>Date</label></td>
									<td>:</td>
									<td><input type='date' name='date' id='dateinput' placeholder='yyyy/mm/dd' required/></td>
									<td colspan='2'>
										<img id='date-alert-image' class='alert-image' src='' alt=''/>
										<p id='date-alert-message' class='alert-message'> Enter the date of transcation</p>
									</td>
									<td></td><td></td>
								<tr id='extrafieldbutton'>
									<td></td>
									<td></td>
									<td><input id='addmore' name='addmore' type='button' value='add field'/></td>
									<td></td><td></td><td></td>
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td><input id='addbutton' name='addbutton' type='submit' value='ADD'/></td>
									<td></td><td></td><td></td>
								</tr>
							</table>
							</center>
						</form>
						<script src='res/js/addDyn.js'></script>
					";
				}
				else if($_GET['action']=='view'){
					echo "
						<h2>View Transactions</h2><hr/>
						<center>
							<table>
							<th>Client</th><th>Amount</th><th>Transaction Date</th><th>Category</th>
					";

					$transactions="SELECT * FROM ".$_SESSION['username'].";";
					$output=$conn->query($transactions);
					if($output->num_rows>0){
						while($record=$output->fetch_assoc()){
							echo "<tr><td>".$record['client']."</td>";
							if($record['amount']>0){
								echo "<td style='color: rgb(20,255,20)'>";
							} else {
								echo "<td style='color: rgb(255,40,40)'>";
							}
							echo $record['amount']."</td>";
							echo "<td>".$record['trn_date']."</td>";
							echo "<td>".$record['category']."</td></tr>";
						}
					}
					echo "
							</table>
							<hr/>
							<center>
							<table>
								<tr>
									<td><h2>Balance</h2></td>
									<td>:</td>
						";
					$balance="SELECT sum(amount) as balance FROM ".$_SESSION['username'].";";
					$output=$conn->query($balance);
					if($output->num_rows>0){
						if($record=$output->fetch_assoc()){
							$bal=$record['balance'];
							if($bal>0){
								echo "<td style='color: rgb(20,255,20)'>+ Rs.";
							} else {
								echo "<td style='color: rgb(255,40,40)'>- Rs.";
							}
							echo abs($record['balance']);
						}
					}
					echo "
									</td>
									<td></td><td></td><td></td>
								</tr>
						</center>
					";

				}
				else if($_GET['action']=='delete'){
					echo "
						<h2>Delete Transaction</h2><hr/>
						";
					// if connection error, then end the page with an error 
					if($conn->connect_error){
						die("<h1>Something Went Wrong</h1>");
					}	
					echo "
						<script>
							document.getElementById('action-container').style.borderColor='rgb(255,20,20)';
						</script>
						
						<form method='POST' action='result.php' onsubmit='return confirm(\"Are you Sure?\")'>
							<center>
							<table>
								<tr>
									<td><label>Transaction</label></td>
									<td>:</td>
									<td colspan='3'>
										<select name='transaction' id='trninput'>
						";
						$transactions="SELECT * FROM ".$_SESSION['username'].";";
						$output=$conn->query($transactions);
						if($output->num_rows>0){
							while($record=$output->fetch_assoc()){
								if($record['amount']>0){
									echo "<option>Income from ";
								}
								else{
									echo "<option>Expense on ";	
								}
								echo $record['client']." : Rs. ".abs($record['amount'])." on ".$record['trn_date']." for ".$record['category']."</option>";
							}
						}
						echo "
										</select>
									</td>
									
								</tr>
								<tr>
									<td></td>
									<td></td>
									<td><input name='delbutton' type='submit' value='DELETE'/></td>
									<td></td><td></td><td></td>
								</tr>
							</table>
							</center>
						</form>
					";

				}
				else if($_GET['action']=='info'){
					echo "
						<h2>Transactions Information Summary</h2><hr/>
						";
					// if connection error, then end the page with an error 
					if($conn->connect_error){
						die("<h1>Something Went Wrong</h1>");
					}	
					echo "	
						<center>
							<script>
								document.getElementById('action-container').style.borderColor='rgb(10,200,255)';
							</script>
							<table>
								<tr>
									<td><label>Number of Transactions</label></td>
									<td>:</td>
									<td>";

					$nooftransactions="SELECT count(*) as noft FROM ".$_SESSION['username'].";";
					$output=$conn->query($nooftransactions);
					if($output->num_rows>0){
						if($record=$output->fetch_assoc()){
							echo $record['noft'];
						}
					}
					echo "
									</td>
									<td></td><td></td><td></td>
								</tr>
								<tr>
									<td><label>Clients</label></td>
									<td>:</td>
									<td>";

					$clients="SELECT distinct(client) FROM ".$_SESSION['username'].";";
					$output=$conn->query($clients);
					if($output->num_rows>0){
						if($record=$output->fetch_assoc()){
							echo $record['client'];
						}
						while($record=$output->fetch_assoc()){
							echo ",".$record['client'];
						}
					}
					echo "
									</td>
									<td></td><td></td><td></td>
								</tr>
								<tr>
									<td><label>balance</label></td>
									<td>:</td>
						";

					$balance="SELECT sum(amount) as balance FROM ".$_SESSION['username'].";";
					$output=$conn->query($balance);
					if($output->num_rows>0){
						if($record=$output->fetch_assoc()){
							$bal=$record['balance'];
							if($bal>0){
								echo "<td style='color: rgb(20,255,20)'>+ Rs.";
							} else {
								echo "<td style='color: rgb(255,40,40)'>- Rs.";
							}
							echo abs($record['balance']);
						}
					}
					echo "
									</td>
									<td></td><td></td><td></td>
								</tr>
							</table>
						</center>
					";
				}
				else{
					echo "<h1>Something Went wrong</h1>";
				}
			?>
		</div>
	</body>
</html>
