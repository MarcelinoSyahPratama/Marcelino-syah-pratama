<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "wedev");
function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows;
}
function materi($materi){
    	global $conn;
    	$username = strtolower(stripslashes($materi["username"]));    	
    	$email = strtolower(stripslashes($materi["email"]));
    	$rekening = strtolower(stripslashes($materi["rekening"]));
    	$nominal = strtolower(stripslashes($materi["nominal"]));

    	//upload gambar
    	$gambar = upload();
    	if( !$gambar ) {
    		return false;
    	}


    	mysqli_query($conn, "INSERT INTO bayar VALUES('','$username', '$email','$rekening','$nominal', '$gambar')");
    	return mysqli_affected_rows($conn);
    }
function upload(){
	$name_file = $_FILES['gambar']['name'];
	$size_file = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmp_name = $_FILES['gambar']['tmp_name'];

	//cek upload
	if( $error === 4 ) {
		echo "<script>
				alert('Pilih Gambar Terlebih Dahulu')
			  </script>
			  ";
		return false;
	}

	//cek format file
	$format_gambar_Valid = ['jpg', 'jpeg', 'png'];
	$format_gambar = explode('.', $name_file);
	$format_gambar = strtolower(end($format_gambar));
	if(!in_array($format_gambar, $format_gambar_Valid)){
		echo "<script>
				alert('File yang Anda Upload Bukan Gambar')
			  </script>
			  ";
		return false;
	}

	//cek size image
	if( $size_file > 8000000 ) {
		echo "<script>
				alert('Ukuran Gambar Terlalu Besar')
			  </script>
			  ";
		return false;
	}

	//upload image
	//generate name image
	$new_image_name = uniqid();
	$new_image_name .='.';
	$new_image_name .= $format_gambar;

	move_uploaded_file($tmp_name, 'tf/' . $new_image_name);
	return $new_image_name;
}
$user = query("SELECT * FROM bayar ORDER BY id desc");
if ( isset($_POST["submit"]) ) {
        if(materi($_POST) > 0 ) {
            echo "	
            		<script>
            			alert('Data Berhasil Ditambahkan Harap Refresh Halaman')
            		</script>
            		";
        }else{
        	echo "	
            		<script>
            			alert('Data Gagal Ditambahkan ')
            		</script>
            		";
        }
        
    }
 ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/bayar.css">
</head>
<body>
<div class="main">
	<div class="nav">
		<li>Profil</li>
		<a href="materi.php"><li>Course</li></a>
		<li>Selamat datang <strong><?php echo $_SESSION["nama"]; ?></strong></li>
	</div>
	<center>
		<div class="box-bayar" style="width: 40%;height: 400px;background-color: red;margin-top: 100px;">
			<div class="header"><h1>Form Pembayaran</h1></div>
			<form action="" method="post" enctype="multipart/form-data">
				<ul style="display: block;list-style: none;">
				<li style="list-style: none;">
					<label for="username">username</label><br>
					<input type="text" name="username" id="username" style="width: 60%;
					height: 25px;">
				</li>
				<li>
					<label for="email">Email</label><br>
					<input type="email" name="email" id="email" style="width: 60%;
					height: 25px;">
				</li>
				<li>
					<label for="rekening">Nomor Rekening</label><br>
					<input type="text" name="rekening" id="rekening" style="width: 60%;
					height: 25px;">
				</li>
				<li>
					<label for="nominal">Jumlah transfer</label><br>
					<input type="number" name="nominal" id="nominal" style="width: 60%;
					height: 25px;">
				</li>
				<li>
					<label for="bukti">Bukti Transfer</label><br>
					<input type="file" name="gambar" id="bukti" style="width: 60%;
					height: 25px;">
				</li>
				<li>
					<button type="submit" name="submit" style="width: 55%;
					height: 30px;cursor: pointer;">Kirim</button>
				</li>
			</ul>
			</form>
		</div>
	</center>
</div>
</body>
</html>