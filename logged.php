<?php session_start(); ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    $_SESSION['IDActive']=NULL;
    $_SESSION['page']=NULL;
    $_SESSION['materia']=NULL;
    $_SESSION['IDFus1']=NULL;
    $_SESSION['IDFus2']=NULL;
?>
<html>
    <head>
    <head>
        <title>Connecté</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/style.css"/>
        <script src="js/ajax.js"></script>
        <script>
            window.location.replace("selection.php");
            document.location.href = "selection.php";
        </script>
    </head>
</head>
<body>
    <nav>
        <div class="nav-wrapper">
            <a href="index.html" class="brand-logo"><img src="logo.png"></a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li><a href="index.html">TowerFall</a></li>
                <li><a href="index.html">Fusion</a></li>
                <li><a href="selection.php">Waifu House</a></li>
                
            </ul>
        </div>
    </nav>
    <p>Salut <?php echo $_SESSION['Pseudo']; ?> dont l'ID est <?php echo $_SESSION['IdJ']; ?></p>
</body>
</html>
