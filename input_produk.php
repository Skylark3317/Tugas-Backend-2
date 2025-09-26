<?php
// File: input_produk.php (Updated with Better UI)

require_once 'Form.class.php';
require_once 'koneksi.php';

session_start();

// Pesan notifikasi
if (!isset($_SESSION['pesan'])) {
    $_SESSION['pesan'] = '';
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi dan sanitasi data
    $nama_produk = mysqli_real_escape_string($koneksi, $_POST['nama_produk'] ?? '');
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi'] ?? '');
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori'] ?? '');
    $harga = floatval(str_replace('.', '', $_POST['harga'] ?? 0)); // Hapus format ribuan sebelum konversi
    $stok = intval($_POST['stok'] ?? 0);
    $status = mysqli_real_escape_string($koneksi, $_POST['status'] ?? 'aktif');
    $fitur = isset($_POST['fitur']) ? implode(", ", $_POST['fitur']) : '';
    $password_input = mysqli_real_escape_string($koneksi, $_POST['password_input'] ?? '');

    // Validasi data required
    if (empty($nama_produk) || empty($deskripsi) || empty($kategori) || empty($password_input)) {
        $_SESSION['pesan'] = "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                                <i class='fas fa-exclamation-triangle'></i> Harap lengkapi semua field yang wajib diisi!
                                <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                              </div>";
    } else {
        // Enkripsi password sebelum disimpan (lebih aman)
        $hashed_password = password_hash($password_input, PASSWORD_DEFAULT);

        // Query insert
        $stmt = $koneksi->prepare("INSERT INTO produk (nama_produk, deskripsi, kategori, harga, stok, status, fitur, password_input) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdisss", $nama_produk, $deskripsi, $kategori, $harga, $stok, $status, $fitur, $hashed_password);

        if ($stmt->execute()) {
            $_SESSION['pesan'] = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                                    <i class='fas fa-check-circle'></i> <strong>Berhasil!</strong> Data produk berhasil disimpan! ID: " . $stmt->insert_id . "
                                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                  </div>";
        } else {
            $_SESSION['pesan'] = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                                    <i class='fas fa-times-circle'></i> <strong>Error!</strong> " . $stmt->error . "
                                    <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                                  </div>";
        }

        $stmt->close();
    }
    header("Location: input_produk.php");
    exit();
}

// Opsi untuk form dengan icon
$kategori_options = [
    'alatpendingin' => '❄️ Alat Pendingin',
    'elektronikdapur' => '🏠 Elektronik Dapur',
    'peralatan' => '🛠️ Peralatan',
    'kelistrikan' => '⚡ Kelistrikan'
];

$status_options = [
    'aktif' => '✅ Aktif',
    'nonaktif' => '❌ Nonaktif'
];

$fitur_options = [
    'promo' => '🎯 Promo',
    'emoney' => '💳 E-Money',
    'cod' => '📦 COD (Cash on Delivery)',
    'ewallet' => '📱 E-Wallet'
];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Produk - Toko Ella</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --light-bg: #f8f9fa;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .card-header {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border-radius: 15px 15px 0 0 !important;
            padding: 1.5rem;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            transition: all 0.3s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }

        .btn {
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border: none;
        }

        .btn-primary:hover {
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.4);
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        .section-title {
            color: var(--primary-color);
            border-left: 4px solid var(--primary-color);
            padding-left: 10px;
            margin: 20px 0 15px 0;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card">
                    <div class="card-header text-white text-center">
                        <h2 class="mb-0"><i class="fas fa-box-open me-2"></i>Input Data Produk</h2>
                        <p class="mb-0 opacity-75">Toko Ella - Management System</p>
                    </div>
                    <div class="card-body p-4">
                        <?php
                        if (!empty($_SESSION['pesan'])) {
                            echo $_SESSION['pesan'];
                            $_SESSION['pesan'] = '';
                        }
                        ?>

                        <?php
                        $form = new Form("", "POST");
                        echo $form->startForm('class="needs-validation" novalidate');
                        ?>

                        <div class="section-title">Informasi Dasar Produk</div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama_produk" class="form-label"><i class="fas fa-tag me-1"></i>Nama
                                    Produk</label>
                                <input type="text" name="nama_produk" id="nama_produk" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="kategori" class="form-label"><i
                                        class="fas fa-sitemap me-1"></i>Kategori</label>
                                <select name="kategori" id="kategori" class="form-select" required>
                                    <option value="" disabled selected>Pilih Kategori...</option>
                                    <?php foreach ($kategori_options as $value => $text): ?>
                                        <option value="<?php echo $value; ?>"><?php echo $text; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label"><i class="fas fa-align-left me-1"></i>Deskripsi
                                Produk</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="section-title">Detail Harga & Stok</div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="harga" class="form-label"><i class="fas fa-money-bill-wave me-1"></i>Harga
                                    (Rp)</label>
                                <input type="text" name="harga" id="harga" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stok" class="form-label"><i class="fas fa-boxes me-1"></i>Stok</label>
                                <input type="number" name="stok" id="stok" class="form-control" min="0" required>
                            </div>
                        </div>

                        <div class="section-title">Status & Fitur</div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label d-block"><i class="fas fa-toggle-on me-1"></i>Status</label>
                                <?php
                                foreach ($status_options as $value => $text) {
                                    echo "
                                    <div class='form-check form-check-inline'>
                                        <input class='form-check-input' type='radio' name='status' id='status_{$value}' value='{$value}' " . ($value == 'aktif' ? 'checked' : '') . ">
                                        <label class='form-check-label' for='status_{$value}'>{$text}</label>
                                    </div>";
                                }
                                ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label d-block"><i class="fas fa-star me-1"></i>Fitur Produk</label>
                                <?php
                                foreach ($fitur_options as $value => $text) {
                                    echo "
                                    <div class='form-check'>
                                        <input class='form-check-input' type='checkbox' name='fitur[]' id='fitur_{$value}' value='{$value}'>
                                        <label class='form-check-label' for='fitur_{$value}'>{$text}</label>
                                    </div>";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="section-title">Keamanan</div>

                        <div class="mb-3">
                            <label for="password_input" class="form-label"><i class="fas fa-lock me-1"></i>Password
                                Input</label>
                            <input type="password" name="password_input" id="password_input" class="form-control"
                                required>
                        </div>

                        <div class="mt-4 pt-3 border-top text-center">
                            <button type="submit" class="btn btn-primary btn-lg me-2">
                                <i class="fas fa-save me-2"></i>Simpan Produk
                            </button>
                            <button type="reset" class="btn btn-outline-secondary btn-lg me-2">
                                <i class="fas fa-redo me-2"></i>Reset Form
                            </button>
                            <a href="lihat_produk.php" class="btn btn-success btn-lg">
                                <i class="fas fa-list me-2"></i>Lihat Data
                            </a>
                        </div>

                        <?php echo $form->endForm(); ?>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <small class="text-white opacity-75">
                        <i class="fas fa-copyright me-1"></i> Gilang Pamungkas | <i class="fas fa-code me-1"></i>
                        V3424027
                    </small>

                    <div class="text-center mt-4">
                        <small class="text-white opacity-75">
                            </i> Styling pakai AI
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            (function () {
                'use strict';
                window.addEventListener('load', function () {
                    var forms = document.getElementsByClassName('needs-validation');
                    Array.prototype.filter.call(forms, function (form) {
                        form.addEventListener('submit', function (event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();

            const hargaInput = document.getElementById('harga');
            hargaInput.addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value) {
                    e.target.value = new Intl.NumberFormat('id-ID').format(value);
                }
            });
        </script>
</body>

</html>