/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************!*\
  !*** ./resources/js/statsUser.js ***!
  \***********************************/
/**
 * Gestion du changement de l'utilisateur sélectionné dans la liste déroulante.
 */
document.getElementById('select_user').addEventListener('change', function () {
  var selectedUserId = this.value;
  var allUserTables = document.querySelectorAll('.admin-table');

  // Masquer toutes les tables d'utilisateurs
  allUserTables.forEach(function (table) {
    return table.style.display = 'none';
  });

  // Afficher la table correspondante à l'utilisateur sélectionné
  var selectedUserTable = document.querySelector('.admin-table[data-user-id="' + selectedUserId + '"]');
  if (selectedUserTable) {
    selectedUserTable.style.display = 'block';
  }
});
/******/ })()
;