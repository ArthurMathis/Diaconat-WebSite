const button_menu = document.querySelector('#barre-de-navigation h2');
const menu = document.getElementById('menu');
const button_fermer = menu.querySelector('main div h2');

button_menu.addEventListener('click', () => { menu.classList.add('active') });
button_fermer.addEventListener('click', () => { menu.classList.remove('active'); });