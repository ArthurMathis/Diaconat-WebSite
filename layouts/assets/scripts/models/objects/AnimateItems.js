/**
 * @brief Classe représentant un object HTML perlettant son apparition disparition selon sa présence dans la vue
 */
class AnimateItems {
    /**
     * @brief Constructeur de la classe
     * @param selector Le chemin d'accès dans le DOM
     */
    constructor(selector) {
        inView(selector)
        .on('enter', function(c) {
            c.classList.add('active');
            
        }).on('exit', function(c) {
            c.classList.remove('active');
        });
    }
}