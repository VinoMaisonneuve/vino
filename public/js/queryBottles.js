/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**************************************!*\
  !*** ./resources/js/queryBottles.js ***!
  \**************************************/
function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }
function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }
function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }
function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) arr2[i] = arr[i]; return arr2; }
function _iterableToArrayLimit(r, l) { var t = null == r ? null : "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"]; if (null != t) { var e, n, i, u, a = [], f = !0, o = !1; try { if (i = (t = t.call(r)).next, 0 === l) { if (Object(t) !== t) return; f = !1; } else for (; !(f = (e = i.call(t)).done) && (a.push(e.value), a.length !== l); f = !0); } catch (r) { o = !0, n = r; } finally { try { if (!f && null != t["return"] && (u = t["return"](), Object(u) !== u)) return; } finally { if (o) throw n; } } return a; } }
function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }
// ==================================================================================================
// LISTENERS ET MUTATIONOBSERVER ====================================================================
// ==================================================================================================

// LISTENER pour empêcher que la page se recharge quand on appuie Enter
document.getElementById('search-input').addEventListener('keydown', function (event) {
  if (event.key === 'Enter') {
    // Empêche que la page se recharge
    event.preventDefault();
  }
});

// LISTENER pour la saisie dans recherche
document.getElementById('search-input').addEventListener('input', function (event) {
  // Charge les bouteilles avec la valeur actuelle de recherche, l'option de tri sélectionnée, les tags sélectionnés, et réinitialise la page à 1
  loadProducts(event.target.value, document.getElementById('sort').value, getSelectedTags());
});

// LISTENER pour le changement de l'option de tri
document.getElementById('sort').addEventListener('change', function (event) {
  // Charge les bouteilles avec la valeur actuelle de recherche, la nouvelle option de tri, les tags sélectionnés, et réinitialise la page à 1
  loadProducts(document.getElementById('search-input').value, event.target.value, getSelectedTags());
});

// MutationObserver pour les tags de Filtres
var tagContainerElement = document.getElementById("tag-container");
var observerFilter = new MutationObserver(function (mutations) {
  mutations.forEach(function (mutation) {
    if (mutation.type === 'childList') {
      // Charge les bouteilles avec la valeur actuelle de recherche, l'option de tri sélectionnée, les tags sélectionnés, et réinitialise la page à 1
      loadProducts(document.getElementById('search-input').value, document.getElementById('sort').value, getSelectedTags());
    }
  });
});
observerFilter.observe(tagContainerElement, {
  childList: true
});

// LISTENER pour la pagination
document.addEventListener('click', function (event) {
  if (event.target.matches('#pagination a')) {
    event.preventDefault(); // Empêche le lien de charger la page
    var pageUrl = new URL(event.target.href);
    var page = pageUrl.searchParams.get('page') || 1;
    // Charge les bouteilles avec la valeur actuelle de recherche, l'option de tri sélectionnée, les tags sélectionnés, et la page sélectionnée
    loadProducts(document.getElementById('search-input').value, document.getElementById('sort').value, getSelectedTags(), page);
  }
});

