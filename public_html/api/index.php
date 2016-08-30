<?php
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->post("/registro","registro");







$app->run();




function addUser() {

        $data = json_decode(file_get_contents('php://input'), true);
        $db = getConnection();
        // a query get all the records from the users table
        $sql_users ="select usuario from usuarios where usuario ='".$data['username']."'";
        $consulta1 = $db->prepare($sql_users);
        $consulta1->execute();
        $result = $consulta1->fetchAll( PDO::FETCH_ASSOC );
         
        if(empty($result)){


           $sql = "INSERT INTO usuarios (usuario, pass, nombre, apellido,tipo_user) VALUES ('".$data['username']."', '".$data['contra']."', '".$data['name']."', '".$data['apellido']."','".$data['tipo']."')";

        // use prepared statements, even if not strictly required is good practice
        $stmt = $db->prepare( $sql );
        // execute the query
        $stmt->execute();

          print_r("Registro exitoso");
 
        }
        else{

          print_r("El usuario ya existe");
        }
}


function mailComprar(){
          $data = json_decode(file_get_contents('php://input'), true);
        
          print_r($data);
       
            $destinatario = "cromo.9@hotmail.com"; 
            $asunto = "Este mensaje es por que alguien quiere comprar un juego"; 
            $cuerpo = ' 
            <html> 
            <head> 
               <title>Ofertaron el juego: '.$data["nombre"].'</title> 
            </head> 
            <body> 
            <h1>Datos del juego!</h1> 
            <p>
              <h4>Nombre: '.$data["nombre"].'</h4> 
              <h4>Precio: '.$data["precio"].'</h4> 
              <h4>Consola: '.$data["consola"].'</h4> 
            </p> 
            <h1>Datos del usuario!</h1> 
            <p>
              <h4>correo: '.$data["user"].' </h4> 
              <h4>Tel: </h4> 
               
            </p> 
            </body> 
            </html> 
            '; 

            //para el envío en formato HTML 
            $headers = "MIME-Version: 1.0\r\n"; 
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

            //dirección del remitente 
            $headers .= "From: Edgames@user.com"; 


            $bool=mail($destinatario,$asunto,$cuerpo,$headers);

            if($bool){
                echo "Mensaje enviado";

            }else{
                echo "Mensaje no enviado";
            }
};


function getConnection() {
  $dbhost="mysql.hostinger.mx";
  $dbuser="u103628263_app";
  $dbpass="applicate2015";
  $dbname="u103628263_app";
  $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);  
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $dbh;
}

?>