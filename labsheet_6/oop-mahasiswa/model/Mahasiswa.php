<?php
namespace Model;

class Mahasiswa {
    private $conn;
    private $table_name = "mahasiswa";

    public $nama;
    public $nim;
    public $jurusan;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function simpan() {
        $query = "INSERT INTO " . $this->table_name . " (nama, nim, jurusan)
                  VALUES (:nama, :nim, :jurusan)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nama", $this->nama);
        $stmt->bindParam(":nim", $this->nim);
        $stmt->bindParam(":jurusan", $this->jurusan);

        return $stmt->execute();
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function update($id) {
        $query = "UPDATE " . $this->table_name . " SET nama = :nama, nim = :nim, jurusan = :jurusan WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nama", $this->nama);
        $stmt->bindParam(":nim", $this->nim);
        $stmt->bindParam(":jurusan", $this->jurusan);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }

    public function hapus($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