// ==================================================================================================
// RECHARGER LORSQU'ON CHANGE DIRECTEMENT LE URL ====================================================
// ==================================================================================================
window.onload = function () {
  var urlParams = new URLSearchParams(window.location.search);
  var searchQuery = urlParams.get('search') || '';
  var sortOption = urlParams.get('sort') || 'name-asc';
  var page = urlParams.get('page') || 1;

  // Mettre à jour le champ de recherche
  document.getElementById('search-input').value = searchQuery;

  // Mettre à jour l'option de tri sélectionnée
  if (sortOption !== '') {
    var sortSelect = document.getElementById('sort');
    sortSelect.value = sortOption;
  }
  // Mettre à jour les tags et les selects
  updateFiltersFromURL(urlParams);
  loadProducts(searchQuery, sortOption, getSelectedTagsFromURL(urlParams), page, false);
};
// Fonction pour aller chercher les tags du URL en objet
function getSelectedTagsFromURL(urlParams) {
  var tags = {};
  var selectors = ['couleur', 'pays', 'format', 'designation', 'producteur', 'agentPromotion', 'type', 'millesime', 'cepage', 'region'];

  // Parcourir tous les paramètres de l'URL
  urlParams.forEach(function (value, key) {
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
  var selectedTags = getSelectedTagsFromURL(urlParams);
  updateTagsDisplay(selectedTags);
  updateSelectsDisplay(urlParams);
  console.log(selectedTags);
}
// fonction pour que les selects réflète les params filtres dans l'URL
function updateSelectsDisplay(urlParams) {
  selectElements.forEach(function (select) {
    var paramName = select.name;
    var paramValue = urlParams.get(paramName);
    if (paramValue) {
      select.value = paramValue;
      // Supprimer l'option correspondante du sélecteur
      var optionToHide = Array.from(select.options).find(function (option) {
        return option.value === paramValue;
      });
      if (optionToHide) {
        optionToHide.remove();
      }
    }
  });
}
// fonction pour que les tags réflètent les params filtres dans l'URL
function updateTagsDisplay(selectedTags) {
  tagContainer.innerHTML = '';
  Object.entries(selectedTags).forEach(function (_ref) {
    var _ref2 = _slicedToArray(_ref, 2),
      selectName = _ref2[0],
      values = _ref2[1];
    values.forEach(function (value) {
      var select = document.querySelector("select[name=\"".concat(selectName, "\"]"));
      var option = Array.from(select.options).find(function (opt) {
        return opt.value === value;
      });
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

// FONCTION pour charger les bouteilles avec les critères de recherche, de tri, de pagination et de tags
function loadProducts(searchQuery, sortOption, selectedTags) {
  var page = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : 1;
  var query = searchQuery || '';
  var sort = sortOption || '';
  var tags = selectedTags || {};
  var url = "/search?search=".concat(encodeURIComponent(query), "&sort=").concat(encodeURIComponent(sort), "&page=").concat(encodeURIComponent(page));

  // Ajouter les tags aux paramètres de l'URL
  Object.keys(tags).forEach(function (key) {
    url += "&".concat(encodeURIComponent(key), "=").concat(encodeURIComponent(tags[key]));
  });
  fetch(url).then(function (response) {
    return response.json();
  }).then(function (data) {
    document.getElementById('search-results').innerHTML = data.resultsHtml;
    updateUrl(query, sort, tags, page);
  });
}
// FONCTION pour récupérer les tags sélectionnés avec leurs noms et valeurs du container de tags
function getSelectedTags() {
  var tagElements = document.querySelectorAll('.tag-container .tag');
  var tags = {};
  tagElements.forEach(function (tag) {
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
function updateUrl(searchQuery, sortOption, tags, page) {
  var params = new URLSearchParams();
  if (searchQuery) {
    params.append('search', searchQuery);
  }
  if (sortOption) {
    params.append('sort', sortOption);
  }
  var _loop = function _loop() {
    var _Object$entries$_i = _slicedToArray(_Object$entries[_i], 2),
      name = _Object$entries$_i[0],
      values = _Object$entries$_i[1];
    if (values.length > 0) {
      // Vérifiez si le tableau de valeurs n'est pas vide
      values.forEach(function (value) {
        params.append(name, value);
      });
    }
  };
  for (var _i = 0, _Object$entries = Object.entries(tags); _i < _Object$entries.length; _i++) {
    _loop();
  }
  params.append('page', page);
  var newUrl = "".concat(window.location.pathname, "?").concat(params.toString());
  window.history.pushState({}, '', newUrl);
}

// ==================================================================================================
// TAGS (création avec ses listeners) ===============================================================
// ==================================================================================================

// Récupérer les éléments du DOM
var selectElements = document.querySelectorAll("details select");
var sliderElements = document.querySelectorAll('input[type="range"]');
var numberElements = document.querySelectorAll('input[type="number"]');
var tagContainer = document.querySelector(".tag-container");
var resetButton = document.getElementById("reset-filters");

// LISTENER pour les sélecteurs (select)
selectElements.forEach(function (select) {
  select.addEventListener("change", function () {
    var selectedOption = this.options[this.selectedIndex];
    createTag(this.name, selectedOption.value, selectedOption.text);

    // Retirer l'option du select
    selectedOption.remove();
  });
});

// FONCTION pour créer les tags
function createTag(selectName, value, text) {
  var tag = document.createElement("div");
  tag.classList.add("tag");
  tag.textContent = text;
  tag.setAttribute("data-value", value);
  tag.setAttribute("data-select-name", selectName); // pour savoir quel select le tag est associé

  tagContainer.appendChild(tag);
  addTagRemoveListener(tag);
}
function addTagRemoveListener(tag) {
  tag.addEventListener("click", function () {
    var selectName = this.getAttribute("data-select-name");
    var associatedSelect = document.querySelector("select[name=\"".concat(selectName, "\"]"));
    var newOption = document.createElement("option");
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
  var tags = tagContainer.querySelectorAll(".tag");
  tags.forEach(function (tag) {
    var selectName = tag.getAttribute("data-select-name");
    var associatedSelect = document.querySelector("select[name=\"".concat(selectName, "\"]"));
    var value = tag.getAttribute("data-value");
    var newOption = document.createElement("option");
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
    var sliderGroup = slider.closest(".form-range"); // Trouver le groupe de slider parent
    var range = sliderGroup.querySelector(".form-range-selected");
    range.style.left = slider.min / slider.max * 100 + "%";
    range.style.right = (1 - slider.value / slider.max) * 100 + "%";
  });
});
/******/ })()
;