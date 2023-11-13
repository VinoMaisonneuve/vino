// document.getElementById("search-box").addEventListener("keyup", function () {
//     var query = this.value;
//     fetchData(query);
// });

// document.addEventListener("click", function (e) {
//     if (
//         e.target.tagName === "A" &&
//         e.target.parentElement.hasAttribute("data-page")
//     ) {
//         e.preventDefault();
//         var query = document.getElementById("search-box").value;
//         var page = e.target.parentElement.getAttribute("data-page");
//         fetchData(query, page);
//     }
// });

// function fetchData(query, page = 1) {
//     fetch(`/search?query=${query}&page=${page}`)
//     // fetch(`/bouteilles?query=${query}&page=${page}`)
//         .then((response) => response.json())
//         .then((data) => {
//             document.getElementById("search-results").innerHTML =
//                 data.resultsHtml;
//             document.getElementById("pagination").innerHTML =
//                 data.paginationHtml;
//             // Update pagination links to include data-page attribute
//             updatePaginationLinks();
//         })
//         .catch((error) => console.error("Error:", error));
// }

// function updatePaginationLinks() {
//     document.querySelectorAll("#pagination a").forEach(function (link) {
//         const url = new URL(link.href);
//         const page = url.searchParams.get("page");
//         link.parentElement.setAttribute("data-page", page);
//         link.href = "#";
//     });
// }


// document.addEventListener('DOMContentLoaded', function() {
//     function loadProducts() {
//         const formData = new FormData(document.getElementById('form-search'));
//         const params = new URLSearchParams(formData).toString();
//         fetch(`/search?${params}`)
//             .then(response => response.text())
//             .then(html => {
//                 document.getElementById('search-results').innerHTML = html;
//                 // attachPaginationEventListeners();
//             });
//     }

//     function attachEventListeners() {
//         document.getElementById('search-input').addEventListener('input', loadProducts);
//         // document.getElementById('category-select').addEventListener('change', loadProducts);
//         // document.getElementById('sort').addEventListener('change', loadProducts);
//         // document.getElementById('direction-select').addEventListener('change', loadProducts);
//     }

//     attachEventListeners();
//     // attachPaginationEventListeners();
// });

// document.addEventListener('DOMContentLoaded', function() {
//     function loadProducts() {
//         const searchInput = document.getElementById('search-input').value;
//         fetch(`/search?search=${encodeURIComponent(searchInput)}`)
//             .then(response => response.json()) // Modifié pour s'attendre à une réponse JSON
//             .then(data => {
//                 document.getElementById('search-results').innerHTML = data.resultsHtml; // Assurez-vous que cet ID est correct
//             });
//     }

//     document.getElementById('search-input').addEventListener('input', loadProducts);
// });

// document.addEventListener('DOMContentLoaded', function() {
//     function loadProducts() {
//         const searchInput = document.getElementById('search-input').value;
//         const sortValue = document.getElementById('sort').value; // Récupérer la valeur de tri
//         fetch(`/search?search=${encodeURIComponent(searchInput)}&sort=${encodeURIComponent(sortValue)}`)
//             .then(response => response.json())
//             .then(data => {
//                 document.getElementById('search-results').innerHTML = data.resultsHtml;
//             });
//     }

//     // Ajouter listener pour recherche et tri
//     document.getElementById('search-input').addEventListener('input', loadProducts);
//     document.getElementById('sort').addEventListener('change', loadProducts);
// });

// document.addEventListener('click', function(event) {
//     if (event.target.matches('#pagination a')) {
//         event.preventDefault(); // Empêcher le lien de charger la page

//         // Récupérez le numéro de la page à partir de l'URL du lien cliqué
//         var pageUrl = new URL(event.target.href);
//         var page = pageUrl.searchParams.get('page') || 1; // Si le paramètre 'page' n'existe pas, 1 sera par défaut.

//         loadProducts(pageUrl.searchParams.get('search'), pageUrl.searchParams.get('sort'), pageUrl.searchParams.get('page'));
//     }
// });

// function loadProducts(searchQuery, sortOption,  page = 1) {
//     fetch(`/search?search=${encodeURIComponent(searchQuery || '')}&sort=${encodeURIComponent(sortOption || '')}&page=${encodeURIComponent(page || '')}`)
//         .then(response => response.json())
//         .then(data => {
//             document.getElementById('search-results').innerHTML = data.resultsHtml;
//             window.history.pushState({}, '', `?search=${searchQuery}&sort=${sortOption}&page=${page}`);
//         });
// }

// document.getElementById('search-input').addEventListener('input', function(event) {
//     loadProducts(event.target.value, document.getElementById('sort').value);
// });

// document.getElementById('sort').addEventListener('change', function(event) {
//     loadProducts(document.getElementById('search-input').value, event.target.value);
// });


