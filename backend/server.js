const express = require('express');
const redis = require('redis');
const cors = require('cors');

const app = express();
const port = 3000;

// Activer CORS pour permettre les requêtes depuis le frontend
app.use(cors());

// Connexion à Redis
const client = redis.createClient();

client.on('error', (err) => console.error('Redis error:', err));

// Route pour incrémenter les vues d'une vidéo
app.post('/video/:id/view', (req, res) => {
	const videoId = req.params.id;
	client.incr(`video:${videoId}:views`, (err, views) => {
		if (err) {
			return res.status(500).send('Erreur avec Redis');
		}
		res.json({ videoId, views });
	});
});

// Route pour récupérer les vues d'une vidéo
app.get('/video/:id/views', (req, res) => {
	const videoId = req.params.id;
	client.get(`video:${videoId}:views`, (err, views) => {
		if (err) {
			return res.status(500).send('Erreur avec Redis');
		}
		res.json({ videoId, views: views || 0 });
	});
});

app.listen(port, () => {
	console.log(`Serveur en cours d'exécution sur http://localhost:${port}`);
});