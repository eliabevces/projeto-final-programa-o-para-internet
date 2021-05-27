window.onload = function() {
    buscaEspecialidades();
    const buscamed = document.querySelector("#especialidade");
    buscamed.addEventListener('change', buscaMedicos);
    const nomemed = document.querySelector("#nomeMedico");
    const data_agendamento = document.querySelector("#dataConsulta");
    nomemed.addEventListener('change', buscaHorarios);
    data_agendamento.addEventListener('change', buscaHorarios);



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
    // console.log(especialidade.value);
    fetch("php/busca_medicos.php?especialidade=" + especialidade.value)
        .then(response => {
            if (!response.ok) {
                throw new Error(response.status);
            }

            return response.json();
        })
        .then(medicos => {
            // console.log(medicos);
            // console.log(medicos.length);

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

async function buscaHorarios(e) {
    e.preventDefault();

    let form = document.querySelector("form");
    let formData = new FormData();
    formData.append("nomeMedico", form.nomeMedico.value);
    formData.append("dataConsulta", form.dataConsulta.value);

    const options = {
        method: "POST",
        body: formData
    }

    console.log(form.nomeMedico.value);
    console.log(form.dataConsulta.value);


    try {
        let response = await fetch("php/horarios_ocupados.php", options);
        if (!response.ok) throw new Error(response.statusText);
        var horarios = await response.json();
    } catch (e) {
        console.error(e);
        return;
    }
    var campoSelect = document.getElementById("horarioConsulta");

    for (i = campoSelect.length - 1; i >= 0; i--) {
        campoSelect.remove(i);
    }

    var mapHorarios = new Map();
    mapHorarios.set('08:00:00', '08:00')
    mapHorarios.set('09:00:00', '09:00')
    mapHorarios.set('10:00:00', '10:00')
    mapHorarios.set('11:00:00', '11:00')
    mapHorarios.set('12:00:00', '12:00')
    mapHorarios.set('13:00:00', '13:00')
    mapHorarios.set('14:00:00', '14:00')
    mapHorarios.set('15:00:00', '15:00')
    mapHorarios.set('16:00:00', '16:00')
    mapHorarios.set('17:00:00', '17:00')


    console.log(mapHorarios);
    for (i = 0; i < horarios.length; i++) {
        horario = horarios[i];
        console.log(horario.ocupado);
        mapHorarios.delete(horario.ocupado);
    }
    console.log(mapHorarios);

    mapHorarios.forEach(function(value, key) {
        option = document.createElement("option");
        option.text = value;
        option.value = value;
        campoSelect.add(option);
    }, mapHorarios);


}