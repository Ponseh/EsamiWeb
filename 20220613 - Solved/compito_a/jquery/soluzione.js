// Variabili globali
let sudokuTable = [];
let currentGame = null;

// Funzione per nascondere elementi all'avvio
function hideElements() {
    const form = document.querySelector('form');
    const spans = document.querySelectorAll('span');
    const valutaButton = document.querySelectorAll('button')[1];
    
    form.style.display = 'none';
    spans.forEach(span => span.style.display = 'none');
    valutaButton.style.display = 'none';
}

// Funzione per mostrare elementi
function showElements() {
    const form = document.querySelector('form');
    const valutaButton = document.querySelectorAll('button')[1];
    
    form.style.display = 'block';
    valutaButton.style.display = 'block';
    
    // Pulisci gli input
    document.getElementById('riga').value = '';
    document.getElementById('colonna').value = '';
    document.getElementById('valore').value = '';
}

// Funzione per creare la tabella 9x9
function createTable(gameData) {
    const table = document.querySelector('table');
    table.innerHTML = ''; // Pulisci la tabella esistente
    
    // Inizializza l'array sudokuTable
    sudokuTable = [];
    
    for (let i = 0; i < 9; i++) {
        const row = document.createElement('tr');
        sudokuTable[i] = [];
        
        for (let j = 0; j < 9; j++) {
            const cell = document.createElement('td');
            
            /* Da qui fino a sudokuTable[i][j]... è tutto css, gradito ma non richiesto */
            const index = i * 9 + j;
            const value = gameData[index];
            
            if (value !== '0') {
                cell.textContent = value;
                cell.style.backgroundColor = '#f0f0f0';
                cell.classList.add('initial');
            } else {
                cell.textContent = '';
            }
            
            // Aggiungi bordi per separare i quadrati 3x3
            cell.style.border = '1px solid #ccc';
            cell.style.width = '30px';
            cell.style.height = '30px';
            cell.style.textAlign = 'center';
            cell.style.verticalAlign = 'middle';
            
            if (j % 3 === 2 && j < 8) {
                cell.style.borderRight = '3px solid #000';
            }
            if (i % 3 === 2 && i < 8) {
                cell.style.borderBottom = '3px solid #000';
            }
             
            sudokuTable[i][j] = cell;
            row.appendChild(cell);
        }
        table.appendChild(row);
    }
}

// Funzione per gestire la nuova partita
function handleNewGame() {
    fetch('req.php', {
        method: 'GET'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            currentGame = data.game_id;
            createTable(data.initial_state);
            showElements();
        } else {
            alert('Errore nel creare una nuova partita');
        }
    })
    .catch(error => {
        console.error('Errore:', error);
        alert('Errore nella comunicazione con il server');
    });
}

// Funzione per validare l'input
function validateInput(riga, colonna, valore) {
    if (riga < 1 || riga > 9 || colonna < 1 || colonna > 9 || valore < 1 || valore > 9) {
        return false;
    }
    return true;
}

// Funzione per aggiungere un valore alla tabella
function handleAddValue(event) {
    event.preventDefault();
    
    const riga = parseInt(document.getElementById('riga').value);
    const colonna = parseInt(document.getElementById('colonna').value);
    const valore = parseInt(document.getElementById('valore').value);
    
    if (!validateInput(riga, colonna, valore)) {
        alert('Errore: riga, colonna e valore devono essere compresi tra 1 e 9');
        return;
    }
    
    const cell = sudokuTable[riga - 1][colonna - 1];
    
    // Controlla se la cella è una cella iniziale (non modificabile)
    if (cell.classList.contains('initial')) {
        alert('Non puoi modificare i numeri iniziali!');
        return;
    }
    
    // Aggiungi il valore alla cella
    cell.textContent = valore;
    
    // Pulisci gli input
    document.getElementById('riga').value = '';
    document.getElementById('colonna').value = '';
    document.getElementById('valore').value = '';
}

// Funzione per raccogliere i dati della tabella
function collectTableData() {
    let tableData = '';
    
    for (let i = 0; i < 9; i++) {
        for (let j = 0; j < 9; j++) {
            const cellValue = sudokuTable[i][j].textContent;
            tableData += cellValue === '' ? '0' : cellValue;
        }
    }
    
    return tableData;
}

// Funzione per valutare la soluzione
function handleEvaluateSolution() {
    const tableData = collectTableData();
    
    const formData = new FormData();
    formData.append('solution', tableData);
    formData.append('game_id', currentGame);
    
    fetch('req.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // Nascondi tutti gli span prima di mostrare quello giusto
        document.querySelectorAll('span').forEach(span => span.style.display = 'none');
        
        if (data.valid) {
            document.querySelector('.win').style.display = 'block';
        } else {
            document.getElementById('lose').style.display = 'block';
        }
    })
    .catch(error => {
        console.error('Errore:', error);
        alert('Errore nella valutazione della soluzione');
    });
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Nascondi elementi all'avvio
    hideElements();
    
    // Bottone "Nuova partita"
    const newGameButton = document.querySelectorAll('button')[0];
    newGameButton.addEventListener('click', handleNewGame);
    
    // Form "Aggiungi"
    const form = document.querySelector('form');
    form.addEventListener('submit', handleAddValue);
    
    // Bottone "Valuta Soluzione"
    const evaluateButton = document.querySelectorAll('button')[1];
    evaluateButton.addEventListener('click', handleEvaluateSolution);
});