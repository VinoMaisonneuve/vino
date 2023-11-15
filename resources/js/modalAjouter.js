// Sélectionner tous les boutons "+ Ajouter"
document.addEventListener('DOMContentLoaded', function() {
    let bouteilleID; 
    let url = '/celliers-json';
    const ajouterButtons = document.querySelectorAll('.btn-ajouter');
    var windowLocation = window.location.toString(); 
    if (windowLocation.includes('listes')) {
      loadOptions('liste');
    }
    else {
      loadOptions('cellier'); 
    }
    
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
  
    // Récupérér les éléments dans la fenêtre modale
    const form = document.querySelector('#form-ajouter'); 
    const listRadio = document.querySelector('#location-liste'); 
    const cellierRadio = document.querySelector('#location-cellier'); 
    let selectLocation = document.querySelector('#select-location'); 
    let labelLocation = document.querySelector('#label-location'); 
    var selectListes = []; 
    var selectCelliers = []; 
  
    // Listeners pour le radio (choix entre cellier ou liste)
      listRadio.addEventListener('change', function(event) {
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
                  window.location.href = "/listes-ajouter"; 
              }
              else {
                  form.querySelector('.btn-modal-action').innerHTML = "Ajouter"; 
              }
          }
      }); 
      cellierRadio.addEventListener('change', function(event) {
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
                  window.location.href = "/celliers-ajouter"; 
              }
              else {
                  form.querySelector('.btn-modal-action').innerHTML = "Ajouter"; 
              }
          }
      }); 
  
    // Fonction pour charger les options (de celliers ou listes)
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
                      console.log(selectListes); 
                  }
              });
              if (windowLocation.includes('celliers') && cellierRadio.checked) {
                  //Trouver l'ID du cellier dans l'URL
                  var cellier_id = windowLocation.match(/\/celliers\/(\d+)\//)[1];
                  //Selectionner le cellier à partir duquel l'utilisateur est venu
                  var cellierOrigine = selectLocation.querySelector('option[value="' + cellier_id + '"]'); 
                  cellierOrigine.selected = true; 
              }
          }
          else {
              var optionElement = document.createElement('option');
              optionElement.textContent = "Vous n'avez pas de " + type;
              selectLocation.appendChild(optionElement);
              if (type === 'cellier') {
                  form.querySelector('.btn-modal-action').innerHTML = "Créer un cellier"; 
                  window.location.href = "/celliers-ajouter"; 
              }
              else if (type === 'liste') {
                  form.querySelector('.btn-modal-action').innerHTML = "Créer une liste"; 
                  window.location.href = "/listes-ajouter"; 
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
  
    // Listener pour le formulaire d'ajout de bouteille
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
              modal.close(); 
          } catch (error) {
              console.error('Error: ', error); 
          }
      }
    }); 
  })