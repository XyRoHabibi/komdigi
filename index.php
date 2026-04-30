<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Lapangan Padel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    $total_display = '';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_SPECIAL_CHARS);
        $hp = filter_input(INPUT_POST, 'nomor_hp', FILTER_SANITIZE_SPECIAL_CHARS);
        $tanggal = filter_input(INPUT_POST, 'tanggal_sewa', FILTER_SANITIZE_SPECIAL_CHARS);
        $jam_mulai = filter_input(INPUT_POST, 'jam_mulai', FILTER_SANITIZE_SPECIAL_CHARS);
        $jam_selesai = filter_input(INPUT_POST, 'jam_selesai', FILTER_SANITIZE_SPECIAL_CHARS);

        // Hitung durasi
        $start = new DateTime($jam_mulai);
        $end = new DateTime($jam_selesai);
        $interval = $start->diff($end);
        $hours = $interval->h + ($interval->i / 60); // jam desimal

        // Tentukan harga per jam berdasarkan hari
        $date = new DateTime($tanggal);
        $dayOfWeek = $date->format('N'); // 1 = Senin, 7 = Minggu
        if ($dayOfWeek == 6 || $dayOfWeek == 7) {
            $harga_per_jam = 500000; // Sabtu dan Minggu
        } else {
            $harga_per_jam = 350000; // Senin sampai Jumat
        }

        $total = $hours * $harga_per_jam;

        if (isset($_POST['action']) && $_POST['action'] == 'pesan') {
            include 'db.php';
            $stmt = $conn->prepare("INSERT INTO pemesanan (nama, hp, tanggal, jam_mulai, jam_selesai, total) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssi", $nama, $hp, $tanggal, $jam_mulai, $jam_selesai, $total);
            $stmt->execute();
            $stmt->close();
            $conn->close();
            $total_display = "Pemesanan berhasil! Total Tagihan: Rp " . number_format($total, 0, ',', '.');
        } elseif (isset($_POST['action']) && $_POST['action'] == 'hitung') {
            $total_display = "Total Tagihan: Rp " . number_format($total, 0, ',', '.');
        }
    }
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
        <h2 class="mb-4">Form Pemesanan Sewa Lapangan Padel</h2>
        <form method="post" action="index.php">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <div class="mb-3">
                <label for="nomor_hp" class="form-label">Nomor HP</label>
                <input type="tel" class="form-control" id="nomor_hp" name="nomor_hp" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_sewa" class="form-label">Tanggal Sewa</label>
                <input type="date" class="form-control" id="tanggal_sewa" name="tanggal_sewa" required>
            </div>
            <div class="mb-3">
                <label for="jam_mulai" class="form-label">Jam Mulai Sewa</label>
                <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
            </div>
            <div class="mb-3">
                <label for="jam_selesai" class="form-label">Jam Selesai Sewa</label>
                <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
            </div>
            <button type="submit" name="action" value="hitung" class="btn btn-primary me-2">Hitung</button>
            <button type="submit" name="action" value="pesan" class="btn btn-success">Pesan</button>
        </form>
        <?php if ($total_display): ?>
        <p class="mt-3"><?php echo $total_display; ?></p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>