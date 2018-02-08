<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of function
 *
 * @author corentin.marolleau
 */

class Waifu {
   
   private $_ID;
   private $_IdC;
   private $_Batk;
   private $_Bdef;
   private $_Bpv;
   private $_XP;
   private $_Nom;
   private $_LienImage;
   private $_ATK;
   private $_DEF;
   private $_PV;
   private $_Rang;
   private $_MesHp;
   private $_NV;
   
    
     public function Hydrate(array $donnees)
            {
              foreach ($donnees as $key => $value){
                // On récupère le nom du setter correspondant à l'attribut.
                $method = 'Mutateur'.ucfirst($key);

                // Si le setter correspondant existe.
                if (method_exists($this, $method)){
                  // On appelle le setter.
                  $this->$method($value);
                }
              }
                
            }
   
   public function __construct($array){
       $this->Hydrate($array);
       $this->_NV=$this->QuelEstMonNiveau();
       $this->_MesHp=$this->QuelEstMaVie();
       
       
   }
   
    public function MutateurID($ID){$this->_ID=$ID;}
    public function MutateurIdC($IDC){$this->_IdC=$IDC;}
    public function MutateurBatk($Batk){$this->_Batk=$Batk;}
    public function MutateurBdef($Bdef){$this->_Bdef=$Bdef;}
    public function MutateurBpv($Bpv){$this->_Bpv=$Bpv;}
    public function MutateurXP($XP){$this->_XP=$XP;}
    public function MutateurNom($nom){$this->_Nom=$nom;}
    public function MutateurLienImage($lien){$this->_LienImage=$lien;}
    public function MutateurATK($ATK){$this->_ATK=$ATK;}
    public function MutateurDEF($DEF){$this->_DEF=$DEF;}
    public function MutateurPV($PV){$this->_PV=$PV;}
    public function MutateurRang($rang){$this->_Rang=$rang;}
    public function MutateurMesHP($hp){$this->_MesHp=$hp;}
   
  
    
     public function frapper(Waifu $cible){
        if ($cible->suisJeVivant()==true and $this->suisJeVivant()==true){
            if($cible->seMangeUneAvoine($this->quelEstMaForce())==true){}
            else{$this->GagnerExperience($cible->QuelEstMonNiveau());}
        }
        
    }
        
    public function SeMangeUneAvoine($SaForce){
        $degat= $this->QuelEstMaDefense()-$SaForce;
        if($degat < 0) {$this->_MesHp+=$degat;}
        return $this->SuisJeVivant();
       
    }
    
    public function CombienMeResteTilDeVie(){return $this->_MesHp;}
    
    public function CommentJeMapelle(){return $this->_Nom;}
    
    public function SuisJeVivant(){
        if($this->_MesHp>0){return true;}
        else{return false;}
    }
    
    private function GagnerExperience($NC){
        $MN=$this->QuelEstMonNiveau();
        if($NC-$MN>0){$this->_XP+=($NC-$MN)*$MN*100;}
        else{$this->_XP+=($MN/($MN-$NC+1))*100;}
        
        
        
    }
    
    public function QuelEstMonNiveau(){
        $niv = 1;
        $expcal=100;
        while($this->_XP>=$expcal){
            $niv=$niv+1;
            $expcal=$expcal*2;
        }
        return $niv;
        }
    
    public function QuelEstMaForce(){return floor ($this->_Batk*$this->_ATK*$this->QuelEstMonNiveau()*3.5);}
    
    public function QuelEstMaDefense(){return floor ($this->_Bdef*$this->_DEF*$this->QuelEstMonNiveau()*1);}
    
    public function QuelEstMaVie(){return floor ($this->_PV*$this->_Bpv*$this->QuelEstMonNiveau()*25);}
    
    public function QuelEstMonImage(){return $this->_LienImage;}
    
    public function QuelEstMonExp(){return $this->_XP;}
    
    public function QuelEstMonBatk(){return $this->_Batk;}
    
    public function QuelEstMonBdef(){return $this->_Bdef;}
    
    public function QuelEstMonBpv(){return $this->_Bpv;}
    
    public function QuelEstMonRang(){return $this->_Rang;}
    




public function Affiche(){
    echo '<br>ID de la carte: '.$this->_ID;
    echo '<br>IdC : '.$this->_IdC;
    echo '<br>  //  NOM : '.$this->_Nom;
    echo '  //  Lien : '.$this->_LienImage;
    echo '<br> Rang : '.$this->_Rang;
     echo '<br>XP : '.$this->_XP;
      echo '    //  NV : '.$this->QuelEstMonNiveau();
    echo '<br>ATK : '.$this->QuelEstMaForce();
    echo '<br>DEF : '.$this->QuelEstMaDefense();
    echo '<br>PV : '.$this->CombienMeResteTilDeVie();
     echo '/'.$this->QuelEstMaVie();
      
      
        echo '<br>';
      
   }
               
              
      }
