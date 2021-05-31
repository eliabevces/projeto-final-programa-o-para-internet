
window.addEventListener("load",function(event) {
    const el = document.querySelector("#logout");
    el.addEventListener('click', logout);
},false);

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