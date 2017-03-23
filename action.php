	<?php
	session_start();
	
	?>
	<html>
	<head>
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="style.css">
	<style>
	
	</style>
	</head>
	<body>
		<h1 align="center"> Library Management</h1>
		<?php include 'navigation.php'; ?>
		<div style="margin-left:15%;padding:1px 16px;height:100px;">
		<form method=post action=/action.php>
		<label for="name">Enter Isbn or Book or Author</label></br>
		<input type="text" name="searchBox" id="searchBox" class="textBox" value=<?php echo $_POST['searchBox']?>>
		<input type="submit" value="Search" name="Search" class="button">
		</form>
		</div>
	</body>
	<?php
	$hostname="localhost";
	$database="libraryManagement";
	$username="root";
	$password="root";
	$conn = mysqli_connect($hostname, $username, $password,$database);
		if (!$conn)
		{
			echo "here";
			die("Connection failed: " . mysqli_connect_error());
		}
		// TODO add available flag to this
		else
		{
			$sqlSearch="select b.Isbn,b.Title, a.Name from BOOK as b, AUTHORS as a, BOOK_AUTHORS as ab where a.Author_id=ab.Author_id and b.Isbn=ab.Isbn and ( a.Name like '%".$_POST['searchBox']."%' or b.Title like '%".$_POST['searchBox']."%' or b.Isbn like '%".$_POST['searchBox']."%') and b.Isbn NOT IN (select Isbn from book_loans where Date_in='0000-00-00 00:00:00')";
			//echo $sqlSearch;
			$result = $conn->query($sqlSearch);
			if ($result->num_rows > 0) {
			    // output data of each row
				$tableData="<div style='margin-left:15%;padding:1px 16px;height:300px;'><table><tr><th>ISBN</th><th>Title</th><th>Author</th><th>Check out</th></tr>";
			    while($row = $result->fetch_assoc()) {
					$tableData=$tableData."<tr><td>".$row["Isbn"]. "</td><td>" . $row["Title"]. "</td><td> " . $row["Name"]. "</td><td><a href='../checkout.php?Isbn=".$row["Isbn"]."' id=".$row["Isbn"]." >Checkout</a></td></tr>";
			    }
				$tableData=$tableData."</table></div>";
				echo $tableData;
			}
			else
			{
				echo "<div style='margin-left:15%;padding:1px 16px;'>Book Not Found (All Books Checked-out.)</div>";
			}
		}
		
	?>