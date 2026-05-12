<?php
class Pendidikan
{
    private $koneksi;
    public function __construct() {
        global $dbh;
        $this->koneksi = $dbh;
    }

    public function index() {
        // Mengambil semua data termasuk kolom foto terbaru
        return $this->koneksi->query("SELECT * FROM pendidikan ORDER BY id DESC");
    }

    public function simpan($data) {
        // Menambahkan placeholder ke-5 untuk kolom foto
        $sql = "INSERT INTO pendidikan (jenjang, nama_sekolah, tahun_lulus, deskripsi, foto) VALUES (?,?,?,?,?)";
        $ps = $this->koneksi->prepare($sql);
        return $ps->execute($data);
    }

    public function getPendidikan($id) {
        $sql = "SELECT * FROM pendidikan WHERE id=?";
        $ps = $this->koneksi->prepare($sql);
        $ps->execute([$id]);
        return $ps->fetch(PDO::FETCH_ASSOC);
    }

    public function ubah($data) {
        // Menyertakan foto dalam query update
        $sql = "UPDATE pendidikan SET jenjang=?, nama_sekolah=?, tahun_lulus=?, deskripsi=?, foto=? WHERE id=?";
        $ps = $this->koneksi->prepare($sql);
        return $ps->execute($data);
    }

    public function hapus($id) {
        $sql = "DELETE FROM pendidikan WHERE id=?";
        $ps = $this->koneksi->prepare($sql);
        return $ps->execute([$id]);
    }
}
?>