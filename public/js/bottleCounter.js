document.querySelectorAll('.card-bouteille-qt').forEach(function(counter) {
    let card = counter.closest('.card-bouteille');
    let input = counter.querySelector('input');
    let decrementButton = counter.querySelector('.btn-decrement');
    let incrementButton = counter.querySelector('.btn-increment');
    let deleteButton = document.createElement('button');
    let deleteForm = counter.querySelector('.form-delete');
    let bouteilleType; 
    let deplacerButton; 
    let cardCount = document.querySelector('.card-count'); 
    if (input.getAttribute('data-bouteille-personnalisee')) {
        bouteilleType = input.getAttribute('data-bouteille-personnalisee'); 
    }
    if (card.querySelector('.btn-deplacer')) {
        deplacerButton = card.querySelector('.btn-deplacer');
    }
  
    // SVG pour le bouton supprimer
    deleteButton.innerHTML = '<svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.3334 11.6666V24.2C22.3334 24.6418 21.9753 25 21.5334 25H4.46675C4.02492 25 3.66675 24.6418 3.66675 24.2V11.6666" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10.3335 19.6666V11.6666" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M15.6665 19.6666V11.6666" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M25 6.33333H18.3333M18.3333 6.33333V1.8C18.3333 1.35817 17.9752 1 17.5333 1H8.46667C8.02484 1 7.66667 1.35817 7.66667 1.8V6.33333M18.3333 6.33333H7.66667M1 6.33333H7.66667" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    deleteButton.classList.add('btn-delete');
    deleteForm.appendChild(deleteButton);
  
    // Masquer initialement le bouton supprimer
    deleteButton.style.display = 'none';
  
    decrementButton.addEventListener('click', function() {
        let totalBouteilles = cardCount.querySelector('p').innerHTML.trim(); 
        totalBouteilles = totalBouteilles.slice(0, -13); 
        let currentValue = parseInt(input.value, 10);
        let totalBouteillesValeur = parseInt(totalBouteilles, 10); 
        if (currentValue > 0) {
            input.value = currentValue - 1;
            cardCount.querySelector('p').innerHTML = totalBouteillesValeur - 1 + " bouteille(s)"; 
            updateQuantity(input.value);
        }
        checkValue();
    });
  
    incrementButton.addEventListener('click', function() {
        let currentValue = parseInt(input.value, 10);
        let totalBouteilles = cardCount.querySelector('p').innerHTML.trim(); 
        totalBouteilles = totalBouteilles.slice(0, -13); 
        let totalBouteillesValeur = parseInt(totalBouteilles, 10); 
        input.value = currentValue + 1;
        cardCount.querySelector('p').innerHTML = totalBouteillesValeur + 1 + " bouteille(s)"; 
        totalBouteilles = totalBouteillesValeur + 1; 
        updateQuantity(input.value);
        checkValue();
    });
  
    async function updateQuantity(newQuantity) {
        let id = card.id;
        let location = card.getAttribute('data-location'); 
        let url = `/bouteilles-${location}-modifier/${id}`;
        if (bouteilleType == 'personnalisees') {
            url = `/bouteilles-personnalisees-celliers-modifier/${id}`
        }
        try {
            const response = await fetch(url, { 
                method: 'PUT',
                headers: {
                    'Content-Type' : 'application/json', 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }, 
                body: JSON.stringify({ quantite: newQuantity })
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
  
    function checkValue() {
        let currentValue = parseInt(input.value, 10);
        if (currentValue === 0) {
            card.classList.add('card-transparent');
            deleteButton.style.display = 'block';
            if (deplacerButton != undefined) {
                deplacerButton.style.display = 'none'; 
                console.log(deplacerButton);
            }
        } else {
            card.classList.remove('card-transparent');
            deleteButton.style.display = 'none';
            if (deplacerButton != undefined) {
                deplacerButton.style.display = 'block'; 
            }
        }
    }
  
    // Vérifier initialement la valeur du compteur
    checkValue();
  });
  