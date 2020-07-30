<?php 
//koneksi ke database
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

function registrasi($data){
	global $conn;

	$nama = strtolower($data["nama"]);
	$email = strtolower(stripcslashes($data["email"]));
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$repassword = mysqli_real_escape_string($conn, $data["repassword"]);


	//cek ketersediaan email
	$result = mysqli_query($conn, "SELECT email FROM user WHERE email = '$email' ");

	if( mysqli_fetch_assoc($result) ) {
		echo "<script>
				alert('email sudah terdaftar')
				</script>";
				return false;
	}

	//cek konfirmasi password

	if( $password !== $repassword) {
		echo "<script>
				alert('konfirmasi password tidak sama')
				</script>";
		return false;
	}

 // enkripsi password

$password = password_hash($password, PASSWORD_DEFAULT);

 //tambah user ke database
mysqli_query($conn, "INSERT INTO user VALUES('', '$nama', '$email', '$password', 'user')");
return mysqli_affected_rows($conn);
}


 ?>
