<?php
// filepath: /home/etudiant/fe240547/TP/s2/s2.03_install_services_reseaux/docker-sae203/php/upload.php

// Chemin vers le dossier où les vidéos seront stockées
$uploadDir = '../../src/videos/';
$videosFile = '../../src/videos.json';

// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $video = $_FILES['video'];

    // Vérifiez que le fichier est bien une vidéo MP4
    if ($video['type'] !== 'video/mp4') {
        die('Erreur : Seuls les fichiers MP4 sont autorisés.');
    }

    // Déplacez le fichier téléchargé dans le dossier des vidéos
    $targetFile = $uploadDir . basename($video['name']);
    if (move_uploaded_file($video['tmp_name'], $targetFile)) {
        // Ajoutez les informations de la vidéo dans le fichier JSON
        $videos = file_exists($videosFile) ? json_decode(file_get_contents($videosFile), true) : [];
        $videos[] = ['title' => $title, 'filename' => $video['name']];
        file_put_contents($videosFile, json_encode($videos, JSON_PRETTY_PRINT));

        echo 'Vidéo importée avec succès.';
    } else {
        echo 'Erreur lors de l\'importation de la vidéo.';
    }
}
?>