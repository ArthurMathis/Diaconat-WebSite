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
        // On construit les nouveaux éléments
        const parentDiv = this.inputElement.parentNode;
        const suggestionBox = parentDiv.querySelector('article');

        // On ajoute les détection d'évênements
        this.inputElement.addEventListener('input', () => { this.autoSuggest(parentDiv, suggestionBox); });
        this.inputElement.addEventListener('click', () => { this.autoSuggest(parentDiv, suggestionBox); });

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

        // On ajoute les events de fermeture des suggestions
        document.addEventListener('click', (e) => {
            if (e.target !== this.inputElement) 
                this.closeAllLists();
        });
        this.inputElement.addEventListener('blur', () => {
                this.closeAllLists();
        });
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

    autoSuggest(parentDiv, suggestionBox) {
        console.log("L'élément a été sélectionné");
        // On efface l'ancienne liste
        this.closeAllLists();

        // On génère le tableau de suggestions selon la saisie de l'utilisateur
        let filteredSuggestions;
        if(this.inputElement.value) {
            console.log("L'utilisateur recherche les résultat commençant par : " + this.inputElement.value);
            filteredSuggestions = this.suggestions.filter(suggestion =>
                suggestion.toLowerCase().trim().startsWith(this.inputElement.value.toLowerCase().trim())
            );

        } else {
            console.log("L'utilisateur n'a pas précisé sa recherche");
            filteredSuggestions = Array.from(this.suggestions);
        }   
        console.log("Résultats proposés : ");
        console.log(filteredSuggestions);

        // On test la présence de résultat
        if (filteredSuggestions.length > 0) {
            suggestionBox.classList.add('autocomplete-items');

            // On génère les items de suggestion
            filteredSuggestions.forEach(suggestion => {
                const item = document.createElement('div');
                item.innerHTML = suggestion;
                item.addEventListener('click', () => {
                    this.inputElement.value = suggestion;
                    this.inputElement.dispatchEvent(new Event('AutoCompleteSelect'));
                    this.closeAllLists();
                });
                suggestionBox.appendChild(item);
            });
        }
    }
}