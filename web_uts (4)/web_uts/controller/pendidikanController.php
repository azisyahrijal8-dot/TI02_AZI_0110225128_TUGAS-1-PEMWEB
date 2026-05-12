<?php
session_start();
include_once '../koneksi.php';
include_once '../models/Pendidikan.php';

$obj = new Pendidikan();
$proses = $_POST['proses'] ?? '';

if ($proses) {
    // Menangkap input foto dari form
    $foto = $_POST['foto']; 
    
    // Menyusun array data (jenjang, sekolah, tahun, deskripsi, foto)
    $data = [$_POST['jenjang'], $_POST['nama_sekolah'], $_POST['tahun_lulus'], $_POST['deskripsi'], $foto];

    switch ($proses) {
        case 'simpan':
            $obj->simpan($data);
            $alertType = "success";
            $alertTitle = "Berhasil!";
            $alertText = "Data pendidikan dan foto berhasil disimpan.";
            $nextUrl = "../index.php?hal=pendidikan_list";
            break;
        case 'ubah':
            $data[] = $_POST['id']; // ID untuk klausa WHERE
            $obj->ubah($data); 
            $alertType = "success";
            $alertTitle = "Berhasil!";
            $alertText = "Data pendidikan berhasil diperbarui.";
            $nextUrl = "../index.php?hal=pendidikan_list";
            break;
        case 'hapus':
            $obj->hapus($_POST['id']);
            $alertType = "success";
            $alertTitle = "Terhapus!";
            $alertText = "Data pendidikan telah dihapus.";
            $nextUrl = "../index.php?hal=pendidikan_list";
            break;
        default:
            header("Location: ../index.php?hal=home");
            exit;
    }
} else {
    header("Location: ../index.php?hal=home");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Processing...</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
    Swal.fire({
        title: '<?= $alertTitle ?>',
        text: '<?= $alertText ?>',
        icon: '<?= $alertType ?>',
        timer: 1500,
        showConfirmButton: false
    }).then(() => {
        window.location = '<?= $nextUrl ?>';
    });
    </script>
</body>
</html>