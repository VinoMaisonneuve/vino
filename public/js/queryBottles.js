let currentPage = 1; // Variable globale pour stocker la page actuelle seulement sur rechargement direct du URL
let pageReload = false; // pageReload sera mis à true lorsqu'on recharge manuellement l'url
setTimeout(function() {
  pageReload = false; // réinitialiser à false à la fin
}, 0);
// window.addEventListener('load', function() {
//   pageReload ? false : false;
//   console.log(pageReload);
//   console.log(currentPage);
// });

// ==================================================================================================
// LISTENERS ET MUTATIONOBSERVER ====================================================================
// ==================================================================================================

// LISTENER pour empêcher que la page se recharge quand on appuie Enter
document.getElementById('search-input').addEventListener('keydown', function(event) {
  if (event.key === 'Enter') {
      // Empêche que la page se recharge
      event.preventDefault();
  }
});

// LISTENER pour la saisie dans recherche
document.getElementById('search-input').addEventListener('input', function(event) {
  // Charge les bouteilles avec la valeur actuelle de recherche, l'option de tri sélectionnée, les tags sélectionnés, et réinitialise la page à 1
  loadProducts(
    event.target.value, 
    document.getElementById('sort').value,
    document.querySelector('input[name="prix-min"]').value,
    document.querySelector('input[name="prix-max"]').value,
    getSelectedTags(),
    // currentPage
  );
});

// Ajout des écouteurs d'événements pour les champs de type number
document.querySelector('input[name="range-min"]').addEventListener('change', function() {
  loadProducts(
    document.getElementById('search-input').value, 
    document.getElementById('sort').value, 
    document.querySelector('input[name="prix-min"]').value,
    document.querySelector('input[name="prix-max"]').value,
    getSelectedTags(),
    pageReload ? currentPage : 1
  );
});
document.querySelector('input[name="range-max"]').addEventListener('change', function() {
  loadProducts(
    document.getElementById('search-input').value, 
    document.getElementById('sort').value, 
    document.querySelector('input[name="prix-min"]').value,
    document.querySelector('input[name="prix-max"]').value,
    getSelectedTags(),
    pageReload ? currentPage : 1
  );
});

// LISTENER pour le changement de l'option de tri
document.getElementById('sort').addEventListener('change', function(event) {
  // Charge les bouteilles avec la valeur actuelle de recherche, la nouvelle option de tri, les tags sélectionnés, et réinitialise la page à 1
  loadProducts(
    document.getElementById('search-input').value, 
    event.target.value,
    document.querySelector('input[name="prix-min"]').value,
    document.querySelector('input[name="prix-max"]').value,
    getSelectedTags(),
    // currentPage
  );
});

// MutationObserver pour les tags de Filtres
const tagContainerElement = document.getElementById("tag-container");
const observerFilter = new MutationObserver(mutations => {
  mutations.forEach(mutation => {
      if (mutation.type === 'childList') {
          // Charge les bouteilles avec la valeur actuelle de recherche, l'option de tri sélectionnée, les tags sélectionnés, et réinitialise la page à 1
          loadProducts(
            document.getElementById('search-input').value, 
            document.getElementById('sort').value, 
            document.querySelector('input[name="prix-min"]').value,
            document.querySelector('input[name="prix-max"]').value,
            getSelectedTags(),
            pageReload ? currentPage : 1
          );
          pageReload = false; // remettre pageReload à false
      }
  });
});
observerFilter.observe(tagContainerElement, { childList: true });

// LISTENER pour la pagination
document.addEventListener('click', function(event) {
  if (event.target.matches('#pagination a')) {
      event.preventDefault(); // Empêche le lien de charger la page
      var pageUrl = new URL(event.target.href);
      var page = pageUrl.searchParams.get('page') || 1;
      // Charge les bouteilles avec la valeur actuelle de recherche, l'option de tri sélectionnée, les tags sélectionnés, et la page sélectionnée
      loadProducts(
        document.getElementById('search-input').value, 
        document.getElementById('sort').value, 
        document.querySelector('input[name="prix-min"]').value,
        document.querySelector('input[name="prix-max"]').value, 
        getSelectedTags(),
        page
      );
      // Après le chargement des produits, faire défiler jusqu'à l'ancre
      document.getElementById('search-results').scrollIntoView({ behavior: 'smooth' });;
  }
});

