<?php
        // put your code here
        session_start();
        include 'Utilisateur.php';
        include'fonction.php';
        header("Content-Type: text/plain"); // Utilisation d'un header pour spécifier le type de contenu de la page. Ici, il s'agit juste de texte brut (text/plain). 

        $variable1 = (isset($_GET["variable1"])) ? $_GET["variable1"] : NULL;
        $variable2 = (isset($_GET["variable2"])) ? $_GET["variable2"] : NULL;
        

        if ($variable1 && $variable2) {
            // Faire quelque chose...
            $id=fonction::VerifiePseudo($variable1);
             echo $id;
             echo '|';
             if ($id>0){
                $db= new PDO('mysql:host=mysql.#master_domain;dbname=waifu;','u256234750_el0u','manaka');
                $request = $db->query('SELECT IdJ, Pseudo, Mdp FROM utilisateur WHERE IdJ='.$id);
                $donnees = $request->fetch(PDO::FETCH_ASSOC);
                $user= new Utilisateur($donnees);
                
                if ($user->AccesseurMdp()==$variable2){
                    $_SESSION['IdJ'] = $id;
                    $_SESSION['Pseudo'] = $variable1;
                    $_SESSION['user'] = $user;
                    
                    echo '1';
                    echo '|';
                }
                else{
                    echo '0';
                    echo '|';
                }
                
                
             }
             else{
                 echo "nope";
                 echo '|';
             }

          
        } else {
            echo "FAIL";
            echo '|';
        }

        ?>


