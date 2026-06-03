<?php
require_once __DIR__ . '/../models/Mahasiswa.php';
require_once __DIR__ . '/../repositories/MahasiswaRepository.php';
require_once __DIR__ . '/../../config/Database.php';

class MahasiswaController {
    private $repo;

    public function __construct() {
        $db = (new Database())->getConnection();
        $this->repo = new MahasiswaRepository($db);
    }

    public function index() {
        $data = $this->repo->getAll();
        require __DIR__ . '/../views/mahasiswa/index.php';
    }

    public function search() {
        $keyword = $_GET['keyword'] ?? '';
        $data = $this->repo->search($keyword);
        require __DIR__ . '/../views/mahasiswa/index.php';
    }

    public function create() {
        require __DIR__ . '/../views/mahasiswa/create.php';
    }

    public function store() {
        $m = new Mahasiswa();
        $m->nim = $_POST['nim'];
        $m->nama = $_POST['nama'];
        $m->prodi = $_POST['prodi'];
        $this->repo->insert($m);
        header("Location: ?action=index");
    }

    public function edit($id) {
        $mhs = $this->repo->findById($id);
        require __DIR__ . '/../views/mahasiswa/edit.php';
    }

    public function update($id) {
        $m = new Mahasiswa();
        $m->id = $id;
        $m->nim = $_POST['nim'];
        $m->nama = $_POST['nama'];
        $m->prodi = $_POST['prodi'];
        $this->repo->update($m);
        header("Location: ?action=index");
    }

    public function delete($id) {
        $this->repo->delete($id);
        header("Location: ?action=index");
    }
}
