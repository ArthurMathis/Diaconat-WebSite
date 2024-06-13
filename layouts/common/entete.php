<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name ?></title>

    <!-- Inclusion des feuilles de style -->
    <link rel="stylesheet" href="layouts\assets\stylesheet\styles.css">
    <?php
    if (!empty($cssFiles)) {
        foreach ($cssFiles as $file) {
            echo '<link rel="stylesheet" href="' . $file . '">';
        }
    }
    ?>
</head>
<body>