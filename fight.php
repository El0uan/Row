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
    $i = (isset($_GET["variable1"])) ? $_GET["variable1"] : NULL;
    
    
    $WaifuActive=new Waifu(fonction::RecupereWaifu($_SESSION['IDActive']));
    $WaifuActive->MutateurMesHP($_SESSION['caPVr']);
    $WaifuActive->MutateurXP($_SESSION['caXP']);
    $_SESSION['caNv'] = $WaifuActive->QuelEstMonNiveau();
    $_SESSION['caPV'] = $WaifuActive->QuelEstMaVie();
    $Nemesis= new Waifu(fonction::NouvelAdverssaire($_SESSION['Expn'],$_SESSION['IDn']));
    $Nemesis->MutateurMesHP($_SESSION['cnPVr']);
    

        if($i){
            if($i==1){//le joueur tape
                $WaifuActive->frapper($Nemesis);
                $_SESSION['cnPVr'] = $Nemesis->CombienMeResteTilDeVie(); 
                if(!$Nemesis->SuisJeVivant()){//la nemesis est morte, on en crée une nouvelle plus puissante
                    $_SESSION['caXP'] = round($WaifuActive->QuelEstMonExp());
                    $_SESSION['Expn'] =$_SESSION['Expn']*2;
                    $_SESSION['IDn'] = fonction::IDAleatoireInf(floor($_SESSION['cnNv']/10)+1);
                    $Nemesis= new Waifu(fonction::NouvelAdverssaire($_SESSION['Expn'],$_SESSION['IDn']));
                    $_SESSION['cnNv'] = $Nemesis->QuelEstMonNiveau();
                    $_SESSION['cnPV'] = $Nemesis->QuelEstMaVie();
                    $_SESSION['cnPVr'] = $Nemesis->CombienMeResteTilDeVie();
                    $_SESSION["cnImg"] = $Nemesis->QuelEstMonImage();
                    $_SESSION['cnNom'] = $Nemesis->CommentJeMapelle();
                    //on met l'xp de notre waifu à jour dans la BDD
                    fonction::Maj($_SESSION['IDActive'],$WaifuActive->QuelEstMonBatk(),$WaifuActive->QuelEstMonBdef(),$WaifuActive->QuelEstMonBpv(),$WaifuActive->QuelEstMonExp());
                }
            $_SESSION['turn']=1;
            }
            if($i==2){//le joueur tape
                $Nemesis->frapper($WaifuActive);
                $_SESSION['caPVr'] = $WaifuActive->CombienMeResteTilDeVie();
                $_SESSION['turn']=0;
           
            }
        echo $i;
        }
        //gestion barres de vie
        $bar1= intval($_SESSION['caPVr'])/intval($_SESSION['caPV'])*100;
        $pbar1='width:'.$bar1.'%';
        $bar2= intval($_SESSION['cnPVr'])/intval($_SESSION['cnPV'])*100;
        $pbar2='width:'.$bar2.'%';
        
        //gestion des probas de drops
        $nblancer=floor($_SESSION['cnNv']/5)+1;
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


?>
<html>
    <head>
        <title>RoW:U TowerFall</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/style.css"/>
        <script src="js/ajax.js"></script>
        <script>
            if (<?php echo $_SESSION['turn']; ?>==1){
                Action(2); 
            }
            function Action(i){
                request(readData);
                setTimeout(function() {
                   location.reload();
                }, 20);
                
                function request(callback) {
                    var xhr = getXMLHttpRequest();
	
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                            callback(xhr.responseText);
                        }
                    };
	
                    xhr.open("GET", "fight.php?variable1=" + i, true);
                    xhr.send(null);
                }

                function readData(sData) {
                    // alert(sData);
                }
            }

        
        </script>
    </head>
    <body>
        <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <script type="text/javascript" src="js/scripts.js"></script>
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
    </body>
    <div class="row" style="margin-top: 15px;">
        <img src="<?php echo $_SESSION['caImg']; ?>" class="col s3">
        <div class="col s3">
            <p align="left"><b><?php echo $_SESSION['caNom']; ?> Niv.<?php echo $_SESSION['caNv']; ?></b></p>
            <div class="w3-light-grey w3-round">
                <div class="w3-container w3-round w3-blue" style="<?php echo $pbar1; ?>">PV: <?php echo $_SESSION['caPVr']; ?>/<?php echo $_SESSION['caPV']; ?></div>
            </div>
            <p class="col offset-s4">Exp: <?php echo $_SESSION['caXP']; ?></p>
            <button class="col s10 offset-s1 btn-large" onclick="Action(1);">Attaquer</button><br>
            <button class="col s10 offset-s1 btn-large disabled" >Attaque spéciale!</button><br>
            <button class="col s10 offset-s1 btn-large disabled" >Attaque auto</button>
            
            
            
        </div>
        <div class="col s3">
            <p align="right"><b><?php echo $_SESSION['cnNom']; ?> Niv.<?php echo $_SESSION['cnNv']; ?></b></p>
            <div class="w3-light-grey w3-round">
                <div class="w3-container w3-round w3-red" style="<?php echo $pbar2; ?>">PV: <?php echo $_SESSION['cnPVr']; ?>/<?php echo $_SESSION['cnPV']; ?></div>
            </div>
            <p align="middle">Nombre de lancers: <?php echo $nblancer; ?><br>Rang1: <?php echo $dropRg1; ?>%<br>Rang2: <?php echo $dropRg2; ?>%<br>Rang3: <?php echo $dropRg3; ?>%</p>
            <button class="col s10 offset-s1 btn-large" onclick="window.location.replace('BonusStat.php');">Terminer</button>
        </div>
        <img src="<?php echo $_SESSION['cnImg']; ?>" class="col s3">
    </div>
</html>
