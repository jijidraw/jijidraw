window.onload = () => {
    let activer = document.querySelectorAll("[type=checkbox]")
    for(let bouton of activer){
        bouton.addEventListener("click", function(){
            let xmlhhtp = new XMLHttpRequest;

            xmlhhtp.open("get", `/admin/monsters/activer/${this.dataset.id}`)
            xmlhhtp.send()
        })
    }
}