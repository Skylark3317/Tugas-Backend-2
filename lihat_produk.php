<?php
require_once 'koneksi.php';

$query = "SELECT * FROM produk ORDER BY id_produk DESC";
$result = mysqli_query($koneksi, $query);

// Mendefinisikan pemetaan kategori ke ikon dan warna
$kategori_info = [
    'alatpendingin' => ['icon' => '❄️', 'badge' => 'bg-info'],
    'elektronikdapur' => ['icon' => '🏠', 'badge' => 'bg-warning text-dark'],
    'peralatan' => ['icon' => '🛠️', 'badge' => 'bg-secondary'],
    'kelistrikan' => ['icon' => '⚡', 'badge' => 'bg-danger'],
    'default' => ['icon' => '📦', 'badge' => 'bg-dark']
];

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Produk - Toko Ella</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3f37c9;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.98);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border-radius: 15px 15px 0 0 !important;
            padding: 1.5rem;
        }

        .btn {
            border-radius: 10px;
            padding: 10px 20px;
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

        .table thead th {
            background-color: #f8f9fa;
            border-bottom-width: 2px;
            font-weight: 600;
            color: #495057;
        }

        .table tbody tr:hover {
            background-color: #f1f3f5;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .badge {
            font-size: 0.9em;
            padding: 0.5em 0.8em;
        }

        /* CSS BARU: Untuk kolom deskripsi */
        .col-deskripsi {
            min-width: 250px;
            max-width: 300px;
            white-space: normal;
            word-wrap: break-word;
        }
    </style>
</head>

<body>
    <div class="container-fluid py-5 px-lg-5">
        <div class="card">
            <div class="card-header text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0"><i class="fas fa-boxes-stacked me-2"></i>Data Produk</h2>
                        <p class="mb-0 opacity-75">Toko Ella - Management System</p>
                    </div>
                    <a href="input_produk.php" class="btn btn-light">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Produk
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Nama Produk</th>
                                <!-- KOLOM HEADER BARU -->
                                <th>Deskripsi</th>
                                <th>Kategori</th>
                                <th class="text-end">Harga</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center">Status</th>
                                <th>Fitur</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <?php
                                    $kategori_key = $row['kategori'];
                                    $info = $kategori_info[$kategori_key] ?? $kategori_info['default'];
                                    ?>
                                    <tr>
                                        <td class="ps-4 fw-bold"><?php echo $row['id_produk']; ?></td>
                                        <td><?php echo htmlspecialchars($row['nama_produk']); ?></td>

                                        <!-- KOLOM DATA BARU -->
                                        <td class="col-deskripsi"><?php echo htmlspecialchars($row['deskripsi']); ?></td>

                                        <td>
                                            <span class="badge <?php echo $info['badge']; ?>">
                                                <?php echo $info['icon']; ?>
                                                <?php echo htmlspecialchars(ucfirst($kategori_key)); ?>
                                            </span>
                                        </td>
                                        <td class="text-end">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                                        <td class="text-center"><?php echo $row['stok']; ?></td>
                                        <td class="text-center">
                                            <span
                                                class="badge <?php echo $row['status'] == 'aktif' ? 'bg-success' : 'bg-danger'; ?>">
                                                <?php echo ucfirst($row['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['fitur']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <!-- Colspan disesuaikan menjadi 8 -->
                                    <td colspan="8" class="text-center p-5">
                                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                        <p class="mb-0">Belum ada data produk. Silakan tambahkan produk baru.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>