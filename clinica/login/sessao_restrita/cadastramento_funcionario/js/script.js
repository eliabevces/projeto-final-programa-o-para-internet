window.onload = function() {

    const el = document.querySelector("#logout");
    el.addEventListener('click', logout);

    const inputCep = document.querySelector("#cep");
    inputCep.onkeyup = () => buscaEndereco(inputCep.value);

    const medcheck = document.querySelector("#medicocheck");
    medcheck.addEventListener('click', medicochecker)
}

function buscaEndereco(cep) {

    if (cep.length != 9) return;
    let form = document.querySelector("form");

    fetch("../listagem_enderecos/php/busca-endereco.php?cep=" + cep)
        .then(response => {
            if (!response.ok) {

                throw new Error(response.status);
            }

            return response.json();
        })
        .then(endereco => {
            form.logradouro.value = endereco.logradouro;
            form.estado.value = endereco.estado;
            form.cidade.value = endereco.cidade;
        })
        .catch(error => {

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

function medicochecker() {
    const medcheck = document.querySelector("#medicocheck");
    const divmedcheck = document.querySelector("#divmedcheck");
    if (medcheck.checked) {
        console.log('checked');
        divmedcheck.style.display = "flex";
    } else {
        console.log('unchecked');
        divmedcheck.style.display = "none";
    }
}