// ===========================
// document.addEventListener('click', function(event) {
//     if (event.target.matches('#pagination a')) {
//         event.preventDefault();

//         // Récupérez le numéro de la page à partir de l'URL du lien cliqué
//         var pageUrl = new URL(event.target.href);
//         var page = pageUrl.searchParams.get('page') || 1; // Si le paramètre 'page' n'existe pas, 1 sera par défaut.

//         // Mise à jour pour utiliser les valeurs actuelles de la recherche et du tri
//         loadProducts(getSearchQuery(), getSortOption(), page);
//     }
// });

// // Modification: Ajout d'un paramètre par défaut 'page' pour la fonction loadProducts
// function loadProducts(searchQuery, sortOption, page = 1) {
//     // Mise à jour pour construire l'URL dynamiquement sans encodage manuel
//     let fetchUrl = `/search?search=${encodeURIComponent(searchQuery || '')}&sort=${encodeURIComponent(sortOption || '')}&page=${page}`;
    
//     fetch(fetchUrl)
//         .then(response => response.json())
//         .then(data => {
//             document.getElementById('search-results').innerHTML = data.resultsHtml;
//             // Modification: Mise à jour pour construire l'URL dynamiquement
//             updateUrl(searchQuery, sortOption, page);
//         });
// }

// // Fonctions pour récupérer les valeurs actuelles de la recherche et du tri
// function getSearchQuery() {
//     return document.getElementById('search-input').value || '';
// }

// function getSortOption() {
//     return document.getElementById('sort').value || '';
// }

// // Fonction pour mettre à jour l'URL
// function updateUrl(searchQuery, sortOption, page) {
//     let newUrl = `?search=${searchQuery}&sort=${sortOption}&page=${page}`;
//     window.history.pushState({}, '', newUrl);
// }

// document.getElementById('search-input').addEventListener('input', function(event) {
//     loadProducts(event.target.value, getSortOption());
// });

// document.getElementById('sort').addEventListener('change', function(event) {
//     loadProducts(getSearchQuery(), event.target.value);
// });

// ============================

// document.addEventListener('click', function(event) {
//     if (event.target.matches('#pagination a')) {
//         event.preventDefault(); // Empêcher le lien de charger la page

//         // Récupérez le numéro de la page à partir de l'URL du lien cliqué
//         var pageUrl = new URL(event.target.href);
//         var page = pageUrl.searchParams.get('page') || 1; // Si le paramètre 'page' n'existe pas, 1 sera par défaut.

//         var searchQuery = document.getElementById('search-input').value;
//         var sortOption = document.getElementById('sort').value;

//         loadProducts(searchQuery, sortOption, page);
//     }
// });

// function loadProducts(searchQuery, sortOption, page = 1) {
//     var query = searchQuery || '';
//     var sort = sortOption || '';
//     var url = `/search?search=${encodeURIComponent(query)}&sort=${encodeURIComponent(sort)}&page=${encodeURIComponent(page)}`;

//     fetch(url)
//         .then(response => response.json())
//         .then(data => {
//             document.getElementById('search-results').innerHTML = data.resultsHtml;
//             updateUrl(query, sort, page);
//         });
// }

// document.getElementById('search-input').addEventListener('input', function(event) {
//     loadProducts(event.target.value, document.getElementById('sort').value);
// });

// document.getElementById('sort').addEventListener('change', function(event) {
//     loadProducts(document.getElementById('search-input').value, event.target.value);
// });

// // Pour que les paramètres vides ("") ne s'affiche pas dans l'url
// function updateUrl(searchQuery, sortOption, page) {
//     let params = new URLSearchParams();

//     // Ajouter le paramètre de recherche à l'URL seulement s'il n'est pas vide
//     if (searchQuery) {
//         params.append('search', searchQuery);
//     }
//     // Ajouter le paramètre de tri à l'URL seulement s'il n'est pas vide
//     if (sortOption) {
//         params.append('sort', sortOption);
//     }
//     // Toujours ajouter le paramètre de page car il a une valeur par défaut (1)
//     params.append('page', page);

//     let newUrl = `${window.location.pathname}?${params.toString()}`;
//     window.history.pushState({}, '', newUrl);
// }


// // Fonction pour récupérer les tags sélectionnés avec leurs noms et valeurs
// function getSelectedTags() {
//     var tagElements = document.querySelectorAll('.tag-container .tag');
//     var tags = Array.from(tagElements).reduce(function(acc, tag) {
//         var key = tag.getAttribute('data-select-name'); // Le nom du champ
//         var value = tag.getAttribute('data-value'); // La valeur du champ
//         if (key && value) {
//             acc[key] = value;
//         }
//         return acc;
//     }, {});
//     return tags;
// }
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

