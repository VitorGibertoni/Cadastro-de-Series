require('dotenv').config();

const express = require('express');
const mysql = require('mysql2');
const app = express();

app.use(express.json());

const db = mysql.createConnection({
    host: process.env.DB_HOST,
    user: process.env.DB_USER,
    password: process.env.DB_PASSWORD,
    database: process.env.DB_DATABASE,
    port: process.env.DB_PORT
});

db.connect(err => {
    if (err) {
        console.error('Erro ao conectar ao banco de dados:', err);
        process.exit(1);
    }
    console.log('Conectado ao banco de dados MySQL!');
});

app.get('/series', (req, res) => {
    const sql = 'SELECT * FROM series';
    db.query(sql, (err, results) => {
        if (err) {
            console.error('Erro ao buscar series:', err);
            return res.status(500).json({ error: 'Erro interno do servidor' });
        }
        res.status(200).json(results);
    });
});


app.listen(3000, () => {
    console.log('Servidor rodando na porta 3000');
});