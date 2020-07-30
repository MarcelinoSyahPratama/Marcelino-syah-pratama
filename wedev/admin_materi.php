<?php
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
    	$judul = strtolower(stripslashes($materi["judul"]));
    	$link = strtolower(stripslashes($materi["link"]));

    	//upload gambar
    	$gambar = upload();
    	if( !$gambar ) {
    		return false;
    	}


    	mysqli_query($conn, "INSERT INTO judul VALUES('', '$judul','$link', '$gambar')");
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

	move_uploaded_file($tmp_name, 'materi/' . $new_image_name);
	return $new_image_name;
}
$user = query("SELECT * FROM judul ORDER BY id desc");
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
 <textarea id="printing-css" style="display:none;">.no-print{display:none}</textarea>
<iframe id="printing-frame" name="print_frame" src="about:blank" style="display:none;"></iframe>
<script type="text/javascript">
function printDiv(elementId) {
 var a = document.getElementById('printing-css').value;
 var b = document.getElementById(elementId).innerHTML;
 window.frames["print_frame"].document.title = document.title;
 window.frames["print_frame"].document.body.innerHTML = '<style>' + a + '</style>' + b;
 window.frames["print_frame"].window.focus();
 window.frames["print_frame"].window.print();
}
</script>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/adminmateri.css">
	<title></title>
</head>
<body>
	<div class="main">
		<div class="nav">
			<li>logout</li>
			<li>Selamat datang <strong> Admin</strong></li>
		</div>
		<div class="side">
			<center>
				<li>Tambah Materi</li>
				<li>User Daftar</li>
				<li>User Terkonfirmasi</li>
				<li>User Bayar</li>
				<li>User Aktif</li>
			</center>
		</div>
		<div class="isi">
			<div class="tambah">
				<form action="" method="post" enctype="multipart/form-data">
					<li>
						<label>Masukkan Judul</label>
						<input type="text" name="judul">
					</li>
					<li>
						<label>Masukkan Link</label>
						<input type="text" name="link">
					</li>
					<li>
						<label>Upload Gambar</label>
						<input type="file" name="gambar">
					</li>
					<li>
						<button type="submit" name="submit">Tambah Materi</button>
					</li>
				</form>
			</div>
			<div class="list" id="table">
				<div id="print"><a href="javascript:printDiv('table');"><button>PRINT!</button></a></div>
					<center>
						<h1>Materi</h1>
				<table border="1" cellpadding="10" cellspacing="0">
					<tr>
						<th>No</th>
						<th>Judul Materi</th>
						<th>Link</th>
						<th>Tanggal</th>
						<th>Gambar</th>
						<th>Aksi</th>
					</tr>
					<?php $i = 1 ?>
					<?php foreach ($user as $row) : ?>
					<tr>
						<td><?= $i ?></td>
						<td><?php echo $row["judul"]; ?></td>
						<td><?php echo $row["link"]; ?></td>
						<td><?php echo date("d/F/Y"); ?></td>
						<td><img src="materi/<?= $row["gambar"]; ?>" style="width: 80px;height: 80px;"></td>
						<td><p>|Ubah|</p><a href="hapus.php"><p>|Hapus|</p></a></td>
						
					</tr>
					<?php $i++; ?>
					<?php endforeach; ?>
				</table>
			</center>
			</div>
		</div>
	</div>
</body>
</html>