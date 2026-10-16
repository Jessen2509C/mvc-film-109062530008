<?php /** @var array $film */ /** @var array $errors */ ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Film</title>
</head>
<body>
    <h2>Edit Film</h2>

    <?php if (!empty($errors)): ?>
        <div style="color:red; border:1px solid red; padding:8px; margin-bottom:12px;">
            <strong>Data gagal diperbarui:</strong>
            <ul>
                <?php foreach ($errors as $e): ?>
                    <li><?= htmlspecialchars($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="index.php?page=film&action=update">
        <input type="hidden" name="id" value="<?= (int) $film['id'] ?>">

        <label>Judul</label><br>
        <input type="text" name="judul" maxlength="150" required
               value="<?= htmlspecialchars($film['judul']) ?>"><br><br>

        <label>Sutradara</label><br>
        <input type="text" name="sutradara" maxlength="100" required
               value="<?= htmlspecialchars($film['sutradara']) ?>"><br><br>

        <label>Genre</label><br>
        <input type="text" name="genre" maxlength="50" required
               value="<?= htmlspecialchars($film['genre']) ?>"><br><br>

        <label>Tahun Rilis</label><br>
        <input type="number" name="tahun_rilis" min="1888" required
               value="<?= htmlspecialchars($film['tahun_rilis']) ?>"><br><br>

        <label>Durasi (menit)</label><br>
        <input type="number" name="durasi" min="1" max="999" required
               value="<?= htmlspecialchars($film['durasi']) ?>"><br><br>

        <label>Rating (0 - 10)</label><br>
        <input type="number" name="rating" min="0" max="10" step="0.1" required
               value="<?= htmlspecialchars($film['rating']) ?>"><br><br>

        <button type="submit">Update</button>
        <a href="index.php?page=film">Kembali</a>
    </form>
</body>
</html>