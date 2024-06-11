const button_menu = document.querySelector('#barre-de-navigation h2');
const menu = document.getElementById('menu');
const button_fermer = menu.querySelector('main div h2');
const link = menu.querySelectorAll('main content a');

// On ajoute les events d'ouverture et de fermeture du menu
button_menu.addEventListener('click', () => { menu.classList.add('active') });
button_fermer.addEventListener('click', () => { menu.classList.remove('active'); });

// On ajoute les events de hover sur les liens
link.forEach((c, index) => {
    c.addEventListener('mouseenter', () => {
        for(i = 0; i < index; i++) 
            link[i].classList.add('not-hover');
        for(i = index + 1; i < link.length; i++)
            link[i].classList.add('not-hover');
    });
    c.addEventListener('mouseleave', () => {
        link.forEach(c => { c.classList.remove('not-hover'); });
    });
});