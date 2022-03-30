window.onload = () => {
    const FilterForm = document.querySelector("#filters");

    document.querySelectorAll("#filter input").forEach(input => {
        input.addEventListener("change", () => {
            console.log("clic");
        });
    });
}