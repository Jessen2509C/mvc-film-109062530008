<?php /** @var array $films */ /** @var array|null $flash */ ?> ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Film</title>
</head>
<body>
    <h2>Daftar Film</h2>
    <a href="index.php?page=film&action=create">Tambah Film</a>
    <br><br>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Sutradara</th>
            <th>Genre</th>
            <th>Tahun</th>
            <th>Durasi</th>
            <th>Rating</th>
            <th>Aksi</th>
        </tr>

        <?php if (empty($films)): ?>
            <tr>
                <td colspan="8">Belum ada data film.</td>
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
                <td>
                    <a href="index.php?page=film&action=edit&id=<?= (int) $f['id'] ?>">Edit</a>
                    <form method="post"
                          action="index.php?page=film&action=delete"
                          style="display:inline"
                          onsubmit="return confirm('Hapus film ini?')">
                        <input type="hidden" name="id" value="<?= (int) $f['id'] ?>">
                        <button type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>