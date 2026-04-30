<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemesanan Lapangan Padel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    include 'db.php';
    $result = $conn->query("SELECT * FROM pemesanan ORDER BY waktu_pesan DESC");
    ?>
    <header class="bg-light py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <img src="assets/logo.png" alt="Logo" class="img-fluid" style="width: 100px; height: auto;">
                </div>
                <div class="col-md-6 text-end">
                    <a href="index.php" class="btn btn-outline-primary me-2">Pemesanan</a>
                    <a href="riwayat.php" class="btn btn-outline-secondary">Riwayat</a>
                </div>
            </div>
        </div>
    </header>

    <div class="container mt-5">
        <h2 class="mb-4">Riwayat Pemesanan Sewa Lapangan Padel</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>HP</th>
                    <th>Tanggal</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Total (Rp)</th>
                    <th>Waktu Pesan</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['hp']; ?></td>
                    <td><?php echo $row['tanggal']; ?></td>
                    <td><?php echo $row['jam_mulai']; ?></td>
                    <td><?php echo $row['jam_selesai']; ?></td>
                    <td><?php echo number_format($row['total'], 0, ',', '.'); ?></td>
                    <td><?php echo $row['waktu_pesan']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>