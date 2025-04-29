<!-- filepath: /home/etudiant/fe240547/TP/s2/s2.03_install_services_reseaux/docker-sae203/html/upload.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de fichiers</title>
    <link rel="stylesheet" href="../styles/styles.css">
</head>

<body>
    <header>
        <a href="index.php" class="logo">Rot<span>Hub</span></a>
    </header>

    <main>
        <h2>Uploader une vidéo ou une image</h2>
        <form action="../php/upload_handler.php" method="POST" enctype="multipart/form-data">
            <label for="title">Titre :</label>
            <input type="text" id="title" name="title" placeholder="Titre du fichier" required>

            <label for="file">Fichier :</label>
            <input type="file" id="file" name="file" accept="video/mp4, image/*" required>

            <button type="submit">Uploader</button>
        </form>
    </main>
</body>

</html>