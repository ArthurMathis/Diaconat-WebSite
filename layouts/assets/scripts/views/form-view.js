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
        console.log("Le bouton d'ajout :");
        console.log(this.button);

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
        switch(this.inputType) {
            // Text + suggestions
            case 'autocomplete':
                // On génère le container
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
                this.inputParent.appendChild(autocomplete);

                // On lance l'autocomplete
                const tab = [];
                this.suggestions.forEach(c => { tab.push(c.text); });
                this.autocomplete = new AutoComplete(input, tab);
                break;

            // Select  
            case 'liste':
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

                // On ajoute les éléments
                this.inputParent.appendChild(select);
                break;    

            // Date    
            case 'date':
                // On génère l'input
                const dateInput = document.createElement('input');
                dateInput.type = 'date';
                dateInput.setAttribute('min', new Date().toISOString().split('T')[0]);
                dateInput.name = this.inputName  + '[]';
                dateInput.id = this.inputName;
                
                // On ajoute l'élément
                this.inputParent.appendChild(dateInput);
                break;
                
            default: throw new Error("Type d'input non reconnu. Génération d'input impossible !");    
        }
    }
    deleteButton() {
        this.button.remove();
    }
}