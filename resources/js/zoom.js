// Sélectionner l'image à aggrandir
const imgToZoom = document.getElementById('zoomableImage');
// const supprimerButton = document.querySelector('.btn-supprimer');

// Sélectionner la fenêtre modale
// const modal = document.getElementById('modal-supprimer');
const modal = document.getElementById('zoomModal');

// Ajouter un événement d'écouteur de clic à l'image à aggrandir
    imgToZoom.addEventListener('click', function(event) {
        // Empêcher le comportement par défaut du lien (qui est de naviguer vers une nouvelle page)
        // event.preventDefault();

        // Ouvrir la fenêtre modale
        modal.showModal();
    });

// // Sélectionner le bouton "annuler" dans la fenêtre modale
const closeModalButton = document.querySelector('#modalClose');

// Ajouter un événement d'écouteur de clic au bouton "annuler"
closeModalButton.addEventListener('click', function(event) {

    // Fermer la fenêtre modale
    modal.close();
});

// Fermer la fenêtre modale lorsque l'utilisateur clique en dehors de celle-ci
window.addEventListener('click', function(event) {
    if (event.target === modal) {
        modal.close();
    }
});