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
        const parentDiv = this.inputElement.parentNode;
        const suggestionBox = parentDiv.querySelector('article');

        this.inputElement.addEventListener('input', () => {
            this.closeAllLists();
            if (!this.inputElement.value) return false;

            const filteredSuggestions = this.suggestions.filter(suggestion =>
                suggestion.toLowerCase().includes(this.inputElement.value.toLowerCase())
            );

            if (filteredSuggestions.length > 0) 
                suggestionBox.classList.add('autocomplete-items');

            filteredSuggestions.forEach(suggestion => {
                const item = document.createElement('div');
                item.innerHTML = suggestion;
                item.addEventListener('click', () => {
                    this.inputElement.value = suggestion;
                    this.closeAllLists();
                });
                suggestionBox.appendChild(item);
            });
        });

        this.inputElement.addEventListener('keydown', (e) => {
            const items = suggestionBox.getElementsByTagName('div');
            if (e.key === "ArrowDown") {
                this.currentFocus++;
                this.addActive(items);
            } else if (e.key === "ArrowUp") {
                this.currentFocus--;
                this.addActive(items);
            } else if (e.key === "Enter") {
                e.preventDefault();
                if (this.currentFocus > -1) {
                    if (items[this.currentFocus]) 
                        items[this.currentFocus].click();
                }
            }
        });

        document.addEventListener('click', (e) => {
            if (e.target !== this.inputElement) {
                this.closeAllLists();
            }
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
        const items = document.querySelectorAll('.autocomplete-items');
        items.forEach(item => item.remove());
        this.currentFocus = -1;
    }
}