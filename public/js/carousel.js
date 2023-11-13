/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************!*\
  !*** ./resources/js/carousel.js ***!
  \**********************************/
// RÉCUPÉRER LES ÉLÉMENTS DU DOM ======================================================

// Sélectionner tous les slides du carousel
var slides = document.querySelectorAll(".carousel-slide");
var prevButton = document.querySelector(".btn-prev");
var nextButton = document.querySelector(".btn-next");

// LISTENERS ==========================================================================

// Ajoute un écouteur d'événement pour le bouton précédent
prevButton.addEventListener("click", function () {
  // Affiche le slide précédent
  showSlide(--slideIndex);
});

// Ajoute un écouteur d'événement pour le bouton suivant
nextButton.addEventListener("click", function () {
  // Affiche le slide suivant
  showSlide(++slideIndex);
});

// FONCTION ===========================================================================

// Initialiser l'index du slide à 0
var slideIndex = 0;

// FONCTION pour afficher un slide spécifique
function showSlide(n) {
  // Si l'index du slide est supérieur au nombre total, retourner au premier slide
  if (n >= slides.length) {
    slideIndex = 0;
  }
  // Si l'index du slide est inférieur à 0, aller au dernier slide
  if (n < 0) {
    slideIndex = slides.length - 1;
  }

  // Cacher tous les slides
  slides.forEach(function (slide) {
    slide.style.display = "none";
  });
  // Afficher le slide courant
  slides[slideIndex].style.display = "block";
}

// Afficher le premier slide au chargement de la page
showSlide(slideIndex);
/******/ })()
;