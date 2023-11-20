/**
 * Gestion du changement de l'utilisateur sélectionné dans la liste déroulante.
 */
document.getElementById('select_user').addEventListener('change', function () {
    var selectedUserId = this.value;
    var allUserTables = document.querySelectorAll('.user-table');

    // Masquer toutes les tables d'utilisateurs
    allUserTables.forEach(table => table.style.display = 'none');

    // Afficher la table correspondante à l'utilisateur sélectionné
    var selectedUserTable = document.querySelector('.user-table[data-user-id="' + selectedUserId + '"]');
    if (selectedUserTable) {
        selectedUserTable.style.display = 'block';
    }
});