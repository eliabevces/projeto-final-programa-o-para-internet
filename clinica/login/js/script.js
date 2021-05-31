window.onload = function() {
    const el = document.querySelector("button");
    el.addEventListener('click', enviaForm);

}

function enviaForm(event) {
    event.preventDefault();

    document.querySelector("#loginFailMsg").style.display = 'none';

    let form = document.querySelector("form");
    let formData = new FormData();
    formData.append("email", form.email.value);
    formData.append("senha", form.senha.value);


    const options = {
        method: "POST",
        body: formData
    }

    fetch("php/login.php", options)
        .then(response => {
            if (!response.ok) {

                throw new Error(response.status);
            }


            return response.json();
        })
        .then(requestResponse => {
            if (requestResponse.success){
                window.open(requestResponse.destination, '_blank');
            } else{
                if(requestResponse.destination === 'LOGADO'){
                    if(window.confirm("Já exite um usuário logado, deslogar?")){
                        const options2 = {
                            method: "GET"
                        }
                    
                        fetch("sessao_restrita/logout/php/logout.php", options2)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(response.status);
                                }

                                window.alert("Deslogado com sucesso!");
                            })
                            .catch(error => {
                                console.error('Falha inesperada: ' + error);
                            });
                    }
                } else {
                    document.querySelector("#loginFailMsg").style.display = 'block';
                }
            }
        })
        .catch(error => {

            form.reset();
            console.error('Falha inesperada: ' + error);
        });


}