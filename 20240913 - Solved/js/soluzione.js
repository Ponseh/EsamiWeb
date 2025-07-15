function init() {
    const button = document.querySelector('button');
    const inputs = document.querySelectorAll('input');
    const par = document.querySelector('form > p');

    button.addEventListener('click', e => {
        e.preventDefault();
        let check = true;

        inputs.forEach(e => {
            let value = e.value;
            value = parseInt(value);

            if(isNaN(value) || value <= 0) {
                check = false;
            }
        });

        if(!check) {
            par.textContent = "Errore nell'inserimento dei numeri!";
        } else {
            par.textContent = "";

            const ul = document.querySelector('section > ul');

            for (let i = 0; i < inputs[0].value; i++) {
                const item = document.createElement('li');
                item.textContent = "Item non ordinato";

                ul.appendChild(item);
            }

            const ol = document.querySelector('section > ol');

            for (let i = 0; i < inputs[1].value; i++) {
                const item = document.createElement('li');
                item.textContent = "Item ordinato";

                ol.appendChild(item);
            }
        }
    })
}

document.addEventListener('DOMContentLoaded', init);