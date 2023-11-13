// https://github.com/w3collective/price-range-slider
// avec modification pour que ça s'applique sur plusieurs
const rangeMin = 1;

function updateRangeSlider(sliderGroup) {
  const range = sliderGroup.querySelector('.form-range-selected');
  const rangeInputs = sliderGroup.querySelectorAll('.form-range-input input');
  const numberInputs = sliderGroup.querySelectorAll('.form-range-number input');

  let minVal = parseInt(rangeInputs[0].value);
  let maxVal = parseInt(rangeInputs[1].value);

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
  range.style.left = (minVal / rangeInputs[0].max) * 100 + "%";
  range.style.right = 100 - (maxVal / rangeInputs[1].max) * 100 + "%";
}

// Listener pour chaque groupe de slider
document.querySelectorAll('.form-range').forEach((sliderGroup) => {
  const rangeInputs = sliderGroup.querySelectorAll('.form-range-input input');
  const numberInputs = sliderGroup.querySelectorAll('.form-range-number input');

  rangeInputs.forEach((input) => {
    input.addEventListener('input', () => updateRangeSlider(sliderGroup));
  });

  numberInputs.forEach((input) => {
    input.addEventListener('input', () => {
      let minVal = parseInt(numberInputs[0].value);
      let maxVal = parseInt(numberInputs[1].value);

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
