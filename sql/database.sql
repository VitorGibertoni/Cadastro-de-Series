-- Criação do banco de dados para o sistema de cadastro de séries
CREATE DATABASE IF NOT EXISTS cadastro_series;

-- Seleciona o banco de dados
USE cadastro_series;

-- Criação da tabela de séries
CREATE TABLE IF NOT EXISTS series (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    genero VARCHAR(50) NOT NULL,
    criador VARCHAR(100) NOT NULL,
    ano_lancamento INT NOT NULL,
    temporadas INT NOT NULL,
    sinopse TEXT,
    avaliacao DECIMAL(3,1),
    status VARCHAR(20) NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserção de alguns dados de exemplo
INSERT INTO series (titulo, genero, criador, ano_lancamento, temporadas, sinopse, avaliacao, status) VALUES
('Breaking Bad', 'Drama', 'Vince Gilligan', 2008, 5, 'Um professor de química do ensino médio com câncer terminal se junta a um ex-aluno para produzir e vender metanfetamina.', 9.5, 'Finalizada'),
('Stranger Things', 'Ficção Científica', 'Irmãos Duffer', 2016, 4, 'Quando um garoto desaparece, uma pequena cidade descobre um mistério envolvendo experimentos secretos, forças sobrenaturais e uma garotinha estranha.', 8.7, 'Em andamento'),
('The Office', 'Comédia', 'Greg Daniels', 2005, 9, 'Um documentário sobre a vida cotidiana dos funcionários de um escritório de uma empresa de papel em Scranton, Pensilvânia.', 8.9, 'Finalizada');
