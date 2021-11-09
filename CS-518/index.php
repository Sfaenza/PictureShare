<html>
<?php include "includes/functions.php";  head();?>
<body>
	<?php
		//before user log in, make sure no session is on
		session_start();
		$_SESSION = array();    //clean up session variables
		session_destroy();    //distroy possible existing session
	
		//clean up cookies
		setcookie('email');
		setcookie('name');
				

		

			
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			//retrieve form data
			$email = $_POST['email'];
			$psword = SHA1($_POST['psword']);
		
			//connect to database
			$myConn = db_connection();
			
			//define a query to select the record for the userid				
			$q = "SELECT * FROM users WHERE Email = '$email'";
				
			//execute the query, return data is referenced by $r
			$r = mysqli_query($myConn, $q);
					
			//find the record, cannot be more than one because userid is the primary key
			if (mysqli_num_rows($r) == 1){
				//save the record to an array $row
				$row = mysqli_fetch_array($r);
				//check if the password input ($psword) matches the one stored in the table ($row['password'])
				if ($psword == $row['Password']){
					session_start();
								
					//set session variables
					$_SESSION['email'] = $email;
					$_SESSION['name'] = $row['Name'];
					
					//set cookies, will expire in 10 seconds
					//if you want them to expire in one hour, then just replace 10 with 3600
					$cookie_duration = 3600;
					setcookie('email', $email, time()+$cookie_duration);
					setcookie('name', $row['Name'], time()+$cookie_duration);
								
					//check the role of user
					
						echo "<script>window.open('pictureshell.php', '_SELF')</script>";
						exit();

				}
				else
					echo "<p class='err'>Incorrect password.</p>";				
			}
			else
				echo "<p class='err'>Email not found.</p>";	 
		}
	?>	
	
	<div align='center'>
	<h1>CS-518 picture shell</h1>
	<form acton="" method="POST">
			

			<input type="text" name="email" value="<?php echo $_POST['email'] ?>" placeholder="Enter your E-mail..." required><br>
			<input type="password" name="psword" placeholder="Enter your password..." required><br>
			<input type="submit" name="submit" value="Log in" >	
			<br><br>
		   	<p> Forgot your password? <a href = reset_psword.php>Click here to reset your password.</a> </p>
			
			<p> Not a user yet? <a href = sign_up.php>Click here to sign up.</p></a>
	</form>
	</div>   <!-- container -->

	
<body>
<?php footer();?>
</html>



