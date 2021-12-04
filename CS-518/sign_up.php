
<html>
	<?php include "includes/functions.php";  head();?>

	<body>		
	<?php
		

		
		echo '<div align="center">';
		 
		//process form data
		//if no problem, insert them to database and then display the data in the users table
		if ($_SERVER['REQUEST_METHOD'] =='POST'){

			$err = array();   //to store all error messages

			//retrieve form data
			$email = $_POST['email'];
			$password = $_POST['password'];
			$cpassword = $_POST['cpassword'];
			$name = $_POST['name'];

			
			
			if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/", $email)){
				$err['email']="Invalid email.";
			}
			$myConn=db_connection();
			$E="SELECT * FROM users where Email='$email'";
			$r=mysqli_query($myConn, $E);
			if(mysqli_num_rows($r) > 0)$err['email']="Email has been registered";
					
			
			//数字字母下划线
			if(!preg_match("/^([A-Z]|[a-z]|\d|_){8,}$/", $password)){
				$err['password']="Invalid password,More than 8 digits,Only alphanumeric underscores.";
			}
	
		/* Jill
				if(!preg_match("/^\w{8,}$/", $psword)|| !preg_match("/[a-zA-Z]{7,}/", $psword) || !preg_match("/_+/", $psword) || preg_match("/[0-9]/", $psword)) {
					$err['password'] = "Invalid password";
				}	
		*/
				
			//two passwords matach?
			if($password!=$cpassword){
				$err['cpassword']="Does not match the password.";
			}
			
			//if first letter starts uppercase the code begins with [A-Z]([A-Z]|[a-z])
			//contains enlgish letters only
			if(!preg_match("/^([A-Z]|[a-z])+$/", $name)){
				$err['name']="Invalid name.";
			}
			
			if (empty($err)){
					//form data okay. insert to the users table.
					
					//connect to the server
					$myConn=db_connection();
					
					//define the insert query

					$q="INSERT INTO users (Email, Password, Name)
					VALUES ('$email',SHA('$password'), '$name')";
					
					
					//execute the query
					$r=mysqli_query($myConn, $q);

					//if data inserted successfully, display the users table
					//this is for testing only. removed it when the code is finalized.
					//it can be implemented as view_users.php
					if($r){
						
						echo "<script>alert('Sing up successful！');</script>";
						echo "<script>window.open('index.php', '_SELF')</script>";
						}
					
					else {
						//the insertion action is failed
						echo "Inserting data to table is failed111.";
					}
					}
			}

		
	?>
<!-- // above ends the php code  -->

<!-- // below sets up the input setup for the data and notes all info is required -->
		<h3> Sign Up</h3>

		<p class="err">* All fields required</p>

		<!-- //allows data to be inputed throughout  -->
		<form action="" method="post">
<!-- //creates data for userID input and the
The * reminds user it is required  -->
<!-- //creates data for email input  -->
			<input type="text" name="email" value="<?php echo $_POST['email'];?>"
			placeholder="email..." required>
				<span class="err">*<?php echo $err['email'] ?></span><br>
<!-- //creates data for password  -->
			<input type="text" name="password" value="<?php echo $_POST['password'];?>"
			placeholder="password..." required>
				<span class="err">*<?php echo $err['password']; ?></span><br>
				
<!-- //creates data to re-confirm the passsword  -->
			<input type="text" name="cpassword" value="<?php echo $_POST['cpassword'];?>"
			placeholder="confirm password..." required>
				<span class="err">*<?php echo $err['cpassword']; ?></span><br>
				
<!-- //creates data for name input  -->
			<input type="text" name="name" value="<?php echo $_POST['name'];?>"
			placeholder="name..." required>
				<span class="err">*<?php echo $err['name']; ?></span><br>

<br>
<!-- //creates submit button -->
				<input type="submit" name='submit' value="Submit">
		</form>
		<a href="javascript:history.go(-1)"><input type = "submit" name = "back" value = "Back" ></a><br>
	</div> <!-- container -->
</body>
<?php footer();?>
</html>
