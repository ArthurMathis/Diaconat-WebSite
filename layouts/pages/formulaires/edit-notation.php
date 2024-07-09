<form method="post" action="index.php?candidats=update-notation&cle_candidat=<?= $item['id']; ?>">
    <h3>Notation</h3>
    <div class="etoile-container">
        <input type="checkbox" name="notation[]" id="notation1" value="1" <?php if(0 < $item['notation']) echo 'checked'; ?>>
        <input type="checkbox" name="notation[]" id="notation2" value="2" <?php if(1 < $item['notation']) echo 'checked'; ?>>
        <input type="checkbox" name="notation[]" id="notation3" value="3" <?php if(2 < $item['notation']) echo 'checked'; ?>>
        <input type="checkbox" name="notation[]" id="notation4" value="4" <?php if(3 < $item['notation']) echo 'checked'; ?>>
        <input type="checkbox" name="notation[]" id="notation5" value="5" <?php if(4 < $item['notation']) echo 'checked'; ?>>
    </div>
    <h3>Caractéristiques</h3>
    <div class="double-items">
        <p>A</p>
        <input type="checkbox" id="a" name="a" <?php if($item['a']) echo 'checked'; ?>></input>
    </div>
    <div class="double-items">
        <p>B</p>
        <input type="checkbox" id="b" name="b" <?php if($item['b']) echo 'checked'; ?>></input>
    </div>
    <div class="double-items">
        <p>C</p>
        <input type="checkbox" id="c" name="c" <?php if($item['c']) echo 'checked'; ?>></input>
    </div>
    <h3>Remarque</h3>
    <textarea name="description" id="description"><?= $item['description']; ?></textarea>
    <button type="submit">Mettre à jour</button>
</form>