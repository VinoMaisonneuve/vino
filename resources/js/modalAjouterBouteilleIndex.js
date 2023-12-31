let bouteilleID; 
// Sélectionner la fenêtre modale
const modal = document.getElementById('modal-ajouter');

// Fonction appelé par l'événement d'écouteur de clic à chaque bouton "+ Ajouter"
function onButtonClick(event) {
    // Empêcher le comportement par défaut du lien (qui est de naviguer vers une nouvelle page)
    event.preventDefault();
    bouteilleID = event.currentTarget.getAttribute('data-bouteille-id'); 

    // Ouvrir la fenêtre modale
    modal.showModal();
}

// Fonction appelé par l'événement d'écouteur de clic à chaque bouton fermer
function onButtonCloseClick(event) {
    // Empêcher le comportement par défaut du bouton (qui est de soumettre le formulaire)
    event.preventDefault();
    
    // Fermer la fenêtre modale
    modal.close();
}

// Fonction appelé par l'événement d'écouteur de clic sur la fenêtre
function onWindowsClick(event) {
    if (event.target === modal) {
        modal.close();
    }
}


// Récupérér les éléments dans la fenêtre modale
const form = document.querySelector('#form-ajouter'); 

//Récupérer les éléments de la fenêtre modale
const listRadio = document.querySelector('#location-liste'); 
const cellierRadio = document.querySelector('#location-cellier'); 
let selectLocation = document.querySelector('#select-location'); 
let labelLocation = document.querySelector('#label-location'); 
var selectListes = []; 
var selectCelliers = [];   
// Sélectionner le bouton "annuler" dans la fenêtre modale
const closeModalButton = document.querySelector('.btn-modal-cancel');

let url = '/celliers-json';
//Fonction appelé par l'événement d'écouteur de changement aux radios
function onListRadioChange(event) {
    url = '/listes-json'; 
    labelLocation.innerHTML = 'Choisir la liste';
    if (selectListes.length === 0) {
        loadOptions('liste');
    }
    else {
        selectLocation.innerHTML = ""; 
        selectListes.forEach(function(liste) {
            selectLocation.appendChild(liste);
        }); 
        if (selectLocation.querySelector('option').textContent == "Vous n'avez pas de liste") {
            form.querySelector('.btn-modal-action').innerHTML = "Créer une liste"; 
        }
        else {
            form.querySelector('.btn-modal-action').innerHTML = "ajouter"; 
        }
    }
}

function onCellierRadioChange(event) {
    url = '/celliers-json'; 
    labelLocation.innerHTML = 'Choisir le cellier';
    if (Object.keys(selectCelliers).length === 0) {
        loadOptions('cellier');
    }
    else {
        selectLocation.innerHTML = ""; 
        selectCelliers.forEach(function(cellier) {
            selectLocation.appendChild(cellier);
        }); 
        if (selectLocation.querySelector('option').textContent == "Vous n'avez pas de cellier") {
            form.querySelector('.btn-modal-action').innerHTML = "Créer un cellier"; 
        }
        else {
            form.querySelector('.btn-modal-action').innerHTML = "ajouter"; 
        }
    }
}

var windowLocation = window.location.toString(); 
if (windowLocation.includes('listes')) {
    url = '/listes-json'; 
    loadOptions('liste');
    listRadio.checked = true; 

}
else {
    url = '/celliers-json'; 
    loadOptions('cellier'); 
}

