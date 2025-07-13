// Funzione per validare l'email
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Funzione per mostrare messaggi di errore
function showError(fieldId, message) {
    const field = document.getElementById(fieldId);
    const formGroup = field.closest('.form-group');
    
    // Rimuovi eventuali messaggi di errore esistenti
    const existingError = formGroup.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }
    
    // Crea e aggiungi il nuovo messaggio di errore
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    formGroup.appendChild(errorDiv);
    
    // Evidenzia il campo con errore
    field.style.borderColor = 'red';
}

// Funzione per rimuovere messaggi di errore
function clearError(fieldId) {
    const field = document.getElementById(fieldId);
    const formGroup = field.closest('.form-group');
    
    // Rimuovi il messaggio di errore
    const existingError = formGroup.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }
    
    // Ripristina il colore del bordo
    field.style.borderColor = '#ccc';
}

// Funzione per validare tutti i campi
function validateForm() {
    let isValid = true;
    
    // Prendi i valori dei campi
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const age = document.getElementById('age').value;
    const gender = document.getElementById('gender').value;
    const message = document.getElementById('message').value;
    
    // Pulisci tutti gli errori precedenti
    clearError('name');
    clearError('email');
    clearError('age');
    clearError('gender');
    clearError('message');
    
    // Validazione Nome
    if (!name) {
        showError('name', 'Il nome è obbligatorio');
        isValid = false;
    } else if (name.length < 3) {
        showError('name', 'Il nome deve contenere almeno 3 caratteri');
        isValid = false;
    }
    
    // Validazione Email
    if (!email) {
        showError('email', 'L\'email è obbligatoria');
        isValid = false;
    } else if (!isValidEmail(email)) {
        showError('email', 'Inserisci un indirizzo email valido');
        isValid = false;
    }
    
    // Validazione Età
    if (!age) {
        showError('age', 'L\'età è obbligatoria');
        isValid = false;
    } else {
        const ageNum = parseInt(age);
        if (isNaN(ageNum) || ageNum < 18 || ageNum > 100) {
            showError('age', 'L\'età deve essere compresa tra 18 e 100 anni');
            isValid = false;
        }
    }
    
    // Validazione Genere
    if (!gender) {
        showError('gender', 'Il genere è obbligatorio');
        isValid = false;
    }
    
    // Validazione Messaggio (facoltativo ma con limite di caratteri)
    if (message && message.length > 300) {
        showError('message', 'Il messaggio non può superare i 300 caratteri');
        isValid = false;
    }
    
    return isValid;
}

// Funzione per aggiungere i risultati al container
function addResultToContainer(formData) {
    const resultContainer = document.getElementById('resultContainer');
    
    // Crea la lista ordinata se non esiste
    let orderedList = resultContainer.querySelector('ol');
    if (!orderedList) {
        orderedList = document.createElement('ol');
        resultContainer.appendChild(orderedList);
    }
    
    // Crea una nuova voce nella lista ordinata
    const listItem = document.createElement('li');
    
    // Crea la lista non ordinata con i dati del form
    const unorderedList = document.createElement('ul');
    
    // Aggiungi ogni coppia chiave-valore come elemento della lista
    for (const [key, value] of Object.entries(formData)) {
        const dataItem = document.createElement('li');
        dataItem.textContent = `${key}: ${value}`;
        unorderedList.appendChild(dataItem);
    }
    
    listItem.appendChild(unorderedList);
    orderedList.appendChild(listItem);
}

// Event listener per il form
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('myForm');
    
    form.addEventListener('submit', e => {
        e.preventDefault(); // Previeni il submit predefinito
        
        if (validateForm()) {
            // Raccogli i dati del form
            const formData = {
                nome: document.getElementById('name').value.trim(),
                email: document.getElementById('email').value.trim(),
                età: document.getElementById('age').value,
                genere: document.getElementById('gender').value,
                messaggio: document.getElementById('message').value || 'Nessun messaggio'
            };
            
            // Stampa i dati in console
            console.log('Dati del form validi:');
            for (const [key, value] of Object.entries(formData)) {
                console.log(`${key}: ${value}`);
            }
            
            // Aggiungi i risultati al container
            addResultToContainer(formData);
            
            // Reset del form
            form.reset();
        }
    });
});