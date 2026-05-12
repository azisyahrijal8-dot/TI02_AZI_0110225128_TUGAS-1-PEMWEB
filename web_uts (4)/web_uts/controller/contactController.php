<?php
session_start();

// Load Library PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load file PHPMailer yang kita letakkan di folder PHPMailer
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email_from = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Instansiasi PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Pengaturan Server (Gmail SMTP)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';            // Server Gmail
        $mail->SMTPAuth   = true;                         // Aktifkan auth
        $mail->Username   = 'azisyahrijal8@gmail.com';   // Email Pengirim (Akun Anda)
        // !!! MASUKKAN KODE APP PASSWORD 16 HURUF DI SINI !!!
        $mail->Password   = 'ticr wqdy dwpt pyys';       
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enkripsi SSL
        $mail->Port       = 465;                         // Port Gmail

        // Pengaturan Penerima & Pengirim
        $mail->setFrom('azisyahrijal8@gmail.com', 'Portofolio Website');
        $mail->addAddress('azisyahrijal8@gmail.com', 'Azi Syahrijal'); // Email tujuan (Anda sendiri)
        $mail->addReplyTo($email_from, $name); // Reply ke pengirim form

        // Isi Email
        $mail->isHTML(false); // Kirim sebagai teks biasa agar aman
        $mail->Subject = $subject;
        $mail->Body    = "Nama: $name\nEmail: $email_from\n\nPesan:\n$message";

        // Kirim Email
        $mail->send();

        // Sukses
        $alertType = "success";
        $alertTitle = "Terkirim!";
        $alertText = "Pesan telah berhasil terkirim ke inbox Anda.";
        $nextUrl = "../index.php?hal=contact";

    } catch (Exception $e) {
        // Gagal (Cek Koneksi Internet / Password Salah)
        $alertType = "error";
        $alertTitle = "Gagal Mengirim";
        $alertText = "Error: " . $mail->ErrorInfo;
        $nextUrl = "../index.php?hal=contact";
    }
} else {
    header("Location: ../index.php?hal=home");
    exit;
}
?>
<!-- Wrapper HTML -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Sending...</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <script>
    Swal.fire({
        title: '<?= $alertTitle ?>',
        text: '<?= $alertText ?>',
        icon: '<?= $alertType ?>',
        timer: 3000,
        showConfirmButton: false
    }).then(() => {
        window.location = '<?= $nextUrl ?>';
    });
    </script>
</body>

</html>