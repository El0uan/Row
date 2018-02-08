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
        
        if($_SESSION['page']==NULL || $_SESSION['page']<0){
            $_SESSION['page']=0;
        }
        
        $newi = (isset($_GET["variable1"])) ? $_GET["variable1"] : NULL;
        if($newi){
            $_SESSION['page']=$newi-1;   
        }
        $pageaffiche=$_SESSION['page']+1;
        
        
        $db= new PDO('mysql:host=mysql.#master_domain;dbname=waifu;','u256234750_el0u','manaka');
        $request = $db->query('SELECT IdJ, Pseudo, Mdp FROM utilisateur WHERE IdJ='.$_SESSION['IdJ']);
        $donnees = $request->fetch(PDO::FETCH_ASSOC);
        $perso = new Utilisateur($donnees);
        $request2 = $db->query('SELECT ID FROM deck WHERE IdJ='.$perso->AccesseurIdJ().' ORDER BY ID DESC');
        while($donnees2 = $request2->fetch(PDO::FETCH_ASSOC)){$perso->MutateurlistWaifu($donnees2["ID"]);}
        $_SESSION['ListeCarte']=$perso->AccesseurListe();
        $borne= count($_SESSION['ListeCarte'])+1-($_SESSION['page']*10);
        if($borne>11){$borne=11;}
        for($i = 1;$i<$borne;$i++){
            $js=$_SESSION['ListeCarte'][$_SESSION['page']*10+($i-1)];
            $j=intval($js);
            $Waifui=new Waifu(fonction::RecupereWaifu($j));
            $_SESSION['c'.$i.'Nv'] = $Waifui->QuelEstMonNiveau();
            $_SESSION['c'.$i.'Atk'] = $Waifui->QuelEstMaForce();
            $_SESSION['c'.$i.'Def'] = $Waifui->QuelEstMaDefense();
            $_SESSION['c'.$i.'PV'] = $Waifui->QuelEstMaVie();
            $_SESSION["c".$i."Img"] = $Waifui->QuelEstMonImage();
        }
        for($i = $borne;$i< 11;$i++){
            $_SESSION['c'.$i.'Nv'] = '';
            $_SESSION['c'.$i.'Atk'] = '';
            $_SESSION['c'.$i.'Def'] = '';
            $_SESSION['c'.$i.'PV'] = '';
            $_SESSION["c".$i."Img"] = "cartes/neutre.png";
        }
        if($_SESSION['materia']==NULL){$_SESSION['materia']= 1;}
        if($_SESSION['IDFus1']==NULL){$_SESSION['IDFus1']= intval($_SESSION['ListeCarte'][0]);}
        if($_SESSION['IDFus2']==NULL){$_SESSION['IDFus2']= intval($_SESSION['ListeCarte'][0]);}
        
        $test1=false;
        $test2=false;
        for($i = 0;$i< count($_SESSION['ListeCarte']);$i++){
            if(intval($_SESSION['ListeCarte'][$i])==$_SESSION['IDFus1']){
                $test1=true;
            }
            if(intval($_SESSION['ListeCarte'][$i])==$_SESSION['IDFus2']){
                $test2=true;
            }
        }
        if(!$test1){$_SESSION['IDFus1']= intval($_SESSION['ListeCarte'][0]);}
        if(!$test2){$_SESSION['IDFus2']= intval($_SESSION['ListeCarte'][0]);}
        
        
        
        $Waifu1=new Waifu(fonction::RecupereWaifu($_SESSION['IDFus1']));
        $_SESSION['cf1Nv'] = $Waifu1->QuelEstMonNiveau();
        $_SESSION['cf1Atk'] = $Waifu1->QuelEstMaForce();
        $_SESSION['cf1Def'] = $Waifu1->QuelEstMaDefense();
        $_SESSION['cf1PV'] = $Waifu1->QuelEstMaVie();
        $_SESSION["cf1Img"] = $Waifu1->QuelEstMonImage();
        $Batk1='+'.((($Waifu1->QuelEstMonBatk())-1)*100).'%';
        $Bdef1='+'.((($Waifu1->QuelEstMonBdef())-1)*100).'%';
        $Bpv1='+'.((($Waifu1->QuelEstMonBpv())-1)*100).'%';
        $Rg1=intval($Waifu1->QuelEstMonRang());
        
        $Waifu2=new Waifu(fonction::RecupereWaifu($_SESSION['IDFus2']));
        $_SESSION['cf2Nv'] = $Waifu2->QuelEstMonNiveau();
        $_SESSION['cf2Atk'] = $Waifu2->QuelEstMaForce();
        $_SESSION['cf2Def'] = $Waifu2->QuelEstMaDefense();
        $_SESSION['cf2PV'] = $Waifu2->QuelEstMaVie();
        $_SESSION["cf2Img"] = $Waifu2->QuelEstMonImage();
        $Batk2='+'.((($Waifu2->QuelEstMonBatk())-1)*100).'%';
        $Bdef2='+'.((($Waifu2->QuelEstMonBdef())-1)*100).'%';
        $Bpv2='+'.((($Waifu2->QuelEstMonBpv())-1)*100).'%';
        $Rg2=intval($Waifu2->QuelEstMonRang());
        
        
        if($Rg1==$Rg2 && $Rg1<3){
             
             if($_SESSION['cf1Nv']+$_SESSION['cf2Nv']>=20){
                 $Rg3=$Rg1+1;
             }
             else{$Rg3=$Rg1;}
        }
        else if($Rg1==$Rg2 && $Rg1==3){
            $Rg3=3;
        }
        else{ 
        $Rg3= max($Rg1,$Rg2);
        }
        $imgresult="cartes/neutre".$Rg3.".png";
        $Batkr='+'.((($Waifu1->QuelEstMonBatk()+$Waifu2->QuelEstMonBatk()+0.05)-2)*100).'%';
        $Bdefr='+'.((($Waifu1->QuelEstMonBdef()+$Waifu2->QuelEstMonBdef()+0.05)-2)*100).'%';
        $Bpvr='+'.((($Waifu1->QuelEstMonBpv()+$Waifu2->QuelEstMonBpv()+0.05)-2)*100).'%';
