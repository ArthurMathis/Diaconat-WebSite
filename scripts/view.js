// Ajout de l'horloge 
const horloge = document.getElementById('horloge');

setInterval(() => {
    horloge.textContent = heure_horloge.toString();
}, 1000);

// Ajout du calendrier
const calendrier = document.getElementById('calendrier');
calendrier.textContent = localDate.toString();

const menu = document.getElementById('menu');
const menuItem = menu.querySelectorAll('a');
const menuIcon = document.getElementById('menu-icon');
let isOpen = false;

menuIcon.addEventListener('click', function() {
    // menu.classList.toggle('active');
    if(isOpen) {
        isOpen = false;
        menuIcon.classList.remove('is-opened');
        
        menuItem.forEach(item => {
            item.classList.remove('active');
        });
        setTimeout(() => {
            menu.classList.remove('active');
        }, 400);
    
    } else {
        isOpen =  true;
        menuIcon.classList.add('is-opened');

        menu.classList.add('active');
        for(let i = 0; i < menuItem.length; i++) {
            setTimeout(() => {
                menuItem[i].classList.add('active');
            }, (i + 1) * 50);
        }
    }
});

const onglets = document.querySelectorAll('aside article');
for(let i = 0; i < onglets.length; i++) {
    setTimeout(() => {
        onglets[i].classList.add('visible');
    }, (i + 1) * 50);
}