const selectElements = document.querySelectorAll("details select");
const sliderElements = document.querySelectorAll('input[type="range"]');
const numberElements = document.querySelectorAll('input[type="number"]');
const tagContainer = document.querySelector(".tag-container");
const resetButton = document.getElementById("reset-filters");

// Listener pour les sélecteurs (select)
selectElements.forEach(function (select) {
    select.addEventListener("change", function () {
        const selectedOption = this.options[this.selectedIndex];
        const value = selectedOption.value;
        const text = selectedOption.text;

        // Créer un nouveau tag
        const tag = document.createElement("div");
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
            const selectName = this.getAttribute("data-select-name");
            const associatedSelect = document.querySelector(
                `select[name="${selectName}"]`
            );
            const newOption = document.createElement("option");
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
    const tags = tagContainer.querySelectorAll(".tag");
    tags.forEach(function (tag) {
        const selectName = tag.getAttribute("data-select-name");
        const associatedSelect = document.querySelector(
            `select[name="${selectName}"]`
        );
        const value = tag.getAttribute("data-value");
        const newOption = document.createElement("option");
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
        const sliderGroup = slider.closest(".form-range"); // Trouver le groupe de slider parent
        const range = sliderGroup.querySelector(".form-range-selected");
        range.style.left = (slider.min / slider.max) * 100 + "%";
        range.style.right = (1 - slider.value / slider.max) * 100 + "%";
    });
});
