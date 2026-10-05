document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-pegawai');
    const sortSelect = document.getElementById('sort-pegawai');
    const btnGridView = document.getElementById('btn-view-grid');
    const btnListView = document.getElementById('btn-view-list');
    
    const containerGrid = document.getElementById('pegawai-grid-view');
    const containerList = document.getElementById('pegawai-list-view');
    const noResults = document.getElementById('no-pegawai-found');

    const gridItems = Array.from(document.querySelectorAll('.pegawai-card-item'));
    const listRows = Array.from(document.querySelectorAll('.pegawai-row-item'));

    function setViewLayout(mode) {
        if (mode === 'list') {
            containerGrid.classList.add('d-none');
            containerList.classList.remove('d-none');
            
            btnListView.classList.add('active', 'btn-secondary');
            btnListView.classList.remove('btn-outline-secondary');
            
            btnGridView.classList.remove('active', 'btn-secondary');
            btnGridView.classList.add('btn-outline-secondary');
            
            localStorage.setItem('admin_doc_view_mode', 'list');
        } else {
            containerList.classList.add('d-none');
            containerGrid.classList.remove('d-none');
            
            btnGridView.classList.add('active', 'btn-secondary');
            btnGridView.classList.remove('btn-outline-secondary');
            
            btnListView.classList.remove('active', 'btn-secondary');
            btnListView.classList.add('btn-outline-secondary');
            
            localStorage.setItem('admin_doc_view_mode', 'grid');
        }
    }

    const savedMode = localStorage.getItem('admin_doc_view_mode') || 'grid';
    setViewLayout(savedMode);

    btnGridView.addEventListener('click', () => setViewLayout('grid'));
    btnListView.addEventListener('click', () => setViewLayout('list'));

    function filterAndSortData() {
        const query = searchInput.value.toLowerCase().trim();
        const sortValue = sortSelect.value;

        let visibleGridCount = 0;

        gridItems.forEach(item => {
            const name = item.getAttribute('data-name');
            const nip = item.getAttribute('data-nip');
            const email = item.getAttribute('data-email');

            if (name.includes(query) || nip.includes(query) || email.includes(query)) {
                item.classList.remove('d-none');
                visibleGridCount++;
            } else {
                item.classList.add('d-none');
            }
        });

        listRows.forEach(row => {
            const name = row.getAttribute('data-name');
            const nip = row.getAttribute('data-nip');
            const email = row.getAttribute('data-email');

            if (name.includes(query) || nip.includes(query) || email.includes(query)) {
                row.classList.remove('d-none');
            } else {
                row.classList.add('d-none');
            }
        });

        if (sortValue !== 'default') {
            sortElements(gridItems, containerGrid, sortValue);
            sortElements(listRows, document.getElementById('pegawai-table-body'), sortValue);
            reindexListNumbers();
        }

        if (visibleGridCount === 0 && gridItems.length > 0) {
            noResults.classList.remove('d-none');
        } else {
            noResults.classList.add('d-none');
        }
    }

    function sortElements(items, parentContainer, criteria) {
        items.sort((a, b) => {
            const nameA = a.getAttribute('data-name');
            const nameB = b.getAttribute('data-name');
            const docsA = parseInt(a.getAttribute('data-docs')) || 0;
            const docsB = parseInt(b.getAttribute('data-docs')) || 0;

            if (criteria === 'name_asc') {
                return nameA.localeCompare(nameB);
            } else if (criteria === 'name_desc') {
                return nameB.localeCompare(nameA);
            } else if (criteria === 'docs_desc') {
                return docsB - docsA;
            } else if (criteria === 'docs_asc') {
                return docsA - docsB;
            }
            return 0;
        });

        items.forEach(el => parentContainer.appendChild(el));
    }

    function reindexListNumbers() {
        let visibleIndex = 1;
        listRows.forEach(row => {
            if (!row.classList.contains('d-none')) {
                const numCell = row.querySelector('.row-number');
                if (numCell) numCell.textContent = visibleIndex++;
            }
        });
    }

    searchInput.addEventListener('keyup', filterAndSortData);
    sortSelect.addEventListener('change', filterAndSortData);
});