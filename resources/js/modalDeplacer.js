document.addEventListener('DOMContentLoaded', function() {
    let bouteilleID; 
    let card;
  
    // Sélectionner tous les boutons "Déplacer"
    const deplacerButtons = document.querySelectorAll('.btn-deplacer');
    const btnModaAction = document.querySelector('.btn-modal-action');
    
    // Sélectionner la fenêtre modale
    const modal = document.getElementById('modal-deplacer');
    
    // Ajouter un événement d'écouteur de clic à chaque bouton "Deplacer"
    deplacerButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            // Empêcher le comportement par défaut du lien (qui est de naviguer vers une nouvelle page)
            event.preventDefault();
    
            // Ouvrir la fenêtre modale
            modal.showModal();
  
            // Prend la valeur de l'ID de la bouteille
            bouteilleID = button.getAttribute('data-bouteille-id'); 
            quantiteMax = button.getAttribute('data-bouteille-max');
            card = button.parentNode.parentNode;
        });
    });
    
    // Sélectionner le bouton "annuler" dans la fenêtre modale
    const closeModalButton = document.querySelector('.btn-modal-cancel');
    
    // Ajouter un événement d'écouteur de clic au bouton "annuler"
    closeModalButton.addEventListener('click', function(event) {
        // Empêcher le comportement par défaut du bouton (qui est de soumettre le formulaire)
        event.preventDefault();
    
        // Fermer la fenêtre modale
        modal.close();
    });
    
    // Fermer la fenêtre modale lorsque l'utilisateur clique en dehors de celle-ci
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.close();
        }
    });
  
    const form = document.querySelector('#form-deplacer'); 
    form.addEventListener('submit', function(event) { 
        event.preventDefault(); 
        let btnInnerHtml = btnModaAction.innerHTML.trim(); 
        if (btnInnerHtml != 'déplacer') {
          window.location.href = "/celliers-ajouter"; 
        }
        else {
            const quantiteBouteille = card.querySelector('#quantite-bouteille').value; 
            const idCellier = document.querySelector('#cellier-location').value;
            deplacerBouteille(quantiteBouteille, idCellier, bouteilleID);
            modifierQuantite(); 
            async function deplacerBouteille(quantite, cellierId, bouteilleId) {
                try {
                    const response = await fetch('/celliers-json', {
                        method: 'POST', 
                        headers: {
                            'Content-Type' : 'application/json', 
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }, 
                        body: JSON.stringify({ 
                            quantite: quantite,
                            location_id: cellierId,
                            bouteille_id: bouteilleId
                        })
                    });
                    if (!response.ok) {
                        throw new Error('Network response was not ok'); 
                    }
      
                    const data = await response.json(); 
                    console.log(data.message);

                    // Ajouter le message au toast et l'afficher avec saut de nav-item
                    afficherToastEtSauterNav(quantiteBouteille, "celliers");

                    modal.close(); 
                } catch(error) {
                    console.error('Error: ',  error)
                }
            }
            async function modifierQuantite() {
                let id = card.id;
                let url = `/bouteilles-listes-modifier/${id}`;
                console.log(document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                try {
                    const response = await fetch(url, { 
                        method: 'PUT',
                        headers: {
                            'Content-Type' : 'application/json', 
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }, 
                        body: JSON.stringify({ quantite: 0 })
                    });
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
            
                    const data = await response.json();
                    card.querySelector('#quantite-bouteille').value = 0; 
                    console.log(data.message); 
                    checkValue(); 
                    card.querySelector('.btn-deplacer').style.display = 'none'; 
                } catch (error) {
                    console.error('Error: ', error); 
                }
            }
            function checkValue() {
                let deleteButton = card.querySelector('.btn-delete');
                card.classList.add('card-transparent');
                deleteButton.style.display = 'block';
            }
        }
    })
    
    // FONCTION pour message toast et animation sur nav-item
    function afficherToastEtSauterNav(quantiteBouteille, toastLocation) {
        // Afficher le toast
        afficherToast(`${quantiteBouteille} bouteille(s) déplacée(s) dans ${toastLocation}!`);
        modal.close();

        // Identifier l'élément de navigation à animer
        let navItemId = toastLocation === 'celliers' ? 'nav-celliers' : 'nav-listes';
        let navItem = document.getElementById(navItemId);

        // Appliquer l'animation
        navItem.classList.add('jump-animation');

        // Optionnel: retirer l'animation après qu'elle soit terminée
        setTimeout(() => {
            navItem.classList.remove('jump-animation');
        }, 500); // 500 ms correspond à la durée de l'animation
    }

    // FONCTION pour afficher le message toast
    function afficherToast(message) {
        const snackbar = document.getElementById('snackbar');
        const messageElement = document.getElementById('snackbar-message');
        messageElement.textContent = message; // Mettre à jour le message seulement

        snackbar.className = 'show'; // Afficher le toast

        // Cacher le toast après 3 secondes
        setTimeout(function() { snackbar.className = snackbar.className.replace('show', ''); }, 3000);
    }
  });