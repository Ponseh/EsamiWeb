document.addEventListener('DOMContentLoaded', () => {
  const button = document.querySelector('button');
  const main = document.querySelector('main');

  button.addEventListener('click', () => {
    fetch('data.json')
      .then(response => {
        if (!response.ok) {
          throw new Error('Errore nel caricamento del file JSON');
        }
        return response.json();
      })
      .then(data => {
        main.innerHTML = ''; // Pulisce eventuali dati già presenti
        
        data['data'].forEach(item => {
          const div = document.createElement('div');
          div.style.border = '1px solid black';
          div.style.padding = '10px';
          div.style.margin = '10px 0';

          const ul = document.createElement('ul');

          for (let key in item) {
            const li = document.createElement('li');
            li.textContent = `${key}: ${item[key]}`;
            ul.appendChild(li);
          }
          
          const upButton = document.createElement('button');
          upButton.textContent = 'Up';

          const downButton = document.createElement('button');
          downButton.textContent = 'Down';

          upButton.addEventListener('click', () => {
            const prev = div.previousElementSibling;
            if (prev) {
              main.insertBefore(div, prev);
            }
          });

          downButton.addEventListener('click', () => {
            const next = div.nextElementSibling;
            if (next) {
              main.insertBefore(next, div);
            }
          });

          div.appendChild(ul);
          div.appendChild(upButton);
          div.appendChild(downButton);

          main.appendChild(div);
        });
      })
      .catch(error => {
        console.error('Errore:', error);
      });
  });
});
