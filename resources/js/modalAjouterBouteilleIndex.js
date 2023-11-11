document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.card-results-container');
    if (container) {
        addEventListenersToElements(container);
    }
});

const observer = new MutationObserver(mutations => {
    mutations.forEach(mutation => {
        if (mutation.type === 'childList') {
            // Vérifiez si de nouveaux éléments ont été ajoutés
            if (mutation.addedNodes.length) {
                const container = document.querySelector('.card-results-container');
                addEventListenersToElements(container);
            }
        }
    });
});

const config = { childList: true, subtree: true };

const targetNode = document.querySelector('.card-results-container');
if (targetNode) {
    observer.observe(targetNode, config);
}


function addEventListenersToElements(container) {

    let bouteilleID; 
    let url = '/celliers-json';
    const ajouterButtons = document.querySelectorAll('.btn-ajouter');
    
    // Sélectionner la fenêtre modale
    const modal = document.getElementById('modal-ajouter');
    
    // Ajouter un événement d'écouteur de clic à chaque bouton "+ Ajouter"
    ajouterButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            // Empêcher le comportement par défaut du lien (qui est de naviguer vers une nouvelle page)
            event.preventDefault();
            bouteilleID = button.getAttribute('data-bouteille-id'); 
    
            // Ouvrir la fenêtre modale
            modal.showModal();
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

    const form = document.querySelector('#form-ajouter'); 
    const listRadio = document.querySelector('#location-liste'); 
    const cellierRadio = document.querySelector('#location-cellier'); 
    let selectLocation = document.querySelector('#select-location'); 
    let labelLocation = document.querySelector('#label-location'); 

    listRadio.addEventListener('change', function(event) {
        selectLocation.innerHTML = ''; 
        labelLocation.innerHTML = 'Choisir la liste'; 
        loadOptions('liste'); 
    }); 

    cellierRadio.addEventListener('change', function(event) {
        selectLocation.innerHTML = 'Choisir le cellier'; 
        loadOptions('cellier'); 
    }); 

    async function loadOptions(type) {
        if (type === 'liste') {
            url = '/listes-json'; 
        }
        else if (type === 'cellier') {
            url = '/celliers-json'; 
        }
        
        try {
            const response = await fetch(url, { 
                method: 'GET',
                headers: {
                    'Content-Type' : 'application/json', 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
    
            const data = await response.json();
            data.forEach(option => {
                let optionElement = document.createElement('option'); 
                optionElement.value = option.id; 
                optionElement.textContent = option.nom; 
                selectLocation.appendChild(optionElement); 
            });
        } 
        catch (error) {
            console.error('Error: ', error); 
        }
    }

    form.addEventListener('submit', function(event) {
        const quantiteBouteille = document.querySelector('#quantite-bouteille').value; 
        const idLocation = document.querySelector('#select-location').value;
        event.preventDefault(); 
        ajouterBouteille(quantiteBouteille, idLocation, bouteilleID); 

        async function ajouterBouteille(newQuantity, locationId, bouteilleId) {
            try {
                const response = await fetch(url, { 
                    method: 'POST',
                    headers: {
                        'Content-Type' : 'application/json', 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }, 
                    body: JSON.stringify({ 
                        quantite: newQuantity,
                        location_id: locationId,
                        bouteille_id: bouteilleId
                    })
                });
                
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
        
                const data = await response.json();
                console.log(data.message); 
            } catch (error) {
                console.error('Error: ', error); 
            }
        }
    }); 
}
