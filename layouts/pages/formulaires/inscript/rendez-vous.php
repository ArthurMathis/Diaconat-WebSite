<form method="post" action="index.php?candidats=inscript-rendez-vous&cle_candidat=<?= $cle_candidat; ?>">
    <h3>Saissisez les informations du rendez-vous</h3>
    <section>
        <p>Entretien</p>
        <input type="text" id="recruteur" name="recruteur" placeholder="Recruteur">
        <input type="text" id="etablissement" name="etablissement" placeholder="Etablissement">
    </section>
    
    <section class="double-items">
        <div class="input-container">
            <label for="date">Date</label>
            <input type="date" name="date" id="date">
        </div>
        <div class="input-container">
            <label for="time">Horaire</label>
            <input type="time" name="time" id="time">
        </div>
    </section>
    <button type="submit" value="new_user">Enregistrer</button>
</form>