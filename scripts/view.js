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
        menuItem.forEach(item => {
            item.classList.remove('active');
        });
        setTimeout(() => {
            menu.classList.remove('active');
        }, 450);
    
        isOpen = false;
    } else {
        menu.classList.add('active');
        for(let i = 0; i < menuItem.length; i++) {
            setTimeout(() => {
                menuItem[i].classList.add('active');
            }, (i + 1) * 150);
        }
        isOpen =  true;
    }
});