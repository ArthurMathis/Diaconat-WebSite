const button_menu = document.getElementById('bouton-menu');
const menu = document.getElementById('menu');
const button_fermer = document.getElementById('bouton-close-menu');
const link = menu.querySelectorAll('main content a');

// On ajoute les events d'ouverture et de fermeture du menu
button_menu.addEventListener('click', () => { menu.classList.add('active') });
button_fermer.addEventListener('click', () => { menu.classList.remove('active'); });