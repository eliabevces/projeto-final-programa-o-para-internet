window.onload = function() {
    const el = document.querySelector("button");
    el.addEventListener('click', enviaForm);

}

function enviaForm(event) {
    event.preventDefault();

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
            if (requestResponse.success)
                window.location = requestResponse.destination;
            else
                document.querySelector("#loginFailMsg").style.display = 'block';
        })
        .catch(error => {

            form.reset();
            console.error('Falha inesperada: ' + error);
        });


}