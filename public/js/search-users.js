/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**************************************!*\
  !*** ./resources/js/search-users.js ***!
  \**************************************/
document.addEventListener('DOMContentLoaded', function () {
  var searchInput = document.getElementById('search_users');
  var tableRows = document.querySelectorAll('.user-row');
  searchInput.addEventListener('input', function () {
    var searchTerm = this.value.toLowerCase();
    tableRows.forEach(function (row) {
      var userName = row.querySelector('.user-name').textContent.toLowerCase();
      var userId = row.querySelector('.user-id').textContent.toLowerCase();
      if (userName.includes(searchTerm) || userId.includes(searchTerm)) {
        row.style.display = 'table-row';
      } else {
        row.style.display = 'none';
      }
    });
  });
});
/******/ })()
;