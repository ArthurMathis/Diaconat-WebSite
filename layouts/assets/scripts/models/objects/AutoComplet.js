 /**
         * @class AutoComplete
         * @classdesc Classe permettant de créer un champ d'auto-complétion.
         */
 class AutoComplete {
    /**
     * @constructor
     * @param {HTMLElement} inputElement - L'élément input sur lequel appliquer l'auto-complétion.
     * @param {Array<string>} suggestions - Tableau contenant les suggestions possibles.
     */
    constructor(inputElement, suggestions) {
        this.inputElement = inputElement;
        this.suggestions = suggestions;
        this.currentFocus = -1;
        this.createAutoComplete();
    }

    /**
     * @function createAutoComplete
     * @description Initialise l'auto-complétion en ajoutant les écouteurs d'événements nécessaires.
     */
    createAutoComplete() {
        console.log('On récupère les éléments graphiques');
        const parentDiv = this.inputElement.parentNode;
        console.log(parentDiv);
        const suggestionBox = parentDiv.querySelector('article');
        console.log(suggestionBox);

        console.log('On lance la détection de saisie')
        this.inputElement.addEventListener('input', () => {
            console.log('Saisie détectée');
            // On efface l'ancienne liste
            this.closeAllLists();

            // Si le champs est vide on s'arrête
            if (!this.inputElement.value) return;

            console.log('On filtre la liste de suggestions')
            // On génère le tableau de suggestions selon la saisie de l'utilisateur
            const filteredSuggestions = this.suggestions.filter(suggestion =>
                suggestion.toLowerCase().trim().startsWith(this.inputElement.value.toLowerCase().trim())
            );
            console.log(filteredSuggestions);

            console.log('On manipule graphiquement les suggestions')
            // On test la présence de résultat
            if (filteredSuggestions.length > 0) {
                suggestionBox.classList.add('autocomplete-items');
                console.log(suggestionBox);

                console.log('On ajoute les suggestions');
                // On génère les items de suggestion
                filteredSuggestions.forEach(suggestion => {
                    const item = document.createElement('div');
                    item.innerHTML = suggestion;
                    item.addEventListener('click', () => {
                        this.inputElement.value = suggestion;
                        this.closeAllLists();
                    });
                    console.log(item);
                    suggestionBox.appendChild(item);
                });
                console.log(suggestionBox);
            }
                
        });

        // On gère la sélection des suggestions avec les flèches directionnelles
        this.inputElement.addEventListener('keydown', (e) => {
            // On récupère les suggestions
            const items = suggestionBox.getElementsByTagName('div');
            if (e.key === "ArrowDown") {
                this.currentFocus++;
                this.addActive(items);
            } else if (e.key === "ArrowUp") {
                this.currentFocus--;
                this.addActive(items);
            } else if (e.key === "Enter") {
                e.preventDefault();
                if (this.currentFocus > -1 && items[this.currentFocus]) 
                    items[this.currentFocus].click();
            }
        });

        // On ferme les suggestions si la souris clique ailleurs
        document.addEventListener('click', (e) => {
            if (e.target !== this.inputElement) 
                this.closeAllLists();
        });
    }

    /**
     * @function addActive
     * @description Ajoute la classe 'autocomplete-active' à un élément de la liste de suggestions.
     * @param {HTMLCollection} items - Collection des éléments de la liste de suggestions.
     */
    addActive(items) {
        if (!items) return false;
        this.removeActive(items);
        if (this.currentFocus >= items.length) this.currentFocus = 0;
        if (this.currentFocus < 0) this.currentFocus = items.length - 1;
        items[this.currentFocus].classList.add('autocomplete-active');
    }

    /**
     * @function removeActive
     * @description Supprime la classe 'autocomplete-active' de tous les éléments de la liste de suggestions.
     * @param {HTMLCollection} items - Collection des éléments de la liste de suggestions.
     */
    removeActive(items) {
        for (let i = 0; i < items.length; i++) {
            items[i].classList.remove('autocomplete-active');
        }
    }

    /**
     * @function closeAllLists
     * @description Ferme toutes les listes de suggestions ouvertes.
     */
    closeAllLists() {
        const items = document.querySelectorAll('.autocomplete-items div');
        items.forEach(item => item.remove());
        this.currentFocus = -1;
    }
}