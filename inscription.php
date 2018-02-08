<?php
        // put your code here
        
        include 'Utilisateur.php';
        include'fonction.php';
        header("Content-Type: text/plain"); // Utilisation d'un header pour spécifier le type de contenu de la page. Ici, il s'agit juste de texte brut (text/plain). 

        $variable1 = (isset($_GET["variable1"])) ? $_GET["variable1"] : NULL;
        $variable2 = (isset($_GET["variable2"])) ? $_GET["variable2"] : NULL;
        

        if ($variable1 && $variable2) {
            // Faire quelque chose...
            if(fonction::VerifiePseudo($variable1)==0){
                fonction::AjoutUtilisateur($variable1, $variable2);
                $db= new PDO('mysql:host=mysql.#master_domain;dbname=waifu;','u256234750_el0u','manaka');
                $request = $db->query('SELECT IdJ FROM utilisateur ORDER BY IdJ DESC');
                $donnees = $request->fetch(PDO::FETCH_ASSOC);
                $IdJ=$donnees['IdJ'];
                
                fonction::AjoutCartesAuxDeck($IdJ,fonction::IDAleatoire(1),1.05,1.05,1.05,200);
                
                echo "1";
                echo '|';
            }
            else{
                echo "0";
                echo '|';
            }
            
        } else {
            echo "FAIL";
            echo '|';
        }

        ?>

