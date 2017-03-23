<?php
session_start();
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script>
	/*var checkedList=[];
	function onChangeHandler(val)
	{
		checkedList.push(val);
		alert(checkedList);
	}
	function checkIn()
	{
		alert("in checkin");
		
	}*/
	</script>	
</head>
<body>
	<h1 align="center"> Library Management</h1>
	<?php include 'navigation.php'; ?>
<div style="margin-left:15%;padding:1px 16px;height:100px;">
	<form method=post action='#' >
	<label for="name">Card No:</label></br>
	<input type="text" name="cardNo" class="textBox" value=<?php echo $_POST['cardNo'];?>></br>
	<input type="submit" value="Check" name="check" class="button">
	</form>
</div>
</body>
<?php

if(isset($_POST['check']))
{
	$_SESSION["cardNo"]=$_POST['cardNo'];
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
		$sqlCheckin="select Loan_id,bo.Isbn as Isbn, title from Book as bo, BOOK_LOANS as bl where bl.Isbn=bo.Isbn and Date_in='0000-00-00 00:00:00' and Card_id=".$_SESSION["cardNo"];
		$bookCheckOutQuery=$conn->query($sqlCheckin);
		if($bookCheckOutQuery->num_rows>0)
		{
			$data="<div style='margin-left:15%;padding:1px 16px;'><form action='/checkInUpdate.php' method=post><table><tr><th></th><th>Isbn</th><th>Title</th></tr>";
			while($row = $bookCheckOutQuery->fetch_assoc())
			{
				$data=$data."<tr><td><input type='checkbox' name='".$row['Loan_id']."'></td><td>".$row['Isbn']."</td><td>".$row['title']."</td></tr>";
			}
			$data=$data."</table>";
			echo $data."<input type='submit' value='Check-In' name='checkIn' class='button' ></form></div>";
		}
		else
		{
			echo "<div style='margin-left:15%;padding:1px 16px;'>No Books to check In</div>";
		}
	}
}
	
?>
</html>