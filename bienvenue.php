<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    if(isset($_GET['auth'])){
        echo '<h2>Bienvenue sur cette page !!</h2>';
    }else{
        echo '<h2>veuillez vous authentifier pour venir sur cette page</h2>';
    }
    ?>
    
</body>
</html>