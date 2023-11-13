/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************!*\
  !*** ./resources/js/filterTag.js ***!
  \***********************************/
var selectElements = document.querySelectorAll("details select");
var sliderElements = document.querySelectorAll('input[type="range"]');
var numberElements = document.querySelectorAll('input[type="number"]');
var tagContainer = document.querySelector(".tag-container");
var resetButton = document.getElementById("reset-filters");

// Listener pour les sélecteurs (select)
selectElements.forEach(function (select) {
  select.addEventListener("change", function () {
    var selectedOption = this.options[this.selectedIndex];
    var value = selectedOption.value;
    var text = selectedOption.text;

    // Créer un nouveau tag
    var tag = document.createElement("div");
    tag.classList.add("tag");
    tag.textContent = text;
    tag.setAttribute("data-value", value);
    tag.setAttribute("data-select-name", this.name); // Stocker le nom du select associé

    // Ajouter le tag au conteneur
    tagContainer.appendChild(tag);

    // Retirer l'option du select
    selectedOption.remove();

    // Listener pour supprimer le tag
    tag.addEventListener("click", function () {
      var selectName = this.getAttribute("data-select-name");
      var associatedSelect = document.querySelector("select[name=\"".concat(selectName, "\"]"));
      var newOption = document.createElement("option");
      newOption.value = this.getAttribute("data-value");
      newOption.text = this.textContent;
      associatedSelect.add(newOption);
      this.remove();
    });
  });
});

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