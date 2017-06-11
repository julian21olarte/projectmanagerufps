<?php

include ('controlador/controladorInicio.php');

session_start();	

	//Variable que me permite llamar funciones de la clase controladorInicio
$controladorInicio = new ControladorInicio();


	//Si alguien se acaba de registrar, seguidamente muestre la vista para iniciar sesion
if(isset($_SESSION['registro'])){
	unset($_SESSION['registro']);
	$controladorInicio->mostrarFormularioLogin();
	exit();
}	






	/*************************************************************************************************
	 ***********************    METODOS GET   ********************************************************
	 *************************************************************************************************
	*/

	//Pregunta si existe el parametro boton con algun valor en la url de la pagina
	if(isset($_GET['boton'])){

		//Guardo el valor de la variable boton 
		$boton = $_GET['boton'];

		//Si no hay ninguna sesion vaya a inicio
		if($controladorInicio->isLoggedIn()){
			header('Location: index.php');
		}

		/********** METODOS GET ADMINISTRADOR ********/

		if(isset($_SESSION['admin'])){

			switch ( $boton ) {

				//Si el administrador desea cerrar sesion
				case 'logouta':
				unset ( $_SESSION['admin'] );
				header('Location: index.php');
				break;
			}
		}else{
			
			/********** METODOS GET USUARIO ********/

			if(isset($_SESSION['user'])){

				switch ($boton) {

					//Si el usuario desea cerrar sesion lo redirigimos a la pagina de inicio					
					case 'logoutu':
					unset ( $_SESSION['user'] );
					header('Location: index.php');
					break;
				}	
			}else{

				switch ( $boton ) {

					
					//Si se solicita la vista de registro 
					case 'registro':
					$controladorInicio->mostrarformularioregistro();
					break;
					
					
					//Si se solicita la vista de inicio de sesion 
					case 'login':
					$controladorInicio->mostrarformulariologin();
					break;

					//Si el enlace no es ninguno de los permitidos para cada usuario, se va a la vista de inicio
					default:
					header('Location: index.php');
					break;
				}
			}		
		}


		//Si hay un peticion para descargar un archivo, llamar la funcion descargar
		if(isset($_GET['descargar'])){

			if($controladorInicio->isLoggedIn()){
				
			//Si no hay ninguna sesion vaya a inicio
				header('Location: index.php');
			}
			
		//Obtenemos la ruta del archivo a descargar
			$ruta = $_GET['descargar'];

			$controladorInicio->descargar($ruta);
		}
		exit();
	}






	/*************************************************************************************************
	 ***********************    METODOS POST   *******************************************************
	 *************************************************************************************************
	*/
	if(isset($_POST['solicitudes'])){

		//Guardo el valor de la variable solicitudes
		$tipo = $_POST['solicitudes'];

		if($controladorInicio->isLoggedIn()){
			//Si no hay ninguna sesion vaya a inicio
			header('Location: index.php');
		}

		
		//Si la solicitud es para iniciar sesion, guardamos los datos de sesion 
		if($tipo == "login"){

			$controladorInicio->guardarlogin($_POST['correo'], $_POST['password']);
		}

		exit();
	}
	
	/*
	 * Si existe una sesion de administrador, o de usuario o no existe ninguna sesion
	 */
	if(isset($_SESSION['admin'])){
		/**
		 * irse a la vista de admin
		 */
		$controladorInicio->inicioadmin();
	}else
	if (isset($_SESSION['user'])) {
			/**
			 * irse a la vista de usuario
			 */
			$controladorInicio->iniciouser();
		}else{
			/**
			 * irse a la vista principal
			 */
			$controladorInicio->inicio();
		}
