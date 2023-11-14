/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***************************************!*\
  !*** ./resources/js/search-cellar.js ***!
  \***************************************/
/**
 * Fonction de recherche d'une bouteille dans un cellier par son nom.
 */
document.addEventListener('DOMContentLoaded', function () {
  var searchInput = document.getElementById('search_cellar');
  var bottleCards = document.querySelectorAll('.card-bouteille');
  searchInput.addEventListener('input', function () {
    var searchTerm = this.value.toLowerCase();
    bottleCards.forEach(function (card) {
      var bottleName = card.querySelector('.bottle-name').textContent.toLowerCase();
      if (bottleName.includes(searchTerm)) {
        card.style.display = '';
      } else {
        card.style.display = 'none';
      }
    });
  });
});
/******/ })()
;