// Script para interação com o frontend
document.addEventListener('DOMContentLoaded', function() {
    // Validação do formulário
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(event) {
            const titulo = document.getElementById('titulo').value.trim();
            const genero = document.getElementById('genero').value.trim();
            const criador = document.getElementById('criador').value.trim();
            const ano = document.getElementById('ano_lancamento').value;
            const temporadas = document.getElementById('temporadas').value;
            const avaliacao = document.getElementById('avaliacao').value;
            const status = document.getElementById('status').value;
            
            if (!titulo || !genero || !criador || !ano || !temporadas || !avaliacao || !status) {
                event.preventDefault();
                alert('Por favor, preencha todos os campos obrigatórios.');
            }
            
            if (ano && (ano < 1900 || ano > new Date().getFullYear() + 5)) {
                event.preventDefault();
                alert('Por favor, insira um ano de lançamento válido.');
            }
            
            if (temporadas && (temporadas < 1 || temporadas > 100)) {
                event.preventDefault();
                alert('Por favor, insira um número válido de temporadas (1-100).');
            }
            
            if (avaliacao && (avaliacao < 0 || avaliacao > 10)) {
                event.preventDefault();
                alert('Por favor, insira uma avaliação válida (0-10).');
            }
        });
    }
    
    // Efeito de fade out para mensagens
    const mensagem = document.querySelector('.mensagem');
    if (mensagem) {
        setTimeout(function() {
            mensagem.style.opacity = '1';
            let fadeEffect = setInterval(function() {
                if (mensagem.style.opacity > 0) {
                    mensagem.style.opacity -= 0.1;
                } else {
                    clearInterval(fadeEffect);
                    mensagem.style.display = 'none';
                }
            }, 100);
        }, 3000);
    }
});
