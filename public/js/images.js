window.onload = () => {
    //Gestion du bouton supprimer
    let links = document.querySelectorAll("[data-delete]")

    for(link of links)
    {
        links.addEventListener("click", function (e) {
            e.preventDefault()
            if(confirm("Supprimer cette image ?"))
            {
                //this : lien sur lequel on clique
                fetch(this.getAttribute("href"), {
                    method: "GET",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({"_token": this.dataset.token})
                }).then(
                    response => response.json()
                ).then(data => {
                    if(data.success)
                    {
                        this.parentElement.remove()
                    }
                    else {
                        alert(data.error)
                    }
                }).catch(e => alert(e))
            }
          })
    }
}