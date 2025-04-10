<?php
class PelangganController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Menampilkan daftar pelanggan
    public function index()
    {
        $sql = "SELECT * FROM pelanggan";
        $result = $this->db->query($sql);
        $pelangganList = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $pelangganList[] = $row;
            }
        }
        include 'views/pelanggan/pelanggan_list.php';
    }

    // Menampilkan form untuk menambah pelanggan
    public function create()
    {
        include 'views/pelanggan/pelanggan_form.php'; // Memanggil form tambah pelanggan
    }

    // Menyimpan pelanggan baru ke database
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = $_POST['Nama'];
            $alamat = $_POST['Alamat'];
            $telepon = $_POST['Telepon'];
            $email = $_POST['Email'];

            if (empty($nama) || empty($alamat) || empty($telepon) || empty($email)) {
                echo "All fields are required!";
                return;
            }

            $sql = "INSERT INTO pelanggan (Nama, Alamat, Telepon, Email) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ssss", $nama, $alamat, $telepon, $email);

            if ($stmt->execute()) {
                header("Location: index.php?action=pelanggan_list");
            } else {
                echo "Error: " . $stmt->error;
            }
        }
    }

    // Menampilkan form untuk mengedit pelanggan
    public function edit($pelangganID)
    {
        $sql = "SELECT * FROM pelanggan WHERE PelangganID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $pelangganID);
        $stmt->execute();
        $result = $stmt->get_result();
        $pelanggan = $result->fetch_assoc();
        include 'views/pelanggan/pelanggan_form.php';
    }

    // Mengupdate data pelanggan
    public function update($pelangganID)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = $_POST['Nama'];
            $alamat = $_POST['Alamat'];
            $telepon = $_POST['Telepon'];
            $email = $_POST['Email'];

            if (empty($nama) || empty($alamat) || empty($telepon) || empty($email)) {
                echo "All fields are required!";
                return;
            }

            $sql = "UPDATE pelanggan SET Nama = ?, Alamat = ?, Telepon = ?, Email = ? WHERE PelangganID = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bind_param("ssssi", $nama, $alamat, $telepon, $email, $pelangganID);

            if ($stmt->execute()) {
                header("Location: index.php?action=pelanggan_list");
            } else {
                echo "Error: " . $stmt->error;
            }
        }
    }

    // Menghapus pelanggan
    public function destroy($pelangganID)
    {
        // Hapus data penjualan terkait pelanggan
        $sql = "DELETE FROM penjualan WHERE PelangganID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $pelangganID);
        $stmt->execute();

        // Hapus pelanggan
        $sql = "DELETE FROM pelanggan WHERE PelangganID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $pelangganID);

        if ($stmt->execute()) {
            header("Location: index.php?action=pelanggan_list");
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>
