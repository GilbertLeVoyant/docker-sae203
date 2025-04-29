const express = require('express');
const redis = require('redis');
const cors = require('cors');

const app = express();
const port = 3000;

// Activer CORS pour permettre les requêtes depuis le frontend
app.use(cors());

// Connexion à Redis
const client = redis.createClient({
	host: 'localhost', // Si Redis est dans le même conteneur, utilisez 'localhost'
	port: 6379         // Port par défaut de Redis
});

// Gestion des événements Redis
client.on('connect', () => {
	console.log('Connecté à Redis');
});

client.on('ready', () => {
	console.log('Redis est prêt');
});

client.on('error', (err) => {
	console.error('Erreur de connexion à Redis:', err);
});

client.on('end', () => {
	console.log('Connexion à Redis fermée');
});

// Route pour incrémenter les vues d'une vidéo
app.post('/video/:id/view', (req, res) => {
	const videoId = req.params.id;
	client.incr(`video:${videoId}:views`, (err, views) => {
		if (err) {
			console.error('Erreur lors de l\'incrémentation des vues:', err);
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
			console.error('Erreur lors de la récupération des vues:', err);
			return res.status(500).send('Erreur avec Redis');
		}
		res.json({ videoId, views: views || 0 });
	});
});

// Démarrage du serveur
app.listen(port, () => {
	console.log(`Serveur en cours d'exécution sur http://localhost:${port}`);
});