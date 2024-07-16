<form method="post" action="">
    <h3>Modification de mot de passe</h3>
    <section>
        <p>Saisissez votre ancien mot de passe</p>
        <input type="password" id="password" name="password" placeholder="Mot de passe">
    </section>
    <section>
        <p>Choissiez votre nouveau mot de passe</p>
        <input type="password" id="new-password" name="new-password" placeholder="Mot de passe">
        <input type="password" id="confirmtion" name="confirmtion" placeholder="Confirmation">
    </section>
    <button class="action_button reverse_color" type="submit" value="new_user">Enregistrer</button>
</form>

<div class="morph"></div>
<div class="morph"></div>
<div class="morph"></div>
<div class="morph"></div>
<div class="morph"></div>
<div class="morph"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const morphs = document.querySelectorAll('.morph');

        morphs.forEach(morph => {
            animateMorph(morph);
        });
    });

    function animateMorph(element) {
        const duration = anime.random(3000, 9000); // Définir une durée aléatoire pour l'animation entière
        anime({
            targets: element,
            translateX: {
                value: () => anime.random(-60, 60),
                duration: duration,
                easing: 'easeInOutQuad'
            },
            translateY: {
                value: () => anime.random(-60, 60),
                duration: duration,
                easing: 'easeInOutQuad'
            },
            scale: {
                value: () => anime.random(0.99, 1.01),
                duration: duration,
                easing: 'easeInOutQuad'
            },
            complete: function() {
                animateMorph(element);
            }
        });
    }
</script>

