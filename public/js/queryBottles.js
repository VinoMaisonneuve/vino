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
// LISTENERS =================================================================
// ===========================================================================

// Ajout de listener pour empêcher que la page se recharge quand on appuie Enter
document.getElementById('search-input').addEventListener('keydown', function (event) {
  if (event.key === 'Enter') {
    // Empêche que la page se recharge
    event.preventDefault();
  }
});

// Ajout de listener pour la saisie dans recherche
document.getElementById('search-input').addEventListener('input', function (event) {
  // Charge les bouteilles avec la valeur actuelle de recherche, l'option de tri sélectionnée, les tags sélectionnés, et réinitialise la page à 1
  loadProducts(event.target.value, document.getElementById('sort').value, getSelectedTags(), 1);
});

// Ajout de listener pour le changement de l'option de tri
document.getElementById('sort').addEventListener('change', function (event) {
  // Charge les bouteilles avec la valeur actuelle de recherche, la nouvelle option de tri, les tags sélectionnés, et réinitialise la page à 1
  loadProducts(document.getElementById('search-input').value, event.target.value, getSelectedTags(), 1);
});

// Ajout de listener pour tout changement dans le formulaire de filtrage
document.getElementById('form-filter').addEventListener('change', function () {
  // Charge les bouteilles avec la valeur actuelle de recherche, l'option de tri sélectionnée, les tags sélectionnés, et réinitialise la page à 1
  loadProducts(document.getElementById('search-input').value, document.getElementById('sort').value, getSelectedTags(), 1);
});
// Ajout de listener pour le bouton "réinitialiser"
document.getElementById('reset-filters').addEventListener('click', function () {
  // Réinitialiser le formulaire de filtrage
  var form = document.getElementById('form-filter');
  form.reset();
  // Charge les bouteilles avec la valeur actuelle de recherche, l'option de tri sélectionnée, les tags par défaut (vide), et réinitialise la page à 1
  loadProducts(document.getElementById('search-input').value, document.getElementById('sort').value, {}, 1);
});

// Ajout de listener pour la pagination
document.addEventListener('click', function (event) {
  if (event.target.matches('#pagination a')) {
    event.preventDefault(); // Empêche le lien de charger la page
    var pageUrl = new URL(event.target.href);
    var page = pageUrl.searchParams.get('page') || 1;
    // Charge les bouteilles avec la valeur actuelle de recherche, l'option de tri sélectionnée, les tags sélectionnés, et la page sélectionnée
    loadProducts(document.getElementById('search-input').value, document.getElementById('sort').value, getSelectedTags(), page);
  }
});

// FONCTIONS ================================================================
// ==========================================================================

// CHARGER LES PRODUITS ===========

// Fonction pour charger les bouteilles avec les critères de recherche, de tri, de pagination et de tags
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

// UPDATE URL ======================

// Fonction pour mettre à jour l'URL sans recharger la page
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

// TAGS ========

// Fonction pour récupérer les tags sélectionnés avec leurs noms et valeurs
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
/******/ })()
;