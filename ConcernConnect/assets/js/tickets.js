document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-tickets');
    const filterSelect = document.getElementById('filter-status');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            applyFilters();
        });
    }
    
    if (filterSelect) {
        filterSelect.addEventListener('change', function() {
            applyFilters();
        });
    }
    
    function applyFilters() {
        const search = searchInput.value;
        const filter = filterSelect.value;
        
        let url = 'tickets.php?';
        if (search) url += 'search=' + encodeURIComponent(search) + '&';
        if (filter && filter !== 'all') url += 'filter=' + encodeURIComponent(filter);
        
        window.location.href = url;
    }
});
