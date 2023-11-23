/**
 * Fonction de recherche d'une bouteille dans un cellier par son nom.
 */
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search_cellar");
    const bottleCards = document.querySelectorAll(".card-bouteille");

    searchInput.addEventListener("input", function (event) {
        const searchTerm = this.value.toLowerCase();

        bottleCards.forEach(function (card) {
            const bottleName = card
                .querySelector(".bottle-name")
                .textContent.toLowerCase();

            if (bottleName.includes(searchTerm)) {
                card.style.display = "";
            } else {
                card.style.display = "none";
            }
        });
    });

    // Ajouter un gestionnaire d'événement pour la touche 'Entrée'
    searchInput.addEventListener("keydown", function (event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Empêche l'action par défaut de la touche 'Entrée'
        }
    });
});
