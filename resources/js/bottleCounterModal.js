document.querySelectorAll('.card-bouteille-qt').forEach(function (counter) {
    var input = counter.querySelector('input');
    var decrementButton = counter.querySelector('.btn-decrement');
    var incrementButton = counter.querySelector('.btn-increment');
    decrementButton.addEventListener('click', function (event) {
      event.preventDefault();
      var currentValue = parseInt(input.value, 10);
      if (currentValue > 0) {
        input.value = currentValue - 1;
      }
    });
    incrementButton.addEventListener('click', function (event) {
      event.preventDefault();
      var currentValue = parseInt(input.value, 10);
      input.value = currentValue + 1;
    });
  });