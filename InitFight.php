<?php session_start(); ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
        // put your code here
        include 'Utilisateur.php';
        include'fonction.php';
        include'Waifu.php';
        $_SESSION['droitbonus']=1;
        $_SESSION['droitroulette']=1;
        $_SESSION['turn']=0;
        //On s'assure qu'on a une waifu active
        $db= new PDO('mysql:host=mysql.#master_domain;dbname=waifu;','u256234750_el0u','manaka');
        $request = $db->query('SELECT IdJ, Pseudo, Mdp FROM utilisateur WHERE IdJ='.$_SESSION['IdJ']);
        $donnees = $request->fetch(PDO::FETCH_ASSOC);
        $perso = new Utilisateur($donnees);
        $request2 = $db->query('SELECT ID FROM deck WHERE IdJ='.$perso->AccesseurIdJ().' ORDER BY XP DESC');
        while($donnees2 = $request2->fetch(PDO::FETCH_ASSOC)){$perso->MutateurlistWaifu($donnees2["ID"]);}
        $_SESSION['ListeCarte']=$perso->AccesseurListe();
        if($_SESSION['IDActive']==NULL){$_SESSION['IDActive']= intval($_SESSION['ListeCarte'][0]);}
        $test=false;
        for($i = 0;$i< count($_SESSION['ListeCarte']);$i++){
            if(intval($_SESSION['ListeCarte'][$i])==$_SESSION['IDActive']){
                $test=true;
            }
        }
        if(!$test){$_SESSION['IDActive']= intval($_SESSION['ListeCarte'][0]);}
        
        
        //On lit les infos de la waifu Active
        $WaifuActive=new Waifu(fonction::RecupereWaifu($_SESSION['IDActive']));
        $_SESSION['caNv'] = $WaifuActive->QuelEstMonNiveau();
        $_SESSION['caAtk'] = $WaifuActive->QuelEstMaForce();
        $_SESSION['caDef'] = $WaifuActive->QuelEstMaDefense();
        $_SESSION['caPV'] = $WaifuActive->QuelEstMaVie();
        $_SESSION['caPVr'] = $WaifuActive->CombienMeResteTilDeVie();
        $_SESSION["caImg"] = $WaifuActive->QuelEstMonImage();
        $_SESSION['caNom'] = $WaifuActive->CommentJeMapelle();
        $_SESSION['caXP'] = $WaifuActive->QuelEstMonExp();
        //On génére la premiere waifu némésis
        $_SESSION['IDn'] = fonction::IDAleatoireInf(1);
        $_SESSION['Expn'] = 50;

        $Nemesis= new Waifu(fonction::NouvelAdverssaire($_SESSION['Expn'],$_SESSION['IDn']));
        $_SESSION['cnNv'] = $Nemesis->QuelEstMonNiveau();
        $_SESSION['cnPV'] = $Nemesis->QuelEstMaVie();
        $_SESSION['cnPVr'] = $Nemesis->CombienMeResteTilDeVie();
        $_SESSION["cnImg"] = $Nemesis->QuelEstMonImage();
        $_SESSION['cnNom'] = $Nemesis->CommentJeMapelle();
        
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script>
            window.location.replace("fight.php");
            document.location.href = "fight.php";
        </script>
    </head>
    <body>
        
    </body>
</html>
