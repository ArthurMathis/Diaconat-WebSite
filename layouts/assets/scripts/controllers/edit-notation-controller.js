const etoiles = document.querySelectorAll('.etoile-container input');
let currentEtoiles = -1;

console.log(etoiles);

etoiles.forEach((e, index) => {
    e.addEventListener('click', () => {
        for(i = 0; i <= index; i++)
            etoiles[i].checked = true;
        for(i = index + 1; i < etoiles.length; i++)
            etoiles[i].checked = false;
    });

    e.addEventListener('mouseenter', () => {
        for(i = 0; i <= index; i++)
            etoiles[i].classList.add('selected');
    });

    e.addEventListener('mouseleave', () => {
        etoiles.forEach(elmt => {
            elmt.classList.remove('selected');
        });
    });
});