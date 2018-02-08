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

class Utilisateur {
   
    private $_Pseudo = "";
    private $_IdJ=0;
    private $_Mdp="";
    private $_listWaifu=array();
    
    static $compteur = 0;
    
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
        
               }
  
    public function AccesseurIdJ(){return $this->_IdJ;}
    public function AccesseurPseudo(){return $this->_Pseudo;}
    public function AccesseurMdp(){return $this->_Mdp;}
    public function AccesseurListe(){return $this->_listWaifu;}
    
    
    public function MutateurPseudo($nom){$this->_Pseudo=$nom;}
    public function MutateurIdJ($Id){$this->_IdJ=$Id;}
   public function MutateurMdp($Mdp){$this->_Mdp=$Mdp;}
   public function MutateurlistWaifu($id){array_push($this->_listWaifu,$id);}
   
     
    
   public function Affiche(){
    echo '<br>Pseudo : '.$this->_Pseudo;
    echo '<br>MDP : '.$this->_Mdp;
    echo '<br>IdJ : '.$this->_IdJ;
     echo '<br> carte en possession du joueur : <br>';
     print_r($this->_listWaifu);
       echo '<br>';
      
   }
   

  
 
    }
