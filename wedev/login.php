<?php 
require 'functions.php';
session_start();

if( isset($_POST["login"]) ) {

	$email = $_POST["email"];
	$password = $_POST["password"];

	$result = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email' ");

	//cek username
	if( mysqli_num_rows($result) === 1 ) {
		//cek password
		$row = mysqli_fetch_assoc($result);
		if( password_verify($password, $row["password"]) ) {
			// set session
			$_SESSION["login"] = true;
			$_SESSION["nama"] = $row["nama"];
			$level = $row["level"] == 'user';
			$pengisi = $row["level"] == 'pengisi';
			if($level) {
			header("Location:materi.php");
			}elseif($pengisi){
			header("Location:pengisi.php");
			}else {
			header("Location:admin.php");
			exit;
			}
		}
	}

$error = true;
}

 ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<title>login</title>
</head>
<body>
	<div class="main">
		<div class="nav">
			<li style="float: left;"><h3>WEDEV Course</h3></li>
		</div>
		<center>
			<div class="box-login">
				<div class="box-ganti">
					<div class="login"><h2>Login</h2></div>
					<div class="regis"><a href="reg.php" style="text-decoration: none;"><h2>Registrasi</h2></a></div>
				</div>
				<div class="box-input">
					<strong><h1>Login</h1></strong>
					<form action="" method="post">
						<ul>
							<li>
								<label for="email" style="font-size: 1.5em;">email :</label>
								<input type="email" name="email" >
							</li>
							<li>
								<label for="password" style="font-size: 1.5em;">password :</label>
								<input type="password" name="password">
							</li>
							<li>
								<button type="submit" name="login">Login</button>
							</li>
							<li><p style="float: right;color: red;">forgot password</p></li>
						</ul>
					</form>
				</div>
			</div>
		</center>
	</div>
</body>
</html>