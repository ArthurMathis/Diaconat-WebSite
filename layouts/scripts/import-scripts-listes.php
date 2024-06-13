<?php 
echo "<script src=\"layouts/assets/scripts/candidatures-model.js\"></script>";
echo "<script src=\"layouts/assets/scripts/candidatures-view.js\"></script>";
echo "<script>
let item_clicked = null;
let method_tri = true;
entete.forEach((item, index) => {
    item.addEventListener('click', () => {
        method_tri = !method_tri;
        // On effectue le tri
        const candidatures_triees = trierSelon(candidatures, index, item_clicked === index ? method_tri : true);
        item_clicked = index;

        // On cherche les éventuelles erreurs
        if(candidatures_triees == null || candidatures_triees.length === 0)
            alert(\"Alerte : Tri non executé.\");
        
        else {
            // On déconstruit et reconstruit le tableau
            destroyTable(document.querySelector('.liste_items .table-wrapper table tbody'));
            createTable(document.querySelector('.liste_items .table-wrapper table'), candidatures_triees);
            // On recharge le tableau dans le script
            candidatures = recupCandidatures()
            
            // On déselectionne les entetes
            entete.forEach(items => {
                items.classList.remove('active');
                items.classList.remove('reverse-tri');
            });
            item.classList.add('active');
            if(method_tri)
                item.classList.add('reverse-tri');
            else item.classList.remove('reverse-tri');
        }

    });
});
</script>";