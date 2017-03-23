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
	<?php
		
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
		//$updateFinePaid="update FINES set Paid=1 WHERE Loan_id IN (SELECT Loan_id FROM BOOK_LOANS AS B WHERE B.Loan_id AND B.Card_id=".$_GET['card_id'].") AND Paid=0";
		$updateFinePaid="update FINES set Paid=1 WHERE Loan_id IN (".$_SESSION['listofLoanId'].") AND Paid=0";
		
		if($conn->query($updateFinePaid)===TRUE)
			{
				echo "<div style='margin-left:15%;padding:1px 16px;'>Fine paid balance $ 0</br><a href=/libraryManagement.php>Home</a></div>";
				
			}	
	}
	?>
</body>
</html>
