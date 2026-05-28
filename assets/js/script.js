// Função para desenhar o gráfico dinâmico na Dashboard
function inicializarGrafico(dados) {
    const ctx = document.getElementById('graficoPetMatch').getContext('2d');
    
    new Chart(ctx, {
        type: 'doughnut', // Estilo Rosca moderno igual combinamos
        data: {
            labels: ['Animais', 'Adotantes', 'Doações', 'Voluntários', 'Processos'],
            datasets: [{
                data: [
                    dados.animais, 
                    dados.adotantes, 
                    dados.doacoes,
                    dados.voluntarios,
                    dados.processos
                ],
                backgroundColor: [
                    '#E8640A', // Laranja do PetMatch
                    '#007bff', // Azul Adotantes
                    '#28a745', // Verde Doações
                    '#dc3545', // Vermelho Voluntários
                    '#ffc107'  // Amarelo Processos
                ],
                borderWidth: 2,
                borderColor: '#151515'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        color: '#aaa',
                        font: { family: 'Segoe UI', size: 12 }
                    }
                }
            }
        }
    });
}

// Aguarda a página carregar completamente
document.addEventListener("DOMContentLoaded", function () {
    const selectEspecie = document.getElementById("select-especie");
    const selectRaca = document.getElementById("select-raca");

    // Verifica se os elementos existem na página atual para não dar erro em outras telas
    if (selectEspecie && selectRaca) {
        selectEspecie.addEventListener("change", function () {
            const especieId = this.value;

            // Se o usuário selecionar a opção vazia, limpa e desativa o campo de raças
            if (!especieId) {
                selectRaca.innerHTML = '<option value="">Selecione uma espécie primeiro...</option>';
                selectRaca.disabled = true;
                return;
            }

            // Faz uma requisição em segundo plano para buscar as raças daquela espécie
            // IMPORTANTE: Ajuste o caminho abaixo caso o buscar_racas.php esteja em outra pasta
            fetch(`buscar_racas.php?especie_id=${especieId}`)
                .then(response => response.json())
                .then(racas => {
                    // Limpa o select de raças e ativa ele
                    selectRaca.innerHTML = '<option value="">Selecione uma raça...</option>';
                    selectRaca.disabled = false;

                    // Preenche o select com as raças retornadas do banco de dados
                    racas.forEach(raca => {
                        const option = document.createElement("option");
                        option.value = raca.id;
                        option.textContent = raca.name || raca.nome; // Trata se a coluna for 'nome' ou 'name'
                        selectRaca.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error("Erro ao buscar raças:", error);
                    selectRaca.innerHTML = '<option value="">Erro ao carregar raças</option>';
                });
        });
    }
});