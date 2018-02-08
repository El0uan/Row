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

	var pseudo = encodeURIComponent(document.forms["formulairei"]["pseudo"].value);
	var password = encodeURIComponent(document.forms["formulairei"]["password"].value);
	
	xhr.open("GET", "inscription.php?variable1=" + pseudo + "&variable2=" + password, true);
	xhr.send(null);
}

function readData(sData) {
	//alert(sData);
        var result=sData.split('|');
        if (result[0]=="FAIL"){
            divi.innerHTML ="Erreur de connection!";
        }
        else if (result[0]=='0'){
            divi.innerHTML ="Pseudo pris";
        }
        else if(result[0]=='1'){
            divi.innerHTML ="Inscription réussie";
            window.location.replace("connect.html");
            document.location.href = "connect.html";
            divc.innerHTML ="Inscription réussie";
        }
}


function validI(){
    var pass=document.forms["formulairei"]["password"].value;
    var cpass=document.forms["formulairei"]["cpassword"].value;
    if(pass==cpass){
    request(readData);}
    else{divi.innerHTML ="MDP incorrect";}
    return false;
}