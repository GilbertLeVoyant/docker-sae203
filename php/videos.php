<?php
// filepath: /var/www/html/videos.php

// Chemin vers le fichier JSON qui stocke les vidéos
$videosFile = 'videos.json';

// Charger la liste des vidéos
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (file_exists($videosFile)) {
        $videos = file_get_contents($videosFile);
        echo $videos;
    } else {
        echo json_encode([]);
    }
}

// Ajouter une vidéo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($input['title']) || !isset($input['filename'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Le titre et le nom de fichier sont requis.']);
        exit;
    }

    $videos = file_exists($videosFile) ? json_decode(file_get_contents($videosFile), true) : [];
    $videos[] = ['title' => $input['title'], 'filename' => $input['filename']];
    file_put_contents($videosFile, json_encode($videos, JSON_PRETTY_PRINT));
    echo json_encode(['message' => 'Vidéo ajoutée avec succès.']);
}

// Supprimer une vidéo
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($input['filename'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Le nom de fichier est requis.']);
        exit;
    }

    $videos = file_exists($videosFile) ? json_decode(file_get_contents($videosFile), true) : [];
    $videos = array_filter($videos, function ($video) use ($input) {
        return $video['filename'] !== $input['filename'];
    });
    file_put_contents($videosFile, json_encode($videos, JSON_PRETTY_PRINT));
    echo json_encode(['message' => 'Vidéo supprimée avec succès.']);
}
?>