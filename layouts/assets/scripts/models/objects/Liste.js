/**
 * @brief Classe représentant un tableau HTML permettant l'apparition et la disparition dynamique de ses lignes
 */
class Liste {
    /**
     * @brief Constructeur de la classe
     * @param id L'identifiant de la liste
     */
    constructor(id) {
        this.parent = document.querySelector('#' + id + ' .table-wrapper');
        this.items = Array.from(document.querySelectorAll('#' + id + ' .table-wrapper table tbody tr'));
        this.observer = new IntersectionObserver(
            this.callback.bind(this), 
            {
                root: this.parent,
                rootMargin: '-60px 0px 0px 0px', 
                threshold: 1
            }
        );
        this.int();
    }

    /**
     * @brief Méthode lançant la détection de visibilité
     */
    int() {
        this.items.forEach(item => {
            this.observer.observe(item);
        });
    }
    /**
     * @brief Méthode affichant/cachant une ligne
     * @param entries La ligne
     */
    callback(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) 
                // entry.target.classList.add('visible');
                entry.target.style.visibility = "visible";

            else 
                // entry.target.classList.remove('visible');
                entry.target.style.visibility = "hidden";
        });
    }
}