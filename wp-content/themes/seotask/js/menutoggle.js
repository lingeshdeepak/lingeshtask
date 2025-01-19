document.addEventListener('DOMContentLoaded', function () {
    const searchToggle = document.getElementById('search-toggle');
    const searchBar = document.getElementById('search-bar');

    searchToggle.addEventListener('click', function () {
        searchBar.style.display =
            searchBar.style.display === 'block' ? 'none' : 'block';
    });
});
