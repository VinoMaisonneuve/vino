document.getElementById('zoomableImage').addEventListener('click', openModal);
document.getElementById('modalClose').addEventListener('click', closeModal);

function openModal() {
    document.getElementById('zoomModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('zoomModal').style.display = 'none';
}