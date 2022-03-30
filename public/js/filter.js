window.onload = () => {
    const FiltersForm = document.querySelector("#filters");

    // On boucle sur les input
    document.querySelectorAll("#filters input").forEach(input => {
        input.addEventListener("change", () => {
            
            // on intercepte les clic
            // on récup les données du formulaire
            const Form = new FormData(FiltersForm);
// on fabrique l'url
            const Params = new URLSearchParams();
            Form.forEach((value, key) => {
                Params.append(key, value);
            });

            const Url = new URL(window.location.href);

            // on lance la requète ajax
            fetch(Url.pathname + "?" + Params.toString() + "&ajax=1", {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            }).then(response => {
                console.log(response)
            }).catch(e => alert(e));

        });
    });
}