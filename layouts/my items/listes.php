<section class="liste_items<?php if(isset($classe) && !empty($classe)) echo $classe ?>">
    <div class="entete">
        <h2><?= $titre; ?></h2>
        <h2>
            <?php 
                $size = count($items); 
                echo $size;
            ?>
        </h2>
    </div>
    <?php $keys = !empty($items) ? array_keys($items[0]) : ["Aucun élément"]; ?>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <?php foreach($keys as $key): ?>
                        <th><?= $key ?></th>
                    <?php endforeach ?>   
                </tr>
            </thead>
            <tbody>
                <?php if($size > 0): ?>
                    <?php $i = 0; while($i < $size && $i < $nb_items_max): ?>
                        <tr>
                            <?php foreach($items[$i] as $cell): ?>
                                <th><?= $cell ?></th>
                            <?php endforeach ?>
                        </tr>
                        <?php $i++; ?>
                    <?php endwhile ?>    
                <?php else : ?>    
                    <tr><th>Ce tableau est vide</th></tr>
                <?php endif ?>    
            </tbody>
        </table>
    </div>
</section>