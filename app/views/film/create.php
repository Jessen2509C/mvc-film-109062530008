<?php /** @var array $errors */ /** @var array $old */ ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Film</title>
</head>
<body>
    <h2>Tambah Film</h2>

    <?php if (!empty($errors)): ?>
        <div style="color:red; border:1px solid red; padding:8px; margin-bottom:12px;">
            <strong>Data gagal disimpan:</strong>
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="index.php?page=film&action=store">
        <label>Judul</label><br>
        <input type="text" name="judul" maxlength="150" required
               value="<?= htmlspecialchars($old['judul'] ?? '') ?>"><br><br>

        <label>Sutradara</label><br>
        <input type="text" name="sutradara" maxlength="100" required
               value="<?= htmlspecialchars($old['sutradara'] ?? '') ?>"><br><br>

        <label>Genre</label><br>
        <input type="text" name="genre" maxlength="50" required
               value="<?= htmlspecialchars($old['genre'] ?? '') ?>"><br><br>

        <label>Tahun Rilis</label><br>
        <input type="number" name="tahun_rilis" min="1888" required
               value="<?= htmlspecialchars($old['tahun_rilis'] ?? '') ?>"><br><br>

        <label>Durasi (menit)</label><br>
        <input type="number" name="durasi" min="1" max="999" required
               value="<?= htmlspecialchars($old['durasi'] ?? '') ?>"><br><br>

        <label>Rating (0 - 10)</label><br>
        <input type="number" name="rating" min="0" max="10" step="0.1" required
               value="<?= htmlspecialchars($old['rating'] ?? '') ?>"><br><br>

        <button type="submit">Simpan</button>
        <a href="index.php?page=film">Kembali</a>
    </form>
</body>
</html>