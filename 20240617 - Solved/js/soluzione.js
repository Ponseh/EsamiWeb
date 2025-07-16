// Funzione per controllare se un valore è un numero intero positivo
function isPositiveInteger(value) {
    const num = parseInt(value);
    return !isNaN(num) && num > 0 && num.toString() === value.toString();
}

// Funzione per creare una tabella accessibile per un singolo manga
function createMangaTable(manga) {
    const table = document.createElement('table');
    table.setAttribute('role', 'table');
    table.setAttribute('aria-label', 'Dettagli manga');
    
    // Intestazione con il titolo del manga
    const thead = document.createElement('thead');
    const headerRow = document.createElement('tr');
    const titleHeader = document.createElement('th');
    titleHeader.textContent = manga.titolo || 'Titolo non disponibile';
    titleHeader.setAttribute('colspan', '2');
    titleHeader.setAttribute('scope', 'col');
    headerRow.appendChild(titleHeader);
    thead.appendChild(headerRow);
    table.appendChild(thead);
    
    // Corpo della tabella con i dati
    const tbody = document.createElement('tbody');
    
    // Itera attraverso le proprietà del manga (escluso il titolo)
    for (const [key, value] of Object.entries(manga)) {
        if (key !== 'titolo') {
            const row = document.createElement('tr');
            
            const labelCell = document.createElement('th');
            labelCell.textContent = key.charAt(0).toUpperCase() + key.slice(1);
            labelCell.setAttribute('scope', 'row');
            
            const valueCell = document.createElement('td');
            valueCell.textContent = value;
            
            row.appendChild(labelCell);
            row.appendChild(valueCell);
            tbody.appendChild(row);
        }
    }
    
    table.appendChild(tbody);
    return table;
}

// Funzione per creare un elenco non ordinato per tutti i manga
function createMangaList(mangas) {
    const ul = document.createElement('ul');
    ul.setAttribute('role', 'list');
    ul.setAttribute('aria-label', 'Elenco manga');
    
    mangas.forEach(manga => {
        const li = document.createElement('li');
        li.setAttribute('role', 'listitem');
        
        // Crea una stringa con le informazioni del manga
        const mangaInfo = Object.entries(manga)
            .map(([key, value]) => `${key.charAt(0).toUpperCase() + key.slice(1)}: ${value}`)
            .join(', ');
        
        li.textContent = mangaInfo;
        ul.appendChild(li);
    });
    
    return ul;
}

// Funzione per gestire gli errori
function handleError(error, container) {
    container.innerHTML = '';
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = `Errore: ${error.message}`;
    errorDiv.setAttribute('role', 'alert');
    container.appendChild(errorDiv);
}

// Funzione per pulire il contenitore dei risultati
function clearResults(container) {
    container.innerHTML = '';
}

// Event listener per il bottone "Leggi Manga"
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('button');
    const leggiMangaBtn = buttons[0]; // Primo bottone "Leggi Manga"
    const leggiTuttiMangaBtn = buttons[1]; // Secondo bottone "Leggi Tutti i Manga"
    const inputManga = document.querySelector('input[type="number"]');
    const risultatiContainer = document.querySelector('main');
    
    // Gestione click su "Leggi Manga"
    leggiMangaBtn.addEventListener('click', function() {
        const inputValue = inputManga.value.trim();
        
        // Controllo che sia un numero intero positivo
        if (!isPositiveInteger(inputValue)) {
            alert('Inserisci un numero intero positivo');
            return;
        }
        
        // Pulisci i risultati precedenti
        clearResults(risultatiContainer);
        
        // Richiesta POST al file manga.json
        fetch('manga.json', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: parseInt(inputValue) })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(manga => {
            // Visualizza i dati del manga in una tabella
            const table = createMangaTable(manga);
            risultatiContainer.appendChild(table);
        })
        .catch(error => {
            handleError(error, risultatiContainer);
        });
    });
    
    // Gestione click su "Leggi Tutti i Manga"
    leggiTuttiMangaBtn.addEventListener('click', function() {
        // Pulisci i risultati precedenti
        clearResults(risultatiContainer);
        
        // Richiesta GET al file mangas.json
        fetch('mangas.json', {
            method: 'GET'
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(mangas => {
            // Visualizza i dati di tutti i manga in un elenco non ordinato
            const list = createMangaList(mangas);
            risultatiContainer.appendChild(list);
        })
        .catch(error => {
            handleError(error, risultatiContainer);
        });
    });
});