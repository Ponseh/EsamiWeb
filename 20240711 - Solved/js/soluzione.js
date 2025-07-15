function init() {
    const button = document.querySelector('button');
    const inputs = document.querySelectorAll('input');
    const logP = document.querySelector('form > p'); // Questo è corretto
    const tabella = document.querySelector('main > table');

    button.addEventListener('click', e => {
        e.preventDefault();
        
        const righe = parseInt(inputs[0].value);
        const colonne = parseInt(inputs[1].value);

        if(isNaN(righe) || righe <= 0 || isNaN(colonne) || colonne <= 0) {
            logP.textContent = "Numeri inseriti non corretti.";
            return;
        }

        logP.textContent = "";
        tabella.innerHTML = "";

        const alfabeto = "abcdefghijklmnopqrstuvwxyz";

        for (let i = 0; i < righe; i++) {
            const row = document.createElement('tr');

            for (let j = 0; j < colonne; j++) {
                if(i == 0 || j == 0) {
                    const head = document.createElement('th');
                    if(!(i == 0 && j == 0)) {
                        if (i == 0) {
                            head.textContent = "C" + j;
                        } else {
                            head.textContent = "R" + i;
                        }
                    } else {
                        head.textContent = "";
                    }
                    row.appendChild(head);
                } else {
                    const cell = document.createElement('td');
                    let randomString = "";
                    for (let k = 0; k < 10; k++) {
                        randomString += alfabeto[Math.floor(Math.random() * alfabeto.length)];
                    }
                    cell.textContent = randomString;
                    row.appendChild(cell);
                }
            }
            tabella.appendChild(row);
        }
    });
}

document.addEventListener('DOMContentLoaded', init);

// 16:15 - 17:00