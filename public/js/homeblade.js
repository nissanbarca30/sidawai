document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-input');
    const clearBtn = document.getElementById('clear-search');
    const folderItems = document.querySelectorAll('.folder-item');
    const noResults = document.getElementById('no-search-results');

    function filterFolders() {
        const query = searchInput.value.toLowerCase().trim();
        let visibleCount = 0;

        if (query.length > 0) {
            clearBtn.classList.remove('hidden');
        } else {
            clearBtn.classList.add('hidden');
        }

        folderItems.forEach(function (item) {
            const bulanName = item.getAttribute('data-bulan') || '';

            if (bulanName.includes(query)) {
                item.style.setProperty('display', 'table-row', 'important');
                visibleCount++;
            } else {
                item.style.setProperty('display', 'none', 'important');
            }
        });

        if (noResults) {
            if (visibleCount === 0 && folderItems.length > 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterFolders);
    }

    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            searchInput.value = '';
            filterFolders();
            searchInput.focus();
        });
    }
});