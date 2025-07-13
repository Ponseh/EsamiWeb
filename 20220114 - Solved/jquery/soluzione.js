/*
Al caricamento della pagina deve essere generata una matrice 6 * 7 che contenga casualmente 1 o 2. In base alla matrice, devono essere inserite tante righe e colonne nella prima tabella in modo che le celle con valore “1” abbiano come colore di sfondo il rosso mentre quelle con valore “2” abbiano sfondo blu.
Al click su una cella della prima tabella, questa non deve più avere un proprio colore di sfondo ma prendere quello del padre e nella matrice la relativa cella deve assumere valore “0”. NB: organizzare il codice in modo che non sia necessario cambiare il codice se cambia il colore di sfondo nel css.
Al click sul bottone, deve essere visualizzata nella seconda tabella lo stato corrente della matrice. Se la tabella è già presente, va sostituita. NB: questo vi serve per controllare se la matrice e la prima tabella sono “allineate”.
*/

// Matrice 6x7 che conterrà i valori 1, 2 o 0
let matrix = [];

// Colori associati ai valori della matrice
const colors = {
    1: 'red',
    2: 'blue',
    0: '' // Nessun colore di sfondo (eredita dal padre)
};

// Funzione per generare la matrice iniziale
function generateMatrix() {
    matrix = [];
    for (let i = 0; i < 6; i++) {
        matrix[i] = [];
        for (let j = 0; j < 7; j++) {
            // Genera casualmente 1 o 2
            matrix[i][j] = Math.floor(Math.random() * 2) + 1;
        }
    }
}

// Funzione per creare la prima tabella basata sulla matrice
function createMainTable() {
    const table = document.querySelector('main > table');
    
    // Pulisci la tabella esistente
    table.innerHTML = '';
    
    // Crea le righe e le celle
    for (let i = 0; i < 6; i++) {
        const row = document.createElement('tr');
        
        for (let j = 0; j < 7; j++) {
            const cell = document.createElement('td');
            
            // Imposta il colore di sfondo in base al valore della matrice
            const cellValue = matrix[i][j];
            if (colors[cellValue]) {
                cell.style.backgroundColor = colors[cellValue];
            }
            
            // Aggiungi event listener per il click
            cell.addEventListener('click', () => {
                handleCellClick(i, j, cell);
            });
            
            row.appendChild(cell);
        }
        
        table.appendChild(row);
    }
}

// Funzione per gestire il click su una cella
function handleCellClick(row, col, cellElement) {
    // Rimuovi il colore di sfondo (eredita dal padre)
    cellElement.style.backgroundColor = '';
    
    // Imposta il valore della matrice a 0
    matrix[row][col] = 0;
}

// Funzione per creare la seconda tabella (copia) che mostra lo stato della matrice
function createCopyTable() {
    const copyDiv = document.querySelector('.copia');
    const existingTable = copyDiv.querySelector('table');
    
    // Se esiste già una tabella, rimuovila
    if (existingTable) {
        existingTable.remove();
    }
    
    // Crea una nuova tabella
    const table = document.createElement('table');
    
    // Crea le righe e le celle con i valori della matrice
    for (let i = 0; i < 6; i++) {
        const row = document.createElement('tr');
        
        for (let j = 0; j < 7; j++) {
            const cell = document.createElement('td');
            
            // Mostra il valore numerico della matrice
            cell.textContent = matrix[i][j];
            
            // Imposta il colore di sfondo in base al valore
            const cellValue = matrix[i][j];
            if (colors[cellValue]) {
                cell.style.backgroundColor = colors[cellValue];
            }
            
            row.appendChild(cell);
        }
        
        table.appendChild(row);
    }
    
    copyDiv.appendChild(table);
}

// Funzione di inizializzazione
function init() {
    // Genera la matrice iniziale
    generateMatrix();
    
    // Crea la prima tabella
    createMainTable();
    
    // Aggiungi event listener al bottone
    const button = document.querySelector('button');
    button.addEventListener('click', createCopyTable);
}

// Avvia l'applicazione quando il DOM è caricato
document.addEventListener('DOMContentLoaded', init);