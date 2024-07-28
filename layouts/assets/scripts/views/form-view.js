function setMinDateFin(input_date_debut, input_date_fin) {
    // On récupère les données
    const inputDebut = document.getElementById(input_date_debut);
    const inputFin = document.getElementById(input_date_fin);

    console.log(inputDebut);
    console.log(inputFin);

    // On limite à la date début
    inputFin.setAttribute('min', inputDebut.getAttribute('min'));

    // On réagit au modification de la date début
    inputDebut.addEventListener('input', () => {
        // On impélmente le minimum
        inputFin.setAttribute('min', inputDebut.value);

        // On vérifie l'intégrité des données
        if(inputFin.value && inputFin.value < inputDebut.value)
            inputFin.value = inputDebut.value;
    });
}

// à compléter (ajout des méthodes de génératipn d'input : paramètre sélection de l'autocomplet + parent + type d'input)