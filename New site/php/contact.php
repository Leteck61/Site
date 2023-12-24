<?php 

$array = array("firstname" => "", "name" => "", "email" => "", "phone" => "", "message" => "", "firstnameError" => "", "nameError" => "", "emailError" => "", "phoneError" => "", "messageError" => "", "isSuccess" => false,);

$emailTo = "leo.louvet@sts-sio-caen.info";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $array["firstname"] = verifyInput($_POST["firstname"]);
    $array["name"] = verifyInput($_POST["name"]);
    $array["email"] = verifyInput($_POST["email"]);
    $array["phone"] = verifyInput($_POST["phone"]);
    $array["message"] = verifyInput($_POST["message"]);
    $array["isSuccess"] = true;
    $emailText = "";
    
    if(empty($array["firstname"])){
        $array["firstnameError"] = "Je veux connaitre ton prénom !";
        $array["isSuccess"] = false;
    }
    else{
        $emailText .= "FirstName : {$array["firstname"]}\n";
    }
    
    if(empty($array["name"])){
        $array["nameError"] = "Et oui je veux tout savoir, même ton nom !";
        $array["isSuccess"] = false;
    }
    else{
        $emailText .= "Name : {$array["name"]}\n";
    }
    
    if(!isEmail($array["email"])){
    $array["emailError"] = "T'essaies de me rouler ? C'est pas un email ça !";
    $array["isSuccess"] = false;
    }
    else{
        $emailText .= "Email : {$array["email"]}\n";
    }
    
    if(!isPhone($array["phone"])){
        $array["phoneError"] = "Que des chiffres et des espaces, stp ...";
        $array["isSuccess"] = false;
    }
    else{
        $emailText .= "Phone : {$array["phone"]}\n";
    }
    
    if(empty($array["message"])){
    $array["messageError"] = "Qu'est ce que tu veux me dire ?";
    $array["isSuccess"] = false;
    }
    else{
        $emailText .= "Message : {$array["message"]}\n";
    }
    
    if($array["isSuccess"]){
        $headers = "From: {$array["firstname"]} {$array["name"]} <{$array["email"]}>\r\n";
        $headers .= "Content-Type: text/plain;charset=utf-8\r\n";
        $headers .= "Reply-to: {$array["email"]}"; 
        mail($emailTo, "Un message de votre site CV", $emailText, utf8_decode($headers));
    }
    
    echo json_encode($array);
    
}

function isEmail($var){
    return filter_var($var, FILTER_VALIDATE_EMAIL); // fonction toute prête qui vérifie si c'est un email valide
}

function isPhone($var){
    return preg_match("/^[0-9 ]*$/", $var); //regex avec 0 ou plusieurs chiffres et espaces. Du coup si champ vide : pas d'erreur.
}

function verifyInput($var){ // Pour la sécurité. Empêche de se faire hacker.
    
    $var = trim($var); // retire les espaces, tabulations
    $var = stripslashes($var); // retire les /
    $var = htmlspecialchars($var); // Convertit les caractères spéciaux en entités HTML
    
    return $var;
        
}


?>
