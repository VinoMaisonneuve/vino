/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************!*\
  !*** ./resources/js/showToast.js ***!
  \***********************************/
window.onload = function () {
  var toast = document.getElementById("snackbar");
  toast.className = "show";
  setTimeout(function () {
    toast.className = toast.className.replace("show", "");
  }, 3000);
};
/******/ })()
;