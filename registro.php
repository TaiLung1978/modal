<?php
 require_once('funciones.php');
 //conectar('localhost', 'root', '', 'simposio');
 
 $mysqli = new mysqli('localhost', 'root', '', 'simposio');
 $mysqli->set_charset("utf8");

 //Recibir
 $ci = strip_tags($_POST['ci']);
 $val=validaCedula($ci);
 if ($val)
 {
	 $nombre = strip_tags($_POST['nombre']);
	 $apellido = strip_tags($_POST['apellido']);
	 $email = strip_tags($_POST['email']);
	 //$password = strip_tags(sha1($_POST['password']));
	 $celular = strip_tags($_POST['celular']);
	 $organizacion = strip_tags($_POST['organizacion']);
	 $query = $mysqli->query('SELECT * FROM usuarios WHERE ci= "'.mysqli_real_escape_string($mysqli,$ci).'" ');

	 if($existe = $query->fetch_object())
	 {
		phpAlert(   "El participante ya está registrado"   ); //echo 'El participante '.$ci. ' ya existe.';
	 }
	 else
	 {
		$meter = $mysqli->query('INSERT INTO usuarios (ci, nombre, apellido, email, celular, organizacion) values ("'.mysqli_real_escape_string($mysqli,$ci).'", "'.mysqli_real_escape_string($mysqli,$nombre).'", "'.mysqli_real_escape_string($mysqli,$apellido).'", "'.mysqli_real_escape_string($mysqli,$email).'", "'.mysqli_real_escape_string($mysqli,$celular).'", "'.mysqli_real_escape_string($mysqli,$organizacion).'")');
		 if($meter)
		 {
			echo 'Participante registrado con exito';
			enviarMail($email);
		 }
		 else{
			echo 'Hubo un error en el registro.';
		 }
	  }
 } 
 else
 {
	phpAlert(   "Cédula no valida"   ); //echo 'Cedula no valida.';	 
  ?>	
	<script>window.history.back();</script>
	<?php
 }
?>