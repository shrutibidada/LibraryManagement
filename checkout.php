<?
session_start();
$_SESSION['Isbn']=$_GET['Isbn'];
//echo $_SESSION['bookId'];
?>
<html>
<head>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
	if(isset($_POST['SubmitButton']))
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
			else
			{
				$sqlLoanBook="Select count(*) as countBooks from BOOK_LOANS where Card_id=".$_POST['cardNo']." and Date_in='0000-00-00 00:00:00'";
				//echo $sqlLoanBook;
				$sqlCheckBookAvailable="Select * from BOOK_LOANS where Date_in='0000-00-00 00:00:00' and Isbn=".$_SESSION['Isbn'];
				$bookAvailableCheck=$conn->query($sqlCheckBookAvailable);
				if($bookAvailableCheck->num_rows>0)
				{
					echo "Book Not available";
				}
				else
				{
					$result = $conn->query($sqlLoanBook);
					//echo $result->num_rows;
					if ($result->num_rows >= 0)
					{
						//echo $result->num_rows;
						if($result->num_rows>=1)
						{
							$row = $result->fetch_assoc();
							//echo $row['countBooks'];
							if($row['countBooks']>=3)
							{
								echo "Cannot Issue, User already has 3 books Issued";
							}
							else
							{
								$dateOut= date('Y-m-d h:i:s');
								$d=strtotime("+14 days");
								$dueDate=date("Y-m-d h:i:s", $d);
								$sqlIssueBook="Insert into BOOK_LOANS values('',".$_SESSION['Isbn'].",".$_POST['cardNo'].",now(),now()+INTERVAL 14 DAY,'')";
								//echo $sqlIssueBook;
								if ($conn->query($sqlIssueBook) === TRUE)
								{
									echo "Book Issued";
								}
								else
								{
									echo "invalid Action";
								}	
							}
						}
						else
						{
							$dateOut= date('Y-m-d h:i:s');
							$d=strtotime("+14 days");
							$dueDate=date("Y-m-d h:i:s", $d);
							$sqlIssueBook="Insert into BOOK_LOANS values('',".$_SESSION['Isbn'].",".$_POST['cardNo'].",now(),now()+INTERVAL 14 DAY,'')";
							//echo $sqlIssueBook;
							if ($conn->query($sqlIssueBook) === TRUE)
							{
								echo "Book Issued";
							}
							else
							{
								echo "invalid insert"+$conn->error;
							}	
						}
					}
				}
			}	
	}
?>
	<h1 align="center"> Library Management</h1>
	<?php include 'navigation.php'; ?>
	<div style="margin-left:15%;padding:1px 16px;height:300px;">
	<form method=post action='#' align='center'>
		<label for="bookId">Book Id</label>
		<Input type='text' name="bookId" id="bookId" class="textBox" value=<?php echo $_SESSION['Isbn'] ?>></br>
		<label for="cardNo">Card No</label>
		<Input type='text' name="cardNo" id="cardNo" class="textBox"></br>
		<a href='checkIn.php'>Check-In</a>
		<Input type="submit" value="Submit" name="SubmitButton" class="button">
		<Input type="button" value="New User" name="NewUser" class="button" onClick="location.href='/newUser.php'">
	</form>
</div>
</body>
</html>