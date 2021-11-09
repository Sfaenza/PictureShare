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
	<div align=center id="container">
	<?php
	
	/*
		// 上传图片
		if($action=='add'){
		 
			$image = mysql_escape_string(file_get_contents($_FILES['photo']['tmp_name']));
			$type = $_FILES['photo']['type'];
			$sqlstr = "insert into photo(type,binarydata) values('".$type."','".$image."')";
		 
			@mysql_query($sqlstr) or die(mysql_error());
		 
			exit();
		 
		// 显示图片
		}elseif($action=='show'){
		 
			$id = isset($_GET['id'])? intval($_GET['id']) : 0;
			$sqlstr = "select * from photo where id=$id";
			$query = mysql_query($sqlstr) or die(mysql_error());
			
			$thread = mysql_fetch_assoc($query);
			
			if($thread){
				header('content-type:'.$thread['type']);
				echo $thread['binarydata'];
				exit();
			}
		 
		}else{
			$sqlstr = "select * from photo order by id desc";
			$query = mysql_query($sqlstr) or die(mysql_error());
			$result = array();
			while($thread=mysql_fetch_assoc($query)){
				$result[] = $thread;
			}
			foreach($result as $val){
				echo '<p><img src="upload_image_todb.php?action=show&id='.$val['id'].'&t='.time().'" width="150"></p>';
			}

		}*/
	
	?>
		<form acton="" method="POST" enctype="multipart/form-data">
		<table>
		<tr>
			<td>Title:</td><td><input type="text" name="title"  placeholder="Enter Title..." required></td>
		</tr>
		<tr>
		<td>Chose picture：</td><td><input type="file" name="picture" required /></td>
		</tr>
		<tr>
			<td>Note:</td><td>	<input type="text" name="note"  placeholder="Enter what you want to say." required><br>
		</td>
		</tr>
		</table>
		<input type="submit" name="submit" value="UpLoad" >
	</form>
	<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$title=$_POST['title'];
		$note=$_POST['note'];
		$tmp_name =$_FILES['picture']['tmp_name'];
		$name = $_FILES["picture"]["name"];
		$dest_folder = "picture/";
		if(!file_exists($dest_folder)){
		mkdir($dest_folder);
		}
		$uploadfile = $dest_folder.$name;
		move_uploaded_file($tmp_name, $uploadfile);
		$myConn = db_connection();
		$q = "INSERT INTO picture(title,note,pictureURL,time)values('$title','$note','$uploadfile',now())";
		$r = mysqli_query($myConn, $q);
		if(r){
			echo "<script>alert('UPLoad successful！')</script>";
			echo "<script>window.open('pictureshell.php', '_SELF')</script>";
		}
					

	}
	?>
	</div>
	</body>
	<?php footer();?>
</html>
