<div class="grid">
<article>
    <div class="notation_bulle">
        <h2>Notation</h2>
        <li class="notation">
            <?php if(empty($item['candidat']['notation'])): ?>
                <ul class="bille_notation"><img src="layouts/assets/img/etoile_noire.svg"></ul>
                <ul class="bille_notation"><img src="layouts/assets/img/etoile_noire.svg"></ul>
                <ul class="bille_notation"><img src="layouts/assets/img/etoile_noire.svg"></ul>
                <ul class="bille_notation"><img src="layouts/assets/img/etoile_noire.svg"></ul>
                <ul class="bille_notation"><img src="layouts/assets/img/etoile_noire.svg"></ul>
            <?php else: ?>
                <ul class="bille_notation <?php if(0 < $item['candidat']['notation']) echo "active"; ?>"><img src="layouts/assets/img/etoile_noire.svg"></ul>
                <ul class="bille_notation <?php if(1 < $item['candidat']['notation']) echo "active"; ?>"><img src="layouts/assets/img/etoile_noire.svg"></ul>
                <ul class="bille_notation <?php if(2 < $item['candidat']['notation']) echo "active"; ?>"><img src="layouts/assets/img/etoile_noire.svg"></ul>
                <ul class="bille_notation <?php if(3 < $item['candidat']['notation']) echo "active"; ?>"><img src="layouts/assets/img/etoile_noire.svg"></ul>
                <ul class="bille_notation <?php if(4 < $item['candidat']['notation']) echo "active"; ?>"><img src="layouts/assets/img/etoile_noire.svg"></ul>
            <?php endif ?>
        </li>
    </div>
    <div id="carcatéristiques" class="notation_bulle">
        <h2>Caractéristiques</h2>
        <content>
            <div>
                <p for="a">A</p>
                <input type="checkbox" name="a" id="a" disabled <?php if($item['candidat']['a']) echo 'checked'; ?>>
            </div>
            <div>
                <p for="b">B</p>
                <input type="checkbox" name="b" id="b" disabled <?php if($item['candidat']['b']) echo 'checked'; ?>>
            </div>
            <div>
                <p for="c">C</p>
                <input type="checkbox" name="c" id="c" disabled <?php if($item['candidat']['c']) echo 'checked'; ?>>
            </div>
        </content>
    </div>
</article>
<div class="notation_bulle">
    <h2>Remarque</h2>
    <?php if(isset($item['candidat']['description']) && empty($item['candidat']['description'])): ?>
        <p><?= $item['candidat']['description']; ?></p>
    <?php else: ?>
        <p style="color: var(--grey)">Aucun descriptif enregistré</p>
    <?php endif ?>    
</div>
</div>