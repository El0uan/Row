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

        if($_SESSION['IDActive']==NULL){$_SESSION['IDActive']= intval($_SESSION['ListeCarte'][0]);}
        
        $test=false;
        for($i = 0;$i< count($_SESSION['ListeCarte']);$i++){
            if(intval($_SESSION['ListeCarte'][$i])==$_SESSION['IDActive']){
                $test=true;
            }
        }
        if(!$test){$_SESSION['IDActive']= intval($_SESSION['ListeCarte'][0]);}
        
        
        $WaifuActive=new Waifu(fonction::RecupereWaifu($_SESSION['IDActive']));
        $_SESSION['caNv'] = $WaifuActive->QuelEstMonNiveau();
        $_SESSION['caAtk'] = $WaifuActive->QuelEstMaForce();
        $_SESSION['caDef'] = $WaifuActive->QuelEstMaDefense();
        $_SESSION['caPV'] = $WaifuActive->QuelEstMaVie();
        $_SESSION["caImg"] = $WaifuActive->QuelEstMonImage();
        $Batk='+'.((($WaifuActive->QuelEstMonBatk())-1)*100).'%';
        $Bdef='+'.((($WaifuActive->QuelEstMonBdef())-1)*100).'%';
        $Bpv='+'.((($WaifuActive->QuelEstMonBpv())-1)*100).'%';
        
?>


