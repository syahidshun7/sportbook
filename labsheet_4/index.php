<?php
// =========================================
// LABSHEET 4 - Object-Oriented Programming
// =========================================

// -----------------------------
// Tugas 1: Class Mahasiswa
// -----------------------------
class Mahasiswa
{
    
    public string $nama;
    public string $nim;
    public string $jurusan;

    
    public function __construct(string $nama, string $nim, string $jurusan)
    {
        $this->nama = $nama;
        $this->nim = $nim;
        $this->jurusan = $jurusan;
    }

   
    public function tampilkanInfo(): string
    {
        return "Nama: {$this->nama}, NIM: {$this->nim}, Jurusan: {$this->jurusan}";
    }
}

// Contoh instansiasi object Mahasiswa
echo "<h3>Tugas 1 - Mahasiswa</h3>";
$mahasiswa1 = new Mahasiswa("Syahid Hussein", "2443908", "Teknik Informatika");
echo $mahasiswa1->tampilkanInfo() . "<br><br>";

// -----------------------------
// Tugas 2: Class Pegawai
// -----------------------------
class Pegawai
{
    // Properties (public)
    public string $nama;
    public string $jabatan;

    // Constructor untuk set nilai awal
    public function __construct(string $nama, string $jabatan)
    {
        $this->nama = $nama;
        $this->jabatan = $jabatan;
        echo "Object Pegawai {$this->nama} berhasil dibuat.<br>";
    }

    // Method tambahan untuk menampilkan data pegawai
    public function tampilkanInfo(): string
    {
        return "Nama: {$this->nama}, Jabatan: {$this->jabatan}";
    }

    // Destructor untuk membersihkan object
    public function __destruct()
    {
        echo "Object Pegawai {$this->nama} telah dihapus.<br>";
    }
}

// Contoh instansiasi object Pegawai
echo "<h3>Tugas 2 - Pegawai</h3>";
$pegawai1 = new Pegawai("Siti Rahma", "Staff Administrasi");
echo $pegawai1->tampilkanInfo() . "<br>";

// unset agar destructor terlihat saat program berjalan
unset($pegawai1);
echo "<br>";
   
class Karyawan
{
    // Properties parent class
    public string $nama;
    public float $gaji;

    // Constructor parent
    public function __construct(string $nama, float $gaji)
    {
        $this->nama = $nama;
        $this->gaji = $gaji;
    }
}

class Manager extends Karyawan
{
    // Property tambahan pada child class
    public float $tunjangan;

    // Constructor child menggunakan parent::__construct()
    public function __construct(string $nama, float $gaji, float $tunjangan)
    {
        parent::__construct($nama, $gaji);
        $this->tunjangan = $tunjangan;
    }

    // Method untuk menghitung total gaji manager
    public function hitungTotalGaji(): float
    {
        return $this->gaji + $this->tunjangan;
    }
}

// Contoh instansiasi object Manager
echo "<h3>Tugas 3 - Inheritance (Karyawan & Manager)</h3>";
$manager1 = new Manager("Andi Wijaya", 7000000, 2500000);
echo "Nama: {$manager1->nama}, Gaji Pokok: Rp " . number_format($manager1->gaji, 0, ',', '.') . ", Tunjangan: Rp " . number_format($manager1->tunjangan, 0, ',', '.') . "<br>";
echo "Total Gaji: Rp " . number_format($manager1->hitungTotalGaji(), 0, ',', '.') . "<br><br>";

// -----------------------------
// Tugas 4: Polymorphism
// -----------------------------
class Hewan
{
    // Method dasar yang akan dioverride oleh class anak
    public function suara(): string
    {
        return "Hewan mengeluarkan suara.";
    }
}

class Kucing extends Hewan
{
    // Override method suara() pada class Kucing
    public function suara(): string
    {
        return "Kucing: Meong!";
    }
}

class Anjing extends Hewan
{
    // Override method suara() pada class Anjing
    public function suara(): string
    {
        return "Anjing: Guk guk!";
    }
}

// Contoh instansiasi object untuk polymorphism
echo "<h3>Tugas 4 - Polymorphism (Hewan)</h3>";
$hewan1 = new Kucing();
$hewan2 = new Anjing();

echo $hewan1->suara() . "<br>";
echo $hewan2->suara() . "<br>";
?>
