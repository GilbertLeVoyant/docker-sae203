<?php
// filepath: /home/etudiant/fe240547/TP/s2/s2.03_install_services_reseaux/docker-sae203/php/upload_handler.php

// Chemins pour stocker les fichiers et les métadonnées
$uploadDir = '../../src/uploads/';
$metadataFile = '../../data/uploads.json';

// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $file = $_FILES['file'];

    // Vérifiez si une erreur s'est produite lors du téléchargement
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo 'Erreur lors du téléchargement du fichier. Code d\'erreur : ' . $file['error'];
        exit;
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
	   // Vérifiez la taille du fichier
    if ($file['size'] > $maxFileSize) {
        die('Erreur : Le fichier est trop lourd. La taille maximale autorisée est de 10 Mo.');
    }

    echo 'Fichier uploadé avec succès.';
    echo '<br><a href="../html/index.php">Retour à l\'accueil</a>';
}
?>