// ==================================================================================================
// RECHARGER LORSQU'ON CHANGE DIRECTEMENT LE URL ====================================================
// ==================================================================================================
window.onload = function() {
  const urlParams = new URLSearchParams(window.location.search);
  const searchQuery = urlParams.get('search') || '';
  const sortOption = urlParams.get('sort') || 'name-asc';
  // const page = urlParams.get('page') || 1;
  currentPage = parseInt(urlParams.get('page')) || 1;
  const prixMin = urlParams.get('prix-min');
  const prixMax = urlParams.get('prix-max');
  pageReload = true;

  // Mettre à jour le champ de recherche
  document.getElementById('search-input').value = searchQuery;

  // Mettre à jour l'option de tri sélectionnée
  if(sortOption !== '' || sortOption !== 'name-asc') {
      const sortSelect = document.getElementById('sort');
      sortSelect.value = sortOption;
  }
  // Mettre à jour les champs pour prix-min et prix-max
  const minInput = document.querySelector('input[name="prix-min"]');
  const maxInput = document.querySelector('input[name="prix-max"]');
  
  if (prixMin) {
    minInput.value = prixMin;
    minInput.dispatchEvent(new Event('input'));  // Déclenche l'événement 'input' pour mettre à jour la position du curseur
  }
  if (prixMax) {
    maxInput.value = prixMax;
    maxInput.dispatchEvent(new Event('input'));
  }
  
  // Mettre à jour les tags et les selects
  updateFiltersFromURL(urlParams);

  loadProducts(searchQuery, sortOption, prixMin, prixMax, getSelectedTagsFromURL(urlParams), currentPage, false);
};
// Fonction pour aller chercher les tags du URL en objet
function getSelectedTagsFromURL(urlParams) {
  let tags = {};
  const selectors = ['couleur', 'pays', 'format', 'designation', 'producteur', 'agentPromotion', 'type', 'millesime', 'cepage', 'region'];

  // Parcourir tous les paramètres de l'URL
  urlParams.forEach((value, key) => {
      // Vérifiez si le paramètre actuel est l'un des sélecteurs
      if (selectors.includes(key)) {
          // Si plusieurs valeurs sont possibles pour le même sélecteur, mettre dans un tableau
          if (!tags[key]) {
              tags[key] = [];
          }
          tags[key].push(value);
      }
  });
  return tags;
}
// fonctions pour réfléter les filtres du URL
function updateFiltersFromURL(urlParams) {
  const selectedTags = getSelectedTagsFromURL(urlParams);
  updateTagsDisplay(selectedTags);
  updateSelectsDisplay(urlParams);
  console.log(selectedTags);
}
// fonction pour que les selects réflète les params filtres dans l'URL
function updateSelectsDisplay(urlParams) {
  selectElements.forEach(select => {
      const paramName = select.name;
      const paramValue = urlParams.get(paramName);

      if (paramValue) {
          select.value = paramValue;
          // Supprimer l'option correspondante du sélecteur
          const optionToHide = Array.from(select.options).find(option => option.value === paramValue);
          if (optionToHide) {
              optionToHide.remove();
          }
      }
  });
}
// fonction pour que les tags réflètent les params filtres dans l'URL
function updateTagsDisplay(selectedTags) {
  tagContainer.innerHTML = '';

  Object.entries(selectedTags).forEach(([selectName, values]) => {
      values.forEach(value => {
          const select = document.querySelector(`select[name="${selectName}"]`);
          const option = Array.from(select.options).find(opt => opt.value === value);

          if (option) {
              // Passez les propriétés de l'option comme chaînes de caractères
              createTag(selectName, option.value, option.text);
          }
      });
  });
}

