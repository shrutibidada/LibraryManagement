<?php
session_start();
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script>
	
	
	</script>	
</head>
<body>
	<h1 align="center"> Library Management</h1>
	<?php include 'navigation.php'; ?>
	<div style="margin-left:15%;padding:1px 16px;height:100px;">
		<form method=post action='#' >
		<label for="name">Card No:</label></br>
		<input type="text" name="cardNo" class="textBox"></br>
		<input type="submit" value="Check" name="check" class="button">
		</form>
	</div>
	<?php
	if(isset($_POST['check']))
	{
		//echo "<div style='margin-left:15%;padding:1px 16px;'>here</div>";
		$hostname="localhost";
		$database="libraryManagement";
		$username="root";
		$password="root";
		$conn = mysqli_connect($hostname, $username, $password,$database);
		if (!$conn)
		{
			die("Connection failed: " . mysqli_connect_error());
		}
		else
		{
			//echo "<div style='margin-left:15%;padding:1px 16px;'>here".$_POST['cardNo']."</div>";
			$sql="select f.fine_amt as due, f.loan_id  as loan_id from fines as f, book_loans as bl where f.loan_id=bl.loan_id and paid=0 and card_id=".$_POST['cardNo'];
			$data=$conn->query($sql);
			$fine=0;
			$loadIdToBeCheckedIn="";
			if($data->num_rows>0)
			{
				while($row=$data->fetch_assoc())
				{
					if($loadIdToBeCheckedIn!=="")
					{
						$loadIdToBeCheckedIn=$loadIdToBeCheckedIn.",";	
					}
					$loadIdToBeCheckedIn=$loadIdToBeCheckedIn.$row['loan_id'];
					$fine=$fine+$row['due'];
				}
				$_SESSION["payerId"]=$_POST['cardNo'];
				$_SESSION["due"]=$fine;
				$_SESSION["listofLoanId"]=$loadIdToBeCheckedIn;
				$message= "amount due for ".$POST['cardNo']." is $".$fine."</br>";
				$message=$message."<a href=/payAmt.php?due=".$fine."&card_id=".$_POST['cardNo']."> Pay</a>";
				echo "<div style='margin-left:15%;padding:1px 16px;'>".$message."</div>";
			}
			else
			{
				echo "<div style='margin-left:15%;padding:1px 16px;'>No Dues.</div>";
			}
			
		}
		
	}
	?>
</body>
</html>
