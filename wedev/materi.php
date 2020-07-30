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
$user = query("SELECT * FROM judul ORDER BY id desc");
if(isset($_POST["cari"])){
	$user = cari($_POST["keyword"]);
}
 ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="test.css">
	<title></title>
</head>
<body>
	<div class="main">
		<div class="nav">
			<li style="float: left;margin-left: 15px;font-size: 1.5em;margin-top: 10px;">NAMAWEB</li>
			<a href="bayar.php"><li style="margin-right: 15px;margin-top: 15px;">pembayaran</li></a>
			<li style="margin-right: 25px;margin-top: 15px;">Selamat belajar</li>
		</div>
		<center>
			<div class="isi">
				<?php $i = 1; ?>
				<?php foreach( $user as $row ) : ?>
				<div class="materi">
					<div class="isimateri">
						<div class="gambar"><img src="materi/<?= $row["gambar"]; ?>" style="width: 100%;height: 100%;"></div>
						<div class="judul"><?php echo $row["judul"]; ?></div>
					</div>
				</div>
				<?php $i++; ?>
				<?php endforeach; ?>
			</div>
		</center>
	</div>

</body>
</html>