// ==================================================================================================
// CHARGER LES PRODUITS =============================================================================
// ==================================================================================================

// Récupérer les valeurs par défaut pour prix min et max
const defaultMinPrice = document.querySelector('input[name="range-min"]').min;
const defaultMaxPrice = document.querySelector('input[name="range-max"]').max;

// FONCTION pour charger les bouteilles avec les critères de recherche, de tri, de pagination et de tags
function loadProducts(searchQuery, sortOption, minPrice = defaultMinPrice, maxPrice = defaultMaxPrice, selectedTags, page = 1) {

  var query = searchQuery || '';
  var sort = sortOption || '';
  var tags = selectedTags || {};

  // Convertir les valeurs en nombres
  var numPrixMin = parseFloat(minPrice).toFixed(2); //parseFloat parce que l'input enlève les décimaux lorsque ,00
  var numPrixMax = parseFloat(maxPrice).toFixed(2);

  var url = `/search?search=${encodeURIComponent(query)}&sort=${encodeURIComponent(sort)}&page=${encodeURIComponent(page)}`;
  
  // Ajouter les tags aux paramètres de l'URL
  Object.keys(tags).forEach(key => {
      url += `&${encodeURIComponent(key)}=${encodeURIComponent(tags[key])}`;
  });
  if (isNaN(numPrixMin)) numPrixMin = defaultMinPrice; // Utilisez la valeur par défaut si la conversion échoue
  if (isNaN(numPrixMax)) numPrixMax = defaultMaxPrice;

  // Ajouter les critères de prix à l'URL, si différents des valeurs par défaut
  console.log(numPrixMin, defaultMinPrice);
  console.log(numPrixMax, defaultMaxPrice);
  if (numPrixMin !== defaultMinPrice) {
    url += `&prix-min=${encodeURIComponent(numPrixMin)}`;

  }
  if (numPrixMax !== defaultMaxPrice) {
      url += `&prix-max=${encodeURIComponent(numPrixMax)}`;
  }

  fetch(url)
      .then(response => response.json())
      .then(data => {
          document.getElementById('search-results').innerHTML = data.resultsHtml;
          updateUrl(query, sort, numPrixMin, numPrixMax, tags, page);
      });
}
// FONCTION pour récupérer les tags sélectionnés avec leurs noms et valeurs du container de tags
function getSelectedTags() {
  var tagElements = document.querySelectorAll('.tag-container .tag');
  var tags = {};
  tagElements.forEach(function(tag) {
      var key = tag.getAttribute('data-select-name'); // Le nom du filtre, par exemple 'couleur'
      var value = tag.getAttribute('data-value'); // La valeur sélectionnée, par exemple 'rouge'

      // Si la clé n'existe pas déjà dans l'objet tags, créer un tableau vide
      if (!tags[key]) {
          tags[key] = [];
      }

      // Ajouter la valeur au tableau correspondant à la clé dans l'objet tags
      tags[key].push(value);
  });
  return tags;
}

// ==================================================================================================
// UPDATE URL =======================================================================================
// ==================================================================================================

// FONCTION pour mettre à jour l'URL sans recharger la page; se fait après chaque chargement de bouteilles
function updateUrl(searchQuery, sortOption, minPrice=defaultMinPrice, maxPrice=defaultMaxPrice, tags, page) {
  let params = new URLSearchParams();
  
  if (searchQuery) {
      params.append('search', searchQuery);
  }
  console.log(sortOption);
  if (sortOption && sortOption !== 'name-asc') {
      params.append('sort', sortOption);
  }
  for (const [name, values] of Object.entries(tags)) {
      if (values.length > 0) { // Vérifiez si le tableau de valeurs n'est pas vide
          values.forEach(value => {
              params.append(name, value);
          });
      }
  }

  var numPrixMin = parseFloat(minPrice).toFixed(2); //parseFloat parce que l'input enlève les décimaux lorsque ,00
  var numPrixMax = parseFloat(maxPrice).toFixed(2);

  // Vérifier et ajouter les paramètres de prix
  if (numPrixMin !== defaultMinPrice) {
    params.append('prix-min', numPrixMin);
  }
  if (numPrixMax !== defaultMaxPrice) {
      params.append('prix-max', numPrixMax);
  }
  
  params.append('page', page);

  let newUrl = `${window.location.pathname}?${params.toString()}`;
  window.history.pushState({}, '', newUrl);
}

