<?php
	function dropdown_menu($asc_array,$selected){
		foreach($asc_array as $key=>$value){
			//echo "<option value=$key>$value</option>";
			echo "<option ";
			if($key==$selected)echo "selected='selected'";
			echo "value=$key>$value</option>";
		}
	}
	function dropdown_menu_2($asc_array,$selected){
		foreach($asc_array as $value){
			//echo "<option value=$key>$value</option>";
			echo "<option ";
			if($value==$selected)echo "selected='selected'";
			echo "value=$value>$value</option>";
		}
	}
	function head(){
		echo '<head>
		  <meta charset="utf-8">
		  <meta content="width=device-width, initial-scale=1.0" name="viewport">

		  <title>CS-518 picture shell</title>
		  <meta content="" name="description">
		  <meta content="" name="keywords">

		  <!-- Google Fonts -->
		  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

		  <!-- Vendor CSS Files -->
		  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
		  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
		  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
		  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
		  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

		  <!-- Template Main CSS File -->
		  <link href="assets/css/style.css" rel="stylesheet">

		</head>';
		
	}
	function navigation(){
		
		session_start();
            
				echo '<header id="header" class="d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="index.php">Pictuers Shell</a></h1><br>
	  <!--Uncomment below if you prefer to use an image logo -->
	   <!--<a href="index.html" class="logo"><img src="img/logo.png" alt=""></a>-->

      <nav id="navbar" class="navbar">
        <ul>';
           		$email = $_SESSION['email'];
				$name = $_SESSION['name'];
				
			
				echo '<li><a class = "nav-link scrollto" href = "pictureshell.php">Pictuers</a></li>';
				echo '<li><a class = "nav-link scrollto" href = "upload.php">Upload picture</a></li>';
				echo '<li><a class = "nav-link scrollto" href = "changing_pasword.php?email='.$email.'">Change Password</a></li>';
            		
            	//allow user to log out
            	echo '<li class = "nav"><a href = "index.php">Log Out</a></li>'; 

				
				//a welcome message for logged-in user
            	echo '<li class = "navWelcome">Welcome, '.$name.' !</li>';  

		echo '</ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->';
	}
	
	
	//function db_connection(){   //for Mac
	//	$myConn = mysqli_connect("localhost", "root", "root", "IEEESystem")
	//					or die("Connection failed");
	//	return $myConn;
	//}
	
	function db_connection(){	//for Windows
		$port = 3306;
		//$myConn = mysqli_connect("localhost", "root", "root", "IEEESystem")or die("Connection failed");
		//$myConn = mysqli_connect("127.0.0.1:3306", "s1317086", "s1317086","registration_s1317086") or die("Connection failed");
		$myConn = mysqli_connect("pictureshare.cwmi4nutxyng.us-east-1.rds.amazonaws.com", "admin", "MonmouthHawks", "pictureshare")or die("Connection failed");				
		return $myConn;
	}
	function randomString($length){
		$characters='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength=strlen($characters);
		$randomString='';
		for ($i=0;$i<$length;$i++){
			$randomString .=$characters[rand(0,$charactersLength-1)];
		}
		return $randomString;
	}
	
	function footer(){
	echo '<footer id="footer">
			<div class="container py-4">
			  <div class="copyright">
				&copy; Copyright <strong><span>CS-518 picture shell</span></strong>
			  </div>
			</div>
		  </footer><!-- End Footer -->

		  <div id="preloader"></div>
		  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

		  <!-- Vendor JS Files -->
		  <script src="assets/vendor/aos/aos.js"></script>
		  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
		  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
		  <script src="assets/vendor/php-email-form/validate.js"></script>
		  <script src="assets/vendor/purecounter/purecounter.js"></script>
		  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
		  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>

		  <!-- Template Main JS File -->
		  <script src="assets/js/main.js"></script>';
	}
	function CreateProjectID($year,$applyyear){
		$myConn=db_connection();
		$q="SELECT count(ID) FROM projectplan WHERE AYear = '$year'";
		$r=mysqli_query($myConn, $q);
		if($r){
			$row=mysqli_fetch_assoc($r);
			$count=$row['count(ID)']+1;
			$projectid=$year."-".sprintf("%02d",$count)."-".($applyyear+1);
		}
		return $projectid;
	}
?>