const button_menu = document.querySelector('#barre-de-navigation h3');
const menu = document.getElementById('menu');
const button_fermer = menu.querySelector('main div h2');
const link = menu.querySelectorAll('main content a');

// On ajoute les events d'ouverture et de fermeture du menu
button_menu.addEventListener('click', () => { menu.classList.add('active') });
button_fermer.addEventListener('click', () => { menu.classList.remove('active'); });