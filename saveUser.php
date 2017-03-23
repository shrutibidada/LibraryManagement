<?php
session_start();
echo now();
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script>
	function popUpMessage(message)
	{
		alert(message);
	}
	</script>
</head>
<body>
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
	// TODO add available flag to this
	else{
		$sqlCheckssn="select * from BORROWER where Ssn=".$_POST['ssn'];
		$result = $conn->query($sqlCheckssn);
		if ($result->num_rows > 0)
			{
				echo "<script>popUpMessage('User Alredy Exists')</script>";
				//redirect
				header( 'Location: checkout.php' ) ;
			} 
			else
			{
				$sqlNewUser= "INSERT into BORROWER VALUES ('',".$_POST['ssn'].",'".$_POST['name']."','".$_POST['address']."',".$_POST['phone'].")";
				if ($conn->query($sqlNewUser) === TRUE)
				{
				    $sqlReturnCardId="select Card_id from BORROWER where Ssn=".$_POST['ssn'];
					$resultCardId = $conn->query($sqlReturnCardId);
					if($resultCardId->num_rows==1)
					{
						$row = $resultCardId->fetch_assoc();
						$message="New User Created, Card Id for user:".$row['Card_id'];
						$message1="popUpMessage('".$message."')";
						echo "<script>".$message1."</script>";
						header( 'Location: checkout.php' ) ;
					}
				} 
				else 
				{
				    
				}
					
			}
	}
?>
</body>
</html>