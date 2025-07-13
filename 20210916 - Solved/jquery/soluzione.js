function firstPoint() {
    const main = document.querySelector('main');
    const table = document.createElement('table');
    table.id = "numeri";

    const row = document.createElement('tr');
    for (let i = 1; i < 10; i++) {
        const cell = document.createElement('td');
        cell.textContent = i;
        row.appendChild(cell);
    }

    table.appendChild(row);

    main.appendChild(table);
}

function secondPoint() {
    const table = document.getElementsByClassName('tabellone')[0];
    const cells = table.querySelectorAll('td');

    const mainBg = getComputedStyle(document.querySelector('main')).backgroundColor;

    cells.forEach(e => {
        e.addEventListener('click', () => {
            const currentBg = getComputedStyle(e).backgroundColor;
            
            if(currentBg == mainBg) {
                cells.forEach(e => {
                    e.style.background = mainBg;
                });
                e.style.background = '#cacaca';
            } else {
                e.style.background = mainBg;
            }
        });
    });
}

function getActiveCell() {
    const cellsTabellone = document.getElementsByClassName('tabellone')[0].querySelectorAll('td');
    const mainBg = getComputedStyle(document.querySelector('main')).backgroundColor;
    let active = null;

    cellsTabellone.forEach(e => {
        if(getComputedStyle(e).backgroundColor != mainBg)
            active = e;
    });

    return active;
}

function thirdPoint() {
    const cellsNumeri = document.getElementById('numeri').querySelectorAll('td');
    const logger = document.getElementsByClassName('log')[0];
    const mainBg = getComputedStyle(document.querySelector('main')).backgroundColor;

    cellsNumeri.forEach(e => {
        e.addEventListener('click', () => {
            if(getActiveCell() == null)
                logger.textContent = "Cella non selezionata";
            else {
                e.textContent = getActiveCell().textContent;
                getActiveCell().style.background = mainBg;
                logger.textContent = "Numero inserito correttamente";
            }
        });
    });
}

function init() {
    firstPoint();

    secondPoint();

    thirdPoint();

}

document.addEventListener('DOMContentLoaded', init);