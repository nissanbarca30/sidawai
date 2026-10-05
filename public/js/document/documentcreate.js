function toggleCategoryInput(kategori) {
    const sectionTanggal = document.getElementById('section-tanggal');
    const inputTglMulai = document.getElementById('tanggal_mulai');

    if (kategori === 'data_dukung') {
        sectionTanggal.classList.remove('hidden');
        inputTglMulai.setAttribute('required', 'required');
    } else {
        sectionTanggal.classList.add('hidden');
        inputTglMulai.removeAttribute('required');
    }
}

// Handler Drag & Drop JavaScript (Sensitif Dark Mode)
const dropzoneArea = document.getElementById('dropzone-area');
const fileInput = document.getElementById('lampiran');

function handleDragOver(e) {
    e.preventDefault();
    e.stopPropagation();
    dropzoneArea.classList.add('bg-emerald-100/70', 'dark:bg-emerald-900/40', 'border-[#40BF89]');
}

function handleDragLeave(e) {
    e.preventDefault();
    e.stopPropagation();
    dropzoneArea.classList.remove('bg-emerald-100/70', 'dark:bg-emerald-900/40', 'border-[#40BF89]');
}

function handleDrop(e) {
    e.preventDefault();
    e.stopPropagation();
    dropzoneArea.classList.remove('bg-emerald-100/70', 'dark:bg-emerald-900/40', 'border-[#40BF89]');

    const files = e.dataTransfer.files;
    if (files.length > 0) {
        fileInput.files = files;
        updateFileList(files);
    }
}

function updateFileList(files) {
    const prompt = document.getElementById('dropzone-prompt');
    const container = document.getElementById('file-list-container');
    const list = document.getElementById('file-names-list');
    const count = document.getElementById('file-count');

    if (files && files.length > 0) {
        prompt.classList.add('hidden');
        container.classList.remove('hidden');
        list.innerHTML = '';
        count.innerText = files.length;

        Array.from(files).forEach(file => {
            const item = document.createElement('div');
            item.className = 'flex items-center space-x-2 text-xs font-bold text-black dark:text-white bg-white dark:bg-gray-800 p-1.5 rounded border border-black/30 dark:border-gray-600 truncate';
            item.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#40BF89] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <span class="truncate">${file.name}</span>
            `;
            list.appendChild(item);
        });
    } else {
        resetFiles();
    }
}

function resetFiles() {
    fileInput.value = '';
    document.getElementById('dropzone-prompt').classList.remove('hidden');
    document.getElementById('file-list-container').classList.add('hidden');
}