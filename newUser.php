<?php
// Start the session
session_start();?>
<html>
<head>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script>
	function popUpMessage(message)
	{
		alert(message);
	}
	function validateForm() {
	    var x = document.forms["userForm"]["fname"].value;
	    if (document.forms["userForm"]["name"].value == "") {
	        alert("Name must be filled out");
	        return false;
	    }
	    if (document.forms["userForm"]["ssn"].value == "" || document.forms["userForm"]["ssn"].length!=9) {
	        alert("Name must be filled out");
	        return false;
	    }
	</script>
</head>
<?php
// Start the session

if(isset($_POST['SubmitBtn']))
{
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
					echo "User Already Exists";
					//echo "<script>popUpMessage('User Alredy Exists')</script>";
					//redirect
					//header( 'Location: checkout.php' ) ;
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
							echo $message;
							//echo "<script>".$message1."</script>";
							//header( 'Location: checkout.php' ) ;
						}
					} 
					else 
					{
				    	echo "Please check the data SSN and Phone number must contain only digits.";
					}
					
				}
		}
}
?>
		

<body>
		
	<h1 align="center"> Library Management</h1>
	<?php include 'navigation.php'; ?>
	<div style="margin-left:15%;padding:1px 16px;height:300px;">
	<form name="userForm" method=post action="#" >
	<label for="name">Name:</label></br>
	<Input type='text' name="name" id="name" class="textBox" required></br>
	<label for="ssn">SSN:</label></br>
	<Input type='text' name="ssn" id="ssn" class="textBox" required></br>
	<label for="address">Address:</label></br>
	<Input type='text' name="address" id="address" class="textBox" required></br>
	<label for="phone">Phone No:</label></br>
	<Input type='text' name="phone" id="phone" class="textBox" required></br>
	<Input type="submit" value="Submit" name="SubmitBtn" class="button">
	</form>
	</div>
</body>
</html>
