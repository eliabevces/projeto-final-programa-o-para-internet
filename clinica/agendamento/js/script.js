const buscaesp = document.querySelector("#especialidade");
buscaesp.addEventListener('change', buscaMedicos);

function buscaMedicos(e) {
    e.preventDefault();
    const especialidade = document.querySelector("#especialidade");

    let xhr = new XMLHttpRequest();
    xhr.open("GET", "busca_medicos.php?especialidade=" + especialidade.value, true);
    xhr.send();

    xhr.onload = function() {
        if (xhr.status != 200) {
            console.error("Falha inesperada: " + xhr.responseText);
        }




        var medicos = JSON.parse(xhr.responseText);

        var campoSelect = document.getElementById("nomeMedico");

        for (i = campoSelect.length - 1; i >= 0; i--) {
            campoSelect.remove(i);
        }

        for (i = 0; i < medicos.length; i++) {

            medico = medicos[i];

            option = document.createElement("option");
            option.text = medico.nome;
            option.value = medico.nome;
            campoSelect.add(option);
        }

    }
    xhr.onerror = function() {
        console.error("Erro de rede - requisição não finalizada");
    };





}