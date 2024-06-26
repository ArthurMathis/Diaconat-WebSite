<form method="post" action="">
    <h2>Durée du contrat</h2>
    <div>
        <label for="date debut">Date de début</label>
        <input type="date" name="date debut" id="date debut">
    </div>
    <div>
        <label for="date fin">Date de fin</label>
        <input type="date" name="date fin" id="date fin">
    </div>
    <h2>Horaires et rémunérations</h2>
    <input type="number" placeholder="Salaire mensuel">
    <input type="number" placeholder="taux horaire hebdomadaire">
    <section class="checkbox-liste">
        <div class="checkbox-item">
            <label for="travail nuit">Travail de nuit</label>
            <input type="checkbox" id="travail nuit" name="travail nuit">
        </div>
        <div class="checkbox-item">
            <input type="checkbox" id="travail wk" name="travail wk"/>
            <label for="travail wk">Visible obselète</label>
        </div>
    </section> 
    <section class="buttons_actions">
            <button type="submit" class="submit_button" value="new_user">Inscrire</button>
    </section>
</form>