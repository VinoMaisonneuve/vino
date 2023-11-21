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
                  modal.close(); 
              } catch(error) {
                  console.error('Error: ',  error)
              }
          }
          async function modifierQuantite() {
              let id = card.id;
              let url = `/bouteilles-listes-modifier/${id}`;
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
});