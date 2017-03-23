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
		<input type="text" name="cardNo" class="textBox" value=<?php echo $_POST['cardNo'];?>></br>
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
			$sqlSearch="SELECT DISTINCT(Book_loans.Isbn) as Isbn, BOOK.Title as Title,Date_out ,Date_in, Fine_amt,Paid FROM `FINES`, BOOK_AUTHORS,BOOK_LOANS, BOOK,AUTHORS where FINES.Loan_id=BOOK_LOANS.Loan_id and BOOK_LOANS.Isbn=BOOK_AUTHORS.Isbn and BOOK_AUTHORS.Isbn=BOOK.Isbn AND BOOK_AUTHORS.Author_id=AUTHORS.Author_id and BOOK_LOANS.card_id=".$_POST['cardNo'];
			//echo $sqlSearch;
			$result = $conn->query($sqlSearch);
			if ($result->num_rows > 0) {
			    // output data of each row
				$tableData="<div style='margin-left:15%;padding:1px 16px;height:300px;'><table><tr><th>ISBN</th><th>Title</th><th>Date_out</th><th>Date_in</th><th>Fine Amount</th><th>Paid</th></tr>";
			    while($row = $result->fetch_assoc()) {
					if($row['Paid']==1)
					$tableData=$tableData."<tr><td>".$row["Isbn"]. "</td><td>" . $row["Title"]. "</td><td>".$row['Date_out']."</td><td>".$row['Date_in']."</td><td>".$row['Fine_amt']."</td><td>True</td></tr>";
					else
						$tableData=$tableData."<tr><td>".$row["Isbn"]. "</td><td>" . $row["Title"]. "</td><td>".$row['Date_out']."</td><td>".$row['Date_in']."</td><td>".$row['Fine_amt']."</td><td>false</td></tr>";
			    }
				$tableData=$tableData."</table></div>";
				echo $tableData;
			}
		
		}
		
	}
	?>
</body>
</html>