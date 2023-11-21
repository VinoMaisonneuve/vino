document.addEventListener("DOMContentLoaded", function() {
    var path = document.getElementById('textPath');
    var text = document.querySelector('textPath');

    var pathLength = path.getTotalLength();
    var textLength = text.getComputedTextLength();

    var fontSize = parseInt(window.getComputedStyle(text).fontSize);
    var scaleFactor = pathLength / textLength;

    text.style.fontSize = (fontSize * scaleFactor) + 'px';
});