?>


<html>
    <head>
        <title>RoW:U Fusion</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
        <link type="text/css" rel="stylesheet" href="css/style.css"/>
        <script src="js/ajax.js"></script>
        <script>
            var page=<?php echo $_SESSION['page'] ?>+1;
            divpage.innerHTML =page;
            function ChangePage(i){
                request(readData);
                location.reload();
                function request(callback) {
                    var xhr = getXMLHttpRequest();
	
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                            callback(xhr.responseText);
                        }
                    };
	
                    xhr.open("GET", "selection.php?variable1=" + i, true);
                    xhr.send(null);
                }

                function readData(sData) {
                    //alert(sData);
                }
            }
            function ChangeMateria(i){
                request(readData);
                window.location.replace("Fusion.php");
                document.location.href = "Fusion.php";
                function request(callback) {
                    var xhr = getXMLHttpRequest();
	
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                            callback(xhr.responseText);
                        }
                    };
	
                    xhr.open("GET", "changefusion.php?variable1=" + i, true);
                    xhr.send(null);
                }

                function readData(sData) {
                    //alert(sData);
                }
            }
            function fusion(){
                if(<?php echo $_SESSION['IDFus1']?>!=<?php echo $_SESSION['IDFus2']?>){ 
                    request(readData);
                    location.reload();
                    
                }
                function request(callback) {
                    var xhr = getXMLHttpRequest();
	
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                            callback(xhr.responseText);
                        }
                    };
	
                    xhr.open("GET", "changefusion.php?fusion=" + 1, true);
                    xhr.send(null);
                }

                function readData(sData) {
                    //alert(sData);
                }
            }
            
        </script>
    </head>
    <body>
        <section style="background-color: #bbdefb">
            <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
            <script type="text/javascript" src="js/materialize.min.js"></script>
            <script type="text/javascript" src="js/scripts.js"></script>
            <nav>
                <div class="nav-wrapper">
                    <a href="index.php" class="brand-logo"><img src="logo.png"></a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li><a href="deco.php">Deconnection</a></li>
                        <li><a href="InitFight.php">Waifu Tower</a></li>
                        <li><a href="index.html">Fusion</a></li>
                        <li><a href="selection.php">My Waifus</a></li>
                        
                    </ul>
                </div>
            </nav>
            <div class="row" style="margin-top: 15px;">
                <div class="col s1 ">
                    <p align="center">Lvl: <?php echo $_SESSION['cf1Nv']; ?> <br>PV: <?php echo $_SESSION['cf1PV']; ?><br>Atk: <?php echo $_SESSION['cf1Atk']; ?><br>Def: <?php echo $_SESSION['cf1Def']; ?></p>
                    <p align="center">Bonus:<br>Atk: <?php echo $Batk1 ?><br>Def: <?php echo $Bdef1 ?><br>PV: <?php echo $Bpv1 ?></p>
                </div>
                <div class="col s3 ">
                    <p align="center"><b>Fusion Materia 1:</b></p>
                    <img class="materialboxed"  src="<?php echo $_SESSION['cf1Img']; ?>">
                </div>
                
                <div class="col s4 ">
                    <p align="middle">Resultat:<br>Atk: <?php echo $Batkr ?> | Def: <?php echo $Bdefr ?> | PV: <?php echo $Bpvr ?></p>
                    <img class="col s8 offset-s2" src="<?php echo $imgresult ?>">
                    <button class="col s8 offset-s2 btn-large" onclick="fusion();">FUSION!</button>
                </div>
                
                <div class="col s3 ">
                    <p align="center"><b>Fusion Materia 2:</b></p>
                    <img class="materialboxed"  src="<?php echo $_SESSION['cf2Img']; ?>"> 
                </div>
                <div class="col s1">
                    <p align="center">Lvl: <?php echo $_SESSION['cf2Nv']; ?> <br>PV: <?php echo $_SESSION['cf2PV']; ?><br>Atk: <?php echo $_SESSION['cf2Atk']; ?><br>Def: <?php echo $_SESSION['cf2Def']; ?></p>
                    <p align="center">Bonus:<br>Atk: <?php echo $Batk2 ?><br>Def: <?php echo $Bdef2 ?><br>PV: <?php echo $Bpv2 ?></p>
                </div>
            </div>
            
            <table>
                
                <tr>
                    <td></td>
                    <td></td>
                    <td><div style="margin: auto;width: 165px"><button class="btn-floating btn waves-effect waves-light blue" onclick="ChangePage(page-1)"><-</button><b><?php echo $pageaffiche ?></b><button class="btn-floating btn waves-effect waves-light blue" onclick="ChangePage(page+1)">-></button></div></td>
                    <td></td>
                    <td></td>
                    
                </tr>
                <tr>
                <a href="#bas"><p align="middle" style="font-size: 20px">Choix de la materia <b><?php echo $_SESSION['materia']; ?></b> </p></a>
                </tr>
                <tr>
                    <td><div class="slot-carte" id="c1">
                            <img class="materialboxed"  src="<?php echo $_SESSION['c1Img']; ?>">
                            <button onclick="ChangeMateria(1)"><p>Lvl: <?php echo $_SESSION['c1Nv']; ?> | PV: <?php echo $_SESSION['c1PV']; ?><br>Atk: <?php echo $_SESSION['c1Atk']; ?> | Def: <?php echo $_SESSION['c1Def']; ?></p></button>
                        </div></td>
                    <td><div class="slot-carte" id="c1">
                            <img class="materialboxed"  src="<?php echo $_SESSION['c2Img']; ?>">
                            <button onclick="ChangeMateria(2)"><p>Lvl: <?php echo $_SESSION['c2Nv']; ?> | PV: <?php echo $_SESSION['c2PV']; ?><br>Atk: <?php echo $_SESSION['c2Atk']; ?> | Def: <?php echo $_SESSION['c2Def']; ?></p></button>
                        </div></td><td><div class="slot-carte" id="c1">
                            <img class="materialboxed"  src="<?php echo $_SESSION['c3Img']; ?>">
                            <button onclick="ChangeMateria(3)"><p>Lvl: <?php echo $_SESSION['c3Nv']; ?> | PV: <?php echo $_SESSION['c3PV']; ?><br>Atk: <?php echo $_SESSION['c3Atk']; ?> | Def: <?php echo $_SESSION['c3Def']; ?></p></button>
                        </div></td>
                    </div></td><td><div class="slot-carte" id="c1">
                            <img class="materialboxed"  src="<?php echo $_SESSION['c4Img']; ?>">
                            <button onclick="ChangeMateria(4)"><p>Lvl: <?php echo $_SESSION['c4Nv']; ?> | PV: <?php echo $_SESSION['c4PV']; ?><br>Atk: <?php echo $_SESSION['c4Atk']; ?> | Def: <?php echo $_SESSION['c4Def']; ?></p></button>
                        </div></td>
                    </div></td><td><div class="slot-carte" id="c1">
                            <img class="materialboxed"  src="<?php echo $_SESSION['c5Img']; ?>">
                            <button onclick="ChangeMateria(5)"><p>Lvl: <?php echo $_SESSION['c5Nv']; ?> | PV: <?php echo $_SESSION['c5PV']; ?><br>Atk: <?php echo $_SESSION['c5Atk']; ?> | Def: <?php echo $_SESSION['c5Def']; ?></p></button>
                        </div></td>
                    
                </tr>
                <tr>
                    <td><div class="slot-carte" id="c1">
                            <img class="materialboxed"  src="<?php echo $_SESSION['c6Img']; ?>">
                            <button onclick="ChangeMateria(6)"><p>Lvl: <?php echo $_SESSION['c6Nv']; ?> | PV: <?php echo $_SESSION['c6PV']; ?><br>Atk: <?php echo $_SESSION['c6Atk']; ?> | Def: <?php echo $_SESSION['c6Def']; ?></p></button>
                        </div></td>
                    <td><div class="slot-carte" id="c1">
                            <img class="materialboxed"  src="<?php echo $_SESSION['c7Img']; ?>">
                            <button onclick="ChangeMateria(7)"><p>Lvl: <?php echo $_SESSION['c7Nv']; ?> | PV: <?php echo $_SESSION['c7PV']; ?><br>Atk: <?php echo $_SESSION['c7Atk']; ?> | Def: <?php echo $_SESSION['c7Def']; ?></p></button>
                        </div></td><td><div class="slot-carte" id="c1">
                            <img class="materialboxed"  src="<?php echo $_SESSION['c8Img']; ?>">
                            <button onclick="ChangeMateria(8)"><p>Lvl: <?php echo $_SESSION['c8Nv']; ?> | PV: <?php echo $_SESSION['c8PV']; ?><br>Atk: <?php echo $_SESSION['c8Atk']; ?> | Def: <?php echo $_SESSION['c8Def']; ?></p></button>
                        </div></td>
                    </div></td><td><div class="slot-carte" id="c1">
                            <img class="materialboxed"  src="<?php echo $_SESSION['c9Img']; ?>">
                            <button onclick="ChangeMateria(9)"><p>Lvl: <?php echo $_SESSION['c9Nv']; ?> | PV: <?php echo $_SESSION['c9PV']; ?><br>Atk: <?php echo $_SESSION['c9Atk']; ?> | Def: <?php echo $_SESSION['c9Def']; ?></p></button>
                        </div></td>
                    </div></td><td><div class="slot-carte" id="c1">
                            <img class="materialboxed"  src="<?php echo $_SESSION['c10Img']; ?>">
                            <button onclick="ChangeMateria(10)"><p>Lvl: <?php echo $_SESSION['c10Nv']; ?> | PV: <?php echo $_SESSION['c10PV']; ?><br>Atk: <?php echo $_SESSION['c10Atk']; ?> | Def: <?php echo $_SESSION['c10Def']; ?></p></button>
                        </div></td>
                    
                    
                    
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><div style="margin: auto;width: 165px"><button class="btn-floating btn waves-effect waves-light blue" onclick="ChangePage(page-1)"><-</button><b><?php echo $pageaffiche ?></b><button class="btn-floating btn waves-effect waves-light blue" onclick="ChangePage(page+1)">-></button></div></td>
                    <td></td>
                    <td></td>
                    
                </tr>
                
            </table>
            <section id="bas"></section>
        </section>
    </body>
</html>
