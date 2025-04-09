const express = require('express');
const bodyParser = require('body-parser');
const fs = require('fs');
const path = require('path');

const app = express();
const PORT = 5000;

// Middleware
app.use(bodyParser.urlencoded({ extended: true }));
app.use(express.static('public'));
app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));

// Funzione per leggere il file JSON
const readData = () => {
    const data = fs.readFileSync(path.join(__dirname, 'data', 'data.json'));
    return JSON.parse(data);
};

// Funzione per scrivere nel file JSON
const writeData = (data) => {
    fs.writeFileSync(path.join(__dirname, 'data', 'data.json'), JSON.stringify(data, null, 2));
};

// Rotte
app.get('/', (req, res) => {
    res.render('home1');
});

app.get('/login', (req, res) => {
    res.render('login');
});

app.get('/register', (req, res) => {
    res.render('register');
});

app.post('/register', (req, res) => {
    const { username, password } = req.body;
    const data = readData();
    data.users.push({ username, password });
    writeData(data);
    res.redirect('/login');
});

app.post('/login', (req, res) => {
    const { username, password } = req.body;
    const data = readData();
    const user = data.users.find(u => u.username === username && u.password === password);
    
    if (user) {
        res.redirect('/home2');
    } else {
        res.send('Credenziali non valide!');
    }
});

app.get('/home2', (req, res) => {
    const data = readData();
    res.render('home2', { posts: data.posts });
});

app.post('/post', (req, res) => {
    const { content } = req.body;
    const data = readData();
    data.posts.push({ content, user: 'Utente' }); // Puoi modificare 'Utente' con l'username dell'utente autenticato
    writeData(data);
    res.redirect('/home2');
});

// Avvia il server
app.listen(PORT, () => {
    console.log(`Server in esecuzione su http://localhost:${PORT}`);
});
