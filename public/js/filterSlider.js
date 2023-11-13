/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**************************************!*\
  !*** ./resources/js/filterSlider.js ***!
  \**************************************/
// https://github.com/w3collective/price-range-slider
// avec modification pour que ça s'applique sur plusieurs
var rangeMin = 1;
function updateRangeSlider(sliderGroup) {
  var range = sliderGroup.querySelector('.form-range-selected');
  var rangeInputs = sliderGroup.querySelectorAll('.form-range-input input');
  var numberInputs = sliderGroup.querySelectorAll('.form-range-number input');
  var minVal = parseInt(rangeInputs[0].value);
  var maxVal = parseInt(rangeInputs[1].value);
  if (maxVal - minVal < rangeMin) {
    if (minVal === parseInt(numberInputs[0].value)) {
      minVal = maxVal - rangeMin;
    } else {
      maxVal = minVal + rangeMin;
    }
    rangeInputs[0].value = minVal;
    rangeInputs[1].value = maxVal;
  }
  numberInputs[0].value = minVal;
  numberInputs[1].value = maxVal;
  range.style.left = minVal / rangeInputs[0].max * 100 + "%";
  range.style.right = 100 - maxVal / rangeInputs[1].max * 100 + "%";
}

// Listener pour chaque groupe de slider
document.querySelectorAll('.form-range').forEach(function (sliderGroup) {
  var rangeInputs = sliderGroup.querySelectorAll('.form-range-input input');
  var numberInputs = sliderGroup.querySelectorAll('.form-range-number input');
  rangeInputs.forEach(function (input) {
    input.addEventListener('input', function () {
      return updateRangeSlider(sliderGroup);
    });
  });
  numberInputs.forEach(function (input) {
    input.addEventListener('input', function () {
      var minVal = parseInt(numberInputs[0].value);
      var maxVal = parseInt(numberInputs[1].value);

      // Vérifier la contrainte de distance minimale et limites des curseurs
      if (minVal < parseInt(rangeInputs[0].min)) minVal = parseInt(rangeInputs[0].min);
      if (maxVal > parseInt(rangeInputs[1].max)) maxVal = parseInt(rangeInputs[1].max);
      if (maxVal - minVal < rangeMin) {
        if (input === numberInputs[0]) {
          minVal = maxVal - rangeMin;
        } else {
          maxVal = minVal + rangeMin;
        }
      }
      rangeInputs[0].value = minVal;
      rangeInputs[1].value = maxVal;
      updateRangeSlider(sliderGroup);
    });
  });
});
/******/ })()
;