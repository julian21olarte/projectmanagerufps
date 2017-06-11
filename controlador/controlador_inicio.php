<?php

include ('controlador.php');
include (__DIR__ .'/../modelo/modelo.php');

/**
	 * Clase que se encarga de llevar a cabo las peticiones recibidas de los usuarios.
	 */
class ControladorInicio extends Controlador{

	/**
	 * @var Modelo
	 */
	private $modelo;

	
	/**
	 * Instancia de la clase modelo donde tengo las funciones de conexion a la base de datos
	 * @return void
	 */
	public function __construct(){

		$this->modelo = new Modelo();
	}

	
	/**
	 * Muestro la vista de inicio
	 * @return void
	 */
	public function inicio(){
		
		$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/inicio.html');
		$this->mostrarVista($plantilla);
	}

	
	/**
	 * Muestro la vista de admin
	 * @return void
	 */
	public function inicioAdmin(){

		$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/admin.html');
		$this->mostrarVista($plantilla);
	}

	
	/**
	 * Muestro la vista de user
	 * @return type
	 */
	public function inicioUser(){

		$plantilla = $this->leerPlantilla(__DIR__ . '/../vista/user.html');

		$consulta1 = "SELECT nombre, correo FROM persona WHERE idpersona = ".$_SESSION['user']."";

		$this->modelo->conectar();
		$respuesta1 = $this->modelo->consultar($consulta1);
		$this->modelo->desconectar();

		$nombre = '';
		$correo = '';
		while ($row = mysqli_fetch_array($respuesta1)) {
			$nombre = $row['nombre'];
			$correo = $row['correo'];
		}

		$plantilla = $this->reemplazar( $plantilla, '{{nombre}}', $nombre);
		$plantilla = $this->reemplazar( $plantilla, '{{correo}}', $correo);
		$this->mostrarVista($plantilla);
	}

	
	/**
	 * Funcion retorna true si un admin o un user iniciaron sesion
	 * @return boolean
	 */
	public function isLoggedIn(){

		return isset( $_SESSION['id_admin']) || isset( $_SESSION['id_user']);
	}

	/**
	 * Funcion para descargar un archivo
	 * @param String $archivo 
	 * @param null $downloadfilename 
	 * @return void
	 */
	public function descargar($archivo, $downloadfilename = null){
		
	    if (file_exists($archivo)) {
	        $downloadfilename = $downloadfilename !== null ? $downloadfilename : basename($archivo);
	        header('Content-Description: File Transfer');
	        header('Content-Type: application/octet-stream');
	        header('Content-Disposition: attachment; filename=' . $downloadfilename);
	        header('Content-Transfer-Encoding: binary');
	        header('Expires: 0');
	        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	        header('Pragma: public');
	        header('Content-Length: ' . filesize($archivo));
	 
	        ob_clean();
	        flush();
	        readfile($archivo);
	        exit;
	    }
	}




	/*************************************************************************************************
	 ***********************    METODOS DEL PROYECTO   ********************************************************
	 *************************************************************************************************
	*/