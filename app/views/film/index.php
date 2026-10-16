<?php /** @var array $films */ ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Film</title>
</head>
<body>
    <h2>Daftar Film</h2>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Sutradara</th>
            <th>Genre</th>
            <th>Tahun</th>
            <th>Durasi</th>
            <th>Rating</th>
        </tr>

        <?php if (empty($films)): ?>
            <tr>
                <td colspan="7">Belum ada data film.</td>
            </tr>
        <?php endif; ?>

        <?php foreach ($films as $i => $f): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= htmlspecialchars($f['judul']) ?></td>
                <td><?= htmlspecialchars($f['sutradara']) ?></td>
                <td><?= htmlspecialchars($f['genre']) ?></td>
                <td><?= htmlspecialchars($f['tahun_rilis']) ?></td>
                <td><?= htmlspecialchars($f['durasi']) ?> menit</td>
                <td><?= htmlspecialchars($f['rating']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>