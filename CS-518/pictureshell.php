<html>
	<?php include "includes/functions.php";  head();?>
	<body>
	<?php 
		session_start();
		if(empty($_SESSION)){
			//$_SESSION is empty, user has not logged in. redirect to the login papge
			echo "<script>window.open('index.php', '_SELF')</script>";
			exit();
        }

		navigation();
	
	?>
	<div align=center >
	<?php
	$myConn = db_connection();
	$q = "SELECT * FROM picture ORDER BY ID desc";
	$r = mysqli_query($myConn, $q);
	if(mysqli_num_rows($r)>0){
		echo "<table  align='centre' id='tbl'>";
	/*	echo "<tr><th width= 100>Title</th><tr>";
		echo "<th >Picture</th>";
		echo "<th width= 100>Note</th>";
		echo "</tr>";*/
		while($row=mysqli_fetch_assoc($r)){
				echo "<tr><th colspan=2>".$row['title']."</th></tr>";
				echo '<tr><td><img src="'.$row['pictureURL'].'" alt=""></td></tr>';
				echo "<tr><td >".$row['note']."</td></tr>";
				echo "</tr>";
		}
		echo "</table>";
	}
	else {
		echo "nothing found";
	}
			
	?>
	</div>
	</body>
	<?php footer();?>
</html>