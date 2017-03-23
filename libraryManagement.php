<?php
// Start the session
session_start();
?>
<html>
<head>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/3/w3.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	
	<h1 align="center"> Library Management</h1>
	<?php include 'navigation.php'; ?>
	<div style="margin-left:15%;padding:1px 16px;height:100px;">
	<form method=post action=/action.php >
	<label for="name">Enter Isbn or Book or Author</label></br>
	<input type="text" name="searchBox" id="searchBox" class="textBox"></br>
	<input type="submit" value="Search" name="Search" class="button">
	</form>
</div>
</body>
</html>
