<?php session_start(); ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    include 'Utilisateur.php';
    include'fonction.php';
    include'Waifu.php';
    $_SESSION['lancers']-=1;
    if($_SESSION['cnNv']<10){
        $dropRg1=30+2*$_SESSION['cnNv'];
        $dropRg2=0;
        $dropRg3=0;
    }
    if($_SESSION['cnNv']>=10){
        $dropRg1=40+$_SESSION['cnNv'];
        $dropRg2=$_SESSION['cnNv'];
        $dropRg3=0;
    }
    if($_SESSION['cnNv']>=20){
        $dropRg1=60;
        $dropRg2=$_SESSION['cnNv'];
        $dropRg3=floor(5+(($_SESSION['cnNv']-20)/2));
    }
    if($_SESSION['cnNv']>30){
        $dropRg1=60;
        $dropRg2=30;
        $dropRg3=10;
    }
    if($_SESSION['lancers']>=0){
        $rand=rand(1,100);
        if ($rand>$dropRg1+$dropRg2+$dropRg3){
            //pas de cartes
            $id=0;
        }
        else if ($rand>$dropRg1+$dropRg2){
            //carte rang3
            $id= fonction::IDAleatoire(3);
        }
        else if ($rand>$dropRg1){
            //carte rang2
            $id= fonction::IDAleatoire(2);
        }
        else{
            //carte rang1
            $id= fonction::IDAleatoire(1);
        }
        if($id>0){
            $drop=new Waifu(fonction::NouvelAdverssaire(50, $id));
            fonction::AjoutCartesAuxDeck($_SESSION['IdJ'],$id,1,1,1,50);
            $img=$drop->QuelEstMonImage();
            $txt="Tu obtiens une nouvelle waifu!";
        }
        else{
            $img="cartes/neutre.png";
            $txt="Pas de chance, pas de waifu cette fois :(";
        }
    }
    
    ?>
<html>
    <head>
        <title>RoW:U Roulette</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/style.css"/>
        <script src="js/ajax.js"></script>
        <script>
            if (<?php echo $_SESSION['lancers']; ?><0){
            window.location.replace("selection.php");
            }
        </script>
    </head>
    <body>
            <section style="background-color: #bbdefb">
                <nav>
                    <div class="nav-wrapper">
                        <a href="index.php" class="brand-logo"><img src="logo.png"></a>
                        <ul id="nav-mobile" class="right hide-on-med-and-down">
                            <li><a href="deco.php">Deconnection</a></li>
                            <li><a href="InitFight.php">Waifu Tower</a></li>
                            <li><a href="Fusion.php">Fusion</a></li>
                            <li><a href="selection.php">My Waifus</a></li>
                            
                        </ul>
                    </div>
                </nav>
                <div class="row">
                    <p class="col s4" style="margin-top: 150px; font-size: 20px" align="right">Lancers restants: <b><?php echo $_SESSION['lancers'] ?></b></p>
                    <div class="col s3">
                        <p style="font-size: 20px" align="middle"><?php echo $txt ?></p>
                        <img  src="<?php echo $img ?>">
                    </div>
                    <div class="col s3">
                        <p style="font-size: 30px" align="middle"><br>Rang1: <?php echo $dropRg1; ?>%<br>Rang2: <?php echo $dropRg2; ?>%<br>Rang3: <?php echo $dropRg3; ?>%</p>
                        <button class="col s10 offset-s1 btn-large" onclick="location.reload();">Relancer!</button>
                    </div>
                </div>
                
            </section>   
    </body>
</html>
