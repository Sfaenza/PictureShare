
<html>
<?php include "includes/functions.php";  head();?>

<body>
	<?php
		if(!isset($_COOKIE['email']) ){
			echo "<script>window.open('index.php', '_SELF')</script>";
			exit();
		}
		else {
			$email = $_COOKIE['email'];
		}
		navigation();
	?>

  <div align = center id = "container">
	<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		$err = array();
		
		$curtpsd=$_POST['curtpsd'];
		$myConn = db_connection();
		$q = "SELECT * FROM users WHERE Email = '$email'";
		$r = mysqli_query($myConn, $q);
		if (mysqli_num_rows($r) == 1){
			$row = mysqli_fetch_array($r);
			if (SHA1($curtpsd) != $row['Password']){
				$err['curtpsd']="error current password.";
			}
		}
		
		$newpsd=$_POST['newpsd'];
		if(!preg_match("/^([A-Z]|[a-z]|\d|_){8,}$/", $newpsd)){
			$err['newpsd']="Invalid password";
		}
		$conmpsd=$_POST['conmpsd'];
		if($newpsd!=$conmpsd){
			$err['conmpsd']="Does not match the password.";
		}
		if($newpsd==$curtpsd){
			$err['psdsame']="Same as the original password.";
		}
		if (empty($err)){
			
			$q="UPDATE users SET Password=SHA('$newpsd') WHERE Email='$email'";
			$r=mysqli_query($myConn, $q);
			if($r){
				$_POST=array();
				echo "<script>alert('Please log in again after successful modification！')</script>";
				echo "<script>window.open('index.php', '_SELF')</script>";
			}
			else {
				echo "Inserting data to table is failed.";
			}
		}
		
	}
	?>
	
	
	<form action = "" method = "POST">
		<h3>Change password:</h3>
		<p class='err'>*All fields required</p>
		<p class='err'><?php echo $err['psdsame'] ?></p>
		<input type = "text" name = "curtpsd" value="<?php echo $_POST['curtpsd'];?>" placeholder="current password"><span class='err'>*<?php echo $err['curtpsd'] ?></span><br><br>
		<input type = "text" name = "newpsd" value="<?php echo $_POST['newpsd'];?>" placeholder="new password"><span class='err'>*<?php echo $err['newpsd'] ?></span><br><br>
		<input type = "text" name = "conmpsd" value="<?php echo $_POST['conmpsd'];?>" placeholder="confirm new password"><span class='err'>*<?php echo $err['conmpsd'] ?></span><br><br>
		<input type = "submit" name = "submit" value = "Submit" />
	</form>

	
	</div>
  </div>
</body>
	<?php footer();?>
</html>