/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**************************************!*\
  !*** ./resources/js/search-users.js ***!
  \**************************************/
document.addEventListener('DOMContentLoaded', function () {
  var searchForm = document.getElementById('searchForm');
  var searchInput = document.getElementById('search_users');
  var tableContainer = document.querySelector('.admin-table-container');
  searchInput.addEventListener('input', function () {
    var searchTerm = this.value;
    fetch("".concat(window.location.origin, "/admin/search-users?search_users=").concat(searchTerm), {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    }).then(function (response) {
      return response.text();
    }).then(function (html) {
      tableContainer.innerHTML = html;
    })["catch"](function (error) {
      return console.error('Error:', error);
    });
  });
});
/******/ })()
;