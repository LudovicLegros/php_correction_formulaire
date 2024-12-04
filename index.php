<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Exercices PHP - Formulaires</title>
</head>

<body>
    <!-- FONCTION INCLUDE POUR RECUPERER LA NAVBAR -->
    <?php include('nav.php') ?>

    
    <h1>Exercices PHP - Formulaires</h1>

    <!-- EXERCICE 1 -- REQUETE GET VIA URL -->
    <h2>1.Requête GET via URL</h2>
    <?php
    // isset() pour vérifier si la variable existe afin de pas mettre d'erreurs
    if (isset($_GET['ville']) && isset($_GET['transport'])) {
        $ville = $_GET['ville'];
        $transport = $_GET['transport'];

        echo "<p> la ville choisie est " . $ville . " et le voyage se fera en " . $transport . "!</p>";
    } else {
        echo "<p> Choisir une ville et un moyen de transport via l'url</p>";
    }

    //Url avec les requêtes get intégrés
    //http://localhost/perigueux_php_form/index.php?ville=hyrule&transport=Tortue
    ?>

    <!------------ EXERCICE 2 -- REQUETE GET ------------->
    <h2>2.Requête GET via Formulaire</h2>
    <form action="index.php" method='GET'>
        <label for="animal">Choisir un animal</label>
        <input type="text" name="animal" id="animal">
        <button>Choisir</button>
    </form>
    <?php
    if (isset($_GET['animal'])) {
        //htmlspecialchar() empéche l'utilisation des caractères spéciaux (évite les injections de codes)
        $animal = htmlspecialchars($_GET['animal']);

        echo 'Votre animal choisi est : ' . $animal;
    }
    ?>


    <!------------ EXERCICE 3 -- REQUETE POST ---------->
    <h2>3.Requête POST</h2>
    <form action="index.php" method='POST'>
        <label for="pseudo">Votre pseudo: </label>
        <input type="text" name="pseudo" id="pseudo">
        <label for="color">Choisir une couleur: </label>
        <input type="color" name="color" id="color">
        <button>Valider</button>
    </form>

    <?php
    if (isset($_POST['pseudo']) && isset($_POST['color'])) {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $color = htmlspecialchars($_POST['color']);

        echo 'Bonjour ' . $pseudo;
    }

    ?>
    <!---------- EXERCICE 4 -- DES NUMERIQUES ------------>
    <h2>4.Dés numériques</h2>
    <!--Section pour l'affichage de message d'erreur-->
    <?php
    if (isset($_GET['error'])) {
        if ($_GET['error'] == 1) {
            echo '<p class="error">Entrez une valeur valide</p>';
        }
    }
    ?>
    <form action="index.php" method='POST'>
        <label for="dice">Choisir le nombre de face pour votre dé: </label>
        <input type="number" name="dice" id="dice">
        <button>Lancer</button>
    </form>

    <?php
    if (isset($_POST['dice'])) {
        $dice = htmlspecialchars($_POST['dice']);
        $randomDice = rand(1, $dice);

        if ($dice % 6 == 0) {
            echo $randomDice;
        } else {
            // Si le dés est pas un multiple de 6, on redirige l'utilisateur via un url qui contien un GET
            header('Location: index.php?error=1');
        }
    }
    
    ?>

    <!---------- EXERCICE 5 -- AUTHENTIFICATION 1ER METHODE ----------->
    <h2>5.authentification methode sha1</h2>
    <form id="auth" action="index.php#auth" method='POST'>
        <label id="nameAuth">Votre nom</label>
        <input type="text" name="nameAuth" id="nameAuth">
        <label id="password">Votre mot de passe</label>
        <input type="password" name="password" id="password">
        <button>Valider</button>
    </form>
    <?php
        $user = 'admin';
        $password = '1234';
        
        // Cryptage du mot de passe VERSION 1
        $passwordCrypted = sha1(sha1($password) . "5943");
        

        if(isset($_POST['nameAuth']) && isset($_POST['password'])){
            $entryUser = htmlspecialchars($_POST['nameAuth']);
            $entryPassword = htmlspecialchars($_POST['password']);
            // Cryptage du mot de passe entrée avec la même méthode que le mot de passe
            $entryPasswordCrypted =  sha1(sha1($entryPassword) . "5943");

            if(($entryUser == $user) && ($entryPasswordCrypted == $passwordCrypted)){
                header('location:bienvenue.php?auth=1');
            }else{
                echo '<p class="error">Mot de passe ou nom d\'utilisateur incorrect<p>';
            }
        }
    ?>

        <!---------- EXERCICE 5 -- AUTHENTIFICATION 2EME METHODE ----------->
    <h2>5.authentification methode argon</h2>
    <form id="auth2" action="index.php#auth2" method='POST'>
        <label id="nameAuth2">Votre nom</label>
        <input type="text" name="nameAuth2" id="nameAuth2">
        <label id="password2">Votre mot de passe</label>
        <input type="password" name="password2" id="password2">
        <button>Valider</button>
    </form>

    <?php 
    // Cryptage du mot de passe avec la fonction PHP "password_hash($mot_de_passe_a_crypter,methode_de_cryptage)"
    $passwordArgon = password_hash($password,PASSWORD_ARGON2I);

    if(isset($_POST['nameAuth2']) && isset($_POST['password2'])){
        $entryUser = htmlspecialchars($_POST['nameAuth2']);
        $entryPassword = htmlspecialchars($_POST['password2']);

        // verification du nom d'utilisateur et du mot de passe avec la fonction "password_verify($le_mot_de_passe_a_verifier,$le_mot_de_passe_hash_par_argon)"
        if(($entryUser == $user) && (password_verify($entryPassword,$passwordArgon))){
            header('location:bienvenue.php?auth=1');
        }else{
            echo '<p class="error">Mot de passe ou nom d\'utilisateur incorrect<p>';
        }
    }
    ?>

    <!------------- EXERCICE 6 -- CALCULATRICE ---------------->
    <h2>6.calculatrice</h2>
    <form id="calculatrice" action="index.php#calculatrice" method='POST'>
        <input type="number" name="number1" id="number1">
        <select name="operateur" id="">
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="/">/</option>
            <option value="x">x</option>
            <option value="%">%</option>
        </select>
        <input type="number" name="number2" id="number2">
        <button>Calculer</button>
    </form>
    <?php
    //Verification de si les champs ne sont pas vide avec la fonction PHP "empty" (le ! pour l'inverse) 
    if (!empty($_POST['number1']) && !empty($_POST['number2']) && !empty($_POST['operateur'])) {
        if (isset($_POST['number1']) && isset($_POST['number2']) && isset($_POST['operateur'])) {
            $number1 = $_POST['number1'];
            $number2 = $_POST['number2'];
            $operateur = $_POST['operateur'];
            // Condition pour changer la fonction en fonction de l'opérateur choisi
            if($operateur=="+"){
                function calculatrice($a, $b){
                    $c = $a + $b;
                    return $c;
                }
            }elseif($operateur=="-"){
                function calculatrice($a, $b){
                    $c = $a - $b;
                    return $c;
                }
            }elseif($operateur=="/"){
                function calculatrice($a, $b){
                    if($b == 0){
                        $c = "Division par zero impossible!";
                    }else{
                        $c = $a / $b;           
                    }
                    return $c;
                }
            }elseif($operateur=="x"){
                function calculatrice($a, $b){
                    $c = $a * $b;
                    return $c;
                }
            }elseif($operateur=="%"){
                function calculatrice($a, $b){
                    if($b == 0){
                        $c = "Division par zero impossible!";
                    }else{
                        $c = $a % $b;
                        
                    }    
                    return $c;
                }
            }
        
            $resultCalculatrice = calculatrice($number1,$number2);

            echo "<p>". $resultCalculatrice . "</p>";
        }
    }

    ?>

    <!---------- EXERCICE 7 -- CONVERTISSEUR D'EUROS  ------------->
    <h2>7.Convertisseur d'euros'</h2>
    <p>Convertir :  </p>
    <form id="convert" action="index.php#convert" method='POST'>
        <input class="euro" type="number" name="euro" id="euro">
        <p><span>€</span> en 
        
        <select name="devise" id="">
                <option value="dollard">$</option>
                <option value="yen">¥</option>
        </select></p>

        <button>Convertir</button>
        <?php
        if(!empty($_POST['euro']) && !empty($_POST['devise'])){
            if(isset($_POST['euro']) && isset($_POST['devise'])){
                $euro = $_POST['euro'];
                $devise = $_POST['devise'];

                // Choix de la conversion en fonction de la devise choisi
                if($devise == "dollard"){
                    $converted = $euro * 1.09 . "$";
                }elseif($devise == "yen"){
                    $converted = $euro * 165.62 . "¥";
                }
            }
        }
        if(isset($converted)){
            echo "<p>" . $converted . "</p>";
        }

        ?>
    </form>
    <!-- EXERCICE 8 -- QUIZZ  -->
     <h2>8.Quizz League Of Legend</h2>
    <form id="quizz" action="index.php#quizz" method='POST'>

        <!-- QUESTION 1 -->
        <h3>Quel champion dit "Vienne la nuit, sonne l'heure"</h3>
        <input type="radio" name="quizz1" value="ahri" id=""><label>Ahri</label>
        <input type="radio" name="quizz1" value="senna" id=""><label>Senna</label>
        <input type="radio" name="quizz1" value="nocturne" id=""><label>Nocturne</label>
        <input type="radio" name="quizz1" value="kindred" id=""><label>Kindred</label>
        <?php 
        // Verification de la réponse
        if(isset($_POST['quizz1'])){
            $score = 0;
            if($_POST['quizz1'] == 'kindred'){
                echo "<p class='vrai'> VRAI </p>";
                $score += 1; //incrémentation du compte de points
            }else{
                echo "<p class='faux'> FAUX, la réponse était kindred </p>";
            }
        }
        ?>

        <!-- QUESTION 2 -->
        <h3>Qui utilise la compétence "surcharge</h3>
        <input type="radio" name="quizz2" id="" value="viktor"><label>Viktor</label>
        <input type="radio" name="quizz2" id="" value="blitzcrank"><label>Blitzcrank</label>
        <input type="radio" name="quizz2" id="" value="rumble"><label>Rumble</label>
        <input type="radio" name="quizz2" id="" value="zeri"><label>Zeri</label>
        <?php 
        // Verification de la réponse
        if(isset($_POST['quizz2'])){
            if($_POST['quizz2'] == 'blitzcrank'){
                echo "<p class='vrai'> VRAI </p>";
                $score += 1; //incrémentation du compte de points
            }else{
                echo "<p class='faux'> FAUX, la réponse était blitzcrank</p>";
            }
        }
        ?>
        
        <!-- QUESTION 3 -->
        <h3>Qui a détruit l'arbre mère de Ionia?</h3>
        <input type="radio" name="quizz3" id="" value="ivern"><label>Ivern</label>
        <input type="radio" name="quizz3" id="" value="teemo"><label>Teemo</label>
        <input type="radio" name="quizz3" id="" value="darius"><label>Darius</label>
        <input type="radio" name="quizz3" id="" value="aatrox"><label>Aatrox</label>
        <?php 
        // Verification de la réponse
        if(isset($_POST['quizz3'])){
            if($_POST['quizz3'] == 'ivern'){
                echo "<p class='vrai'> VRAI </p>";
                $score += 1; //incrémentation du compte de points
            }else{
                echo "<p class='faux'> FAUX, la réponse était ivern </p>";
            }
        }
        ?>
        <button>Vérifier</button>
    </form>
    <?php
        // Affichage du score final
        if(isset($_POST['quizz1']) && isset($_POST['quizz2']) && isset($_POST['quizz3'])){
            echo "<p>Votre score est de " . $score ." points!</p>";
        }
    ?> 


    <!----------- EXERCICE 9 -- NOMBRE MYSTERE  ----------->
    <h2>9.Jeux : nombre mytère</h2>
    <form id="mystery" action="index.php#mystery" method='POST'>
        <label for="number">Trouvez le nombre mystère compris entre 1 et 1000 </label>
        <input type="number" name="number" id="number">

        <!-- Input hidden pour cacher le nombre -->
        <input type="hidden" name="mystere" <?php
                                            // Si pas encore d'entrée dans l'input Hidden
                                            if (!isset($_POST['mystere'])) {
                                                //nouveau nombre mystère
                                                $mysteryNumber = rand(1, 1000);
                                                //Je met la valeur dans l'input hidden
                                                echo  'value="' . $mysteryNumber . '"';
                                            } else {
                                                //Recuperation de l'input hidden si le nombre existe déjà
                                                $mysteryNumber = $_POST['mystere'];
                                                //Je met la valeur dans l'input hidden
                                                echo 'value="' . $mysteryNumber . '"';
                                            }
                                            ?>>
        <button>Try !</button>
    </form>

    

    <?php

    if (isset($_POST['number'])) {
        $number = htmlspecialchars($_POST['number']);


        if ($number < $mysteryNumber) {
            echo '<p>Votre nombre est trop petit</p>';
        } else if ($number > $mysteryNumber) {
            echo '<p>Votre nombre est trop grand</p>';
        } else if ($number == $mysteryNumber) {
            echo '<p>Bravo !! pour rejouer <a href="index.php">Cliquez ici</a></p>';
        } else {
            echo '<p>Entrée non valide</p>';
        }
    }

    ?>

    <!------------- EXERCICE 10 -- UPLOAD D'IMAGE  -------------->
     <h2>10.Upload d'image</h2>
     <form id="upload" action="index.php#upload" method='POST' enctype='multipart/form-data'>
        <input type="file" name="upload">
        <button>Upload</button>
    </form>
    <?php
        if(isset($_FILES['upload'])){
            $imageName = $_FILES['upload']['name'];
            $imageInfo = pathinfo($imageName);
            $imageExt = $imageInfo['extension'];
            // Tableau qui va permettre de spécifier les extensions autorisées
            $autorizedExt = ['png','jpeg','jpg','webp','bmp','svg'];

            // Verification de l'extention du fichier
            
            if(in_array($imageExt,$autorizedExt)){
                $uniqueName = time() . rand(1,1000) . "." . $imageExt;
                move_uploaded_file($_FILES['upload']['tmp_name'],"assets/img/".$uniqueName);
            
            }else{
                echo "<p>Veuillez choisir un format de fichier valide(png,jpg,webp,bmp,svg)</p>";
            }
        }

        // Affichage de l'image après l'upload
        if(isset($uniqueName)){
            echo "<img src='assets/img/" . $uniqueName . "' alt=''>";
        }
     
    ?>
    
    

</body>

<style>
    /* Style dans le html, necessaire pour l'exercice 3 */
    body {
        background-color: <?php echo $color ?>;
    }
</style>

</html>