// Fonction pour charger les options (de celliers ou listes)
async function loadOptions(type) {
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
        selectLocation.innerHTML = '';
        if (data && data.length > 0) {
            data.forEach(function (option) {
                var optionElement = document.createElement('option');
                optionElement.value = option.id;
                optionElement.textContent = option.nom;
                selectLocation.appendChild(optionElement);
                if (type === "cellier") {
                selectCelliers.push(optionElement); 
                }
                else {
                    selectListes.push(optionElement); 
                }
            });
            if (windowLocation.includes('celliers') && cellierRadio.checked) {
                //Trouver l'ID du cellier dans l'URL
                var cellier_id = windowLocation.match(/\/celliers\/(\d+)\//)[1];
                //Selectionner le cellier à partir duquel l'utilisateur est venu
                labelLocation.innerHTML = 'Choisir le cellier';
                var cellierOrigine = selectLocation.querySelector('option[value="' + cellier_id + '"]'); 
                cellierOrigine.selected = 'selected'; 
                console.log(cellierOrigine); 
            }
            else if (windowLocation.includes('listes') && listRadio.checked) {
                //Trouver l'ID du cellier dans l'URL
                var liste_id = windowLocation.match(/\/listes\/(\d+)\//)[1];
                labelLocation.innerHTML = 'Choisir la liste';
                //Selectionner le cellier à partir duquel l'utilisateur est venu
                var listeOrigine = selectLocation.querySelector('option[value="' + liste_id + '"]'); 
                listeOrigine.selected = 'selected'; 
            }
        }
        else {
            var optionElement = document.createElement('option');
            optionElement.textContent = "Vous n'avez pas de " + type;
            selectLocation.appendChild(optionElement);
            if (type === 'cellier') {
                form.querySelector('.btn-modal-action').innerHTML = "Créer un cellier"; 
            }
            else if (type === 'liste') {
                form.querySelector('.btn-modal-action').innerHTML = "Créer une liste"; 
            }
            if (type === "cellier") {
                selectCelliers.push(optionElement); 
            }
            else {
                selectListes.push(optionElement); 
            }
        }
    } 
    catch (error) {
        console.error('Error: ', error); 
    }
}

//Fonction appelé par l'événement d'écouteur de changement de l'envoi du formulaire
function onFormSubmit(event) {
    event.preventDefault(); 
    console.log(form.querySelector('.btn-modal-action').textContent);
    if(form.querySelector('.btn-modal-action').textContent != "ajouter") {
        if(form.querySelector('.btn-modal-action').textContent == "Vous n'avez pas de liste") {        
            //window.location.href = "/listes-ajouter"; 
        }
        else {
            //window.location.href = "/celliers-ajouter"; 
        }
    }
    else {
        const quantiteBouteille = document.querySelector('#quantite-bouteille').value; 
        const idLocation = document.querySelector('#select-location').value;
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
                console.log(url);

                if(url == '/celliers-json') {
                    var toastLocation = "celliers";
                }
                else {
                    var toastLocation = "listes"
                }

                // Ajouter le message au toast et l'afficher avec saut de nav-item
                afficherToastEtSauterNav(quantiteBouteille, toastLocation);
                modal.close(); 
            } catch (error) {
                console.error('Error: ', error); 
            }
        }
    }
}

// FONCTION pour message toast et animation sur nav-item
function afficherToastEtSauterNav(quantiteBouteille, toastLocation) {
    // Afficher le toast
    afficherToast(`${quantiteBouteille} bouteille(s) ajoutée(s) dans ${toastLocation}!`);
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

// LISTENER au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('.card-results-container');
    if (container) {
        addEventListenersToElements(container);
    }
});

// MUTATIONOBSERVER pour surveiller les changements dans le container "card-results-container"
// (pour ensuite pouvoir mettre des listeners sur chaque bouton "+ AJOUTER" à chaque fois que le contenu du contenu change)
const observer = new MutationObserver(mutations => {
    mutations.forEach(mutation => {
        if (mutation.type === 'childList') {
            // Vérifiez si de nouveaux éléments ont été ajoutés
            if (mutation.addedNodes.length) {
                const container = document.querySelector('.card-results-container');
                closeModalButton.removeEventListener('click', onButtonCloseClick);
                window.removeEventListener('click', onWindowsClick);
                listRadio.removeEventListener('change', onListRadioChange); 
                cellierRadio.removeEventListener('change', onCellierRadioChange); 
                form.removeEventListener('submit', onFormSubmit); 
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

// FONCTION pour ajouter des listeners (pour bouton +Ajouter et boutons de la fenêtre modale)
function addEventListenersToElements(container) {
    // Ajouter un événement d'écouteur de clic à chaque bouton "+ Ajouter"
    const ajouterButtons = document.querySelectorAll('.btn-ajouter');
    ajouterButtons.forEach(function(button) {
        button.removeEventListener('click', onButtonClick); 
        button.addEventListener('click', onButtonClick);
    });

    // Ajouter un événement d'écouteur de clic au bouton "annuler"
    closeModalButton.addEventListener('click', onButtonCloseClick);
    
    // Fermer la fenêtre modale lorsque l'utilisateur clique en dehors de celle-ci
    window.addEventListener('click', onWindowsClick);

    // Listeners pour le radio (choix entre cellier ou liste)
    listRadio.addEventListener('change', onListRadioChange); 
    cellierRadio.addEventListener('change', onCellierRadioChange); 

    // Listener pour le formulaire d'ajout de bouteille
    form.addEventListener('submit', onFormSubmit); 
}