<html>
    <head>
        <title>RoW:U Ma Waifu House</title>
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
            function ChangeActive(i){
                request(readData);
                window.location.replace('selection.php');
                function request(callback) {
                    var xhr = getXMLHttpRequest();
	
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
                            callback(xhr.responseText);
                        }
                    };
	
                    xhr.open("GET", "changeactive.php?variable1=" + i, true);
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
                        <li><a href="Fusion.php">Fusion</a></li>
                        <li><a href="selection.php">My Waifus</a></li>
                        
                    </ul>
                </div>
            </nav>
            <div align="middle" style="margin-top: 20px;font-size: 45px;"><b>Ma Waifu:</b></div>
            <div class="row">
                <div class="col s3 offset-s1">
                    <img class="materialboxed"  src="<?php echo $_SESSION['caImg']; ?>">
                </div>
                <div class="col s2" style="margin-top: 120px;font-size: 45px;"><p align="center"><b>Statistiques:</b><br>Lvl: <?php echo $_SESSION['caNv']; ?> <br>PV: <?php echo $_SESSION['caPV']; ?><br>Atk: <?php echo $_SESSION['caAtk']; ?><br>Def: <?php echo $_SESSION['caDef']; ?></p></div>
                <div class="col s2" style="margin-top: 120px;font-size: 45px;"><p align="center"><b>Bonus:</b><br>------------<br>(<?php echo $Bpv; ?>)<br>(<?php echo $Batk; ?>)<br>(<?php echo $Bdef; ?>)</p></div>
                <div class="col s4" style="margin-top: 200px">
                    <a href="fusion.php"><button class="col s10 btn-large" >Fusionner cette Waifu</button></a>
                    <a href="InitFight"><button class="col s10 btn-large" >Combattre avec cette Waifu</button></a>
                    <a href="#bas"><button class="col s10 btn-large" href="#bas">Changer de waifu</button></a>
                    
                </div>
            </div>
            <table style="width: 100%">
                <tr>
                    <td></td>
                    <td></td>
                    <td><div style="margin: auto;width: 165px"><button class="btn-floating btn waves-effect waves-light blue" onclick="ChangePage(page-1)"><-</button><b><?php echo $pageaffiche ?></b><button class="btn-floating btn waves-effect waves-light blue" onclick="ChangePage(page+1)">-></button></div></td>
                    <td></td>
                    <td></td>
                    
                </tr>
                <tr>
                    <td><div class="slot-carte" id="c1">
                            <img class="materialboxed"  src="<?php echo $_SESSION['c1Img']; ?>">
                            <button onclick="ChangeActive(1)"><p>Lvl: <?php echo $_SESSION['c1Nv']; ?> | PV: <?php echo $_SESSION['c1PV']; ?><br>Atk: <?php echo $_SESSION['c1Atk']; ?> | Def: <?php echo $_SESSION['c1Def']; ?></p></button>
                        </div></td>
                    <td><div class="slot-carte" id="c1">
                            <img class="materialboxed"  src="<?php echo $_SESSION['c2Img']; ?>">
                            <button onclick="ChangeActive(2)"><p>Lvl: <?php echo $_SESSION['c2Nv']; ?> | PV: <?php echo $_SESSION['c2PV']; ?><br>Atk: <?php echo $_SESSION['c2Atk']; ?> | Def: <?php echo $_SESSION['c2Def']; ?></p></button>
                        </div></td><td><div class="slot-carte" id="c1">
                            <img class="materialboxed"  src="<?php echo $_SESSION['c3Img']; ?>">
                            <button onclick="ChangeActive(3)"><p>Lvl: <?php echo $_SESSION['c3Nv']; ?> | PV: <?php echo $_SESSION['c3PV']; ?><br>Atk: <?php echo $_SESSION['c3Atk']; ?> | Def: <?php echo $_SESSION['c3Def']; ?></p></button>
                        </div></td>
                    </div></td><td><div class="slot-carte" id="c1">
                            <img class="materialboxed"  src="<?php echo $_SESSION['c4Img']; ?>">
                            <button onclick="ChangeActive(4)"><p>Lvl: <?php echo $_SESSION['c4Nv']; ?> | PV: <?php echo $_SESSION['c4PV']; ?><br>Atk: <?php echo $_SESSION['c4Atk']; ?> | Def: <?php echo $_SESSION['c4Def']; ?></p></button>
                        </div></td>
                    </div></td><td><div class="slot-carte" id="c1">
                            <img class="materialboxed"  src="<?php echo $_SESSION['c5Img']; ?>">
                            <button onclick="ChangeActive(5)"><p>Lvl: <?php echo $_SESSION['c5Nv']; ?> | PV: <?php echo $_SESSION['c5PV']; ?><br>Atk: <?php echo $_SESSION['c5Atk']; ?> | Def: <?php echo $_SESSION['c5Def']; ?></p></button>
                        </div></td>
                    
                </tr>
                <tr>
                    <td><div class="slot-carte" id="c1">
                            <img class="materialboxed"  src="<?php echo $_SESSION['c6Img']; ?>">
                            <button onclick="ChangeActive(6)"><p>Lvl: <?php echo $_SESSION['c6Nv']; ?> | PV: <?php echo $_SESSION['c6PV']; ?><br>Atk: <?php echo $_SESSION['c6Atk']; ?> | Def: <?php echo $_SESSION['c6Def']; ?></p></button>
                        </div></td>
                    <td><div class="slot-carte" id="c1">
                            <img class="materialboxed"  src="<?php echo $_SESSION['c7Img']; ?>">
                            <button onclick="ChangeActive(7)"><p>Lvl: <?php echo $_SESSION['c7Nv']; ?> | PV: <?php echo $_SESSION['c7PV']; ?><br>Atk: <?php echo $_SESSION['c7Atk']; ?> | Def: <?php echo $_SESSION['c7Def']; ?></p></button>
                        </div></td><td><div class="slot-carte" id="c1">
                            <img class="materialboxed"  src="<?php echo $_SESSION['c8Img']; ?>">
                            <button onclick="ChangeActive(8)"><p>Lvl: <?php echo $_SESSION['c8Nv']; ?> | PV: <?php echo $_SESSION['c8PV']; ?><br>Atk: <?php echo $_SESSION['c8Atk']; ?> | Def: <?php echo $_SESSION['c8Def']; ?></p></button>
                        </div></td>
                    </div></td><td><div class="slot-carte" id="c1">
                            <img class="materialboxed"  src="<?php echo $_SESSION['c9Img']; ?>">
                            <button onclick="ChangeActive(9)"><p>Lvl: <?php echo $_SESSION['c9Nv']; ?> | PV: <?php echo $_SESSION['c9PV']; ?><br>Atk: <?php echo $_SESSION['c9Atk']; ?> | Def: <?php echo $_SESSION['c9Def']; ?></p></button>
                        </div></td>
                    </div></td><td><div class="slot-carte" id="c1">
                            <img class="materialboxed"  src="<?php echo $_SESSION['c10Img']; ?>">
                            <button onclick="ChangeActive(10)"><p>Lvl: <?php echo $_SESSION['c10Nv']; ?> | PV: <?php echo $_SESSION['c10PV']; ?><br>Atk: <?php echo $_SESSION['c10Atk']; ?> | Def: <?php echo $_SESSION['c10Def']; ?></p></button>
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