// ==================================================================================================
// TAGS (création avec ses listeners) ===============================================================
// ==================================================================================================

// Récupérer les éléments du DOM
const selectElements = document.querySelectorAll("details select");
const sliderElements = document.querySelectorAll('input[type="range"]');
const numberElements = document.querySelectorAll('input[type="number"]');
const tagContainer = document.querySelector(".tag-container");
const resetButton = document.getElementById("reset-filters");

// LISTENER pour les sélecteurs (select)
selectElements.forEach(function (select) {
  select.addEventListener("change", function () {
      const selectedOption = this.options[this.selectedIndex];
      createTag(this.name, selectedOption.value, selectedOption.text);

      // Retirer l'option du select
      selectedOption.remove();
  });
});

// FONCTION pour créer les tags
function createTag(selectName, value, text) {
  const tag = document.createElement("div");
  tag.classList.add("tag");
  tag.textContent = text;
  tag.setAttribute("data-value", value);
  tag.setAttribute("data-select-name", selectName); // pour savoir quel select le tag est associé

  tagContainer.appendChild(tag);

  addTagRemoveListener(tag);
}
function addTagRemoveListener(tag) {
  tag.addEventListener("click", function () {
      const selectName = this.getAttribute("data-select-name");
      const associatedSelect = document.querySelector(`select[name="${selectName}"]`);
      const newOption = document.createElement("option");
      newOption.value = this.getAttribute("data-value");
      newOption.text = this.textContent;
      associatedSelect.add(newOption);
      this.remove();
  });
}

// ==================================================================================================
// BOUTON RÉINITIALISER =============================================================================
// ==================================================================================================

// Listener pour le bouton de réinitialisation
resetButton.addEventListener("click", function () {
  // Réinitialiser les tags et les options dans les sélecteurs (select)
  const tags = tagContainer.querySelectorAll(".tag");
  tags.forEach(function (tag) {
      const selectName = tag.getAttribute("data-select-name");
      const associatedSelect = document.querySelector(
          `select[name="${selectName}"]`
      );
      const value = tag.getAttribute("data-value");
      const newOption = document.createElement("option");
      newOption.value = value;
      newOption.textContent = tag.textContent;
      associatedSelect.add(newOption);
      tag.remove();
  });

  // Réinitialiser les selects à leur première option
  selectElements.forEach(function (select) {
      select.selectedIndex = 0;
  });

  // Réinitialiser les sliders et les champs numériques
  sliderElements.forEach(function (slider, index) {
      // Réinitialiser les sliders avec des index impairs au maximum et les autres au minimum
      if (index % 2 !== 0) {
          // les index impairs pour les valeurs max
          slider.value = slider.max;
          numberElements[index].value = slider.max;
      } else {
          // les index pairs pour les valeurs min
          slider.value = slider.min;
          numberElements[index].value = slider.min;
      }

      // Mettre à jour l'affichage du slider pour chaque groupe
      const sliderGroup = slider.closest(".form-range"); // Trouver le groupe de slider parent
      const range = sliderGroup.querySelector(".form-range-selected");
      range.style.left = (slider.min / slider.max) * 100 + "%";
      range.style.right = (1 - slider.value / slider.max) * 100 + "%";

      
  });

  // Appel de loadProducts avec les valeurs réinitialisées
  loadProducts(
    document.getElementById('search-input').value, 
    document.getElementById('sort').value, 
    document.querySelector('input[name="prix-min"]').value,
    document.querySelector('input[name="prix-max"]').value,
    getSelectedTags(),
    pageReload ? currentPage : 1
  );
});
