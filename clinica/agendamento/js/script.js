window.onload = function() {
    buscaEspecialidades();
    const buscamed = document.querySelector("#especialidade");
    buscamed.addEventListener('change', buscaMedicos);

}


function buscaEspecialidades() {

    fetch("php/busca_especialidades.php")
        .then(response => {
            if (!response.ok) {
                throw new Error(response.status);
            }

            return response.json();
        })
        .then(medico_esp => {

            var campoSelect = document.getElementById("especialidade");


            for (i = 0; i < medico_esp.length; i++) {

                esp = medico_esp[i];

                option = document.createElement("option");
                option.text = esp.especialidade;
                option.value = esp.especialidade;
                campoSelect.add(option);
            }
        })
        .catch(error => {

            form.reset();
            console.error('Falha inesperada: ' + error);
        });
}



function buscaMedicos(e) {
    e.preventDefault();
    const especialidade = document.querySelector("#especialidade");
    console.log(especialidade.value);
    fetch("php/busca_medicos.php?especialidade=" + especialidade.value)
        .then(response => {
            if (!response.ok) {
                throw new Error(response.status);
            }

            return response.json();
        })
        .then(medicos => {
            console.log(medicos);
            console.log(medicos.length);

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
        })
        .catch(error => {

            console.error('Falha inesperada: ' + error);
        });

}