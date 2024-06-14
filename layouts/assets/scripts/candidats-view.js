const liste_onglets = document.querySelectorAll('.navbarre p');
const onglet = document.querySelectorAll('.onglet');

console.table(liste_onglets);
console.table(onglet);

liste_onglets[0].classList.add('active');
onglet[0].classList.add('active');

liste_onglets.forEach((elmt, index) => {
    elmt.addEventListener('click', () => {
        console.log('Item ' + index + " cliqué.");

        // On ajoute l'onglet actif
        console.log("On ajoute les éléments d'index : " + index);
        elmt.classList.add('active');
        onglet[index].classList.add('active');

        // On retire les onglets inactifs
        for(let i = 0; i < index; i++) {
            console.log("On retire les éléments d'index : " + i);
            liste_onglets[i].classList.remove('active');
            onglet[i].classList.remove('active');
        } 
        for(let i = index + 1; i < liste_onglets.length; i++) {
            console.log("On retire les éléments d'index : " + i);
            liste_onglets[i].classList.remove('active');
            onglet[i].classList.remove('active');
        }     
    });
});
