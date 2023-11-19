document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('search_users');
    const tableContainer = document.querySelector('.admin-table-container');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value;

        fetch(`${window.location.origin}/admin/search-users?search_users=${searchTerm}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.text())
            .then(html => {
                tableContainer.innerHTML = html;
            })
            .catch(error => console.error('Error:', error));
    });
});