<?php
// Chemins pour stocker les fichiers et les métadonnées
$uploadDir = '../../src/uploads/';
$metadataFile = '../../data/uploads.json';

// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $file = $_FILES['file'];

    // Vérifiez si une erreur s'est produite lors du téléchargement
    if ($file['error'] !== UPLOAD_ERR_OK) {
        switch ($file['error']) {
            case UPLOAD_ERR_INI_SIZE:
                die('Erreur : Le fichier dépasse la taille maximale autorisée par le serveur (upload_max_filesize).');
            case UPLOAD_ERR_FORM_SIZE:
                die('Erreur : Le fichier dépasse la taille maximale autorisée par le formulaire.');
            case UPLOAD_ERR_PARTIAL:
                die('Erreur : Le fichier n\'a été que partiellement téléchargé.');
            case UPLOAD_ERR_NO_FILE:
                die('Erreur : Aucun fichier n\'a été téléchargé.');
            case UPLOAD_ERR_NO_TMP_DIR:
                die('Erreur : Le dossier temporaire est manquant.');
            case UPLOAD_ERR_CANT_WRITE:
                die('Erreur : Échec de l\'écriture du fichier sur le disque.');
            case UPLOAD_ERR_EXTENSION:
                die('Erreur : Une extension PHP a arrêté le téléchargement.');
            default:
                die('Erreur inconnue lors du téléchargement.');
        }
    }

    // Vérifiez la taille du fichier
    $maxFileSize = 50 * 1024 * 1024; // 50 Mo
    if ($file['size'] > $maxFileSize) {
        die('Erreur : Le fichier est trop lourd. La taille maximale autorisée est de 50 Mo.');
    }

    // Vérifiez le type de fichier (vidéo MP4 ou image)
    $allowedTypes = ['video/mp4', 'image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        die('Erreur : Seuls les fichiers MP4, JPEG, PNG et GIF sont autorisés.');
    }

    // Déplacez le fichier téléchargé dans le dossier des uploads
    $targetFile = $uploadDir . basename($file['name']);
    if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
        die('Erreur lors du déplacement du fichier.');
    }

    // Ajoutez les informations du fichier dans le fichier JSON
    $uploads = file_exists($metadataFile) ? json_decode(file_get_contents($metadataFile), true) : [];
    $uploads[] = ['title' => $title, 'filename' => $file['name'], 'type' => $file['type']];
    file_put_contents($metadataFile, json_encode($uploads, JSON_PRETTY_PRINT));

    echo 'Fichier uploadé avec succès.';
    echo '<br><a href="../html/index.php">Retour à l\'accueil</a>';
}
?>