<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of fonction
 *
 * @author corentin.marolleau
 */
class fonction {

    public static function RecupereWaifu($ID){
       $db= new PDO('mysql:host=mysql.#master_domain;dbname=waifu;','u256234750_el0u','manaka');

        $request = $db->query('SELECT ID,IdJ,deck.IdC,Batk,Bdef,Bpv,XP,Nom,LienImage,ATK,DEF,PV,Rang FROM deck INNER JOIN collection ON deck.IdC = collection.IdC WHERE ID='.$ID);


        while ($donnees = $request->fetch(PDO::FETCH_ASSOC)){  
            return $donnees;
            }



   }

    public static function NouvelAdverssaire($XP,$IdC){
       $db= new PDO('mysql:host=mysql.#master_domain;dbname=waifu;','u256234750_el0u','manaka');
        $request = $db->query('SELECT Nom,LienImage,ATK,DEF,PV,Rang FROM collection WHERE collection.IdC='.$IdC);
           $data = $request->fetch (PDO::FETCH_ASSOC);
           //print_r($data);
        $lol=$data+array('ID'=>0,"IdC"=>$IdC,"Batk"=>1,"Bdef"=>1,"Bpv"=>1,"XP"=>$XP);
        return $lol;
   }   

    public static function AjoutUtilisateur($Pseudo,$Mdp){

        $db = new PDO('mysql:host=mysql.#master_domain;dbname=waifu;','u256234750_el0u','manaka');
        $req = $db->prepare('INSERT INTO utilisateur (Pseudo,Mdp) VALUES (:Pseudo,:Mdp)');
        $req->execute(array(
         'Pseudo' => $Pseudo,
         'Mdp' => $Mdp
        ));
        }
        
     public static function VerifiePseudo($Pseudo){

        $db= new PDO('mysql:host=mysql.#master_domain;dbname=waifu;','u256234750_el0u','manaka');
        $request = $db->query('SELECT IdJ, Pseudo, Mdp FROM utilisateur');
        while ($donnees = $request->fetch(PDO::FETCH_ASSOC)){
            $perso = new Utilisateur($donnees);
            if($perso->AccesseurPseudo()==$Pseudo){return $perso->AccesseurIdJ();}
            
            
        }
        return 0;
    }

    public static function SupprimeCarteAuxDeck($ID){

        $db = new PDO('mysql:host=mysql.#master_domain;dbname=waifu;','u256234750_el0u','manaka');
        $db->exec('DELETE FROM deck WHERE deck.ID='.$ID);
               } 

    public static function SupprimeUtilisateur($IdJ){

        $db = new PDO('mysql:host=mysql.#master_domain;dbname=waifu;','u256234750_el0u','manaka');
        $db->exec('DELETE FROM utilisateur WHERE utilisateur.IdJ='.$IdJ);
               } 

    public static function AjoutCartesAuxDeck($idj,$idC,$Batk,$Bdef,$Bpv,$XP){

        $db = new PDO('mysql:host=mysql.#master_domain;dbname=waifu;','u256234750_el0u','manaka');
        $req = $db->prepare('INSERT INTO deck(IdJ,IdC,Batk,Bdef,Bpv,XP) VALUES (:IdJ,:IdC,:Batk,:Bdef,:Bpv,:XP)');
        $req->execute(array(
         'IdJ' => $idj,
         'IdC' => $idC,
         'Batk' => $Batk,
         'Bdef' => $Bdef,
          'Bpv' => $Bpv,  
         'XP' =>$XP
        ));
        }
    
    public static function Niveau($XP){
        $niv = 1;
        $expcal=100;
        while($XP>=$expcal){
            $niv=$niv+1;
            $expcal=$expcal*2;
        }
        return $niv;
        }
        
    public static function Fusion($ID1,$ID2){
        
        $db = new PDO('mysql:host=mysql.#master_domain;dbname=waifu;','u256234750_el0u','manaka');
        $requestRang = $db->query('SELECT Rang FROM `collection` ORDER BY Rang DESC');
        $Rang = $requestRang->fetch(PDO::FETCH_ASSOC);
        
        $RangMax=$Rang["Rang"];
        echo "Rang Max=".$RangMax;
        
        $StatCarte1=fonction::RecupereWaifu($ID1);
        $StatCarte2=fonction::RecupereWaifu($ID2);
        
        $IDJ=$StatCarte1["IdJ"];
        
        $NV1=fonction::Niveau($StatCarte1["XP"]);
        $NV2=fonction::Niveau($StatCarte2["XP"]);
        
        $Rg1=$StatCarte1["Rang"];
        $Rg2=$StatCarte2["Rang"];
        
        $BatkFusion=$StatCarte1["Batk"]+$StatCarte2["Batk"]+0.05-1;
                
        $BdefFusion=$StatCarte1["Bdef"]+$StatCarte2["Bdef"]+0.05-1;
                
        $BPVFusion=$StatCarte1["Bpv"]+$StatCarte2["Bpv"]+0.05-1;
        
        if($Rg1==$Rg2 && $Rg1<$RangMax){
             
             if($NV1+$NV2>=20){
                 $Rg3=$Rg1+1;
                 
             }
             else{$Rg3=$Rg1;}
        }
        else if($Rg1==$Rg2 && $Rg1==$RangMax){
             
            $Rg3=$RangMax;
           
        }
        else{ 
        
        $Rg3= max($Rg1,$Rg2);
       
        }
        
      
        
        
        $db1 = new PDO('mysql:host=mysql.#master_domain;dbname=waifu;','u256234750_el0u','manaka');
        $requestIDC = $db1->query('SELECT IdC FROM `collection` WHERE Rang='.$Rg3.' ORDER BY RAND()');
        $IDC = $requestIDC->fetch(PDO::FETCH_ASSOC);

        fonction::AjoutCartesAuxDeck($IDJ,$IDC["IdC"],$BatkFusion,$BdefFusion,$BPVFusion,1);
        fonction::SupprimeCarteAuxDeck($ID1);
        fonction::SupprimeCarteAuxDeck($ID2);
        
    }
    
    public static function IDAleatoireInf($Rang){
        $db1 = new PDO('mysql:host=mysql.#master_domain;dbname=waifu;','u256234750_el0u','manaka');
        $requestIDC = $db1->query('SELECT IdC FROM `collection` WHERE Rang<='.$Rang.' ORDER BY RAND()');
        $IDC = $requestIDC->fetch(PDO::FETCH_ASSOC);
        return $IDC["IdC"];
        }
        
    public static function IDAleatoire($Rang){
        $db1 = new PDO('mysql:host=mysql.#master_domain;dbname=waifu;','u256234750_el0u','manaka');
        $requestIDC = $db1->query('SELECT IdC FROM `collection` WHERE Rang='.$Rang.' ORDER BY RAND()');
        $IDC = $requestIDC->fetch(PDO::FETCH_ASSOC);
        return $IDC["IdC"];
        }
        
    public static function Maj($ID,$Batk,$Bdef,$Bpv,$XP){
            $db = new PDO('mysql:host=mysql.#master_domain;dbname=waifu;','u256234750_el0u','manaka');
        $req = $db->prepare('UPDATE deck SET Batk = :Batk, Bdef = :Bdef, Bpv = :Bpv, XP = :XP WHERE ID = :ID');
        $req->execute(array(
	'Batk' => $Batk,
	'Bdef' => $Bdef,
	'Bpv' => $Bpv,
        'XP' => $XP,
	'ID' => $ID
	));
        }


}

