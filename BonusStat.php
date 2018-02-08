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
    $_SESSION['lancers']=floor($_SESSION['cnNv']/5)+1;
    $ba=0;
    $bd=0;
    $bp=0;
    for ($i=0;$i<$_SESSION['cnNv'];$i++){
        $rand=rand(1,20);
        if($rand==1){
            $ba+=0.05;
        }
        if($rand==2){
            $bd+=0.05;
        }
        if($rand==3){
            $bp+=0.05;
        }
    }
    if($_SESSION['droitbonus']==0){
        $ba=0;
        $bd=0;
        $bp=0;
    }
    $WaifuActive=new Waifu(fonction::RecupereWaifu($_SESSION['IDActive']));
    fonction::Maj($_SESSION['IDActive'],$WaifuActive->QuelEstMonBatk()+$ba,$WaifuActive->QuelEstMonBdef()+$bd,$WaifuActive->QuelEstMonBpv()+$bp,$WaifuActive->QuelEstMonExp());
    
    $pba='+'.($ba*100).'%';
    $pbd='+'.($bd*100).'%';
    $pbp='+'.($bp*100).'%';
    
    $_SESSION['droitbonus']=0;
?>
<html>
    <head>
        <title>RoW:U Bonus Stat</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/style.css"/>
        <script src="js/ajax.js"></script>
    </head>
    <body>
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <script type="text/javascript" src="js/scripts.js"></script>
        <nav>
            <div class="nav-wrapper">
                <a href="index.html" class="brand-logo"><img src="logo.png"></a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="selection.php">Fusion</a></li>
                    <li><a href="selection.php">Waifu House</a></li>
                    
                </ul>
            </div>
        </nav>
        <div class="row" style="margin-top: 30px">
            <div class="col s3 offset-s3">
                <img src="<?php echo $_SESSION['caImg']; ?>">
            </div>
            <div class="col s2" style="margin-top: 50px;font-size: 45px;"><p align="center"><b>Bonus de combat:</b><br>PV: <?php echo $pbp ?><br>Atk: <?php echo $pba ?><br>Def: <?php echo $pbd ?></p>
            <button class="col s10 offset-s1 btn-large" onclick="window.location.replace('Roulette.php');">Lancer la roulette!</button>
            </div>
        </div>
    </body>
</html>
