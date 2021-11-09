
<html>
<?php include "includes/functions.php";  head();?>

<body>

  <div align='center'>
	<?php
		if ($_SERVER['REQUEST_METHOD'] == 'POST')  {	
			
			if(isset($_POST['reset'])) { 

				$myConn = DB_connection();
				
				$email = $_POST['email'];
				
				$q = "SELECT * FROM users WHERE Email = '$email'";
				
				$r = mysqli_query($myConn, $q);

				
				if (mysqli_num_rows($r) == 1) {
					$row = mysqli_fetch_array($r);
					$email = $row['Email'];
					$name = $row['Name'];
					
					//get temp password with a length of 8 characters
					$length = 8;
					$temp_psword = randomString($length);
					
					//hashing the temp password
					$temp_psword_hashed = SHA1($temp_psword);
					
	     			//change password to the new one
					$update = "UPDATE users SET password = '$temp_psword_hashed' WHERE Email = '$email'";
					$u = mysqli_query($myConn, $update);
					if (!$u)
						echo "Something Wrong";
					else {		//send the new password to user's email account
						$to = $email;
						$subject = 'New Password for Monmouth Online Registration System';
						$message = "Hi ". $name .", \n\nYou have been assigned a temporary password [ ". $temp_psword . " ]";
						$headers = 'From: IEEE System' . "\r\n" .
    								'Reply-To: ' . "\r\n" .
    								'X-Mailer: PHP/' . phpversion();
						mail($to, $subject, $message, $headers);
						echo "<p class='err'>".$temp_psword." An email with a temporal password has been sent to you.</p>";
					}
					
				}
				else {
					echo "<p class='err'>Your email does not exist! Please enter again!</p>";
				}
			}
		}
	?>
	
	
	<form action = "" method = "POST">
		<p>
			<h2>Please enter your email here. A temporary password will be sent to your email account.</h2>
		</p>

		<input type = "text" name = "email" value = <?php echo $email; ?> ><br><br>

		<input type = "submit" name = "reset" value = "Reset" >
	</form>
	<a href="javascript:history.go(-1)"><input type = "submit" name = "back" value = "Back" ></a><br>

	
	</div>
  </div>
</body>
	<?php footer();?>
</html>