// Servidor Node.js para o projeto Cadastro de Séries
const express = require('express');
const path = require('path');
const { exec } = require('child_process');
const fs = require('fs');

// Inicializa o aplicativo Express
const app = express();
const PORT = process.env.PORT || 3000;

// Define o diretório raiz do projeto
const projectRoot = path.join(__dirname);

// Middleware para servir arquivos estáticos
app.use(express.static(projectRoot));

// Rota principal - redireciona para o PHP
app.get('/', (req, res) => {
    res.redirect('/php');
});

// Rota para servir a aplicação PHP
app.use('/php', (req, res, next) => {
    // Verifica se o PHP está instalado
    exec('php -v', (error, stdout, stderr) => {
        if (error) {
            console.error('PHP não está instalado ou não está no PATH');
            return res.status(500).send('Erro: PHP não está instalado no servidor.');
        }
        next();
    });
});

// Middleware para processar arquivos PHP
app.use('/php', (req, res) => {
    const phpFile = req.path === '/' ? '/index.php' : req.path;
    const phpFilePath = path.join(projectRoot, 'php', phpFile);
    
    // Verifica se o arquivo PHP existe
    if (fs.existsSync(phpFilePath)) {
        // Executa o arquivo PHP
        exec(`php ${phpFilePath}`, (error, stdout, stderr) => {
            if (error) {
                console.error(`Erro ao executar PHP: ${error}`);
                return res.status(500).send('Erro ao processar a requisição PHP.');
            }
            
            res.send(stdout);
        });
    } else {
        res.status(404).send('Arquivo PHP não encontrado.');
    }
});

// Inicia o servidor
app.listen(PORT, '0.0.0.0', () => {
    console.log(`Servidor rodando em http://localhost:${PORT}`);
    console.log('Para acessar o sistema:');
    console.log(`1. Abra o navegador e acesse http://localhost:${PORT}`);
    console.log('2. Certifique-se de que o MySQL está em execução');
    console.log('3. Importe o arquivo SQL em sql/database.sql para criar o banco de dados');
});

// Função para verificar se o MySQL está em execução
function checkMySQLConnection() {
    console.log('Verificando conexão com MySQL...');
    
    exec('mysql --version', (error, stdout, stderr) => {
        if (error) {
            console.warn('MySQL não encontrado ou não está no PATH. Certifique-se de que o MySQL está instalado.');
            return;
        }
        
        console.log('MySQL encontrado. Verifique se o serviço está em execução.');
        console.log('Para importar o banco de dados, use o comando:');
        console.log(`mysql -u root -p < ${path.join(projectRoot, 'sql', 'database.sql')}`);
    });
}

// Verifica a conexão MySQL ao iniciar
checkMySQLConnection();
