<!DOCTYPE html>
<html>
	<title>Putri - Wardrobe</title>
	<head>
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" >
		<script type="text/javascript" language="javascript" src="assets/js/jquery-3.3.1.js"></script>
		<script type="text/javascript" language="javascript" src="assets/js/bootstrap.min.js"></script>
	</head>

	<body>
		<!-- <div class="header"><h1>Stores</h1></div> -->
		<div class="container">
			<!-- content -->
			<?php
				if ($_GET['menu']=='store') {
					include 'views/storeView.php';
				}else{
					echo "home";
				}
			?>
		</div>
	</body>

	<link rel="stylesheet" type="text/css" href="assets/css/jquery.dataTables.min.css">
	<script type="text/javascript" language="javascript" src="assets/js/jquery.dataTables.min.js"></script>

</html>
