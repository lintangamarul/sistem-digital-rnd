<!DOCTYPE html>
<html>
<head>
    <title>Schedule WhatsApp Message</title>
    <!-- Flatpickr CSS untuk date-time picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <h1>Schedule WhatsApp Message</h1>

    <!-- Tampilkan flash message jika ada -->
    <?php if(session()->getFlashdata('success')): ?>
        <p style="color: green;"><?= session()->getFlashdata('success'); ?></p>
    <?php elseif(session()->getFlashdata('info')): ?>
        <p style="color: blue;"><?= session()->getFlashdata('info'); ?></p>
    <?php endif; ?>

    <!-- Form Input Pesan Terjadwal -->
    <form action="<?= site_url('schedule-message/store'); ?>" method="post">
        <?= csrf_field() ?>
        <label>Nomor WA (misal: 08123456789):</label>
        <input type="text" name="target" required><br><br>

        <label>Pesan:</label>
        <textarea name="message" required></textarea><br><br>

        <label>Jadwal (tanggal & waktu):</label>
        <input type="text" id="schedule" name="schedule" required><br><br>

        <button type="submit">Simpan Pesan Terjadwal</button>
    </form>

    <hr>

    <!-- Tombol untuk mengirim pesan terjadwal secara manual -->
    <form action="<?= site_url('schedule-message/send-now'); ?>" method="post" style="margin-top: 20px;">
        <?= csrf_field() ?>
        <button type="submit" style="padding: 10px 20px; background-color: #28a745; color: white; border: none;">
            Kirim Pesan Sekarang
        </button>
    </form>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#schedule", {
            enableTime: true,
            dateFormat: "Y-m-d H:i"
        });
    </script>
</body>
</html>
