<?php

class Database
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "toko_ella";
    public $koneksi;

    public function __construct()
    {
        $this->koneksi = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

        if ($this->koneksi->connect_error) {
            die("Koneksi gagal: " . $this->koneksi->connect_error);
        }

        $this->koneksi->set_charset("utf8");
    }
}

//  instance 
$database = new Database();
$koneksi = $database->koneksi;
?>