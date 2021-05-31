
window.onload = function() {
    const el = document.querySelector("#logout");
    el.addEventListener('click', logout);

    const inputCep = document.querySelector("#cep");
    inputCep.onkeyup = () => buscaEndereco(inputCep.value);
}

function buscaEndereco(cep) {
                    
    if (cep.length != 9) return;      
    let form = document.querySelector("form");
    
    fetch("../listagem_enderecos/php/busca-endereco.php?cep=" + cep)
        .then(response => {
            if (!response.ok) {
                // A requisição finalizou com sucesso a nível de rede,
                // porém o servidor retornou um código de status
                // fora da faixa 200-299 (indicando outros possíveis erros).
                // Neste caso, lança uma exceção para que a promise seja
                // rejeitada. Como o próximo 'then' não possui callback 
                // de erros, será executada a função do próximo 'catch'.
                throw new Error(response.status);
                // return Promise.reject(response.status);
            }

            // Requisição finalizada com sucesso e o servidor
            // retornou um código de status de sucesso (200-299). 
            // O método json() faz a leitura dos dados de forma 
            // assíncrona e converte para um objeto JS. Qdo essa 
            // operação finalizar com sucesso, a função de callback
            // do próximo then receberá o resultado e será executada.
            return response.json();
        })
        .then(endereco => {
            // utiliza os dados para preencher o formulário
            form.logradouro.value = endereco.logradouro;
            form.estado.value = endereco.estado;
            form.cidade.value = endereco.cidade;
        })
        .catch(error => {
            // Ocorreu um erro na comunicação com o servidor ou
            // no processamento da requisição no PHP, que pode não
            // ter retornado uma string JSON válida.
            form.reset();
            console.error('Falha inesperada: ' + error);
        });
}

function logout(event) {
    event.preventDefault();

    const options = {
        method: "GET"
    }

    fetch("../logout/php/logout.php", options)
        .then(response => {
            if (!response.ok) {
                throw new Error(response.status);
            }

            window.close();
        })
        .catch(error => {
            console.error('Falha inesperada: ' + error);
        });


}