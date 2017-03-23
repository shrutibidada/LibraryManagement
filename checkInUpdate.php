<?php
session_start();?>
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
if(isset($_POST['checkIn']))
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
		$sqlCheckin="select Loan_id,bo.Isbn as Isbn, title from Book as bo, BOOK_LOANS as bl where bl.Isbn=bo.Isbn and Date_in='0000-00-00 00:00:00' and Card_id=".$_SESSION["cardNo"];
		$bookCheckOutQuery=$conn->query($sqlCheckin);
		$loadIdToBeCheckedIn="";
		$fine=0;
		//echo "her1";
		if($bookCheckOutQuery->num_rows>0)
		{
			while($row = $bookCheckOutQuery->fetch_assoc())
			{
				//echo "here2";
				if($_POST[$row['Loan_id']]=='on')
				{
					
					if($loadIdToBeCheckedIn!=="")
					{
						
						$loadIdToBeCheckedIn=$loadIdToBeCheckedIn.",";
						
					}
					
					$loadIdToBeCheckedIn=$loadIdToBeCheckedIn.$row['Loan_id'];
					//echo $loadIdToBeCheckedIn;
					$sqlUpdateCheckIn= "Update BOOK_LOANS set Date_in=now() where Loan_Id =".$row['Loan_id'];
					if ($conn->query($sqlUpdateCheckIn) === TRUE)
					{
						$fineQuery="select DATEDIFF(Date_in,Date_out) as days from BOOK_LOANS where Loan_id=".$row['Loan_id'];
						$noOFDays=$conn->query($fineQuery);
						$rowFine=$noOFDays->fetch_assoc();
						if($rowFine['days']>14)
						{
							$fine=($rowFine['days']-14)*0.25;
						}
						$fineQueryChck="select * from fines where Loan_id= ".$row['Loan_id'];
						$chkEntry=$conn->query($fineQueryChck);
						if($chkEntry->num_rows==0)
						{
							if($fine==0)
							{
								$sqlInsert="insert into fines values(".$row['Loan_id'].",".$fine.",1)";
							}
							else
							{
								$sqlInsert="insert into fines values(".$row['Loan_id'].",".$fine.",0)";
							}
							if($conn->query($sqlInsert)===TRUE)
							{
								//echo "<div style='margin-left:15%;padding:1px 16px;'>Book Checked In and fine updated</br></div>";
							}
						}
						else
						{
								$sqlInsert="update fines set fine_amt=".$fine." where Loan_id=".$row['Loan_id'];
								$conn->query($sqlInsert);
								if($conn->query($sqlInsert)===TRUE)
								{
									//echo "<div style='margin-left:15%;padding:1px 16px;'>Book Checked In and fine updated</br></div>";
								}
						}
						
					}
						
					//echo "here1";
				}	
				//echo "here111";
			}
			//echo "here11";
			echo "<div style='margin-left:15%;padding:1px 16px;'>Book Checked In and fine updated</br></div>";
			$_SESSION["listofLoanId"]=$loadIdToBeCheckedIn;
			//echo $loadIdToBeCheckedIn;
			$totalFine="SELECT sum(Fine_amt) as totalDue, BOOK_LOANS.Card_id as card_id from FINES,BOOK_LOANS where FINES.Paid='0'and FINES.Loan_id=BOOK_LOANS.Loan_id and FINES.Loan_id in (".$loadIdToBeCheckedIn.") GROUP BY (SELECT DISTINCT(BOOK_LOANS.Card_id) from BOOK_LOANS where Loan_id in (".$loadIdToBeCheckedIn."))";
			//echo $totalFine;
			$payFine=$conn->query($totalFine);
			$rowPay=$payFine->fetch_assoc();
			if($rowPay['totalDue']=="")
				$_SESSION["due"]=0;
			else
			$_SESSION["due"]=$rowPay['totalDue'];
			$message= "amount due for ".$rowPay['card_id']." is $".$_SESSION["due"]."</br>";
			$_SESSION["payerId"]=$rowPay['card_id'];
			
			$message=$message."<a href=/payAmt.php?due=".$_SESSION["due"]."&card_id=".$rowPay['card_id']."> Pay</a>";
			echo "<div style='margin-left:15%;padding:1px 16px;'>".$message."</div>";
			
			
		}
		
	}
}
?>
