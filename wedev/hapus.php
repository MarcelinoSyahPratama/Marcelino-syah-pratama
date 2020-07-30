<?php
require 'admin_materi.php';

$id = $_GET["id"];

if(hapus($id) > 0 ){
    echo "
    <script>
        alert('data berhasil di hapus!');
        document.location.href = 'admin_materi.php';
    </script>";
}
else{
    echo "
    <script>
        alert('data gagal berhasil di hapus!');
        document.location.href = 'admin_materi.php';
    </script>";
}

?>