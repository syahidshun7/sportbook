<?php
class Mahasiswa
{
    public string $nama;
    public string $nim;
    public string $jurusan;
    public string $cv;

    public function __construct(string $nama, string $nim, string $jurusan, string $cv = '')
    {
        $this->nama = trim($nama);
        $this->nim = trim($nim);
        $this->jurusan = trim($jurusan);
        $this->cv = trim($cv);
    }

    public static function fromLine(string $line): ?self
    {
        $line = trim($line);
        if ($line === '') {
            return null;
        }

        $parts = explode('|', $line);
        $nama = $parts[0] ?? '';
        $nim = $parts[1] ?? '';
        $jurusan = $parts[2] ?? '';
        $cv = $parts[3] ?? '';

        return new self($nama, $nim, $jurusan, $cv);
    }

    public function toLine(): string
    {
        return implode('|', [$this->nama, $this->nim, $this->jurusan, $this->cv]);
    }
}
