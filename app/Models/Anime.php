<?php
namespace app\Models;

include_once __DIR__ . '/../Config/DatabaseConfig.php';

use app\Config\DatabaseConfig;
use mysqli;
use Exception;

class Anime extends DatabaseConfig {
    public $conn;

    public function __construct() {
        // connect ke database mysql
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database_name, $this->port);
        
        // check koneksi
        if ($this->conn->connect_error) {
            die("Connection Failed: " . $this->conn->connect_error);
        }
    }

    // Function menampilkan semua data
    public function findAll() {
        $sql = "SELECT * FROM datanime";
        $result = $this->conn->query($sql);
    
        if ($result === false) {
            // Tangani error query
            return [
                "error" => $this->conn->error,
                "message" => "Error executing query"
            ];
        }
    
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    
        return $data;
    }    

    // Function menampilkan data dengan id
    public function findById($id) {
        $sql = "SELECT * FROM datanime WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $this->conn->close();
        return $data;
    }

    // Function untuk membuat data baru
    public function create($data) {
        // Cek apakah tabel kosong
        $checkEmptyQuery = "SELECT COUNT(*) as total FROM datanime";
        $result = $this->conn->query($checkEmptyQuery);
        $row = $result->fetch_assoc();
    
        // Jika tabel kosong, reset auto-increment ke 1
        if ($row['total'] == 0) {
            $resetQuery = "ALTER TABLE datanime AUTO_INCREMENT = 1";
            $this->conn->query($resetQuery);
        }
    
        // Data yang akan dimasukkan
        $AnimeName = $data['anime_name'];
        $Type = $data['type'];
        $Status = $data['status'];
        $ImageUrl = $data['image_url'];
    
        // Query untuk insert data
        $query = "INSERT INTO datanime (anime_name, type, status, image_url) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
    
        if (!$stmt) {
            return ["success" => false, "error" => $this->conn->error];
        }
    
        // Bind parameter
        $stmt->bind_param("ssss", $AnimeName, $Type, $Status, $ImageUrl);
        $success = $stmt->execute();
    
        if ($success) {
            $insertedId = $stmt->insert_id; // Ambil ID yang terakhir dimasukkan
            $stmt->close();
            return ["success" => true, "id" => $insertedId];
        } else {
            $stmt->close();
            return ["success" => false, "error" => $stmt->error];
        }
    }    

    // Function untuk update data
    public function update($data, $id) {
        $AnimeName = $data['anime_name'];
        $Type = $data['type'];
        $Status = $data['status'];
        $ImageUrl = $data['image_url'];

        $query = "UPDATE datanime SET anime_name = ?, type = ?, status = ?, image_url = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssi", $AnimeName, $Type, $Status, $ImageUrl, $id);
        $stmt->execute();
        $this->conn->close();
    }

    // Function delete data dengan id
    public function delete($id) {
        if (strpos($id, '-') !== false) {
            // ID adalah rentang
            $ids = explode('-', $id);
            $startId = (int)$ids[0];
            $endId = (int)$ids[1];
    
            // Cek apakah rentang ID valid
            if (is_int($startId) && is_int($endId)) {
                // Cek apakah data dengan rentang ID ada
                $checkQuery = "SELECT COUNT(*) FROM datanime WHERE id BETWEEN ? AND ?";
                $stmt = $this->conn->prepare($checkQuery);
                $stmt->bind_param("ii", $startId, $endId);
                $stmt->execute();
                $stmt->bind_result($count);
                $stmt->fetch();
    
                // Menutup statement setelah selesai
                $stmt->close();
    
                if ($count > 0) {
                    // Data ada, hapus
                    $query = "DELETE FROM datanime WHERE id BETWEEN ? AND ?";
                    $stmt = $this->conn->prepare($query);
                    $stmt->bind_param("ii", $startId, $endId);
                    $stmt->execute();
    
                    // Menutup statement setelah eksekusi query DELETE
                    $stmt->close();
    
                    return ["success" => true, "message" => "Data berhasil dihapus."];
                } else {
                    return ["success" => false, "message" => "Data tidak ditemukan."];
                }
            } else {
                return ["success" => false, "message" => "Rentang ID tidak valid."];
            }
        } else {
            // ID tunggal
            $id = (int)$id;
            if (is_int($id)) {
                // Cek apakah data ada
                $checkQuery = "SELECT COUNT(*) FROM datanime WHERE id = ?";
                $stmt = $this->conn->prepare($checkQuery);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->bind_result($count);
                $stmt->fetch();
    
                // Menutup statement setelah selesai
                $stmt->close();
    
                if ($count > 0) {
                    // Data ada, hapus
                    $query = "DELETE FROM datanime WHERE id = ?";
                    $stmt = $this->conn->prepare($query);
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
    
                    // Menutup statement setelah eksekusi query DELETE
                    $stmt->close();
    
                    return ["success" => true, "message" => "Data berhasil dihapus."];
                } else {
                    return ["success" => false, "message" => "Data tidak ditemukan."];
                }
            } else {
                return ["success" => false, "message" => "ID tidak valid."];
            }
        }
    }    
}
