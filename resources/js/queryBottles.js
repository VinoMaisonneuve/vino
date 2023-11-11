// LISTENERS =================================================================
// ===========================================================================

// Ajout de listener pour empêcher que la page se recharge quand on appuie Enter
document.getElementById('search-input').addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        // Empêche que la page se recharge
        event.preventDefault();
    }
});

// Ajout de listener pour la saisie dans recherche
document.getElementById('search-input').addEventListener('input', function(event) {
    // Charge les bouteilles avec la valeur actuelle de recherche, l'option de tri sélectionnée, les tags sélectionnés, et réinitialise la page à 1
    loadProducts(event.target.value, document.getElementById('sort').value, getSelectedTags(), 1);
});

// Ajout de listener pour le changement de l'option de tri
document.getElementById('sort').addEventListener('change', function(event) {
    // Charge les bouteilles avec la valeur actuelle de recherche, la nouvelle option de tri, les tags sélectionnés, et réinitialise la page à 1
    loadProducts(document.getElementById('search-input').value, event.target.value, getSelectedTags(), 1);
});

// Ajout de listener pour tout changement dans le formulaire de filtrage
document.getElementById('form-filter').addEventListener('change', function() {
    // Charge les bouteilles avec la valeur actuelle de recherche, l'option de tri sélectionnée, les tags sélectionnés, et réinitialise la page à 1
    loadProducts(document.getElementById('search-input').value, document.getElementById('sort').value, getSelectedTags(), 1);
});
// Ajout de listener pour le bouton "réinitialiser"
document.getElementById('reset-filters').addEventListener('click', function() {
    // Réinitialiser le formulaire de filtrage
    var form = document.getElementById('form-filter');
    form.reset();
    // Charge les bouteilles avec la valeur actuelle de recherche, l'option de tri sélectionnée, les tags par défaut (vide), et réinitialise la page à 1
    loadProducts(document.getElementById('search-input').value, document.getElementById('sort').value, {}, 1);
});

// Ajout de listener pour la pagination
document.addEventListener('click', function(event) {
    if (event.target.matches('#pagination a')) {
        event.preventDefault(); // Empêche le lien de charger la page
        var pageUrl = new URL(event.target.href);
        var page = pageUrl.searchParams.get('page') || 1;
        // Charge les bouteilles avec la valeur actuelle de recherche, l'option de tri sélectionnée, les tags sélectionnés, et la page sélectionnée
        loadProducts(document.getElementById('search-input').value, document.getElementById('sort').value, getSelectedTags(), page);
    }
});

// FONCTIONS ================================================================
// ==========================================================================


// CHARGER LES PRODUITS ===========

// Fonction pour charger les bouteilles avec les critères de recherche, de tri, de pagination et de tags
function loadProducts(searchQuery, sortOption, selectedTags, page = 1) {
    var query = searchQuery || '';
    var sort = sortOption || '';
    var tags = selectedTags || {};
    var url = `/search?search=${encodeURIComponent(query)}&sort=${encodeURIComponent(sort)}&page=${encodeURIComponent(page)}`;
    
    // Ajouter les tags aux paramètres de l'URL
    Object.keys(tags).forEach(key => {
        url += `&${encodeURIComponent(key)}=${encodeURIComponent(tags[key])}`;
    });

    fetch(url)
        .then(response => response.json())
        .then(data => {
            document.getElementById('search-results').innerHTML = data.resultsHtml;
            updateUrl(query, sort, tags, page);
        });
}


// UPDATE URL ======================

// Fonction pour mettre à jour l'URL sans recharger la page
function updateUrl(searchQuery, sortOption, tags, page ) {
    let params = new URLSearchParams();

    if (searchQuery) {
        params.append('search', searchQuery);
    }
    if (sortOption) {
        params.append('sort', sortOption);
    }
    for (const [name, values] of Object.entries(tags)) {
        if (values.length > 0) { // Vérifiez si le tableau de valeurs n'est pas vide
            values.forEach(value => {
                params.append(name, value);
            });
        }
    }
    

    params.append('page', page);

    let newUrl = `${window.location.pathname}?${params.toString()}`;
    window.history.pushState({}, '', newUrl);
}

// TAGS ========

// Fonction pour récupérer les tags sélectionnés avec leurs noms et valeurs
function getSelectedTags() {
    var tagElements = document.querySelectorAll('.tag-container .tag');
    var tags = {};
    tagElements.forEach(function(tag) {
        var key = tag.getAttribute('data-select-name'); // Le nom du filtre, par exemple 'couleur'
        var value = tag.getAttribute('data-value'); // La valeur sélectionnée, par exemple 'rouge'

        // Si la clé n'existe pas déjà dans l'objet tags, créer un tableau vide
        if (!tags[key]) {
            tags[key] = [];
        }

        // Ajouter la valeur au tableau correspondant à la clé dans l'objet tags
        tags[key].push(value);
    });
    return tags;
}
