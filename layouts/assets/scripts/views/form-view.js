function setMinDateFin(input_date_debut, input_date_fin) {
    // On récupère les données
    const inputDebut = document.getElementById(input_date_debut);
    const inputFin = document.getElementById(input_date_fin);

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

/// function ajoutant l'input coopteur si besoin
function setCooptInput(input, inputName, searchValue, suggestions) {
    if(input.value == searchValue) {
        // On génère le nouvel élément
        const elmt = document.createElement('div');
        elmt.className = 'autocomplete'
        const new_i = document.createElement('input');
        new_i.type = 'text';
        new_i.name = inputName + '[]';
        new_i.autocomplete = 'off';

        // On ajoute les élements
        elmt.appendChild(new_i);
        elmt.appendChild(document.createElement('article'));

        console.log(elmt);

        // On lance l'autocomplete
        const tab = [];
        suggestions.forEach(c => { tab.push(c.text); });
        const autocomp = new AutoComplete(new_i, tab);

        // On ajoute l'élément au DOM
        const parent = input.parentNode;
        if (parent.lastChild === input) parent.appendChild(elmt);
        else parent.insertBefore(elmt, input.nextSibling);  
    }
}

class cooptInput {
    constructor(input, inputName, searchValue, suggestions) {
        this.input = input;
        this.inputName = inputName;
        this.searchValue = searchValue;
        this.suggestions = suggestions;

        // On signale l'action
        Swal.fire({
            title: 'Information',
            text: "Vous ne pouvez renseigner qu'une prime de cooptation !",
            icon: 'info',
            position: "top-end",
            backdrop: false,
            timer: 6000, 
            showConfirmButton: false,
            customClass: {
                popup: 'notification',
                title: 'notification-title',
                content: 'notification-content',
                confirmButton: 'action_button reverse_color'
            }
        });
    }

    react() {
        if(this.input.value == this.searchValue) this.createInput();
        else this.destroyInput();
    }

    createInput() {
        // On génère le nouvel élément
        this.elmt = document.createElement('div');
        this.elmt.className = 'autocomplete'
        const new_i = document.createElement('input');
        new_i.type = 'text';
        new_i.name = this.inputName + '[]';
        new_i.autocomplete = 'off';

        // On ajoute les élements
        this.elmt.appendChild(new_i);
        this.elmt.appendChild(document.createElement('article'));

        // On lance l'autocomplete
        const tab = [];
        this.suggestions.forEach(c => { tab.push(c.text); });
        this.autocomplete = new AutoComplete(new_i, tab);

        // On ajoute l'élément au DOM
        const parent = this.input.parentNode;
        if (parent.lastChild === this.input) parent.appendChild(this.elmt);
        else parent.insertBefore(this.elmt, this.input.nextSibling);  
    }
    destroyInput() {
        if(this.autocomplete) this.autocomplete = null;
        if(this.elmt) this.elmt.remove();
    }
}

// à compléter (ajout des méthodes de génératipn d'input : paramètre sélection de l'autocomplet + parent + type d'input)
class implementInput {
    /**
     * Constructeur de la classe
     * @param {HTMLElement} inputParent Le container des inputs à générer
     * @param {string} inputType Le type d'input
     * @param {integer} nbMaxInput Le nombre maximum d'inputs autorisé dans le container
     * @param {array<string>} suggestions Le tableau de suggestions (si autocomplet)
     */
    constructor(inputName, inputParent, inputType, nbMaxInput, suggestions) {
        // On initialise les données
        this.inputName = inputName;
        this.inputParent = document.getElementById(inputParent);
        this.inputType = inputType
        this.nbMaxInput = nbMaxInput;
        this.nbInput = 0;
        this.suggestions = Array.from(suggestions);

        // On lance la détection d'events
        this.init();
    }

    init() {
        this.button = this.inputParent.querySelector('button');
        this.button.addEventListener('click', () => {
            Swal.fire({
                title: "Question ?",
                text: "Voulez-vous ajouter un nouvel input ?",
                icon: 'question',
                backdrop: false,
                focusConfirm: false,
                showCancelButton: true,
                cancelButtonText: 'Annuler',
                confirmButtonText: 'Confirmer',
                customClass: {
                    popup: 'notification',
                    title: 'notification-title',
                    content: 'notification-content',
                    confirmButton: 'action_button reverse_color',
                    cancelButton: 'action_button cancel_button',
                    actions: 'notification-actions'
                }
            }).then((result) => {
                if (result.isConfirmed) 
                    this.addInput();
            });
        });
    }
    addInput() {
        // On impélmente le nombre d'inputs
        this.nbInput++;

        // On test le nombre d'input
        if(this.nbMaxInput && this.nbMaxInput <= this.nbInput)
            this.deleteButton();

        this.createInput();
    }

    createInput() {
        // On déclare le nouvel élément
        let inputElement;
        switch(this.inputType) {
             // Text + suggestions
            case 'autocomplete': 
            inputElement = this.createAutoCopmlete();
                break;

            // Select
            case 'liste':
                inputElement = this.createListe();
                break;   

            // Date
            case 'date':
                inputElement = this.createDate();
                break;  

            default: throw new Error("Type d'input non reconnu. Génération d'input impossible !"); 
        }
        
        // On ajoute le nouvel élément au DOM
        this.inputParent.appendChild(inputElement);
        const e = new CustomEvent('elementCreated', { detail: { element: inputElement }});
        document.dispatchEvent(e);
    }

    createAutoCopmlete() {
        const autocomplete = document.createElement('div');
        autocomplete.className = "autocomplete";

        // On génère l'input
        const input = document.createElement('input');
        input.type = 'text';
        input.id = this.inputName + '-' + this.nbInput;
        input.name = this.inputName + '[]';
        this.autocomplete = 'off';
        
        // On ajoute les élements
        autocomplete.appendChild(input);
        autocomplete.appendChild(document.createElement('article'));

        // On lance l'autocomplete
        const tab = [];
        this.suggestions.forEach(c => { tab.push(c.text); });
        this.autocomplete = new AutoComplete(input, tab);

        // On retourne l'élément
        return autocomplete;
    }
    createListe() {
        // On génère la liste
        const select = document.createElement('select');
        select.name = this.inputName + '[]';

        // On génère les options
        this.suggestions.forEach(c => {
            // On construit l'option
            const option = document.createElement('option');
            option.value = c.id;
            option.textContent = c.text;
        
            // On l'ajoute à la liste
            select.appendChild(option);
        });

        // On retourne l'élément
        return select;
    } 
    createDate() {
        // On génère l'input
        const dateInput = document.createElement('input');
        dateInput.type = 'date';
        dateInput.setAttribute('min', new Date().toISOString().split('T')[0]);
        dateInput.name = this.inputName  + '[]';
        dateInput.id = this.inputName;

        // On retourne l'élément
        return dateInput;
    }
    deleteButton() {
        this.button.remove();
    }
}