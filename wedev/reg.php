<?php 
require 'functions.php';

if( isset($_POST["register"]) ) {

	if( registrasi($_POST) > 0 ) {
		echo "<script>
				alert('Anda berhasil melakukan registrasi')
				</script>";
	}else {
		echo mysqli_error($conn);
	}
}

 ?>
 <!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/reg.css">
	<title>Register</title>
</head>
<body>
	<div class="main">
		<div class="nav">
			<li style="float: left;"><h3>WEDEV Course</h3></li>
		</div>
		<center>
			<div class="box-login">
				<div class="box-ganti">
					<div class="login"><a href="login.php"><h2>Login</h2></a></div>
					<div class="regis"><h2>Registrasi</h2></div>
				</div>
				<div class="box-input">
					<strong><h1>Login</h1></strong>
					<form action="" method="post">
						<ul>
							<li>
								<label for="nama">nama :</label>
								<input type="text" name="nama">
							</li>
							<li>
								<label for="email">email :</label>
								<input type="email" name="email">
							</li>
							<li>
								<label for="password">password :</label>
								<input type="password" name="password">
							</li>
							<li>
								<label for="repassword">repassword :</label>
								<input type="password" name="repassword">
							</li>
							<li>
								<button type="submit" name="register">Register</button>
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