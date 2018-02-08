/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function request(callback) {
	var xhr = getXMLHttpRequest();
	
	xhr.onreadystatechange = function() {
		if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
			callback(xhr.responseText);
		}
	};

	var pseudo = encodeURIComponent(document.forms["formulairec"]["pseudo"].value);
	var password = encodeURIComponent(document.forms["formulairec"]["password"].value);
	
	xhr.open("GET", "connect.php?variable1=" + pseudo + "&variable2=" + password, true);
	xhr.send(null);
}

function readData(sData) {
	var result=sData.split('|');
        //alert(result);
        if (result[0]=="FAIL"){
            divc.innerHTML ="Erreur de connection!";
        }
        else if (result[0]!="0"){
            if(result[1]=="0"){
                divc.innerHTML ="MDP incorrect";
            }
            else{
                divc.innerHTML ="Connection réussie!";
                window.location.replace("logged.php");
                document.location.href = "logged.php";
            }
        }
        else{
            divc.innerHTML ="ID incorrect";
        }
}

function validc(){
    request(readData);
    return (false);
}



